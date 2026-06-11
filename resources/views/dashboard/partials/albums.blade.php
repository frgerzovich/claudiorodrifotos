<h2 class="mb-3">Mis álbumes</h2>

<div class="row g-3 mb-5">

    @foreach($albums as $album)

        <div class="col-md-3">

            <div class="card h-100">

                <a href="{{ route('albums.show', $album) }}">
                         @if($album->cover_url)

                        <img
                            src="{{ $album->cover_url }}"
                            class="card-img-top"
                            alt="{{ $album->title }}"
                        >

                    @endif
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

                </a>

            </div>

        </div>

    @endforeach

</div>