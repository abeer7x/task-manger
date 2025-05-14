<?php

namespace App\Services;
use App\Models\Status;
use Throwable;
class statusService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    public function getAllStatus()
    {
        return Status::all();
    }
    public function addStatus(array $data){
      
        $existing = Status::where('name', $data['name'])->first();

        if ($existing) {
            return "The status is existed";
        }    
           
        $Status= Status::create($data);
              return $Status;
       
    }


public function updatestatus(array $data , Status $status){
        try {
            $status->update($data);
            return $status;
        } catch(Throwable $th) {
            return response()->json([
                'message' => 'Error updating status',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
