@extends('layouts.app')

@section('title', 'Subir lote')

@section('content')

<div class="container py-4">

    <h1>
        Subir varias fotos
    </h1>

    <form
        action="{{ route('photos.bulk-store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        <div class="mb-3">

            <label class="form-label">
                Precio
            </label>

            <input
                type="number"
                step="0.01"
                name="price"
                class="form-control"
            >

        </div>

        <div class="mb-3">

            <label class="form-label">
                Álbum
            </label>

            <select
                name="album_id"
                class="form-select"
            >

                <option value="">
                    Sin álbum
                </option>

                @foreach($albums as $album)

                    <option  value="{{ $album->id }}"
            @selected($selectedAlbum == $album->id)>
                        {{ $album->title }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="mb-4">

            <label class="form-label">
                Fotos
            </label>

            <input
                type="file"
                name="images[]"
                multiple
                class="form-control"
            >

        </div>

        <button class="btn btn-dark">
            Subir lote
        </button>

    </form>

</div>

@endsection