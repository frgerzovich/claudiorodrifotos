@extends('layouts.app')

@section('title', $album->title)

@section('content')

<div class="container py-4">

    <div class="mb-4">

        <h1>
            {{ $album->title }}

            @if($album->is_private)
                <span class="badge bg-warning text-dark">
                    Privado
                </span>
            @endif

        </h1>

        @if($album->description)

            <p class="text-muted">
                {{ $album->description }}
            </p>

        @endif

    </div>

    @auth

        @if(
            auth()->id() === $album->user_id
            || auth()->user()->role === \App\Enums\UserRole::ADMIN
        )

            <div class="mb-4">

                <a
                    href="{{ route('albums.edit', $album) }}"
                    class="btn btn-outline-primary"
                >
                    Editar álbum
                </a>

                <form
        action="{{ route('albums.destroy', $album) }}"
        method="POST"
        class="d-inline"
    >
        @csrf
        @method('DELETE')
    
        <button
            class="btn btn-danger"
            onclick="return confirm('¿Eliminar álbum?')"
        >
            Eliminar álbum
        </button>
    
    </form>
            </div>
            <a
    href="{{ route('photos.create', [
        'album' => $album->id
    ]) }}"
    class="btn btn-dark"
>
    Agregar una foto
</a>
 <a
    href="{{ route('photos.bulk-create', [
        'album' => $album->id
    ]) }}"
    class="btn btn-dark"
>
    Agregar fotos
</a>

        @endif

    @endauth

    <div class="row">

        @forelse($album->photos as $photo)

            <div class="col-md-3 mb-4">

                <div class="card h-100">

                    <img
                        src="{{ asset('storage/' . $photo->preview_path) }}"
                        class="card-img-top"
                        alt="{{ $photo->title }}"
                    >

                    <div class="card-body">

                        <h6>
                            {{ $photo->title }}
                        </h6>

                        <p>
                            ${{ number_format($photo->price, 2) }}
                        </p>

                        <a
                            href="{{ route('photos.show', $photo) }}"
                            class="btn btn-sm btn-outline-dark"
                        >
                            Ver foto
                        </a>

                    </div>

                </div>

            </div>

        @empty

            <p>
                Este álbum todavía no tiene fotos.
            </p>

        @endforelse

    </div>

</div>

@endsection