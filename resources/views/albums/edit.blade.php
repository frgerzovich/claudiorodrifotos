@extends('layouts.app')

@section('title', 'Editar álbum')

@section('content')

<div class="container py-4">
<a
        href="{{ route('dashboard') }}"
        class="btn btn-outline-dark btn-sm mb-4"
    >
        ← Volver
    </a>
    <h1 class="h2 fw-bold mb-4">
        Editar álbum
    </h1>


    <div class="card shadow-sm border-0">

        <div class="card-body p-4">


            <form
                method="POST"
                action="{{ route('albums.update', $album) }}"
                enctype="multipart/form-data"
            >

                @csrf
                @method('PUT')


                <div class="mb-3">

                    <label class="form-label">
                        Título
                    </label>

                    <input
                        type="text"
                        name="title"
                        value="{{ $album->title }}"
                        class="form-control"
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
                    >{{ $album->description }}</textarea>

                </div>



                <div class="form-check mb-3">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="isPrivate"
                        name="is_private"
                        @checked($album->is_private)
                    >

                    <label
                        class="form-check-label"
                        for="isPrivate"
                    >
                        Álbum privado
                    </label>

                </div>



                <div
                    id="passwordContainer"
                    class="mb-4 {{ $album->is_private ? '' : 'd-none' }}"
                >

                    <label class="form-label">
                        Contraseña
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        value="{{ $album->password }}"
                    >

                </div>



                <h5 class="fw-bold mb-3">
                    Portada del álbum
                </h5>


                <div class="mb-4">

                    <label class="form-label">
                        Subir nueva portada
                    </label>

                    <input
                        type="file"
                        name="cover_image"
                        class="form-control"
                    >

                </div>



                <div class="mb-4">

                    <label class="form-label mb-3">
                        Elegir portada desde fotos del álbum
                    </label>


                    <div class="row g-3">

                        @foreach($album->photos as $photo)

                            <div class="col-md-3">

                                <label
                                    class="card h-100 shadow-sm border-0 p-2"
                                >

                                    <input
                                        type="radio"
                                        name="cover_photo_id"
                                        value="{{ $photo->id }}"
                                        class="form-check-input mb-2"
                                        @checked($album->cover_photo_id === $photo->id)
                                    >


                                    <img
                                        src="{{ asset('storage/' . $photo->preview_path) }}"
                                        class="img-fluid rounded"
                                        alt="{{ $photo->title }}"
                                    >

                                </label>

                            </div>

                        @endforeach

                    </div>

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


<script>

const isPrivate = document.getElementById('isPrivate');
const passwordContainer = document.getElementById('passwordContainer');


isPrivate.addEventListener('change', () => {

    passwordContainer.classList.toggle(
        'd-none',
        !isPrivate.checked
    );

});

</script>

@endsection