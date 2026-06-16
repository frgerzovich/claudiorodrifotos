<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Photo;
use App\Models\Album;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $photoFilter = request('photos');
        $orderFilter = request('orders');


        // FOTOS
        $photosQuery = $user->isAdmin()
            ? Photo::latest()
            : $user->photos()->latest();


        if ($photoFilter === 'album') {
            $photosQuery->whereNotNull('album_id');
        }

        if ($photoFilter === 'no_album') {
            $photosQuery->whereNull('album_id');
        }

        $photos = $photosQuery
            ->take(6)
            ->get();



        // MOSTRAR ÁLBUMES
        $albums = $user->isAdmin()
            ? Album::withCount('photos')
                ->latest()
                ->take(4)
                ->get()

            : $user->albums()
                ->withCount('photos')
                ->latest()
                ->take(4)
                ->get();



        // MOSTRAR PEDIDOS
        if ($user->isAdmin()) {

            $ordersQuery = Order::with('items.photo')
                ->latest();

        } else {

            $ordersQuery = Order::whereHas(
                'items.photo',
                function ($q) use ($user) {

                    $q->where('user_id', $user->id);

                }
            )
            ->with('items.photo')
            ->latest();

        }


        if ($orderFilter) {
            $ordersQuery->where('status', $orderFilter);
        }


        $orders = $ordersQuery
            ->take(5)
            ->get();



        // MOSTRAR ESTADÍSTICAS
        if ($user->isAdmin()) {

            $photoIds = Photo::pluck('id');

        } else {

            $photoIds = $user->photos()->pluck('id');

        }


        $totalRevenue = OrderItem::whereIn('photo_id', $photoIds)
            ->sum(DB::raw('quantity * unit_price'));

        $totalPhotos = $user->isAdmin()
            ? Photo::count()
            : $user->photos()->count();


        $totalAlbums = $user->isAdmin()
            ? Album::count()
            : $user->albums()->count();


        $totalOrders = $user->isAdmin()
            ? Order::count()
            : Order::whereHas('items.photo', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->count();

        return view(
            'dashboard.index',
            compact(
                'photos',
                'albums',
                'orders',
                'photoFilter',
                'orderFilter',
                'totalRevenue',
                'totalPhotos',
                'totalAlbums',
                'totalOrders'
            )
        );
    }



    public function photos()
    {
        $user = auth()->user();

        $photos = $user->isAdmin()
            ? Photo::latest()->get()
            : $user->photos()->latest()->get();
        
        $albums = $user->isAdmin()
            ? Album::latest()->get()
            : $user->albums()->latest()->get();

        return view(
            'dashboard.photos.index',
            compact('photos', 'albums')
        );
    }



    public function albums()
    {
        $user = auth()->user();

        $albums = $user->isAdmin()
            ? Album::withCount('photos')
                ->latest()
                ->get()

            : $user->albums()
                ->withCount('photos')
                ->latest()
                ->get();

        return view(
            'dashboard.albums.index',
            compact('albums')
        );
    }



    public function orders()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {

            $orders = Order::with('items.photo')
                ->latest()
                ->get();

        } else {

            $orders = Order::whereHas(
                'items.photo',
                function ($query) use ($user) {

                    $query->where('user_id', $user->id);

                }
            )
            ->with('items.photo')
            ->latest()
            ->get();

        }


        return view(
            'dashboard.orders.index',
            compact('orders')
        );
    }
}