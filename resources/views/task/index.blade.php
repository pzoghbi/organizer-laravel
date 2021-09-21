@extends('layouts.app')
@section('content')
    @foreach($tasks as $task)
        <div class="row">
            {{ $task->id }}
            {{ $task->details }}
            {{ $task->subject }}
            {{ $task->type }}
            {{ $task->date }}
            {{ $task->time }}

            <a href="{{ route('task.edit', $task) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('task.delete', $task) }}" class="btn btn-danger">Delete</a>
        </div>
    @endforeach
@endsection
