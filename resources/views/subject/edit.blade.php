<form action="{{ route('subject.update', $subject) }}" method="post">
    @method('PUT')
    @csrf

    <div class="row">
        <label for="name">Name</label>
        <input type="text" name="name" id="subject-name" value="{{ $subject->name }}" />
    </div>

    <div class="row">
        <label for="color">Color</label>
        <input type="color" name="color" id="subject-color" value="{{ $subject->color }}"/>
    </div>

    <button class="btn btn-primary">Update</button>
</form>
