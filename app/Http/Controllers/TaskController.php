<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Notifications\TaskReminder;
use App\Services\TaskService;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    private $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        Log::debug('Task Index');
        $tasks = $this->taskService->index($request->query('span', 'default'));
        foreach($tasks as $task) {
            $task->subject = $task->subject()->first();
        }
        return response()->json($tasks);
    }

    public function create()
    {
        return View('task.create');
    }

    public function store(CreateTaskRequest $request)
    {
        Log::debug('Task Store');
        $this->taskService->store($request->validated());
        return response()->json(['status' => 200]);
    }

    public function show(Task $task)
    {
        $task = $this->taskService->show($task);
        return response()->json($task);
    }

    public function edit(Task $task)
    {
        $this->taskService->authorize($task->id);
        return View('task.edit')->with('task', $task);
    }

    public function update(Task $task, UpdateTaskRequest $request)
    {
        $update = $this->taskService->update($task, $request->validated());
        return response()->json([], $update ? 200 : 404);
    }

    public function destroy(Task $task)
    {
        $count = $this->taskService->destroy($task);
        return response()->json([], $count ? 200 : 404);
    }

    public function complete(Task $task)
    {
        $this->taskService->complete($task);
        return back();
    }
}
