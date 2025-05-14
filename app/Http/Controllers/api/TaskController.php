<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\taskService;
use Illuminate\Support\Facades\Auth;
use App\Models\Status;
class TaskController extends Controller
{

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
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    
        return $this->success($this->taskService->getTask());
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {    
        $validatedData = $request->validated();
        $validatedData['user_id'] =  Auth::id();
        return $this->success($this->taskService->addTask($validatedData),201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {   
        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to update this task.',
            ], 403);
        }
    
       
        if ($request->has('status_name')) {
            $status = Status::where('name', $request->input('status_name'))->first();
            if (!$status) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'The status name provided is invalid.',
                ], 422);
            }
            $task->status_id = $status->id;
        }

        $task->update($request->validated());
    
        return $this->success($task, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {if ($task->user_id !== Auth::id()) {
        return response()->json([
            'status' => 'error',
            'message' => 'You are not authorized to delete this task.',
        ], 403);
    }

    $task->delete();

    return $this->success(['message' => 'Task deleted successfully'], 200);
    }
}
