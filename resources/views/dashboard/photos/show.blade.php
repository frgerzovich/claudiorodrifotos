@extends('layouts.app')

@section('title', $photo->title . ' - ' . $photo->user->name)

@section('content')

<div class="container py-4">


    <a
        href="{{ route('dashboard.photos') }}"
        class="btn btn-outline-dark btn-sm mb-4"
    >
        ← Volver
    </a>



    <div class="row g-5 align-items-start">


        <div class="col-md-7">

            <img
                src="{{ asset('storage/' . $photo->file_path) }}"
                alt="{{ $photo->title }}"
                class="img-fluid rounded shadow-sm"
            >

        </div>



        <div class="col-md-5">


            <h1 class="h2 fw-bold mb-3">
                {{ $photo->title }}
            </h1>


            @if($photo->description)

                <p class="text-muted mb-4">
                    {{ $photo->description }}
                </p>

            @endif



            <div class="card shadow-sm border-0 mb-4">

                <div class="card-body">

                    <p class="text-muted mb-1">
                        Precio
                    </p>

                    <h3 class="fw-bold mb-0">
                        ${{ number_format($photo->price, 0, ',', '.') }}
                    </h3>

                </div>

            </div>



            @auth

                @if(auth()->user()->canManagePhoto($photo))


                    <a
                        href="{{ route('photos.edit', $photo) }}"
                        class="btn btn-outline-dark w-100 mb-2"
                    >
                        Editar foto
                    </a>


                    <form
                        action="{{ route('photos.destroy', $photo) }}"
                        method="POST"
                    >

                        @csrf
                        @method('DELETE')


                        <button
                            class="btn btn-outline-danger w-100"
                            onclick="return confirm('¿Eliminar foto?')"
                        >
                            Eliminar foto
                        </button>


                    </form>


                @else


                    <button
                        class="btn btn-dark w-100"
                    >
                        Agregar al carrito
                    </button>


                @endif


            @else


                <button
                    class="btn btn-dark w-100"
                >
                    Agregar al carrito
                </button>


            @endauth


        </div>


    </div>


</div>

@endsection