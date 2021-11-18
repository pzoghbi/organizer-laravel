@extends('layouts.app')
@section('content')
    <div class="d-flex mb-3">
        <h1 class="h1 mb-0">Your schedules</h1>
        <a href="{{ route('schedule.create') }}" class="ms-auto btn btn-success h-100 text-white align-self-center">
            New schedule
        </a>
    </div>
    @forelse($schedules as $schedule)
        <div
            class="mb-3 d-flex shadow p-3 rounded-3 {{ $schedule->is_active ? 'border-5 border-start border-success' : '' }}">
            <div class="d-inline-block align-self-center">
                <span class="fw-bold me-3">{{ $schedule->name }}</span>
                <span>{{ date('d M Y', strtotime($schedule->start)) }} - {{ date('d M Y', strtotime($schedule->end)) }}</span>
            </div>

            <div class="ms-auto d-inline-block">
                <a href="{{ route('schedule.edit', $schedule) }}" class="btn btn-warning shadow-sm">Edit</a>
                <form action="{{ route('schedule.destroy', $schedule) }}" method="post" class="d-inline">
                    @csrf
                    @method('delete')
                    <input type="submit" value="Delete" class="btn btn-danger text-white shadow-sm">
                </form>
                <form action="{{ route('schedule.active', $schedule) }}" method="post" class="d-inline">
                    @csrf
                    <input type="submit" value="{{ $schedule->is_active ? 'Deactivate' : 'Activate' }}"
                           class="btn text-white {{ $schedule->is_active ? 'btn-primary' : 'btn-success' }}">
                </form>
            </div>
        </div>
    @empty
        <div class="d-flex">You don't have any schedules.</div>
    @endforelse
@endsection
