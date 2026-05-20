<h2 class="mb-3">Mis pedidos</h2>

@foreach($orders as $order)

    <div class="border rounded p-3 mb-3">

        <p>Pedido #{{ $order->id }}</p>
        <p>Estado: {{ $order->status }}</p>
        <p>Total: {{ $order->total }}</p>

        <ul>
            @foreach($order->items as $item)

                @if($item->photo && $item->photo->user_id === auth()->id())

                    <li>
                        {{ $item->photo->title }} - x{{ $item->quantity }}
                    </li>

                @endif

            @endforeach
        </ul>

    </div>

@endforeach