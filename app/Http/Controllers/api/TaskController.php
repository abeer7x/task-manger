<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Http\Requests\task\StoreTaskRequest;
use App\Http\Requests\task\UpdateTaskRequest;
use App\Models\Task;
use App\Services\taskService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;
    protected $taskService;

    public function __construct(taskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {       
        $this->authorize('viewAny', Task::class);
        return $this->success($this->taskService->getTask());
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {    
        $validatedData = $request->validated();
        $validatedData['user_id'] =  Auth::id();
        $task = $this->taskService->addTask($validatedData);
        if (!$task) {
                return $this->error([
                    'message' => "This status not found , try another Status"
                ], 422);
            }   

    return $this->success(['data' => $task,], 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task); 
        return $this->success(['data' => $task]);
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {   
        
        $this->authorize('update', $task);
        $updatedTask = $this->taskService->updateTask($task, $request->validated());

        if (!$updatedTask) {
            return $this->error([
                'message' => 'The status name provided is invalid.',
            ], 422);
        }
    
        return $this->success([
            'data' => $updatedTask,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return $this->error([
                'message' => 'The task does not exist.',
            ], 404);
        }
        
        $this->authorize('delete', $task);
        $this->taskService->deleteTask($task);
    
        return $this->success(['message' => 'Task deleted successfully'], 200);
    }
}
