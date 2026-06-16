@extends('layouts.app')

@section('title', 'Galería')

@section('content')

<div class="container py-4">


    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h2 fw-bold mb-0">
            Galería
        </h1>

    </div>



    <div class="row g-4">


        @forelse($photos as $photo)


            <div class="col-md-3">


                <div class="card h-100 shadow-sm border-0 overflow-hidden">



                    <img
                        src="{{ asset('storage/' . $photo->preview_path) }}"
                        class="card-img-top"
                        alt="{{ $photo->title }}"
                    >



                    <div class="card-body d-flex flex-column">


                        <h5 class="fw-bold mb-2">
                            {{ $photo->title }}
                        </h5>



                        @if($photo->album)

                            <span class="badge bg-light text-dark border mb-2">
                                {{ $photo->album->title }}
                            </span>

                        @endif



                        @if($photo->description)

                            <p class="text-muted small">
                                {{ Str::limit($photo->description, 80) }}
                            </p>

                        @endif



                        <p class="fw-bold mb-3">
                            ${{ number_format($photo->price, 0, ',', '.') }}
                        </p>



                        <div class="mt-auto">


                            <a
                                href="{{ route('photos.show', $photo) }}"
                                class="btn btn-outline-dark w-100 mb-2"
                            >
                                Ver foto
                            </a>


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


            </div>


        @empty


            <p>
                No hay fotos disponibles.
            </p>


        @endforelse



    </div>


</div>


@endsection