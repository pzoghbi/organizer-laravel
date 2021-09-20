@foreach($subjects as $subject)
    <div class="row">
        {{ $subject->id }}
        {{ $subject->name }}
        {{ $subject->color }}

        <a href="{{ route('subject.edit', $subject->id) }}" class="btn btn-warning">Edit</a>
    </div>
@endforeach
