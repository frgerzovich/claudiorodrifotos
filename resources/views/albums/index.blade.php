@extends('layouts.app')

@section('title', 'Álbumes')

@section('content')

<div class="container py-4">

    <div class="mb-4">

        <h1 class="h2 fw-bold mb-2">
            Galería
        </h1>

        <p class="text-muted mb-0">
            Explorá nuestros álbumes.
        </p>

    </div>


    <div class="row g-3">

        @forelse($albums as $album)

            <div class="col-md-4">

                <div class="card h-100 shadow-sm border-0 overflow-hidden">


                    @if($album->cover_url)

                        <img
                            src="{{ $album->cover_url }}"
                            class="card-img-top"
                            alt="{{ $album->title }}"
                        >

                    @endif


                    <div class="card-body d-flex flex-column">


                        <h5 class="fw-bold mb-2">
                            {{ $album->title }}
                        </h5>


                        @if($album->is_private)

                            <span class="badge bg-warning text-dark align-self-start mb-2">
                                Acceso protegido
                            </span>

                        @endif


                        @if($album->description)

                            <p class="text-muted">
                                {{ Str::limit($album->description, 100) }}
                            </p>

                        @endif


                        <div class="mt-auto">

                            <a
                                href="{{ route('albums.show', $album) }}"
                                class="btn btn-outline-dark btn-sm w-100"
                            >
                                Ver álbum
                            </a>

                        </div>


                    </div>

                </div>

            </div>


        @empty

            <p>
                No hay álbumes disponibles.
            </p>


        @endforelse

    </div>

</div>

@endsection