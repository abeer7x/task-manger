<?php

namespace App\Services;

use App\Models\Task;
use App\Models\Status;

use Illuminate\Support\Facades\Auth;

class taskService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function addTask(array $data)
    {
        if (isset($data['status_name'])) {
            $status = Status::where('name', $data['status_name'])->first();

            if (!$status) {
                return null;
            }
            $data['status_id'] = $status->id;
            unset($data['status_name']);
        }

        return Task::create($data);
    }

    public function updateTask(Task $task, array $data)
    {
        logger($data); 
        if (isset($data['status_name'])) {
            $status = Status::where('name', $data['status_name'])->first();
            if (!$status) {
                return null;
            }
            $task->status_id = $status->id;
            unset($data['status_name']);
        }
    
        $task->update($data);
    
        return $task;
    }
        public function getTask()
    {
        return Task::forUser(Auth::id())->with('status')->get();
    }
    public function deleteTask(Task $task){
       
        return $task->delete();
        
    }
    public function confirmUser(Task $task): bool
{
    return $task->user_id === Auth::id();
}

}

