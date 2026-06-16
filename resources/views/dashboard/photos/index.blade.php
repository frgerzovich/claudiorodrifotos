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
            Mis fotos
        </h1>

    </div>



    {{-- ACCIONES BULK --}}
    <div
    id="bulkActions"
    class="d-none d-flex align-items-center gap-2 mb-4"
    >
    <span
    id="selectedCount"
    class="text-muted small d-none"
>
    0 fotos seleccionadas
</span>

        {{-- ELIMINAR --}}

        <button
            type="submit"
            form="deleteForm"
            class="btn btn-danger btn-sm"
            onclick="return confirm('¿Eliminar fotos seleccionadas?')"
        >
            Eliminar seleccionadas
        </button>



        {{-- MOVER --}}

        <form
            action="{{ route('photos.bulk-move') }}"
            method="POST"
            class="d-flex gap-2"
        >

            @csrf


            <select
                name="album_id"
                class="form-select form-select-sm"
            >

                <option value="">
                    Sin álbum
                </option>


                @foreach($albums as $album)

                    <option value="{{ $album->id }}">
                        {{ $album->title }}
                    </option>

                @endforeach


            </select>



            <div id="moveSelectedPhotos"></div>


            <button
                class="btn btn-outline-dark btn-sm"
            >
                Mover
            </button>


        </form>


    </div>




    {{-- FORM ELIMINAR --}}

    <form
        id="deleteForm"
        action="{{ route('photos.bulk-delete') }}"
        method="POST"
    >

        @csrf
        @method('DELETE')



        <div class="form-check mb-4">

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





        <div class="row g-4">


            @forelse($photos as $photo)


                <div class="col-md-3">


                    <div class="card h-100 shadow-sm border-0 overflow-hidden">



                        <div class="card-header bg-white border-0">

                            <input
                                type="checkbox"
                                name="photos[]"
                                value="{{ $photo->id }}"
                                class="photo-checkbox form-check-input"
                            >

                        </div>





                        <img
                            src="{{ asset('storage/' . $photo->file_path) }}"
                            class="card-img-top"
                            alt="{{ $photo->title }}"
                        >





                        <div class="card-body d-flex flex-column">


                            <h5 class="fw-bold mb-2">
                                {{ $photo->title }}
                            </h5>
                            @if($photo->album)

    <span class="badge bg-light text-dark border mb-2">
        Álbum: {{ $photo->album->title }}
    </span>

@else

    <span class="badge bg-secondary mb-2">
        Sin álbum
    </span>

@endif



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


    </form>


</div>


@if(session('success'))

    <div
        class="toast position-fixed bottom-0 end-0 m-3"
        role="alert"
        id="successToast"
    >
        <div class="toast-body">
            {{ session('success') }}
        </div>
    </div>

@endif
<script>


const checkboxes =
    document.querySelectorAll('.photo-checkbox');


const selectAll =
    document.getElementById('selectAll');


const bulkActions =
    document.getElementById('bulkActions');



function updateBulkActions() {

    const selected =
        document.querySelectorAll('.photo-checkbox:checked')
        .length;


    bulkActions.classList.toggle(
        'd-none',
        selected === 0
    );


    const counter =
        document.getElementById('selectedCount');


    const container =
        document.getElementById('moveSelectedPhotos');


    container.innerHTML = '';



    if(selected > 0){

        counter.textContent =
            `${selected} foto${selected > 1 ? 's' : ''} seleccionada${selected > 1 ? 's' : ''}`;

        counter.classList.remove('d-none');


    } else {


        counter.classList.add('d-none');


    }



    document
        .querySelectorAll('.photo-checkbox:checked')
        .forEach(photo => {


            const input =
                document.createElement('input');


            input.type = 'hidden';

            input.name = 'photos[]';

            input.value = photo.value;


            container.appendChild(input);


        });


}




checkboxes.forEach(checkbox => {


    checkbox.addEventListener(
        'change',
        updateBulkActions
    );


});




selectAll.addEventListener(
    'change',
    function () {


        checkboxes.forEach(checkbox => {

            checkbox.checked = this.checked;

        });


        updateBulkActions();


    }
);


@if(session('success'))

    const toast =
        new bootstrap.Toast(
            document.getElementById('successToast')
        );

    toast.show();

@endif
</script>


@endsection