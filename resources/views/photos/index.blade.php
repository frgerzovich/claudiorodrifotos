@extends('layouts.app')

@section('title', 'Galería')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="fw-bold">Galería</h1>
</div>

<div class="row g-4">

    @forelse($photos as $photo)

        <div class="col-md-4">

            <div class="card h-100 shadow-sm border-0">

                <img
                    src="{{ asset('storage/' . $photo->file_path) }}"
                    class="card-img-top"
                    alt="{{ $photo->title }}"
                >

                <div class="card-body d-flex flex-column">

                    <h5 class="card-title">
                        {{ $photo->title }}
                    </h5>

                    <p class="card-text text-muted small">
                        {{ Str::limit($photo->description, 80) }}
                    </p>

                    <div class="mt-auto">
                        <a
                            href="{{ route('photos.show', $photo) }}"
                            class="btn btn-dark w-100"
                        >
                            Ver foto
                        </a>
                    </div>

                </div>

            </div>

        </div>

    @empty

        <p>No hay fotos cargadas.</p>

    @endforelse

</div>

@endsection