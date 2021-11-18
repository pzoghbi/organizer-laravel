<nav class="navbar navbar-expand-lg position-relative shadow container-fluid d-flex bg-light">
    <div class="d-flex position-relative start-0 top-0 w-auto collapse" style="z-index: 1;">
        <a class="navbar-brand text-reset fw-bolder text-uppercase border border-1 p-1 rounded"
           href="{{ route('home') }}">Task<i class="bi bi-shield-fill mx-1 fs-4"></i>Titan</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>

    <div class="collapse navbar-collapse justify-content-center position-absolute w-100" id="navbarSupportedContent">
        <div class="navbar-nav mb-2 mb-lg-0 d-flex fs-2">

            <a class="link-secondary rounded-1 px-4 bg-opacity-25 {{ request()->is('/') ? 'bg-secondary' : '' }}"
               aria-current="page" href="{{ route('home') }}">
                <i class="bi bi-house"></i>
            </a>

            <a class="link-secondary rounded-1 px-4 bg-opacity-25 {{ request()->is('schedule*') ? 'bg-secondary' : ''}}"
               href="{{ route('schedule.index') }}">
                <i class="bi bi-calendar-week"></i>
            </a>

            <a class="link-secondary rounded-1 px-4 bg-opacity-25 {{ request()->is('task*') ? 'bg-secondary' : ''}}"
               href="{{ route('task.index') }}">
                <i class="bi bi-check-square"></i>
            </a>

            <a class="link-secondary rounded-1 px-4 bg-opacity-25 {{ request()->is('material*') || request()->is('lecture*') ? 'bg-secondary' : ''}}"
               href="{{ route('material.index') }}">
                <i class="bi bi-folder"></i>
            </a>

            <a class="link-secondary rounded-1 px-4 bg-opacity-25" href="#" title="coming soon">
                <i class="bi bi-book"></i>
            </a>
        </div>
    </div>

    <div class="d-flex w-auto ms-auto collapse">
        <div class="d-inline-block align-middle me-2">
            <form>
                <div class="input-group">
                    <input class="form-control rounded-pill rounded-end" type="search" placeholder="Search"
                           aria-label="Search">
                    <button class="btn btn-success text-white rounded-pill rounded-start" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="nav-item dropdown">
            <button class="btn btn-outline-secondary rounded-circle border-0 bg-dark text-secondary bg-opacity-10"
                    href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-caret-down-fill align-middle"></i>
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow py-0 overflow-hidden mt-2 border-0"
                aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item border-bottom border-light" href="#">Profile</a></li>
                <li><a class="dropdown-item border-bottom border-light" href="#">Settings</a></li>
                <li>
                    <button class="dropdown-item" type="Submit" form="logout-form">Logout</button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
