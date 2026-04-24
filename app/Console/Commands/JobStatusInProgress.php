<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Job;
class JobStatusInProgress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:job-in-progress';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the job status in progrss';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today()->toDateString();
        $tasks = Job::where('start_date','<=',$today)
        ->whereHas('bidding', function ($query) {
            $query->where('status', 1);
        })
        ->whereIn('status',[1,2])
        ->get();
        foreach($tasks as $_job){           
           $_job->update(['status'=>4]);
        }
    }
}
