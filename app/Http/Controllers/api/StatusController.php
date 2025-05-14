<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Services\statusService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StatusController extends Controller
{
    use AuthorizesRequests;
    protected $statusTask;

    public function __construct(statusService $statusTask)
    {
        $this->statusTask = $statusTask;
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {    $this->authorize('viewAny', Status::class);
        return $this->success($this->statusTask->getAllStatus());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatusRequest $request)
    {   $this->authorize('create', Status::class); 
        return $this->success($this->statusTask->addStatus($request->validated()),201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {    $this->authorize('view', $status);
        return $this->success($status);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatusRequest $request, Status $status)
    {    $this->authorize('update', $status);
        return $this->success(
            $this->statusTask->updatestatus($request->validated(),$status));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status)
    {   $this->authorize('delete', $status); 
        $status->delete();
        return $this->success(['message'=>'delete}'],200);
    }
}
