@extends('layouts.app')
@section('content')
    @include('layouts.errors')
    <h2 class="h2 text-center">{{ $schedule->name }}</h2>

    <div class="d-flex mb-3">
        <span class="align-self-center">{{ date('d.m.Y', strtotime($schedule->start)) }}
            - {{ date('d.m.Y', strtotime($schedule->end)) }}</span>
        <a href="{{ route('schedule.edit', $schedule) }}"
           class="btn btn-outline-warning ms-auto border border-dark text-dark">Edit</a>
    </div>

    <div class="table-responsive">
        <table class="table table-borderless mb-5">
            <thead>
            <tr class="text-center">
                <th class="bg-danger bg-gradient text-white border-bottom-0" scope="col">Monday</th>
                <th class="bg-warning bg-gradient text-dark border-bottom-0" scope="col">Tuesday</th>
                <th class="bg-success bg-gradient text-dark border-bottom-0" scope="col">Wednesday</th>
                <th class="bg-info bg-gradient text-dark border-bottom-0" scope="col">Thursday</th>
                <th class="bg-primary bg-gradient text-white border-bottom-0" scope="col">Friday</th>
                <th class="bg-dark bg-gradient text-white border-bottom-0" scope="col">Saturday</th>
            </tr>
            </thead>
            <tbody class="schedule">
            <tr>
                @for($i = 0; $i < 6; $i++)
                    <td class="p-0">
                        <table class="table table-bordered mb-0">
                            @foreach($schedule->groupLectures() as $key => $lecture_group)
                                @if($i == $key)
                                    @foreach($lecture_group as $lecture)
                                        <tr>
                                            <td class="p-0">
                                                <a class="p-2 gap-1 h-100 w-100 d-block text-decoration-none rounded-0 border-0 text-start text-dark btn btn-outline-info"
                                                   href="{{ route('lecture.edit', $lecture) }}">
                                                    <div class="d-flex">
                                                        <strong>{{ $lecture->subject->name }}</strong>
                                                        <strong class="ms-auto"
                                                                title="Room">{{ $lecture->room }}</strong>
                                                    </div>
                                                    <span>{{ date('H:i', strtotime($lecture->start)) }} - {{ date('H:i', strtotime($lecture->end)) }}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        </table>
                    </td>
                @endfor
            </tr>
            </tbody>
        </table>
    </div>

    <div class="d-flex">
        <a href="{{ route('schedule.index') }}" class="btn btn-secondary ms-auto">Back</a>
    </div>
@endsection
