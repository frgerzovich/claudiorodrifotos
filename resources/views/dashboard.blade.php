@extends('layouts.app')

@section('title', 'Mi panel')

@section('content')
<form method="GET" class="mb-4 d-flex gap-3">

    <div>
        <label>Fotos</label>
        <select name="photos" class="form-select">
            <option value="">Todas</option>
            <option value="album" @selected($photoFilter === 'album')>Con álbum</option>
            <option value="no_album" @selected($photoFilter === 'no_album')>Sin álbum</option>
        </select>
    </div>

    <div>
        <label>Pedidos</label>
        <select name="orders" class="form-select">
            <option value="">Todos</option>
            <option value="pending" @selected($orderFilter === 'pending')>Pendiente</option>
            <option value="paid" @selected($orderFilter === 'paid')>Pagado</option>
            <option value="shipped" @selected($orderFilter === 'shipped')>Enviado</option>
            <option value="received" @selected($orderFilter === 'received')>Recibido</option>
        </select>
    </div>

    <div class="align-self-end">
        <button class="btn btn-dark">Filtrar</button>
    </div>

</form>
<div class="container py-4">

    <h1 class="mb-4">Mi panel</h1>

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

                        <h5 class="card-title">
                            {{ $photo->title }}
                        </h5>

                        <a href="{{ route('photos.show', $photo) }}" class="btn btn-dark btn-sm w-100">
                            Ver
                        </a>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

    <h2 class="mb-3">Mis pedidos</h2>

    @foreach($orders as $order)

        <div class="border rounded p-3 mb-3">

            <p>Pedido #{{ $order->id }}</p>
            <p>Estado: {{ $order->status }}</p>
            <p>Total: {{ $order->total }}</p>

            <p class="mt-2 mb-1">
                Mis fotos vendidas en este pedido:
            </p>

            <ul class="mb-0">

                @foreach($order->items as $item)

                    @if($item->photo && $item->photo->user_id === auth()->id())

                        <li>
                            {{ $item->photo->title }} -
                            x{{ $item->quantity }}
                        </li>

                    @endif

                @endforeach

            </ul>

        </div>

    @endforeach

</div>

@endsection