@extends('layouts.app')

@section('title', 'Editar foto')

@section('content')

<div class="container py-4">
<a
    href="{{ route('photos.show', $photo) }}"
    class="btn btn-outline-dark btn-sm mb-4"
>
    ← Volver a la foto
</a>
    <h1 class="h2 fw-bold mb-4">
        Editar foto
    </h1>


    <div class="card shadow-sm border-0">

        <div class="card-body p-4">


            <form
                action="{{ route('photos.update', $photo) }}"
                method="POST"
            >

                @csrf
                @method('PUT')


                <div class="mb-4">

                    <label class="form-label">
                        Título
                    </label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        value="{{ old('title', $photo->title) }}"
                    >

                </div>



                <div class="mb-4">

                    <label class="form-label">
                        Descripción
                    </label>

                    <textarea
                        name="description"
                        class="form-control"
                        rows="4"
                    >{{ old('description', $photo->description) }}</textarea>

                </div>



                <div class="mb-4">

                    <label class="form-label">
                        Precio
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="price"
                        class="form-control"
                        value="{{ old('price', $photo->price) }}"
                    >

                </div>



                <div class="mb-4">

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

                            <option
                                value="{{ $album->id }}"
                                @selected($photo->album_id == $album->id)
                            >
                                {{ $album->title }}
                            </option>

                        @endforeach


                    </select>

                </div>



                <button
                    class="btn btn-dark"
                >
                    Guardar cambios
                </button>


            </form>


        </div>

    </div>

</div>

@endsection