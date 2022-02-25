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
        @if (Auth::user() != null)
            <span></span>
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->email }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('settings.index') }}">Settings</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('auth.logout') }}">Logout</a>
                    </li>
                </ul>
            </div>
        @else
            <span>Hello world</span>
        @endif
    </div>
</div>
