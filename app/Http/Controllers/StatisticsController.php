<?php

namespace App\Http\Controllers;

use App\Repositories\Repository;

class StatisticsController extends Controller
{
    protected Repository $statisticsRepository;

    public function __invoke(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $this->statisticsRepository = Repository::getRepository('Statistics');

        $statistics = $this->statisticsRepository
            ->getStatisticsOrderByAndLimit('total_tasks', 'desc', 10, ['user'])
            ->get();

        return view('statistics', [
            'statistics' => $statistics
        ]);
    }
}
