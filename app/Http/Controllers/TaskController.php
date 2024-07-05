<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\CreateTaskRequest;
use App\Models\User;
use App\Repositories\Repository;
use App\Services\TaskCrudService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    protected Repository $taskRepository;
    protected Repository $userRepository;

    protected TaskCrudService $taskCurdService;

    public function __construct()
    {
        // initialize
        $this->taskCurdService = new TaskCrudService('Task');
        $this->userRepository = Repository::getRepository('User');
        $this->taskRepository = Repository::getRepository('Task');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $tasks = $this->taskRepository->getAll()->paginate(10);

        return view('dashboard', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $users = $this->userRepository->getByKey('role', User::ROLE_TYPE_USER)
            ->limit(10)->pluck('name', 'id');
        $admins = $this->userRepository->getByKey('role', User::ROLE_TYPE_ADMIN)
            ->limit(10)->pluck('name', 'id');

        return view('task.create', [
            'users' => $users,
            'admins' => $admins,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTaskRequest $request): \Illuminate\Http\RedirectResponse
    {
        $output = new \stdClass();
        try {

            DB::beginTransaction();
            $this->taskCurdService->create($request->validated(),$output);
            if (isset($output->Error)){
                DB::rollBack();
                return redirect()->back()->withErrors($output->Error);
            }
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect()->back()->withErrors('something went wrong , please try again later');
        }

        return redirect()->route('dashboard')->with('success', 'Task created successfully');
    }


}
