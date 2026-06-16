@extends('layouts.app')

@section('title', 'Subir lote')

@section('content')

<div class="container py-4">
<a
        href="{{ route('dashboard') }}"
        class="btn btn-outline-dark btn-sm mb-4"
    >
        ← Volver
    </a>
    <h1 class="h2 fw-bold mb-4">
        Subir varias fotos
    </h1>


    <div class="card shadow-sm border-0">

        <div class="card-body p-4">


            <form
                action="{{ route('photos.bulk-store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                <div class="mb-4">

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



                <div class="mb-4">

                    <label class="form-label">
    Álbum
</label>

<div class="d-flex gap-2">

    <select
        name="album_id"
        id="albumSelect"
        class="form-select"
    >

        <option value="">
            Sin álbum
        </option>

        @foreach($albums as $album)

            <option
                value="{{ $album->id }}"
                @selected($selectedAlbum == $album->id)
            >
                {{ $album->title }}
            </option>

        @endforeach

    </select>


    <button
        type="button"
        class="btn btn-outline-dark text-nowrap"
        data-bs-toggle="modal"
        data-bs-target="#albumModal"
    >
        + Nuevo álbum
    </button>

</div>

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

                    <div class="form-text">
                        Podés seleccionar varias imágenes a la vez.
                    </div>

                </div>



                <button
                    class="btn btn-dark"
                >
                    Subir lote
                </button>


            </form>


        </div>

    </div>

</div>
@include('photos.partials.create-modal')
@endsection