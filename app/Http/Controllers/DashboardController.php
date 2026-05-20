<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $photoFilter = request('photos');
        $orderFilter = request('orders');
        //filtro de fotos
        $photosQuery = $user->photos()->latest();

        if ($photoFilter === 'album') {
            $photosQuery->whereNotNull('album_id');
        }

        if ($photoFilter === 'no_album') {
            $photosQuery->whereNull('album_id');
        }

        $photos = $photosQuery->get();

        //filtro pedidos
        $ordersQuery = Order::whereHas('items.photo', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with(['items.photo'])->latest();

        if ($orderFilter) {
            $ordersQuery->where('status', $orderFilter);
        }
        $orders = $ordersQuery->get();
        //estadisticas
        $photoIds = $user->photos()->pluck('id');

        $totalRevenue = OrderItem::whereIn('photo_id', $photoIds)
            ->sum(DB::raw('quantity * unit_price'));


            return view('dashboard.index', compact(
                'photos',
                'orders',
                'photoFilter',
                'orderFilter',
                'totalRevenue'
            ));
    }
}