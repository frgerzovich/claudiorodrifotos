<h2 class="mb-3">Mis fotos</h2>

<div class="row g-3 mb-5">

    @foreach($photos as $photo)

        <div class="col-md-3">

            <div class="card h-100">

                <a href="{{ route('photos.show', $photo) }}">

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