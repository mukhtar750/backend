<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MentorshipForm;
use App\Models\MentorshipFormField;
use App\Models\MentorshipFormSubmission;
use App\Models\MentorshipFormReview;
use App\Models\Pairing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MentorshipFormController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pairings = Pairing::where('user_one_id', $user->id)
                            ->orWhere('user_two_id', $user->id)
                            ->with(['userOne', 'userTwo'])
                            ->get();

        // Get all forms grouped by phase
        $forms = MentorshipForm::where('active', true)->orderBy('phase')->orderBy('order')->with('fields')->get();
        $formsByPhase = [
            'first_meeting' => $forms->where('phase', 'first_meeting')->values(),
            'ongoing_meetings' => $forms->where('phase', 'ongoing_meetings')->values(),
            'feedback_resources' => $forms->where('phase', 'feedback_resources')->values(),
        ];

        // Get all submissions for the current user and their pairings
        $pairingIds = $pairings->pluck('id');
        $submissions = MentorshipFormSubmission::whereIn('pairing_id', $pairingIds)
            ->with('form', 'pairing', 'submitter')
            ->get();

        // Build a status map: [pairing_id][form_id] => submission
        $statusMap = [];
        foreach ($submissions as $submission) {
            $statusMap[$submission->pairing_id][$submission->mentorship_form_id] = $submission;
        }

        return view('mentorship.forms.index', compact('pairings', 'formsByPhase', 'statusMap'));
    }

    public function dashboard()
    {
        $user = Auth::user();
        $pairings = Pairing::where('user_one_id', $user->id)
                            ->orWhere('user_two_id', $user->id)
                            ->with(['userOne', 'userTwo'])
                            ->get();

        $forms = MentorshipForm::where('active', true)->orderBy('phase')->orderBy('order')->with('fields')->get();
        $formsByPhase = [
            'first_meeting' => $forms->where('phase', 'first_meeting')->values(),
            'ongoing_meetings' => $forms->where('phase', 'ongoing_meetings')->values(),
            'feedback_resources' => $forms->where('phase', 'feedback_resources')->values(),
        ];

        $pairingIds = $pairings->pluck('id');
        $submissions = \App\Models\MentorshipFormSubmission::whereIn('pairing_id', $pairingIds)
            ->with('form', 'pairing', 'submitter')
            ->get();

        $statusMap = [];
        foreach ($submissions as $submission) {
            $statusMap[$submission->pairing_id][$submission->mentorship_form_id] = $submission;
        }

        return view('mentorship.forms.index', compact('pairings', 'formsByPhase', 'statusMap'));
    }

    public function create(Request $request, $form, $pairing)
    {
        $form = MentorshipForm::with('fields')->findOrFail($form);
        $pairing = Pairing::with(['userOne', 'userTwo'])->findOrFail($pairing);
        // Only allow the correct user to fill the form
        if ($form->completion_by !== auth()->user()->role) {
            return redirect()->back()->with('error', 'This form is meant to be filled by your ' . $form->completion_by . '.');
        }

        // Check if a submission already exists for this form and pairing by the current user
        $existingSubmission = MentorshipFormSubmission::where('mentorship_form_id', $form->id)
                                                    ->where('pairing_id', $pairing->id)
                                                    ->where('user_id', Auth::id())
                                                    ->first();

        if ($existingSubmission) {
            return redirect()->route('mentorship.forms.edit', $existingSubmission->id)
                             ->with('info', 'You have an existing submission for this form and pairing. You can edit it.');
        }

        return view('mentorship.forms.create', compact('form', 'pairing'));
    }

    public function store(Request $request, $form, $pairing)
    {
        $form = MentorshipForm::with('fields')->findOrFail($form);
        $pairing = Pairing::with(['userOne', 'userTwo'])->findOrFail($pairing);

        $rules = [];
        foreach ($form->fields as $field) {
            if ($field->is_required) {
                $rules[$field->label] = 'required';
            }
            if ($field->field_type === 'file') {
                $rules[$field->label] = array_merge($rules[$field->label] ?? [], ['file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:2048']);
            }
        }

        try {
            $validatedData = $request->validate($rules);
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        $formData = [];
        foreach ($form->fields as $field) {
            if ($field->field_type === 'file') {
                if ($request->hasFile($field->label)) {
                    $file = $request->file($field->label);
                    $path = $file->store('mentorship_form_uploads', 'public');
                    $formData[$field->label] = ['name' => $file->getClientOriginalName(), 'path' => $path];
                } elseif (isset($validatedData[$field->label])) {
                    // This case handles if a file was required but not uploaded, it would be caught by validation
                    // If it's not required and not uploaded, it simply won't be in formData
                }
            }
            elseif ($field->field_type === 'checkbox') {
                $formData[$field->label] = $request->has($field->label) ? (array)$request->input($field->label) : [];
            } else {
                $formData[$field->label] = $request->input($field->label);
            }
        }

        DB::beginTransaction();
        try {
            $submission = MentorshipFormSubmission::create([
                'mentorship_form_id' => $form->id,
                'pairing_id' => $pairing->id,
                'submitted_by' => Auth::id(),
                'form_data' => json_encode($formData),
                'status' => $request->input('action') === 'draft' ? 'draft' : 'submitted',
            ]);

            // Create a MentorshipSession if this is a mentor's ongoing meeting form and not a draft
            if ($form->phase === 'ongoing_meetings' && $form->completion_by === 'mentor' && $request->input('action') !== 'draft') {
                // Try to extract date, duration, and topic from form fields
                // Ensure date is a valid datetime string
                if (isset($formData['Meeting Date'])) {
                    $date = $formData['Meeting Date'];
                    // If only a date (no time), append noon
                    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                        $date .= ' 12:00:00';
                    }
                } else {
                    $date = now();
                }
                $duration = 60; // default 60 minutes
                if (!empty($formData['Meeting Duration'])) {
                    // Try to extract a number from the duration string (e.g., '1 hour' => 60)
                    if (preg_match('/(\d+)/', $formData['Meeting Duration'], $matches)) {
                        $duration = (int)$matches[1];
                        if (stripos($formData['Meeting Duration'], 'hour') !== false) {
                            $duration *= 60;
                        }
                    }
                }
                $topic = $formData['Topics Discussed'] ?? $form->title;
                // Determine mentor and mentee
                $mentorId = Auth::id();
                $menteeId = $pairing->user_one_id == $mentorId ? $pairing->user_two_id : $pairing->user_one_id;
                $sessionData = [
                    'pairing_id' => $pairing->id,
                    'scheduled_by' => $mentorId,
                    'scheduled_for' => $menteeId,
                    'date_time' => $date,
                    'duration' => $duration,
                    'topic' => is_array($topic) ? (implode(', ', $topic)) : $topic,
                    'status' => 'pending',
                    'notes' => null,
                    'meeting_link' => null,
                ];
                \Log::info('Creating MentorshipSession from form submission', $sessionData);
                try {
                    $createdSession = \App\Models\MentorshipSession::create($sessionData);
                    \Log::info('Created MentorshipSession', $createdSession ? $createdSession->toArray() : []);
                } catch (\Exception $ex) {
                    \Log::error('Failed to create MentorshipSession: ' . $ex->getMessage(), $sessionData);
                    return redirect()->back()->with('error', 'Failed to create mentorship session. Please try again or contact support.')->withInput();
                }
            }

            DB::commit();

            // Notify admin if both mentor and mentee have signed the mentorship agreement
            if ($form->form_type === 'mentorship_agreement') {
                $mentor = $pairing->userOne->role === 'mentor' ? $pairing->userOne : $pairing->userTwo;
                $mentee = $pairing->userOne->role === 'mentee' ? $pairing->userOne : $pairing->userTwo;
                $agreementForm = $form;
                $mentorSubmission = \App\Models\MentorshipFormSubmission::where([
                    'pairing_id' => $pairing->id,
                    'mentorship_form_id' => $agreementForm->id,
                    'submitted_by' => $mentor->id,
                ])->first();
                $menteeSubmission = \App\Models\MentorshipFormSubmission::where([
                    'pairing_id' => $pairing->id,
                    'mentorship_form_id' => $agreementForm->id,
                    'submitted_by' => $mentee->id,
                ])->first();
                if ($mentorSubmission && $mentorSubmission->is_signed && $menteeSubmission && $menteeSubmission->is_signed) {
                    $admins = \App\Models\User::where('role', 'admin')->get();
                    foreach ($admins as $admin) {
                        $admin->notify(new \App\Notifications\AdminMentorshipAgreementCompletedNotification($pairing));
                    }
                }
            }

            $message = $request->input('action') === 'draft' ? 'Form saved as draft successfully!' : 'Form submitted for review successfully!';
            return redirect()->route('mentorship.forms.show', $submission->id)->with('success', $message);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to save form: ' . $e->getMessage())->withInput();
        }
    }

    public function show(MentorshipFormSubmission $submission)
    {
        // Ensure the user can only view their own submissions or if they are part of the pairing
        if ($submission->submitted_by !== Auth::id() &&
            !($submission->pairing && ($submission->pairing->user_one_id === Auth::id() || $submission->pairing->user_two_id === Auth::id())))
        {
            abort(403, 'Unauthorized action.');
        }

        $submission->load('form.fields', 'submitter', 'pairing.userOne', 'pairing.userTwo', 'reviews');
        $form = $submission->form;
        $pairing = $submission->pairing;

        if ($form->completion_by === 'both') {
            $mentor = $pairing->userOne->role === 'mentor' ? $pairing->userOne : $pairing->userTwo;
            $mentee = $pairing->userOne->role === 'mentee' ? $pairing->userOne : $pairing->userTwo;
            $mentorSubmission = \App\Models\MentorshipFormSubmission::where([
                'pairing_id' => $pairing->id,
                'mentorship_form_id' => $form->id,
                'submitted_by' => $mentor->id,
            ])->first();
            $menteeSubmission = \App\Models\MentorshipFormSubmission::where([
                'pairing_id' => $pairing->id,
                'mentorship_form_id' => $form->id,
                'submitted_by' => $mentee->id,
            ])->first();
            return view('mentorship.forms.show-both', compact('form', 'pairing', 'mentorSubmission', 'menteeSubmission'));
        }

        return view('mentorship.forms.show', compact('submission'));
    }

    public function edit(MentorshipFormSubmission $submission)
    {
        // Ensure the user can only edit their own submissions and if the status allows editing
        if ($submission->user_id !== Auth::id() || !in_array($submission->status, ['draft', 'pending_review'])) {
            abort(403, 'Unauthorized action or submission cannot be edited.');
        }

        $submission->load('form.fields', 'user', 'pairing.userOne', 'pairing.userTwo');
        $formData = json_decode($submission->form_data, true);

        return view('mentorship.forms.edit', compact('submission', 'formData'));
    }

    public function update(Request $request, MentorshipFormSubmission $submission)
    {
        // Ensure the user can only update their own submissions and if the status allows updating
        if ($submission->user_id !== Auth::id() || !in_array($submission->status, ['draft', 'pending_review'])) {
            abort(403, 'Unauthorized action or submission cannot be updated.');
        }

        $form = $submission->form;

        $rules = [];
        foreach ($form->fields as $field) {
            if ($field->is_required && $field->type !== 'file') {
                $rules[$field->name] = 'required';
            } elseif ($field->is_required && $field->type === 'file' && !$submission->getMedia($field->name)->first()) {
                // If file is required and no existing file, then it's required for upload
                $rules[$field->name] = array_merge($rules[$field->name] ?? [], ['required', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:2048']);
            }
            if ($field->type === 'file') {
                $rules[$field->name] = array_merge($rules[$field->name] ?? [], ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:2048']);
            }
        }

        try {
            $validatedData = $request->validate($rules);
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        $formData = json_decode($submission->form_data, true) ?? [];

        foreach ($form->fields as $field) {
            if ($field->type === 'file') {
                if ($request->hasFile($field->name)) {
                    // Delete old file if exists
                    if (isset($formData[$field->name]['path'])) {
                        Storage::disk('public')->delete($formData[$field->name]['path']);
                    }
                    $file = $request->file($field->name);
                    $path = $file->store('mentorship_form_uploads', 'public');
                    $formData[$field->name] = ['name' => $file->getClientOriginalName(), 'path' => $path];
                } elseif ($request->input($field->name . '_clear')) {
                    // Handle file clear if checkbox is checked
                    if (isset($formData[$field->name]['path'])) {
                        Storage::disk('public')->delete($formData[$field->name]['path']);
                    }
                    unset($formData[$field->name]);
                }
            } elseif ($field->type === 'checkbox') {
                $formData[$field->name] = $request->has($field->name) ? (array)$request->input($field->name) : [];
            } else {
                $formData[$field->name] = $request->input($field->name);
            }
        }

        DB::beginTransaction();
        try {
            $submission->update([
                'form_data' => json_encode($formData),
                'status' => $request->input('action') === 'draft' ? 'draft' : 'pending_review',
            ]);

            DB::commit();

            $message = $request->input('action') === 'draft' ? 'Form updated as draft successfully!' : 'Form updated and submitted for review successfully!';
            return redirect()->route('mentorship.forms.show', $submission->id)->with('success', $message);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update form: ' . $e->getMessage())->withInput();
        }
    }

    public function adminDashboard()
    {
        $totalSubmissions = MentorshipFormSubmission::count();
        $pendingReviews = MentorshipFormSubmission::where('status', 'pending_review')->count();
        $approvedSubmissions = MentorshipFormSubmission::where('status', 'approved')->count();
        $rejectedSubmissions = MentorshipFormSubmission::where('status', 'rejected')->count();

        $formsForReview = MentorshipFormSubmission::where('status', 'pending_review')
                                                ->with('form', 'user', 'pairing.userOne', 'pairing.userTwo')
                                                ->get();

        $allSubmissions = MentorshipFormSubmission::with('form', 'user', 'pairing.userOne', 'pairing.userTwo')
                                                ->get();

        return view('admin.mentorship.forms.admin_dashboard', compact('totalSubmissions', 'pendingReviews', 'approvedSubmissions', 'rejectedSubmissions', 'formsForReview', 'allSubmissions'));
    }

    public function listSubmissions()
    {
        $submissions = MentorshipFormSubmission::with('form', 'user', 'pairing.userOne', 'pairing.userTwo')->get();
        return view('admin.mentorship.forms.list_submissions', compact('submissions'));
    }

    public function showSubmission(MentorshipFormSubmission $submission)
    {
        $submission->load('form.fields', 'user', 'pairing.userOne', 'pairing.userTwo', 'review');
        return view('admin.mentorship.forms.show_submission', compact('submission'));
    }

    public function reviewSubmission(MentorshipFormSubmission $submission)
    {
        $submission->load('form.fields', 'user', 'pairing.userOne', 'pairing.userTwo', 'review');
        return view('admin.mentorship.forms.review_submission', compact('submission'));
    }

    public function storeReview(Request $request, MentorshipFormSubmission $submission)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'comments' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Update submission status
            $submission->status = $request->input('status');
            $submission->save();

            // Create or update review record
            MentorshipFormReview::updateOrCreate(
                ['mentorship_form_submission_id' => $submission->id],
                [
                    'user_id' => Auth::id(), // Admin user who is reviewing
                    'status' => $request->input('status'),
                    'comments' => $request->input('comments'),
                ]
            );

            DB::commit();

            return redirect()->route('admin.mentorship.forms.show_submission', $submission->id)->with('success', 'Submission reviewed successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to store review: ' . $e->getMessage());
        }
    }

    public function downloadSubmission(MentorshipFormSubmission $submission, $fieldName = null)
    {
        $formData = json_decode($submission->form_data, true);

        if ($fieldName && isset($formData[$fieldName]) && isset($formData[$fieldName]['path'])) {
            // Download a specific file from the submission
            $filePath = $formData[$fieldName]['path'];
            $fileName = $formData[$fieldName]['name'];

            if (Storage::disk('public')->exists($filePath)) {
                return Storage::disk('public')->download($filePath, $fileName);
            } else {
                abort(404, 'File not found.');
            }
        } else {
            // If no specific field name is provided, create a zip of all files or a PDF summary
            // For simplicity, let's just return a message for now or implement a basic text summary download
            // A more robust solution would involve generating a PDF or a zip file of all attachments
            $summaryContent = "Mentorship Form Submission Summary\n\n";
            $summaryContent .= "Form: " . $submission->form->title . "\n";
            $summaryContent .= "Submitted By: " . $submission->user->name . "\n";
            $summaryContent .= "Status: " . $submission->status . "\n";
            $summaryContent .= "Submitted At: " . $submission->created_at->format('M d, Y H:i') . "\n\n";

            $summaryContent .= "Form Data:\n";
            foreach ($submission->form->fields as $field) {
                if (isset($formData[$field->name])) {
                    $summaryContent .= $field->label . ": ";
                    if ($field->type === 'file') {
                        $summaryContent .= "[File: " . $formData[$field->name]['name'] . "]\n";
                    } elseif (is_array($formData[$field->name])) {
                        $summaryContent .= implode(', ', $formData[$field->name]) . "\n";
                    } else {
                        $summaryContent .= $formData[$field->name] . "\n";
                    }
                }
            }

            $headers = [
                'Content-Type' => 'text/plain',
                'Content-Disposition' => 'attachment; filename="submission_summary_' . $submission->id . '.txt"',
            ];

            return response($summaryContent, 200, $headers);
        }
    }
}