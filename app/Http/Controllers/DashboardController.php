<?php

namespace App\Http\Controllers;

use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $photoFilter = request('photos');
        $orderFilter = request('orders');

        // -------------------
        // PHOTOS FILTER
        // -------------------
        $photosQuery = $user->photos()->latest();

        if ($photoFilter === 'album') {
            $photosQuery->whereNotNull('album_id');
        }

        if ($photoFilter === 'no_album') {
            $photosQuery->whereNull('album_id');
        }

        $photos = $photosQuery->get();

        // -------------------
        // ORDERS FILTER
        // -------------------
        $ordersQuery = Order::whereHas('items.photo', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with(['items.photo'])->latest();

        if ($orderFilter) {
            $ordersQuery->where('status', $orderFilter);
        }

        $orders = $ordersQuery->get();

        return view('dashboard', compact('photos', 'orders', 'photoFilter', 'orderFilter'));
    }
}