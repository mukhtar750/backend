<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TrainingSession;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TrainingSessionController extends Controller
{
    // User registers for a training session
    public function register($id)
    {
        $user = Auth::user();
        $session = TrainingSession::findOrFail($id);

        // Check if already registered
        $alreadyRegistered = DB::table('training_session_participants')
            ->where('training_session_id', $session->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyRegistered) {
            return redirect()->back()->with('info', 'You are already registered for this training session.');
        }

        DB::table('training_session_participants')->insert([
            'training_session_id' => $session->id,
            'user_id' => $user->id,
            'registered_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Optionally, notify admin(s) here
        // $admins = User::where('role', 'admin')->get();
        // foreach ($admins as $admin) {
        //     $admin->notify(new \App\Notifications\TrainingSessionRegistered($user, $session));
        // }

        return redirect()->back()->with('success', 'You have successfully registered for this training session.');
    }
} 