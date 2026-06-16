@extends('layouts.app')

@section('title', 'Ingresar')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow-sm border-0">

                <div class="card-body p-4">


                    <h1 class="h3 fw-bold mb-4 text-center">
                        Ingresar
                    </h1>


                    <x-auth-session-status
                        class="mb-3"
                        :status="session('status')"
                    />


                    <form
                        method="POST"
                        action="{{ route('login') }}"
                    >

                        @csrf


                        <div class="mb-3">

                            <label
                                for="email"
                                class="form-label"
                            >
                                Email
                            </label>


                            <input
                                id="email"
                                class="form-control"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                            >


                            <x-input-error
                                :messages="$errors->get('email')"
                                class="mt-2"
                            />

                        </div>


                        <div class="mb-3">

                            <label
                                for="password"
                                class="form-label"
                            >
                                Contraseña
                            </label>


                            <input
                                id="password"
                                class="form-control"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                            >


                            <x-input-error
                                :messages="$errors->get('password')"
                                class="mt-2"
                            />

                        </div>


                        <div class="form-check mb-4">

                            <input
                                id="remember_me"
                                type="checkbox"
                                class="form-check-input"
                                name="remember"
                            >

                            <label
                                for="remember_me"
                                class="form-check-label"
                            >
                                Recordarme
                            </label>

                        </div>


                        <div class="d-flex justify-content-between align-items-center">


                            @if (Route::has('password.request'))

                                <a
                                    href="{{ route('password.request') }}"
                                    class="text-muted small"
                                >
                                    ¿Olvidaste tu contraseña?
                                </a>

                            @endif


                            <button
                                class="btn btn-dark"
                            >
                                Ingresar
                            </button>


                        </div>


                    </form>


                </div>

            </div>

        </div>

    </div>

</div>

@endsection