<?php

namespace App\Http\Controllers\Tradie;

use App\Http\Controllers\Controller;
use App\Models\{Job, JobApplication, Post};
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // dd($user);

        $appliedJobs   = JobApplication::where('bidder_id', $user->id)->where('status', 0)->count();
        $upcomingJobs  = JobApplication::where('bidder_id', $user->id)->where('status', 1)
                            ->whereHas('job', fn($q) => $q->where('status', 5))->count();
        $ongoingJobs   = JobApplication::where('bidder_id', $user->id)->where('status', 1)
                            ->whereHas('job', fn($q) => $q->where('status', 4))->count();
        $completedJobs = JobApplication::where('bidder_id', $user->id)->where('status', 1)
                            ->whereHas('job', fn($q) => $q->where('status', 6))->count();

        $recentJobs = JobApplication::with('job')
                        ->where('bidder_id', $user->id)
                        ->latest()->take(5)->get();

        return view('tradie.dashboard', compact(
            'appliedJobs', 'upcomingJobs', 'ongoingJobs', 'completedJobs', 'recentJobs'
        ));
    }
}
