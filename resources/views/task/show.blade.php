@extends('layouts.app')
@section('content')
    <h3 class="h3">{{ $task->title }}</h3>
    <p>{{ $task->details }}</p>
    <p class="fs-3 mb-0">{{ date_format(date_create($task->datetime), 'H:i') }}</p>
    <p>{{ date_format(date_create($task->datetime), 'd-m-y') }}</p>
    <p class="custom-control-label">{{ $task->subject_name }}</p>
    <p>{{ $task->active ? 'Active': 'Completed' }}</p>

    <div class="col-4">
        <a href="{{ route('task.show', $task) }}" class="btn btn-primary">Show</a>
        <a href="{{ route('task.edit', $task) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('task.delete', $task) }}" class="btn btn-danger">Delete</a>
        <form id="complete-task-{{ $task->id }}" class="d-inline" action="{{ route('task.complete', $task) }}"
              method="post">@csrf @method('PATCH')
            <input class="btn btn-success text-white" type="submit" value="Complete"
                   form="complete-task-{{ $task->id }}">
        </form>
    </div>
@endsection
