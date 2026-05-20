@extends('layouts.app')

@section('title', 'Subir foto')

@section('content')

<div class="container py-4">

    <h1 class="mb-4">
        Subir foto
    </h1>

    <form
        action="{{ route('photos.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf

        <div class="mb-3">

            <label class="form-label">Título</label>

            <input
                type="text"
                name="title"
                class="form-control"
                value="{{ old('title') }}"
            >

        </div>
@if($errors->any())

    <div class="alert alert-danger">

        <ul class="mb-0">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif
        <div class="mb-3">

            <label class="form-label">Descripción</label>

            <textarea
                name="description"
                class="form-control"
            >{{ old('description') }}</textarea>

        </div>

        <div class="mb-3">

            <label class="form-label">Precio</label>

            <input
                type="number"
                step="0.01"
                name="price"
                class="form-control"
                value="{{ old('price') }}"
            >

        </div>

        <div class="mb-3">

            <label class="form-label">Álbum</label>

            <select name="album_id" class="form-select">

                <option value="">
                    Sin álbum (pública)
                </option>

                @foreach($albums as $album)

                    <option value="{{ $album->id }}">
                        {{ $album->title }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="mb-4">

            <label class="form-label">Imagen</label>

            <input
                type="file"
                name="image"
                class="form-control"
            >

        </div>

        <button class="btn btn-dark">
            Subir foto
        </button>

    </form>

</div>

@endsection