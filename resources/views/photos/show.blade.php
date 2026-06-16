@extends('layouts.app')

@section('title', $photo->title)

@section('content')

<div class="container py-4">


    <a
        href="{{ url()->previous() }}"
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



            <form
                action="#"
                method="POST"
            >

                @csrf


                <button
                    class="btn btn-dark w-100"
                >
                    Agregar al carrito
                </button>


            </form>



        </div>


    </div>


</div>


@endsection