@foreach($subjects as $subject)
    <div class="row">
        {{ $subject->id }}
        {{ $subject->name }}
        {{ $subject->color }}

        <a href="{{ route('subject.edit', $subject->id) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('subject.destroy', $subject) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
@endforeach
