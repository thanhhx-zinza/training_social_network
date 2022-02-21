<div class="row navbar navbar-expand-lg navbar-light bg-light w-100 px-2">
    <div class="col-3 d-flex">
        <a class="navbar-brand" href="#">SC</a>
        <form>
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        </form>
    </div>
    <div class="col-6">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">
                    <i class="fa fa-home" aria-hidden="true"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fa fa-television" aria-hidden="true"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Dropdown
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled">Disabled</a>
            </li>
        </ul>
    </div>
    <div class="col-3">
        <span>Hello world / </span>
        <span>
            <a href="{{ route('auth.logout') }}">Logout</a>
        </span>
    </div>
</div>
