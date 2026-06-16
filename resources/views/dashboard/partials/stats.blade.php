<div class="row g-3 mb-5">

    <div class="col-md-3">

        <div class="card h-100 p-3 shadow-sm border-0">

            <p class="text-muted mb-2">
                Total vendido
            </p>

            <h3 class="fw-bold mb-0">
                ${{ number_format($totalRevenue, 0, ',', '.') }}
            </h3>

        </div>

    </div>


    <div class="col-md-3">

        <div class="card h-100 p-3 shadow-sm border-0">

            <p class="text-muted mb-2">
                Fotos
            </p>

            <h3 class="fw-bold mb-0">
                {{ $totalPhotos }}
            </h3>

        </div>

    </div>


    <div class="col-md-3">

        <div class="card h-100 p-3 shadow-sm border-0">

            <p class="text-muted mb-2">
                Álbumes
            </p>

            <h3 class="fw-bold mb-0">
                {{ $totalAlbums }}
            </h3>

        </div>

    </div>


    <div class="col-md-3">

        <div class="card h-100 p-3 shadow-sm border-0">

            <p class="text-muted mb-2">
                Pedidos
            </p>

            <h3 class="fw-bold mb-0">
                {{ $totalOrders }}
            </h3>

        </div>

    </div>

</div>