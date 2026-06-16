<h1 class="h2 fw-bold mb-4">
    Pedidos
</h1>


<div class="mb-5">

    @foreach($orders as $order)

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


                <p class="mb-3">
                    <strong>Total:</strong>
                    ${{ number_format($order->total, 0, ',', '.') }}
                </p>


                <p class="text-muted mb-2">
                    Fotos:
                </p>


                <ul class="mb-0">

                    @foreach($order->items as $item)

                        @if($item->photo && $item->photo->user_id === auth()->id())

                            <li>
                                {{ $item->photo->title }}
                                - x{{ $item->quantity }}
                            </li>

                        @endif

                    @endforeach

                </ul>

            </div>

        </div>

    @endforeach

</div>


<div class="text-end">

    <a
        href="{{ route('dashboard.orders') }}"
        class="btn btn-outline-dark btn-sm"
    >
        Ver todos los pedidos
    </a>

</div>