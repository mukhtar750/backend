<?php

namespace App\Http\Controllers;

use App\Models\PitchEventProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PitchEventProposalController extends Controller
{
    /**
     * Display a listing of the investor's proposals
     */
    public function index()
    {
        $proposals = Auth::user()->pitchEventProposals()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('investor.proposals.index', compact('proposals'));
    }

    /**
     * Show the form for creating a new proposal
     */
    public function create()
    {
        return view('investor.proposals.create');
    }

    /**
     * Store a newly created proposal
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'event_type' => 'required|in:pitch_competition,networking,demo_day,workshop',
            'target_sector' => 'nullable|string|max:100',
            'target_stage' => 'nullable|in:seed,series_a,series_b,series_c,growth',
            'target_criteria' => 'nullable|string|max:500',
            'max_participants' => 'nullable|integer|min:1|max:1000',
            'min_funding_needed' => 'nullable|numeric|min:0',
            'max_funding_needed' => 'nullable|numeric|min:0|gte:min_funding_needed',
            'expected_outcomes' => 'required|string|max:500',
            'success_metrics' => 'nullable|string|max:500',
            'proposed_format' => 'nullable|string|max:1000',
            'supporting_rationale' => 'nullable|string|max:1000',
            'proposed_date' => 'nullable|date|after:today',
            'proposed_time' => 'nullable|date_format:H:i',
            'proposed_duration' => 'nullable|integer|min:30|max:480',
            'proposed_location' => 'nullable|string|max:255',
            'is_virtual' => 'boolean',
            'virtual_platform' => 'nullable|string|max:100',
            'additional_requirements' => 'nullable|string|max:500',
        ]);

        try {
            $proposal = PitchEventProposal::create([
                'investor_id' => Auth::id(),
                'title' => $request->title,
                'description' => $request->description,
                'event_type' => $request->event_type,
                'target_sector' => $request->target_sector,
                'target_stage' => $request->target_stage,
                'target_criteria' => $request->target_criteria,
                'max_participants' => $request->max_participants,
                'min_funding_needed' => $request->min_funding_needed,
                'max_funding_needed' => $request->max_funding_needed,
                'expected_outcomes' => $request->expected_outcomes,
                'success_metrics' => $request->success_metrics,
                'proposed_format' => $request->proposed_format,
                'supporting_rationale' => $request->supporting_rationale,
                'proposed_date' => $request->proposed_date,
                'proposed_time' => $request->proposed_time,
                'proposed_duration' => $request->proposed_duration,
                'proposed_location' => $request->proposed_location,
                'is_virtual' => $request->boolean('is_virtual'),
                'virtual_platform' => $request->virtual_platform,
                'additional_requirements' => $request->additional_requirements,
                'status' => 'pending',
            ]);

            Log::info('Pitch event proposal created', [
                'proposal_id' => $proposal->id,
                'investor_id' => Auth::id(),
                'title' => $proposal->title,
            ]);

            return redirect()->route('investor.proposals.index')
                ->with('success', 'Your pitch event proposal has been submitted successfully and is under review.');

        } catch (\Exception $e) {
            Log::error('Failed to create pitch event proposal', [
                'investor_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            return back()->withInput()
                ->with('error', 'Failed to submit your proposal. Please try again.');
        }
    }

    /**
     * Display the specified proposal
     */
    public function show(PitchEventProposal $proposal)
    {
        // Ensure the investor can only view their own proposals
        if ($proposal->investor_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this proposal.');
        }

        return view('investor.proposals.show', compact('proposal'));
    }

    /**
     * Show the form for editing the specified proposal
     */
    public function edit(PitchEventProposal $proposal)
    {
        // Ensure the investor can only edit their own pending proposals
        if ($proposal->investor_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this proposal.');
        }

        if (!$proposal->canBeReviewed()) {
            return redirect()->route('investor.proposals.show', $proposal)
                ->with('error', 'This proposal cannot be edited at this time.');
        }

        return view('investor.proposals.edit', compact('proposal'));
    }

    /**
     * Update the specified proposal
     */
    public function update(Request $request, PitchEventProposal $proposal)
    {
        // Ensure the investor can only update their own proposals
        if ($proposal->investor_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this proposal.');
        }

        if (!$proposal->canBeReviewed()) {
            return redirect()->route('investor.proposals.show', $proposal)
                ->with('error', 'This proposal cannot be updated at this time.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'event_type' => 'required|in:pitch_competition,networking,demo_day,workshop',
            'target_sector' => 'nullable|string|max:100',
            'target_stage' => 'nullable|in:seed,series_a,series_b,series_c,growth',
            'target_criteria' => 'nullable|string|max:500',
            'max_participants' => 'nullable|integer|min:1|max:1000',
            'min_funding_needed' => 'nullable|numeric|min:0',
            'max_funding_needed' => 'nullable|numeric|min:0|gte:min_funding_needed',
            'expected_outcomes' => 'required|string|max:500',
            'success_metrics' => 'nullable|string|max:500',
            'proposed_format' => 'nullable|string|max:1000',
            'supporting_rationale' => 'nullable|string|max:1000',
            'proposed_date' => 'nullable|date|after:today',
            'proposed_time' => 'nullable|date_format:H:i',
            'proposed_duration' => 'nullable|integer|min:30|max:480',
            'proposed_location' => 'nullable|string|max:255',
            'is_virtual' => 'boolean',
            'virtual_platform' => 'nullable|string|max:100',
            'additional_requirements' => 'nullable|string|max:500',
        ]);

        try {
            $proposal->update([
                'title' => $request->title,
                'description' => $request->description,
                'event_type' => $request->event_type,
                'target_sector' => $request->target_sector,
                'target_stage' => $request->target_stage,
                'target_criteria' => $request->target_criteria,
                'max_participants' => $request->max_participants,
                'min_funding_needed' => $request->min_funding_needed,
                'max_funding_needed' => $request->max_funding_needed,
                'expected_outcomes' => $request->expected_outcomes,
                'success_metrics' => $request->success_metrics,
                'proposed_format' => $request->proposed_format,
                'supporting_rationale' => $request->supporting_rationale,
                'proposed_date' => $request->proposed_date,
                'proposed_time' => $request->proposed_time,
                'proposed_duration' => $request->proposed_duration,
                'proposed_location' => $request->proposed_location,
                'is_virtual' => $request->boolean('is_virtual'),
                'virtual_platform' => $request->virtual_platform,
                'additional_requirements' => $request->additional_requirements,
                'status' => 'pending', // Reset to pending for admin review
                'admin_feedback' => null, // Clear previous feedback
                'reviewed_by' => null,
                'reviewed_at' => null,
            ]);

            Log::info('Pitch event proposal updated', [
                'proposal_id' => $proposal->id,
                'investor_id' => Auth::id(),
            ]);

            return redirect()->route('investor.proposals.show', $proposal)
                ->with('success', 'Your proposal has been updated and is under review again.');

        } catch (\Exception $e) {
            Log::error('Failed to update pitch event proposal', [
                'proposal_id' => $proposal->id,
                'investor_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            return back()->withInput()
                ->with('error', 'Failed to update your proposal. Please try again.');
        }
    }

    /**
     * Remove the specified proposal
     */
    public function destroy(PitchEventProposal $proposal)
    {
        // Ensure the investor can only delete their own pending proposals
        if ($proposal->investor_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this proposal.');
        }

        if (!$proposal->isPending()) {
            return redirect()->route('investor.proposals.show', $proposal)
                ->with('error', 'Only pending proposals can be deleted.');
        }

        try {
            $proposal->delete();

            Log::info('Pitch event proposal deleted', [
                'proposal_id' => $proposal->id,
                'investor_id' => Auth::id(),
            ]);

            return redirect()->route('investor.proposals.index')
                ->with('success', 'Your proposal has been deleted successfully.');

        } catch (\Exception $e) {
            Log::error('Failed to delete pitch event proposal', [
                'proposal_id' => $proposal->id,
                'investor_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Failed to delete your proposal. Please try again.');
        }
    }
}
