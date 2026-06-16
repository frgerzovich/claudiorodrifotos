@extends('layouts.app')

@section('title', 'Álbum privado')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow-sm border-0">

                <div class="card-body p-4">


                    <h1 class="h3 fw-bold mb-3">
                        Álbum privado
                    </h1>


                    <p class="text-muted mb-4">
                        Este álbum está protegido con contraseña.
                    </p>


                    <form
                        action="{{ route('albums.access', $album) }}"
                        method="POST"
                    >

                        @csrf


                        <div class="mb-3">

                            <label
                                class="form-label"
                                for="password"
                            >
                                Contraseña
                            </label>


                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Ingresá la contraseña"
                            >

                        </div>


                        @error('password')

                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>

                        @enderror


                        <button
                            class="btn btn-dark"
                        >
                            Entrar
                        </button>


                    </form>


                </div>

            </div>

        </div>

    </div>

</div>

@endsection