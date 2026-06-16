@extends('layouts.app')

@section('title', 'Crear álbum')

@section('content')

<div class="container py-4">
<a
        href="{{ route('dashboard') }}"
        class="btn btn-outline-dark btn-sm mb-4"
    >
        ← Volver
    </a>
    <h1 class="h2 fw-bold mb-4">
        Crear álbum
    </h1>


    <div class="card shadow-sm border-0">

        <div class="card-body p-4">


            <form
                method="POST"
                action="{{ route('albums.store') }}"
                enctype="multipart/form-data"
            >

                @csrf


                <div class="mb-3">

                    <label
                        class="form-label"
                    >
                        Título
                    </label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        value="{{ old('title') }}"
                    >

                </div>


                <div class="mb-4">

                    <label
                        class="form-label"
                    >
                        Descripción
                    </label>

                    <textarea
                        name="description"
                        class="form-control"
                        rows="4"
                    >{{ old('description') }}</textarea>

                </div>



                <div class="form-check mb-3">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="isPrivate"
                        name="is_private"
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
                    class="mb-4 d-none"
                >

                    <label class="form-label">
                        Contraseña
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                    >

                </div>



                <h5 class="fw-bold mb-3">
                    Portada del álbum
                </h5>


                <div class="mb-4">

                    <label class="form-label">
                        Subir portada (opcional)
                    </label>

                    <input
                        type="file"
                        name="cover_image"
                        class="form-control"
                    >

                    <div class="form-text">
                        Podés asignarla luego desde la edición del álbum.
                    </div>

                </div>



                <button
                    class="btn btn-dark"
                >
                    Crear álbum
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