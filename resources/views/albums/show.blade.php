@extends('layouts.app')

@section('title', $album->title)

@section('content')

<div class="container py-4">

    <div class="mb-4">

        <div class="d-flex align-items-center gap-2 mb-2">

            <h1 class="h2 fw-bold mb-0">
                {{ $album->title }}
            </h1>


            @if($album->is_private)

                <span class="badge bg-warning text-dark">
                    Acceso protegido
                </span>

            @endif

        </div>


        @if($album->description)

            <p class="text-muted">
                {{ $album->description }}
            </p>

        @endif

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


        <span
            id="selectedCount"
            class="text-muted small d-none"
        >
        </span>


        {{-- dsp ponerlo así: <form
            action="{{ route('cart.addMultiple') }}"
            method="POST"
            id="cartForm"
            class="d-none"
        > --}}
        <form
            action="#"
            method="POST"
            id="cartForm"
            class="d-none"
        >

            @csrf

            <div id="cartInputs"></div>


            <button
                class="btn btn-dark btn-sm"
            >
                Agregar seleccionadas al carrito
            </button>

        </form>

    </div>



    <div class="row g-4">

        @forelse($album->photos as $photo)

            <div class="col-md-3">

                <div class="card h-100 shadow-sm border-0 overflow-hidden">


                    <div class="card-header bg-white border-0">

                        <input
                            type="checkbox"
                            value="{{ $photo->id }}"
                            class="photo-checkbox"
                        >

                    </div>


                    <img
                        src="{{ asset('storage/' . $photo->preview_path) }}"
                        class="card-img-top"
                        alt="{{ $photo->title }}"
                    >


                    <div class="card-body d-flex flex-column">

                        <h6 class="fw-bold">
                            {{ $photo->title }}
                        </h6>


                        <p class="text-muted">
                            ${{ number_format($photo->price, 2) }}
                        </p>


                        <a
                            href="{{ route('photos.show', $photo) }}"
                            class="btn btn-outline-dark btn-sm mt-auto"
                        >
                            Ver foto
                        </a>

                    </div>


                </div>

            </div>


        @empty

            <p>
                Este álbum todavía no tiene fotos.
            </p>

        @endforelse

    </div>


</div>


<script>

const checkboxes =
    document.querySelectorAll('.photo-checkbox');

const selectAll =
    document.getElementById('selectAll');

const cartForm =
    document.getElementById('cartForm');

const cartInputs =
    document.getElementById('cartInputs');

const counter =
    document.getElementById('selectedCount');


function updateSelection(){

    const selected =
        [...checkboxes]
        .filter(cb => cb.checked);


    cartInputs.innerHTML = '';


    selected.forEach(photo => {

        const input =
            document.createElement('input');

        input.type = 'hidden';
        input.name = 'photos[]';
        input.value = photo.value;

        cartInputs.appendChild(input);

    });


    cartForm.classList.toggle(
        'd-none',
        selected.length === 0
    );


    counter.classList.toggle(
        'd-none',
        selected.length === 0
    );


    if(selected.length){

        counter.textContent =
            `${selected.length} foto${selected.length > 1 ? 's' : ''} seleccionada${selected.length > 1 ? 's' : ''}`;

    }

}


checkboxes.forEach(cb => {

    cb.addEventListener(
        'change',
        updateSelection
    );

});


selectAll.addEventListener(
    'change',
    function(){

        checkboxes.forEach(cb => {
            cb.checked = this.checked;
        });

        updateSelection();

    }
);


</script>

@endsection