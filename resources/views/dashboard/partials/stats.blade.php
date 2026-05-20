<div class="row mb-4">

    <div class="col-md-4">
        <div class="card p-3">
            <h5>Total vendido</h5>
            <h3>${{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3">
            <h5>Mis fotos</h5>
            <h3>{{ $photos->count() }}</h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3">
            <h5>Pedidos</h5>
            <h3>{{ $orders->count() }}</h3>
        </div>
    </div>

</div>