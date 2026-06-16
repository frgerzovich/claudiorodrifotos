@extends('layouts.app')

@section('title', 'Subir foto')

@section('content')

<div class="container py-4">
<a
        href="{{ route('dashboard') }}"
        class="btn btn-outline-dark btn-sm mb-4"
    >
        ← Volver
    </a>
    <h1 class="h2 fw-bold mb-4">
        Subir foto
    </h1>


    <div class="card shadow-sm border-0">

        <div class="card-body p-4">


            <form
                action="{{ route('photos.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                @if($errors->any())

                    <div class="alert alert-danger">

                        <ul class="mb-0">

                            @foreach($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif



                <div class="mb-4">

                    <label class="form-label">
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

                    <label class="form-label">
                        Descripción
                    </label>

                    <textarea
                        name="description"
                        class="form-control"
                        rows="4"
                    >{{ old('description') }}</textarea>

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
                        value="{{ old('price') }}"
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
                                Sin álbum (pública)
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
                            id="openAlbumModalBtn"
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
                        Imagen
                    </label>

                    <input
                        type="file"
                        name="image"
                        class="form-control"
                    >

                    

                </div>



                <button
                    class="btn btn-dark"
                >
                    Subir foto
                </button>


            </form>


        </div>

    </div>

</div>
<script>
const isPrivate =
    document.getElementById('isPrivate');

const passwordContainer =
    document.getElementById('passwordContainer');

isPrivate.addEventListener('change', () => {

    passwordContainer.classList.toggle(
        'd-none',
        !isPrivate.checked
    );
     if (!isPrivate.checked) {
        document.getElementById('albumPassword').value = '';
    }

});
    document
    .getElementById('createAlbumBtn')
    .addEventListener('click', async () => {
        
        const title =
        document.getElementById('albumTitle').value;
        
        const description =
        document.getElementById('albumDescription').value;

        const password = document.getElementById('albumPassword').value;
        const errorContainer =
    document.getElementById('albumErrors');

    errorContainer.classList.add('d-none');
    errorContainer.innerHTML = '';
   const response = await fetch(
            "{{ route('albums.ajax.store') }}",
            {
                method: 'POST',
                
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN':
                    '{{ csrf_token() }}',
                    'Accept':
                    'application/json'
                },
                
                body: JSON.stringify({
                    title,
                    description,
                    password
                })
            }
        );
        if (!response.ok) {

    const errors = await response.json();     

console.log(errors);

    const container =
        document.getElementById('albumErrors');

    container.classList.remove('d-none');

    if (errors.errors) {

    container.innerHTML = Object
        .values(errors.errors)
        .flat()
        .join('<br>');

} else {

    container.innerHTML =
        errors.message || 'Ocurrió un error.';

}

    return;
}
        console.log(response);   
        const album = await response.json();
        
        const select =
        document.getElementById('albumSelect');
        
        const option =
        document.createElement('option');
        
        option.value = album.id;
        option.textContent = album.title;
        option.selected = true;
        
        select.appendChild(option);
        
        bootstrap.Modal
        .getInstance(
            document.getElementById('albumModal')
        )
        .hide();
        const toast = new bootstrap.Toast(
    document.getElementById('albumToast')
);

toast.show();
document.getElementById('albumTitle').value = '';
document.getElementById('albumDescription').value = '';
document.getElementById('albumPassword').value = '';

document.getElementById('isPrivate').checked = false;

document
.getElementById('passwordContainer')
.classList.add('d-none');
});
    
</script>
    @endsection