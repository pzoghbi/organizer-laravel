<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Models\Subject;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $tasks = Task::where('user_id', auth()->user()->id)->get();

        return View('task.index')
            ->with('tasks', $tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $subjects = Subject::where('user_id', auth()->user()->id)->get();

        return View('task.create')
            ->with('subjects', $subjects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function store(CreateTaskRequest $request)
    {
        $task = new Task();
        $task->user_id = auth()->user()->id;
        $task->subject_id = $request->input('subject_id');
        $task->details = $request->input('details');
        $task->type = $request->input('type');
        $task->datetime = $request->input('datetime');
        $task->save();

        return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Task $task)
    {
        $my_subjects = Subject::where('user_id', auth()->user()->id)->get();
        $task_types = ['assignment', 'exam', 'reminder'];

        return View('task.edit')
            ->with('task', $task)
            ->with('subjects', $my_subjects)
            ->with('task_types', $task_types);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function update(CreateTaskRequest $request, Task $task)
    {
        $task->details = $request->input('details');
        $task->subject_id = $request->input('subject_id');
        $task->type = $request->input('type');
        $task->datetime = $request->input('datetime');
        $task->update();

        return $this->index();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function delete(Task $task) {
        return View('task.delete')->with('task', $task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        // Check if the task is user's
        $my_tasks = Task::where('user_id', auth()->user()->id)
            ->pluck('id')->toArray();
        abort_unless(in_array($task->id, $my_tasks), 403);

        Task::destroy($task->id);

        return $this->index();
    }
}
