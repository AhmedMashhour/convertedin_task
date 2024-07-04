<?php

namespace App\Jobs;

use App\Repositories\Repository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateStatistics implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $user_id;
    protected Repository $statisticsRepository;
    protected Repository $taskRepository;

    /**
     * Create a new job instance.
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
        $this->statisticsRepository = Repository::getRepository('Statistics');
        $this->taskRepository = Repository::getRepository('Task');
    }

    /**
     * Execute the job.
     */
    public function handle()
    {


        $statistics = $this->statisticsRepository->getByKey('user_id', $this->user_id)->first();
        $total_tasks = $this->taskRepository->getByKey('assigned_to_id', $this->user_id)->get()->count();


        if (isset($statistics->id)) {
            $statistics=  $this->statisticsRepository->update($statistics, [
                'total_tasks' => $total_tasks,
            ]);
        } else {
            $statistics=  $this->statisticsRepository->create([
                'user_id' => $this->user_id,
                'total_tasks' => $total_tasks,
            ]);
        }


    }
}
