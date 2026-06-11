@extends('layouts.app')

@section('title', 'Editar álbum')
@section('content')

<div class="container py-4">

    <h1>Editar álbum</h1>

    <form method="POST" action="{{ route('albums.update', $album) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Título --}}
        <div class="mb-3">
            <label>Título</label>
            <input type="text" name="title" value="{{ $album->title }}" class="form-control">
        </div>

        {{-- Descripción --}}
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="description" class="form-control">{{ $album->description }}</textarea>
        </div>

        <hr>
        <div class="form-check mb-3">

    <input
        class="form-check-input"
        type="checkbox"
        id="isPrivate"
        name="is_private"
        @checked($album->is_private)
    >

    <label class="form-check-label" for="isPrivate">
        Álbum privado
    </label>

</div>

<div id="passwordContainer" class="mb-3 {{ $album->is_private ? '' : 'd-none' }}">

    <label class="form-label">Contraseña</label>

    <input
        type="password"
        name="password"
        class="form-control"
        value="{{ $album->password }}"
    >

</div>
<hr>

        <h4>Cover del álbum</h4>

        {{-- 1. Upload manual --}}
        <div class="mb-3">
            <label>Subir nueva portada</label>
            <input type="file" name="cover_image" class="form-control">
        </div>

        <hr>

        {{-- 2. Elegir desde fotos --}}
        <div class="mb-3">

            <label class="mb-2">O elegir desde fotos del álbum</label>

            <div class="row g-2">

                @foreach($album->photos as $photo)

                    <div class="col-3">

                        <label class="d-block border p-2">

                            <input
                                type="radio"
                                name="cover_photo_id"
                                value="{{ $photo->id }}"
                            >

                            <img
                                src="{{ asset('storage/' . $photo->preview_path) }}"
                                class="img-fluid"
                            >

                        </label>

                    </div>

                @endforeach

            </div>

        </div>

        <button class="btn btn-dark">
            Guardar cambios
        </button>

    </form>

</div>

<script>
const isPrivate = document.getElementById('isPrivate');
const passwordContainer = document.getElementById('passwordContainer');

isPrivate.addEventListener('change', () => {
    passwordContainer.classList.toggle('d-none', !isPrivate.checked);
});
</script>
@endsection