<h2 class="mb-3">Mis fotos</h2>

<div class="row g-3 mb-5">

    @foreach($photos as $photo)

        <div class="col-md-3">

            <div class="card">

                <img
                    src="{{ asset('storage/' . $photo->file_path) }}"
                    class="card-img-top"
                >

                <div class="card-body">
                    <h6>{{ $photo->title }}</h6>
                </div>

            </div>

        </div>

    @endforeach

</div>