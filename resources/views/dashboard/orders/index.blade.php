@extends('layouts.app')

@section('title', 'Pedidos')

@section('content')

<div class="container py-4">
<a
        href="{{ route('dashboard') }}"
        class="btn btn-outline-dark btn-sm mb-4"
    >
        ← Volver
    </a>
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h2 fw-bold mb-0">
            Pedidos
        </h1>

    </div>


    {{-- filtros futuros --}}

    <div class="d-flex gap-2 mb-4">

        <button class="btn btn-outline-dark btn-sm">
            Todos
        </button>

        <button class="btn btn-outline-dark btn-sm">
            Pendientes
        </button>

        <button class="btn btn-outline-dark btn-sm">
            Pagados
        </button>

        <button class="btn btn-outline-dark btn-sm">
            Completados
        </button>

    </div>


    @forelse($orders as $order)

        <div class="card shadow-sm border-0 mb-3">

            <div class="card-body">


                <div class="d-flex justify-content-between align-items-start mb-3">

                    <h5 class="fw-bold mb-0">
                        Pedido #{{ $order->id }}
                    </h5>


                    <span class="badge bg-secondary">
                        {{ $order->status }}
                    </span>

                </div>


                <p class="mb-2">
                    <strong>Total:</strong>
                    ${{ number_format($order->total, 2) }}
                </p>


                <h6 class="mt-4 mb-2">
                    Mis fotos en este pedido:
                </h6>


                <ul class="mb-0">

                    @foreach($order->items as $item)

                        @if(
                            $item->photo &&
                            $item->photo->user_id === auth()->id()
                        )

                            <li>
                                {{ $item->photo->title }}
                                x{{ $item->quantity }}
                            </li>

                        @endif

                    @endforeach

                </ul>


                <div class="mt-3">

                    <a
                        href="{{ route('orders.show', $order) }}"
                        class="btn btn-outline-dark btn-sm"
                    >
                        Ver pedido
                    </a>

                </div>


            </div>

        </div>


    @empty

        <p>
            No hay pedidos todavía.
        </p>

    @endforelse


</div>

@endsection