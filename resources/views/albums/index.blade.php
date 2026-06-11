@extends('layouts.app')

@section('title', 'Álbumes')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>Álbumes</h1>

        @auth
            <a
                href="{{ route('albums.create') }}"
                class="btn btn-dark"
            >
                Nuevo álbum
            </a>
        @endauth

    </div>

    <div class="row">

        @forelse($albums as $album)

            <div class="col-md-4 mb-4">

                <div class="card h-100">

                    @if($album->cover_url)

                        <img
                            src="{{ $album->cover_url }}"
                            class="card-img-top"
                            alt="{{ $album->title }}"
                        >

                    @endif

                    <div class="card-body">

                        <h5 class="card-title">
                            {{ $album->title }}
                        </h5>

                        @if($album->is_private)

                            <span class="badge bg-warning text-dark">
                                Privado
                            </span>

                        @endif

                        <p class="text-muted mt-2">
                            {{ Str::limit($album->description, 100) }}
                        </p>

                        <a
                            href="{{ route('albums.show', $album) }}"
                            class="btn btn-outline-dark"
                        >
                            Ver álbum
                        </a>

                    </div>

                </div>

            </div>

        @empty

            <p>No hay álbumes.</p>

        @endforelse

    </div>

</div>

@endsection