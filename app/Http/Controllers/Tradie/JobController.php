<?php

namespace App\Http\Controllers\Tradie;

use App\Http\Controllers\Controller;
use App\Models\{Job, JobApplication, JobReviews, JobTradersComplaint};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate([
            'job_id'     => 'required|exists:tasks,id',
            'bid_amount' => 'required|numeric|min:1',
        ]);

        $user = Auth::user();
        $job  = Job::findOrFail($request->job_id);

        $alreadyApplied = JobApplication::where('task_id', $job->id)
            ->where('bidder_id', $user->id)->exists();

        if ($alreadyApplied) {
            return redirect()->back()->with('error', 'You have already applied for this job.');
        }

        JobApplication::create([
            'task_id'    => $job->id,
            'bidder_id'  => $user->id,
            'agency_id'  => $job->agency_id,
            'bid_amount' => $request->bid_amount,
            'start_date' => $job->start_date,
            'end_date'   => $job->end_date,
            'status'     => 0,
        ]);

        return redirect()->back()->with('success', 'You have successfully applied for this job!');
    }

    public function index(Request $request){

        $user = Auth::user();
        $tab  = $request->tab ?? 'applied';

        $query = JobApplication::with('job')->where('bidder_id', $user->id);

        switch ($tab) {
            case 'upcoming':
                $jobs = $query->where('status', 1)->whereHas('job', fn($q) => $q->where('status', 5))->paginate(10);
                break;
            case 'ongoing':
                $jobs = $query->where('status', 1)->whereHas('job', fn($q) => $q->where('status', 4))->paginate(10);
                break;
            case 'completed':
                $jobs = $query->whereHas('job', fn($q) => $q->where('status', 6))->paginate(10);
                break;
            default:
                $jobs = $query->where('status', 0)->paginate(10);
        }

        return view('tradie.jobs.index', compact('jobs', 'tab'));
    }

    public function show($id)
    {
        $user        = Auth::user();
        $job         = Job::with(['agency', 'SkillCategory'])->findOrFail($id);
        $application = JobApplication::where('task_id', $id)->where('bidder_id', $user->id)->first();
        $review      = JobReviews::where('job_id', $id)->where('user_id', $user->id)->first();

        return view('tradie.jobs.show', compact('job', 'application', 'review'));
    }

    public function withdraw(Request $request)
    {
        $user        = Auth::user();
        $application = JobApplication::where('task_id', $request->job_id)->where('bidder_id', $user->id)->firstOrFail();
        $job         = $application->job;

        // Deduct 0.5 rating if withdrawn within 48 hours
        $hoursLeft = (strtotime($job->start_date) - time()) / 3600;
        if ($hoursLeft < 48) {
            $newRating = max(0, $user->over_all_rating - 0.5);
            $user->update(['over_all_rating' => $newRating]);
        }

        $application->delete();

        return redirect()->route('tradie.jobs.index')->with('success', 'Withdrawn from job successfully.');
    }

    public function markComplete($id)
    {
        $user        = Auth::user();
        $application = JobApplication::where('task_id', $id)->where('bidder_id', $user->id)->firstOrFail();
        $application->update(['status' => 3]);

        return redirect()->route('tradie.jobs.show', $id)->with('success', 'Job marked as complete.');
    }

    public function review(Request $request)
    {
        $request->validate([
            'job_id'  => 'required|exists:tasks,id',
            'rating'  => 'required|numeric|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $user = Auth::user();

        JobReviews::updateOrCreate(
            ['job_id' => $request->job_id, 'user_id' => $user->id],
            ['over_all_rating' => $request->rating, 'comment' => $request->comment, 'status' => 2]
        );

        return redirect()->route('tradie.jobs.show', $request->job_id)->with('success', 'Review submitted.');
    }

    public function report(Request $request)
    {
        $request->validate([
            'job_id'  => 'required|exists:tasks,id',
            'comment' => 'required|string',
        ]);

        $user = Auth::user();
        $job  = Job::findOrFail($request->job_id);

        JobTradersComplaint::create([
            'job_id'    => $request->job_id,
            'trader_id' => $user->id,
            'agency_id' => $job->agency_id,
            'comment'   => $request->comment,
        ]);

        $job->agency->update(['has_complain' => 1]);

        return redirect()->route('tradie.jobs.show', $request->job_id)->with('success', 'Report submitted.');
    }
}
