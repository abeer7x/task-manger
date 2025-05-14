<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Validation\ValidationException;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Throwable;
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
                throw ValidationException::withMessages([
                    'status_name' => ['الحالة غير موجودة.'],
                ]);
            }

            $data['status_id'] = $status->id;
            unset($data['status_name']);
        }

        return Task::create($data);
    }


    public function getTask()
    {

    
        $tasks = Task::where('user_id', Auth::id())
            ->with('status') 
            ->get();
    
            return $tasks;
    }


    
}

