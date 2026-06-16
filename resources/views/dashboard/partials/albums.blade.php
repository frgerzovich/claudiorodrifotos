<h1 class="h2 fw-bold mb-4">
    Álbumes
</h1>


<div class="row g-3 mb-5">

    @foreach($albums as $album)

        <div class="col-md-3">

            <div class="card h-100 shadow-sm border-0 overflow-hidden">

                <a href="{{ route('dashboard.albums.show', $album) }}">

                    @if($album->cover_url)

                        <img
                            src="{{ $album->cover_url }}"
                            class="card-img-top"
                            alt="{{ $album->title }}"
                        >

                    @endif

                </a>

                <div class="card-body">

                    <h5 class="mb-2">
                        {{ $album->title }}
                    </h5>

                    <p class="text-muted mb-2">
                        {{ $album->photos_count }} fotos
                    </p>

                    @if($album->is_private)

                        <span class="badge bg-warning text-dark">
                            Privado
                        </span>

                    @endif

                </div>

            </div>

        </div>

    @endforeach

</div>


<div class="text-end mt-3">

    <a
        href="{{ route('dashboard.albums') }}"
        class="btn btn-outline-dark btn-sm"
    >
        Ver todos los álbumes
    </a>

</div>