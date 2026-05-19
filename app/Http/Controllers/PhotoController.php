<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Photo;

class PhotoController extends Controller{
//helper
    private function checkOwnership(Photo $photo){
        $user = auth()->user();

        if (
            $photo->user_id !== $user->id &&
            !$user->isAdmin()
        ) {
            abort(403);
        }
    }
   public function index(){
    $order = request('order', 'latest');

    $photographerId = request('photographer');
    // SOLO catálogo público
    $query = Photo::whereNull('album_id');
    //para cuando haya mas de un fotografo :3
    if ($photographerId) {
        $query->where('user_id', $photographerId);
    }
//ordenamiento
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
    // si pertenece a álbum privado
    if (
        $photo->album &&
        $photo->album->is_private &&
        !session()->has('album_access_' . $photo->album->id)
    ) {
        abort(403);
    }

    return view('photos.show', compact('photo'));
}

    public function create(){
        $albums = auth()->user()->albums;

        return view('photos.create', compact('albums'));
    }

    public function store(Request $request){
        $validated = $request->validate([

            'title' => 'required|string|max:255',

            'description' => 'nullable|string',

            'price' => 'required|numeric|min:0',

            'image' => 'required|image|max:5120',

            'album_id' => 'nullable|exists:albums,id',
        ]);

        // guardar archivo físicamente
        $path = $request->file('image')
            ->store('photos', 'public');

        // crear foto
        $photo = auth()->user()->photos()->create([

            'title' => $validated['title'],

            'description' => $validated['description'] ?? null,

            'price' => $validated['price'],

            'file_path' => $path,

            // temporalmente misma imagen
            'preview_path' => $path,

            'album_id' => $validated['album_id'] ?? null,
        ]);

        return redirect()->route('photos.show', $photo);
    }

    public function edit(Photo $photo){
        $this->checkOwnership($photo);

        $albums = auth()->user()->albums;

        return view('photos.edit', compact('photo', 'albums'));
    }

    public function update(Request $request, Photo $photo){
        $this->checkOwnership($photo);

        $validated = $request->validate([

            'title' => 'required|string|max:255',

            'description' => 'nullable|string',

            'price' => 'required|numeric|min:0',

            'album_id' => 'nullable|exists:albums,id',
        ]);

        $photo->update($validated);

        return redirect()->route('photos.show', $photo);
    }

    public function destroy(Photo $photo){
        $this->checkOwnership($photo);

        // eliminar archivo físicamente
        Storage::disk('public')->delete($photo->file_path);
        Storage::disk('public')->delete($photo->preview_path);

        $photo->delete();

        return redirect()->route('photos.index');   
    }
}
