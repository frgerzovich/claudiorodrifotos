<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Photo;

class PhotoController extends Controller
{
    public function index()
    {
        $order = request('order', 'latest');

        $photographerId = request('photographer');

        $query = Photo::whereNull('album_id');

        if ($photographerId) {
            $query->where('user_id', $photographerId);
        }

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

    public function show(Photo $photo)
    {
        if (
            $photo->album &&
            $photo->album->is_private &&
            !session()->has('album_access_' . $photo->album->id)
        ) {
            abort(403);
        }

        return view('photos.show', compact('photo'));
    }

    public function create()
    {
        $albums = auth()->user()->albums;

        return view('photos.create', compact('albums'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|max:5120',
            'album_id' => 'nullable|exists:albums,id',
        ]);

        $path = $request->file('image')->store('photos', 'public');

        $photo = auth()->user()->photos()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'file_path' => $path,
            'preview_path' => $path,
            'album_id' => $validated['album_id'] ?? null,
        ]);

        return redirect()->route('photos.show', $photo);
    }

    public function edit(Photo $photo)
    {
        auth()->user()->ensureCanManagePhoto($photo);

        $albums = auth()->user()->albums;

        return view('photos.edit', compact('photo', 'albums'));
    }

    public function update(Request $request, Photo $photo)
    {
        auth()->user()->ensureCanManagePhoto($photo);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'album_id' => 'nullable|exists:albums,id',
        ]);

        $photo->update($validated);

        return redirect()->route('photos.show', $photo);
    }

    public function destroy(Photo $photo)
    {
        auth()->user()->ensureCanManagePhoto($photo);

        Storage::disk('public')->delete($photo->file_path);
        Storage::disk('public')->delete($photo->preview_path);

        $photo->delete();

        return redirect()->route('photos.index');
    }

    public function forceDestroy(Photo $photo)
    {
        auth()->user()->ensureAdmin();

        Storage::disk('public')->delete($photo->file_path);
        Storage::disk('public')->delete($photo->preview_path);

        $photo->forceDelete();

        return redirect()->route('photos.index');
    }
}