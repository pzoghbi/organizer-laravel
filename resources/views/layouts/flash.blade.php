@if (session('message'))
    <div class="alert alert-success">
        <ul class="list-unstyled mb-0">
            <li>{{ session('message') }}</li>
        </ul>
    </div>
@elseif (session('error'))
    <div class="alert alert-danger">
        <ul class="list-unstyled mb-0">
            <li>{{ session('error') }}</li>
        </ul>
    </div>
@endif
