@extends('layouts.app')

@section('title', 'Álbumes')

@section('content')

<div class="container py-4">
<a
        href="{{ route('dashboard') }}"
        class="btn btn-outline-dark btn-sm mb-4"
    >
        ← Volver
    </a>
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h2 fw-bold mb-0">
            Álbumes
        </h1>
        

        @auth

            <a
                href="{{ route('albums.create') }}"
                class="btn btn-dark"
            >
                Nuevo álbum
            </a>

        @endauth

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

                            <span  class="badge bg-warning text-dark align-self-start mb-2">
                                Privado
                            </span>

                        @endif


                        <p class="text-muted">
                            {{ Str::limit($album->description, 100) }}
                        </p>


                        <div class="mt-auto">

                            <a
                                href="{{ route('albums.show', $album) }}"
                                class="btn btn-outline-dark btn-sm"
                            >
                                Ver álbum
                            </a>

                        </div>

                    </div>

                </div>

            </div>


        @empty

            <p>
                No hay álbumes.
            </p>

        @endforelse

    </div>

</div>

@endsection