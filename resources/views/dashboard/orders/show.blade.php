@extends('layouts.app')

@section('title', 'Pedido #' . $order->id)

@section('content')

<div class="container py-4">


    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h2 fw-bold mb-1">
                Pedido #{{ $order->id }}
            </h1>

            <p class="text-muted mb-0">
                Detalle del pedido
            </p>
        </div>


        <span class="badge bg-secondary">
            {{ $order->status }}
        </span>

    </div>



    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <h5 class="fw-bold mb-3">
                Información
            </h5>


            <p class="mb-1">
                Total:
                <strong>
                    ${{ number_format($order->total, 2) }}
                </strong>
            </p>


            <p class="mb-0">
                Fecha:
                {{ $order->created_at->format('d/m/Y') }}
            </p>


        </div>

    </div>



    <div class="card shadow-sm border-0">

        <div class="card-body">

            <h5 class="fw-bold mb-3">
                Fotos del pedido
            </h5>


            <div class="row g-3">


                @foreach($order->items as $item)

                    @if(
                        $item->photo &&
                        $item->photo->user_id === auth()->id()
                    )


                        <div class="col-md-4">


                            <div class="card h-100">


                                <img
                                    src="{{ asset('storage/' . $item->photo->preview_path) }}"
                                    class="card-img-top"
                                >


                                <div class="card-body">


                                    <h6 class="fw-bold">
                                        {{ $item->photo->title }}
                                    </h6>


                                    <p class="text-muted mb-0">
                                        Cantidad:
                                        x{{ $item->quantity }}
                                    </p>


                                </div>


                            </div>


                        </div>


                    @endif


                @endforeach


            </div>


        </div>

    </div>


</div>

@endsection