@extends('layouts.app')
@section('content')
    <h2 class="h2">Are you sure you want to delete?</h2>
    <form action="{{ route('task.destroy', $task) }}" method="post">
        @csrf
        @method('DELETE')
        <p>{{ substr($task->details, 0, 64) . '...' }}</p>

        <button class="btn btn-danger" type="submit">Delete</button>
    </form>
@endsection
