<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Models\Subject;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Get the first 10 tasks that need to be done
        // contains, each
        $tasks = Task::where('user_id', auth()->user()->id)
//            ->where('active', true)
            ->orderBy('datetime')
            ->get()
            ->filter(function ($task) {
                return date('W', strtotime($task->datetime)) > date('W', strtotime('-1 week'));
            }); // filters tasks that are past due (optional TODO make this an option)

        $this_week = $tasks->filter(function ($task) {
            return date('W', strtotime($task->datetime)) == date('W', strtotime('this week'));
        });

        $two_weeks = $tasks->filter(function ($task) {
            return date('W', strtotime($task->datetime)) <= date('W', strtotime('+1 week'));
        });

        // Cut the second 5 tasks (after 5th index)
//        $tasks_next = $tasks->splice(10);

        // take, [splice], takeWhile, forPage

        $subjects = Subject::where('user_id', auth()->user()->id)->pluck('name', 'id')->all();
        return View('task.index')
            ->with('this_week', $this_week)
            ->with('two_weeks', $two_weeks)
            ->with('tasks', $tasks)
            ->with('subjects', $subjects);
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateTaskRequest $request)
    {
        $task = new Task();
        $task->user_id = auth()->user()->id;
        $task->title = $request->input('title');
        $task->details = $request->input('details');
        $task->subject_id = $request->input('subject_id');
        $task->type = $request->input('type');
        $task->datetime = $request->input('datetime');
        $task->save();

        return redirect()->route('task.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Task $task)
    {
        // Get subject name
        $task->subject_name = Subject::find($task->subject_id)->pluck('name')->first();

        return View('task.show')
            ->with('task', $task);
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CreateTaskRequest $request, Task $task)
    {
        $task->title = $request->input('title');
        $task->details = $request->input('details');
        $task->subject_id = $request->input('subject_id');
        $task->type = $request->input('type');
        $task->datetime = $request->input('datetime');
        $task->update();

        return redirect()->route('task.index');
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Task $task)
    {
        // Check if the task is the user's
        $my_tasks = Task::where('user_id', auth()->user()->id)
            ->pluck('id')->toArray();
        abort_unless(in_array($task->id, $my_tasks), 403);

        Task::destroy($task->id);

        return redirect()->route('task.index');
    }

    public function complete(Task $task)
    {
        $task = Task::where('user_id', auth()->user()->id)
            ->where('id', $task->id)->firstOrFail();

        $task->active = !$task->active;
        $task->save();

        return back();
    }
}
