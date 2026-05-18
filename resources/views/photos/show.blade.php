<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $photo->title }}</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body>

<div class="container py-5">

    <a
        href="{{ route('photos.index') }}"
        class="btn btn-outline-dark mb-4"
    >
        ← Volver
    </a>

    <div class="row g-5 align-items-start">

        <div class="col-md-7">

            <img
                src="{{ $photo->file_path }}"
                alt="{{ $photo->title }}"
                class="img-fluid rounded shadow"
            >

        </div>

        <div class="col-md-5">

            <h1 class="fw-bold mb-3">
                {{ $photo->title }}
            </h1>

            <p class="text-muted mb-4">
                {{ $photo->description }}
            </p>

            <div class="border rounded p-3 mb-4">

                <h4 class="fw-bold">
                    ${{ number_format($photo->price, 0, ',', '.') }}
                </h4>

            </div>

            <button class="btn btn-dark w-100">
                Agregar al carrito
            </button>

        </div>

    </div>

</div>

</body>
</html>