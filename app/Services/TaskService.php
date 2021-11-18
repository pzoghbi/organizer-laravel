<?php


namespace App\Services;


use App\Models\Subject;
use App\Models\Task;
use App\Notifications\TaskReminder;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TaskService
{
    public function index($query)
    {
        /* Todo filter tasks - how many to show, from - to date, by subject,
        by name, by any text inside, past due, only past due, inactive, active, etc */

        // contains, each

        $tasks = Task::where('user_id', auth()->id())
            ->where('datetime', '>=', date('Y-m-d H:i:s', strtotime('today')))
            ->orderBy('datetime')
            ->get();

        switch ($query) {
            case 1:
                $tasks = $tasks->filter(function ($task) {
                    return date('W', strtotime($task->datetime)) == date('W', strtotime('this week'));
                });
                break;
            case 2:
                $tasks = $tasks->filter(function ($task) {
                    return date('W', strtotime($task->datetime)) == date('W', strtotime('+1 week'));
                });
                break;
            case 3:
                $tasks = $tasks->filter(function ($task) {
                    return date('W', strtotime($task->datetime)) >= date('W', strtotime('this week'));
                });
                break;
            default:
                return $this->index(1);
        }

        return $tasks;
    }

    public function show($task)
    {
        $this->authorize($task->id);
        $task->subject_name = Subject::find($task->subject_id)->pluck('name')->first();
        return $task;
    }

    public function store($data)
    {
        $user = auth()->user();
        $task = new Task();
        $task->user_id = $user->id;
        $task->title = $data['title'];
        $task->details = $data['details'];
        $task->subject_id = $data['subject_id'];
        $task->type = $data['type'];
        $task->datetime = $data['datetime'];
        $task->save();

        // Reminders //
        $timezone = $user->timezone;

        $reminders = [
            '-1 hour',
            '-1 day',
            '-2 days'
        ];

        // Reminder TODO check if the time has passed, and only then apply the job
        foreach ($reminders as $reminder) {
            if (date_diff(date_create(), date_create())) {
                $user->notify((new TaskReminder($task))
                    ->delay(date_create($task->datetime . $reminder, new DateTimeZone($timezone))));
            }
        }
    }

    public function update($task, $data)
    {
        $this->authorize($task->id);

        $task->title = $data['title'];
        $task->details = $data['details'];
        $task->subject_id = $data['subject_id'];
        $task->type = $data['type'];
        $task->datetime = $data['datetime'];
        $task->update();
    }

    public function delete($task)
    {
        $this->authorize($task->id);
        return $task;
    }

    public function destroy($task)
    {
        $this->authorize($task->id);
        Task::destroy($task->id);
    }

    public function complete($task)
    {
        $this->authorize($task->id);
        $task->active = !$task->active;
        $task->save();
    }

    public function authorize($task_id)
    {
        $tasks = Task::where('user_id', auth()->id())->pluck('id')->toArray();
        abort_unless(in_array($task_id, $tasks), 403);
    }
}
