<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Job;
class JobStatusComplete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:job-completed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the job status as completed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today()->toDateString();
        $jobs = Job::where('end_date', '<', $today)
                ->where('status',4)
                ->with(['bidding' => function ($query) {
                    $query->select('task_id', 'status'); 
                }])->get();

        $results = $jobs->map(function ($task) {
            $totalBidding        = $task->bidding->whereIn('status',[1,3])->count();           
            $completedBidding    = $task->bidding->where('status',3)->count(); 
            $percentageCompleted = $totalBidding > 0 ? ($completedBidding / $totalBidding) * 100 : 0;
            return [
                'id' => $task->id,
                'end_date' => $task->end_date,
                'percentage_completed' => round($percentageCompleted, 2),
            ];
        });
        foreach ($results as $_job) {      
            $endDate = strtotime($_job['end_date']);
            $hrsDiff = ((time()-$endDate) / 60)/60;     
            if( $_job['percentage_completed']==100 || ($_job['percentage_completed']>=50 && $hrsDiff>=48) ){               
                $model = Job::find($_job['id']);
                $model->status = 6;
                $model->update();
            }
        }
    }
}
