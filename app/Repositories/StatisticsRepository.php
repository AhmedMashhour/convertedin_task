<?php

namespace App\Repositories;

class StatisticsRepository extends Repository
{
    public  function getStatisticsOrderByAndLimit(string $key ,string $direction = 'desc' ,int $limit = 10, array $relatedObjects=[])
    {
        return $this->getModel->with($relatedObjects)
            ->orderBy($key, $direction)
            ->take($limit);
    }

}
