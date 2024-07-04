<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\GetUserByNameRequest;
use App\Repositories\Repository;

class GetUserByNameController extends Controller
{
    protected Repository $userRepository;

    public function __invoke(GetUserByNameRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->userRepository = Repository::getRepository('User');

        $user = $this->userRepository->getUsersByRoleAndName($request->get('name'),$request->get('role'))
            ->limit(10)
            ->get(['name','id']);

        return response()->json($user);
    }
}
