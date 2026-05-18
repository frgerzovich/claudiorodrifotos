<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $orders = Order::query()
            ->when($user->role !== 'admin', function ($q) use ($user) {
                $q->whereHas('items', function ($q2) use ($user) {
                    $q2->where('photographer_id', $user->id);
                });
            })
            ->with('items.photo')
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }


    public function show(Order $order)
    {
        $user = auth()->user();

        if ($user->role !== 'admin') {
            $hasAccess = $order->items()
                ->where('photographer_id', $user->id)
                ->exists();

            if (!$hasAccess) {
                abort(403);
            }
        }

        $order->load('items.photo');

        return view('orders.show', compact('order'));
    }

    
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'buyer_name' => 'required|string',
            'buyer_email' => 'required|email',
            'buyer_phone' => 'required|string',
            'buyer_address' => 'nullable|string',
            'items' => 'required|array|min:1',
        ]);

        $order = Order::create([
            'buyer_name' => $validated['buyer_name'],
            'buyer_email' => $validated['buyer_email'],
            'buyer_phone' => $validated['buyer_phone'],
            'buyer_address' => $validated['buyer_address'] ?? null,
            'total' => 0,
            'status' => OrderStatus::PENDING,
        ]);

        $total = 0;

        foreach ($validated['items'] as $item) {

            $orderItem = $order->items()->create([
                'photo_id' => $item['photo_id'],
                'photographer_id' => $item['photographer_id'],
                'quantity' => $item['quantity'] ?? 1,
                'unit_price' => $item['unit_price'],
                'type' => $item['type'],
                'print_size' => $item['print_size'] ?? null,
            ]);

            $total += $orderItem->subtotal();
        }

        $order->update(['total' => $total]);

        return redirect()->route('orders.show', $order);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,shipped,received'
        ]);

        $order->update([
            'status' => OrderStatus::from($validated['status'])
        ]);

        return back();
    }
}