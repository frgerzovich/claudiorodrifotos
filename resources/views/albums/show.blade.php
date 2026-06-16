@extends('layouts.app')

@section('title', $album->title)

@section('content')

<div class="container py-4">

<a
    href="{{ route('dashboard') }}"
    class="btn btn-outline-dark btn-sm mb-4"
>
    ← Volver
</a>
    <div class="mb-4">

        <div class="d-flex align-items-center gap-2 mb-2">

            <h1 class="h2 fw-bold mb-0">
                {{ $album->title }}
            </h1>


            @if($album->is_private)

                <span class="badge bg-warning text-dark">
                    Privado
                </span>

            @endif

        </div>


        @if($album->description)

            <p class="text-muted mb-0">
                {{ $album->description }}
            </p>

        @endif

    </div>



    @auth

        @if(auth()->user()->canManageAlbum($album))


            <div class="d-flex flex-wrap gap-2 mb-4">


                <a
                    href="{{ route('albums.edit', $album) }}"
                    class="btn btn-outline-dark"
                >
                    Editar álbum
                </a>


                <form
                  form  action="{{ route('albums.destroy', $album) }}"
                    method="POST"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        class="btn btn-outline-danger"
                        onclick="return confirm('¿Eliminar álbum?')"
                    >
                        Eliminar álbum
                    </button>

                </form>


                <a
                    href="{{ route('photos.create', ['album' => $album->id]) }}"
                    class="btn btn-dark"
                >
                    Agregar una foto
                </a>


                <a
                    href="{{ route('photos.bulk-create', ['album' => $album->id]) }}"
                    class="btn btn-outline-dark"
                >
                    Agregar fotos
                </a>


            </div>


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



    <div
        id="bulkActions"
        class="d-none d-flex gap-2"
    >


        <form
            action="{{ route('photos.bulk-delete') }}"
            method="POST"
        >

            @csrf
            @method('DELETE')


            <div id="deleteInputs"></div>


            <button
                class="btn btn-danger btn-sm"
                onclick="return confirm('¿Eliminar fotos seleccionadas?')"
            >
                Eliminar seleccionadas
            </button>


        </form>



        <form
            action="{{ route('photos.bulk-move') }}"
            method="POST"
            class="d-flex gap-2"
        >

            @csrf


            <div id="moveInputs"></div>


            <select
                name="album_id"
                class="form-select form-select-sm"
            >

                <option value="">
                    Sin álbum
                </option>


                @foreach(auth()->user()->albums as $userAlbum)

                    @if($userAlbum->id !== $album->id)

                        <option value="{{ $userAlbum->id }}">
                            {{ $userAlbum->title }}
                        </option>

                    @endif

                @endforeach


            </select>


            <button
                class="btn btn-outline-dark btn-sm"
            >
                Mover
            </button>


        </form>


    </div>


</div>


        @endif

    @endauth



    <div class="row g-4">


        @forelse($album->photos as $photo)


            <div class="col-md-3">


                <div class="card h-100 shadow-sm border-0 overflow-hidden">


                    @auth

                        @if(auth()->user()->canManageAlbum($album))

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
                        src="{{ asset('storage/' . $photo->preview_path) }}"
                        class="card-img-top"
                        alt="{{ $photo->title }}"
                    >



                    <div class="card-body d-flex flex-column">


                        <h6 class="fw-bold mb-2">
                            {{ $photo->title }}
                        </h6>


                        <p class="text-muted mb-3">
                            ${{ number_format($photo->price, 2) }}
                        </p>


                        <div class="mt-auto">

                            <a
                                href="{{ route('photos.show', $photo) }}"
                                class="btn btn-outline-dark btn-sm w-100"
                            >
                                Ver foto
                            </a>

                        </div>


                    </div>


                </div>


            </div>


        @empty

            <p>
                Este álbum todavía no tiene fotos.
            </p>


        @endforelse


    </div>





<script>

const checkboxes =
    document.querySelectorAll('.photo-checkbox');

const selectAll =
    document.getElementById('selectAll');

const bulkActions =
    document.getElementById('bulkActions');


function updateBulkActions() {

    const selected =
        [...checkboxes]
            .filter(cb => cb.checked)
            .map(cb => cb.value);


    bulkActions.classList.toggle(
        'd-none',
        selected.length === 0
    );


    document.getElementById('deleteInputs').innerHTML =
        selected.map(id =>
            `<input type="hidden" name="photos[]" value="${id}">`
        ).join('');


    document.getElementById('moveInputs').innerHTML =
        selected.map(id =>
            `<input type="hidden" name="photos[]" value="${id}">`
        ).join('');

}


checkboxes.forEach(checkbox => {

    checkbox.addEventListener(
        'change',
        updateBulkActions
    );

});


selectAll?.addEventListener('change', function () {

    checkboxes.forEach(checkbox => {

        checkbox.checked = this.checked;

    });


    updateBulkActions();

});

</script>


@endsection