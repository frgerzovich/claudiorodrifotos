@extends('layouts.app')

@section('title', 'Álbum privado')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card">

                <div class="card-body">

                    <h1 class="h4 mb-4">
                        Álbum privado
                    </h1>

                    <p>
                        Este álbum está protegido por contraseña.
                    </p>

                    <form
                        action="{{ route('albums.access', $album) }}"
                        method="POST"
                    >

                        @csrf

                        <input
                            type="password"
                            name="password"
                            class="form-control mb-3"
                            placeholder="Contraseña"
                        >

                        @error('password')

                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>

                        @enderror

                        <button class="btn btn-dark">
                            Entrar
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection