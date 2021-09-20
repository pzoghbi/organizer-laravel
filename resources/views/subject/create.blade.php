<form action="/subject" method="post">
    @csrf
    <input type="text" name="name" id="subject-name">
    <input type="color" name="color" id="subject-color">
    <button class="btn btn-primary" type="submit">Add</button>
</form>
