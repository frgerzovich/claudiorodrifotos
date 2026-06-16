<h1 class="h2 fw-bold mb-4">
    Fotos
</h1>


<div class="row g-3 mb-5">

    @foreach($photos as $photo)

        <div class="col-md-3">

            <div class="card h-100 shadow-sm border-0">

                <a href="{{ route('dashboard.photos.show', $photo) }}">

                    <img
                        src="{{ asset('storage/' . $photo->file_path) }}"
                        class="card-img-top"
                        alt="{{ $photo->title }}"
                    >

                </a>

                <div class="card-body">

                    <h6 class="mb-2">
                        {{ $photo->title }}
                    </h6>

                    <small class="text-muted">
                        ${{ number_format($photo->price, 2) }}
                    </small>

                </div>

            </div>

        </div>

    @endforeach

</div>


<div class="text-end mt-3">

    <a
        href="{{ route('dashboard.photos') }}"
        class="btn btn-outline-dark btn-sm"
    >
        Ver todas las fotos
    </a>

</div>