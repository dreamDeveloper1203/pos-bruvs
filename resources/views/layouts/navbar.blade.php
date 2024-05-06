<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid">
        {{-- <button class="navbar-toggler d-block border-0 shadow-none" href="#" id="menu-toggle" type="button">
            <span class="navbar-toggler-icon"></span>
        </button> --}}
        <button class="navbar-toggler d-block border-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <span class="navbar-toggler-icon"></span>
          </button>
        <div class="d-flex">
            <a class="nav-link px-0 d-md-none d-block" href="#" id="navbarDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('images/webp/user.webp') }}" height="35" alt="user" class="me-1">
            </a>
            <ul class="dropdown-menu dropdown-menu-end animate slideIn shadow-sm" aria-labelledby="navbarDropdown">
                <li>
                    <a class="dropdown-item py-2" href="{{ route('profile.show') }}">Profile</a>
                </li>
                <li>
                    <a class="dropdown-item py-2" href="{{ route('password.show') }}">Change Password</a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item py-2" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Log Out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('images/webp/user.webp') }}" height="35" alt="user" class="me-1">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end animate slideIn shadow-sm"
                        aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('profile.show') }}">Profile</a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('password.show') }}">Change Password</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form2').submit();">
                                Log Out
                            </a>
                            <form id="logout-form2" action="{{ route('logout') }}" method="POST"
                                class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
