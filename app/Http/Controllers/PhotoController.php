<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;

class PhotoController extends Controller
{
    public function index(){
        $order = request('order', 'latest');

        $query = Photo::query();

        if ($order === 'latest') {
            $query->orderBy('created_at', 'desc');
        }

        if ($order === 'oldest') {
            $query->orderBy('created_at', 'asc');
        }

        if ($order === 'price_asc') {
            $query->orderBy('price', 'asc');
        }

        if ($order === 'price_desc') {
            $query->orderBy('price', 'desc');
        }

        $photos = $query->get();

        return view('photos.index', compact('photos'));
    }    
    public function show(Photo $photo){ 
        return view('photos.show', compact('photo')); 
    }
}
