<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Subject;
use App\Models\Task;
use App\Notifications\TaskReminder;
use App\Services\TaskService;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    private $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        $tasks = $this->taskService->index($request->query('span', 'default'));
        return View('task.index')->with('tasks', $tasks);
    }

    public function create()
    {
        return View('task.create');
    }

    public function store(CreateTaskRequest $request)
    {
        $this->taskService->store($request->validated());
        return redirect()->route('task.index');
    }

    public function show(Task $task)
    {
        $task = $this->taskService->show($task);
        return View('task.show')->with('task', $task);
    }

    public function edit(Task $task)
    {
        $this->taskService->authorize($task->id);
        return View('task.edit')->with('task', $task);
    }

    public function update(Task $task, UpdateTaskRequest $request)
    {
        $this->taskService->update($task, $request->validated());
        return redirect()->route('task.index');
    }

    public function delete(Task $task)
    {
        $task = $this->taskService->delete($task);
        return View('task.delete')->with('task', $task);
    }

    public function destroy(Task $task)
    {
        $this->taskService->destroy($task);
        return redirect()->route('task.index');
    }

    public function complete(Task $task)
    {
        $this->taskService->complete($task);
        return back();
    }
}
