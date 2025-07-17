<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PitchEvent;

class InvestorDashboardController extends Controller
{
    public function pitchEvents()
    {
        $events = PitchEvent::where('status', 'published')
            ->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->paginate(12);

        return view('dashboard.investor-pitch-events', compact('events'));
    }
} 