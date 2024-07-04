<?php

namespace App\Services;

use App\Jobs\UpdateStatistics;
use App\Models\User;
use App\Repositories\Repository;
use Illuminate\Support\MessageBag;

class TaskCrudService extends CrudService
{
    protected Repository $userRepository;
    public function __construct(string $entityName)
    {
        parent::__construct($entityName);
        $this->userRepository = Repository::getRepository('User');

    }

    public function create(array $request, \stdClass &$output): void
    {
        // check if the roles of assigned_to_id , assigned_by_id

        $assignedToHasRoleUser = $this->userRepository->getByKeys([
            'role' => User::ROLE_TYPE_USER,
            'id' => $request['assigned_to_id'],
        ])->exists();

        if (!$assignedToHasRoleUser){
           $output->Error = new MessageBag(['assigned_to_id' => 'Assigned to must be a user.']) ;
            return;
        }
        $assignedByHasRoleAdmin = $this->userRepository->getByKeys([
            'role' => User::ROLE_TYPE_ADMIN,
            'id' => $request['assigned_by_id'],
        ])->exists();

        if (!$assignedByHasRoleAdmin){
            $output->Error =new MessageBag(['assigned_by_id' => 'Assigned By must be an Admin.']) ;
            return;
        }
        $output->task = $this->repository->create($request);

        parent::create($request, $output);


        UpdateStatistics::dispatch($output->task->assigned_to_id);
    }
}
