<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 py-3">

    <div class="container-fluid">

        <a
            class="navbar-brand fw-bold"
            href="{{ url('/') }}"
        >
            Fotos
        </a>


        <div class="d-flex align-items-center gap-2">

            @auth

                <a
                    href="{{ route('dashboard') }}"
                    class="btn btn-outline-light btn-sm"
                >
                    Panel
                </a>


                <form
                    method="POST"
                    action="{{ route('logout') }}"
                    class="m-0"
                >
                    @csrf

                    <button
                        class="btn btn-danger btn-sm"
                    >
                        Salir
                    </button>

                </form>


            @else

                <a
                    href="{{ route('login') }}"
                    class="btn btn-outline-light btn-sm"
                >
                    Entrar
                </a>

            @endauth

        </div>

    </div>

</nav>