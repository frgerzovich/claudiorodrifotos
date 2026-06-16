<div
    class="toast position-fixed bottom-0 end-0 m-3"
    id="albumToast"
    role="alert"
>
    <div class="toast-body">
        Álbum creado correctamente ✅
    </div>
</div>


<div class="modal fade" id="albumModal" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Nuevo álbum
                </h5>

            </div>


            <div class="modal-body">

                <div
                    id="albumErrors"
                    class="alert alert-danger d-none"
                ></div>


                <input
                    type="text"
                    id="albumTitle"
                    class="form-control mb-3"
                    placeholder="Título"
                >


                <textarea
                    id="albumDescription"
                    class="form-control mb-3"
                    placeholder="Descripción"
                ></textarea>


                <div class="form-check mb-3">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="isPrivate"
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
                    class="mb-3 d-none"
                >

                    <label class="form-label">
                        Contraseña
                    </label>


                    <input
                        type="password"
                        id="albumPassword"
                        class="form-control"
                    >

                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-dark"
                    id="createAlbumBtn"
                >
                    Crear álbum
                </button>

            </div>

        </div>

    </div>

</div>


<script>
const isPrivate =
    document.getElementById('isPrivate');

const passwordContainer =
    document.getElementById('passwordContainer');


isPrivate?.addEventListener('change', () => {

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
    ?.addEventListener('click', async () => {

        const title =
            document.getElementById('albumTitle').value;

        const description =
            document.getElementById('albumDescription').value;

        const password =
            document.getElementById('albumPassword').value;


        const response = await fetch(
            "{{ route('albums.ajax.store') }}",
            {
                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
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

            const container =
                document.getElementById('albumErrors');

            container.classList.remove('d-none');

            container.innerHTML =
                errors.errors
                    ? Object.values(errors.errors).flat().join('<br>')
                    : errors.message;

            return;
        }


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


        const toast =
            new bootstrap.Toast(
                document.getElementById('albumToast')
            );

        toast.show();

    });
</script>