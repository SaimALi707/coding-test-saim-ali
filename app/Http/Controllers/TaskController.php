<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Phase;
use App\Models\Task;
use App\Models\User;
use App\Traits\ImageUpload;
use Carbon\Carbon;
use PharIo\Version\Exception;

class TaskController extends Controller
{

    use ImageUpload;

    public function kanban()
    {
        return view('tasks.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Phase::with('tasks.user')
            ->with('tasks.priority')
            ->withCount('tasks') // counting the total tasks in each phases
            ->get();
    }

    /**
     * Display a listing of the Users resource.
     */
    public function users()
    {
        return \App\Models\User::all();
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
        // Create a new task from the $request
        $requestedPhase = Phase::query()->find($request->phase_id);
        if (!$requestedPhase)
            return response()->json(['message' => 'No such phase found with the provided id.']);

        $request->merge(
            [
                'attachment' => $this->simpleImageUpload($request->attachment_image, '/task-images/')
            ]
        );

        $task = Task::create($request->only((new Task)->getFillable()));

        return response()->json(['message' => 'Task created!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        try {
            $task = Task::query()->with('user')->find($task->id);
            return response()->json(['message' => 'Task fetched successfully.', 'data' => $task]);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        try {
            $requestedPhase = Phase::query()->find($request->phase_id);
            if (!$requestedPhase)
                return response()->json(['message' => 'No such phase found with the provided id.']);

            if ($requestedPhase->completed_at != null && $request->completed_at == null)
                $request->merge(['completed_at' => Carbon::now()]);

            if ($request->hasFile('attachment_image')) {
                $request->merge(['attachment' => $this->simpleImageUpload($request->attachment_image, '/task-images/')]);
            }
            $isUpdated = $task->update($request->only((new Task)->getFillable()));

            if ($isUpdated)
                return response()->json(['message' => 'Task has been updated successfully']);
            else
                return response()->json(['message' => 'Failed to update the task.'], 409);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Task::destroy($task->id);
    }
}
