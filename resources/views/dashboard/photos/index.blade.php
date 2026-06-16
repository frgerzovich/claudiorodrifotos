@extends('layouts.app')

@section('title', 'Galería')

@section('content')

<div class="container py-4">
<a
        href="{{ route('dashboard') }}"
        class="btn btn-outline-dark btn-sm mb-4"
    >
        ← Volver
    </a>
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h2 fw-bold mb-0">
            Galería
        </h1>

    </div>


    @auth

        <form
            action="{{ route('photos.bulk-delete') }}"
            method="POST"
        >

            @csrf
            @method('DELETE')


            <div class="d-flex align-items-center gap-3 mb-4">

                <div class="form-check">

                    <input
                        type="checkbox"
                        class="form-check-input"
                        id="selectAll"
                    >

                    <label
                        class="form-check-label"
                        for="selectAll"
                    >
                        Seleccionar todas
                    </label>

                </div>


                <button
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('¿Eliminar fotos seleccionadas?')"
                >
                    Eliminar seleccionadas
                </button>

            </div>

    @endauth


            <div class="row g-4">

                @forelse($photos as $photo)

                    <div class="col-md-3">

                        <div class="card h-100 shadow-sm border-0 overflow-hidden">


                            @auth

                                @if(auth()->user()->canManagePhoto($photo))

                                    <div class="card-header bg-white border-0">

                                        <input
                                            type="checkbox"
                                            name="photos[]"
                                            value="{{ $photo->id }}"
                                            class="photo-checkbox"
                                        >

                                    </div>

                                @endif

                            @endauth


                            <img
                                src="{{ asset('storage/' . $photo->file_path) }}"
                                class="card-img-top"
                                alt="{{ $photo->title }}"
                            >


                            <div class="card-body d-flex flex-column">

                                <h5 class="fw-bold mb-2">
                                    {{ $photo->title }}
                                </h5>


                                <p class="text-muted small">
                                    {{ Str::limit($photo->description, 80) }}
                                </p>


                                <div class="mt-auto">

                                    <a
                                        href="{{ route('photos.show', $photo) }}"
                                        class="btn btn-outline-dark w-100"
                                    >
                                        Ver foto
                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>


                @empty

                    <p>
                        No hay fotos cargadas.
                    </p>

                @endforelse


            </div>


    @auth

        </form>

    @endauth


</div>


<script>

document
    .getElementById('selectAll')
    ?.addEventListener('change', function () {

        document
            .querySelectorAll('.photo-checkbox')
            .forEach(checkbox => {

                checkbox.checked = this.checked;

            });

    });

</script>


@endsection