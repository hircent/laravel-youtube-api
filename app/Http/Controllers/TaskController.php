<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TasksResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Traits\HttpResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return $this->success([
        //     'tasks' => Task::where('user_id',50)->get()
        // ]);

        return TasksResource::collection(
            Task::where('user_id',Auth::user()->id)->get()
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $request->validated();

        $task = Task::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'priority' => $request->priority,
        ]);

        return new TasksResource($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // with param string $id:
        // $task = Task::where('id',$id)->get();
        // return $task;
        if(Auth::user()->id != $task->user_id){
            return $this->error('','You are not autherized to make this request','403');
        }
        return new TasksResource($task);


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task,StoreTaskRequest $store)
    {
        $store->validated();

        if(Auth::user()->id != $task->user_id){
            return $this->error('','You are not autherized to make this update request','403');
        }
        $task->update($request->all());

        return new TasksResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if(Auth::user()->id != $task->user_id){
            return $this->error('','You are not autherized to make this delete request','403');
        }
        try{
            $data = $task;
            $task->delete();
        }catch(ModelNotFoundException $e){
            return $this->error('','Task not found in database','404');
        }

        return $this->success($data,'Task deleted');
    }
}
