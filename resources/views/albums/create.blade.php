@extends('layouts.app')

@section('title', 'Crear álbum')

@section('content')

<div class="container py-4">

    <h1>Crear álbum</h1>

    <form method="POST" action="{{ route('albums.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Título --}}
        <div class="mb-3">
            <label>Título</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
        </div>

        {{-- Descripción --}}
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <hr>

        {{-- Privacidad --}}
        <div class="form-check mb-3">

            <input
                class="form-check-input"
                type="checkbox"
                id="isPrivate"
                name="is_private"
            >

            <label class="form-check-label" for="isPrivate">
                Álbum privado
            </label>

        </div>

        <div id="passwordContainer" class="mb-3 d-none">

            <label class="form-label">Contraseña</label>

            <input
                type="password"
                name="password"
                class="form-control"
            >

        </div>

        <hr>

        {{-- Cover opcional al crear --}}
        <h4>Cover del álbum (opcional)</h4>

        {{-- 1. Upload manual --}}
        <div class="mb-3">
            <label>Subir portada</label>
            <input type="file" name="cover_image" class="form-control">
            <div class="form-text">
                Podés asignarla luego en edición o elegirla desde fotos.
            </div>
        </div>

        <hr>

        <button class="btn btn-dark">
            Crear álbum
        </button>

    </form>

</div>

{{-- JS privacidad --}}
<script>
const isPrivate = document.getElementById('isPrivate');
const passwordContainer = document.getElementById('passwordContainer');

isPrivate.addEventListener('change', () => {
    passwordContainer.classList.toggle('d-none', !isPrivate.checked);
});
</script>

@endsection