<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">

    <a class="navbar-brand" href="{{ url('/') }}">
        Fotos
    </a>

    <div class="ms-auto d-flex gap-2">

        @auth
            <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">
                Dashboard
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-danger btn-sm">
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                Login
            </a>
        @endauth

    </div>

</nav>