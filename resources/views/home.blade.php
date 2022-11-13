@extends('layouts.app')

@section('content')
    <h1 class="h3 text-secondary mb-3 text-light">{{ __('Overview') }}</h1>

    <div class="row mb-4">
        <!-- ScheduleListItem -->
        <div class="col-lg-8 col-md-12 mb-lg-0 mb-4">
            <div class="card shadow h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="">{{ __('Your schedule') }}</div>
                        @if($schedule)
                            <a class="ms-auto btn-sm text-decoration-none link-secondary"
                               href="{{ route('schedule.edit', $schedule) }}"
                               title="Click here to edit this schedule">
                                <i class="bi bi-pencil-square"></i></a>
                        @endif
                    </div>
                </div>

                <div class="card-body p-0">
                    @if(!$schedule && !auth()->user()->schedules)
                        Looks like you don't have an active schedule!
                        <a class="" href="{{ route('schedule.index') }}">Activate one here.</a>
                    @else
                    <!-- Show the schedule -->
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                <tr class="text-center">
                                    <th class="bg-info bg-opacity-25 bg-gradient" scope="col">Mon</th>
                                    <th class="bg-info bg-opacity-25 bg-gradient" scope="col">Tue</th>
                                    <th class="bg-info bg-opacity-25 bg-gradient" scope="col">Wed</th>
                                    <th class="bg-info bg-opacity-25 bg-gradient" scope="col">Thu</th>
                                    <th class="bg-info bg-opacity-25 bg-gradient" scope="col">Fri</th>
                                    <th class="bg-info bg-opacity-25 bg-gradient" scope="col">Sat</th>
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
                                                                    <a class="p-2 gap-1 h-100 w-100 d-block text-decoration-none rounded-0 border-0 text-start text-dark btn btn-outline-light"
                                                                        href="{{ route('lecture.edit', $lecture) }}">
                                                                        <div class="d-flex">
                                                                            <strong>{{ $lecture->subject->name }}</strong>
                                                                            <strong class="ms-auto" title="Room">{{ $lecture->room }}</strong>
                                                                        </div>
                                                                        <span>{{ date('H:i', strtotime($lecture->start)) }}-{{ date('G:i', strtotime($lecture->end)) }}</span>
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
                    @endif
                </div>
            </div>
        </div>
        <!-- schedule end -->

        <!-- Upcoming tasks start -->
        <div class="col-lg-4 col-md-12">
            <div class="card shadow overflow-hidden h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        {{ __('Upcoming tasks') }}
                        <a class="ms-auto btn-sm text-decoration-none link-secondary"
                           href="{{ route('task.create', $schedule) }}"
                           title="Click here to create a new task">
                            <i class="bi bi-plus-circle"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @foreach($tasks as $task)
                        <a class="p-3 btn btn-outline-light text-start border-0 rounded-0 border-bottom d-block text-reset"
                           href="{{ route('task.show', $task) }}">
                            <div class="card-title">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">{{ $task->title }}</h5>
                                    <span class="small text-primary">{{ $task->subject->name }}</span>
                                </div>
                            </div>

                            <p class="card-text mb-2">{{ \Illuminate\Support\Str::words($task->details, 10, '...') }}</p>

                            <div class="d-flex justify-content-between text-muted">
                                <span class="small">{{ ucfirst($task->type) }}</span>
                                <span
                                    class="small {{ (now() > new DateTime($task->datetime)) ? 'text-danger' : '' }}">
                                    {{ \Carbon\Carbon::parse($task->datetime)->shortRelativeToNowDiffForHumans() }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Upcoming task end -->
    </div>

    <div class="row mb-4">
        <!-- Recent materials start -->
        <div class="col-lg-4 col-md-12 mb-lg-0 mb-4">
            <div class="card shadow overflow-hidden h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <span>{{ __('Recently viewed materials') }}</span>
                        <a class="ms-auto btn-sm text-decoration-none link-secondary"
                           href="{{ route('material.create') }}"
                           title="Click here to create a new task">
                            <i class="bi bi-plus-circle"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @foreach(auth()->user()->recentMaterials() as $material)
                        <a class="p-3 btn btn-outline-light text-start border-0 rounded-0 border-bottom d-block text-reset"
                           href="{{ route('material.show', $material) }}">
                            <div class="card-title">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">{{ \Illuminate\Support\Str::limit($material->name, 26) }}</h5>
                                    <span class="small text-primary">{{ $material->subject->name }}</span>
                                </div>
                            </div>

                            <p class="card-text mb-2">{{ \Illuminate\Support\Str::words($material->details, 10, '...') }}</p>

                            <div class="d-flex justify-content-between text-muted">
                                <div class="d-flex gap-3">
                                    @foreach(auth()->user()->categories()->whereIn('id', explode(",", $material->categories))->take(3)->get() as $category)
                                        <span class="badge bg-light text-opacity-50 text-secondary">{{ $category->name }}</span>
                                    @endforeach
                                </div>
                                <span class="small">
                                    {{ \Carbon\Carbon::parse($material->created_at)->shortRelativeToNowDiffForHumans() }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Recent materials end -->

        <!-- Performance start -->
        <div class="col-lg-8 col-md-12">
            <div class="card shadow overflow-hidden h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <span>{{ __('Your monthly performance') }}</span>
                        <a class="ms-auto btn-sm text-decoration-none link-secondary"
                           href="{{ route('task.create', $schedule) }}"
                           title="Click here to create a new task">
                            <i class="bi bi-plus-circle"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </div>
            </div>
        </div>
        <!-- performance end -->
    </div>
@endsection
