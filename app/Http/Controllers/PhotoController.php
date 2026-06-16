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
        !(
            auth()->id() === $photo->album->user_id ||
            auth()->user()?->role === \App\Enums\UserRole::ADMIN ||
            session()->has('album_access_' . $photo->album->id)
        )
    ) {
        abort(403);
    }

    return view('photos.show', compact('photo'));
}
public function dashboardShow(Photo $photo)
{
    $user = auth()->user();

    if (!$user->canManagePhoto($photo)) {
        abort(403);
    }

    return view('dashboard.photos.show', compact('photo'));
}

    public function create()
    {
        $albums = auth()->user()->albums;
         $selectedAlbum = request('album');

        return view('photos.create', compact('albums', 'selectedAlbum'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',

        'image' => 'required|image|max:20480',

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

    if (!empty($validated['album_id'])) {
        $album = \App\Models\Album::find($validated['album_id']);
        return redirect()->route('dashboard.albums.show', $album);
    }

    return redirect()->route('dashboard.photos.show', $photo);
}

    public function bulkCreate()
    {
        $albums = auth()->user()->albums;
        $selectedAlbum = request('album');

        return view('photos.bulk-create', compact('albums', 'selectedAlbum'));
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'price' => 'required|numeric|min:0',

            'album_id' => 'nullable|exists:albums,id',

            'images' => 'required|array|min:1',

            'images.*' => 'image|max:20480',
        ]);

        foreach ($request->file('images') as $image) {

            $path = $image->store(
                'photos',
                'public'
            );

            auth()->user()->photos()->create([

                'title' => pathinfo(
                    $image->getClientOriginalName(),
                    PATHINFO_FILENAME
                ),

                'description' => null,

                'price' => $validated['price'],

                'file_path' => $path,

                'preview_path' => $path,

                'album_id' =>
                    $validated['album_id'] ?? null,
            ]);
        }

        if (!empty($validated['album_id'])) {

            $album = \App\Models\Album::find($validated['album_id']);

            return redirect()->route('dashboard.albums.show', $album);
        }

        return redirect()->route('dashboard.photos');
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

        return redirect()->route('dashboard.photos.show', $photo);
    }

    public function destroy(Photo $photo)
    {
        auth()->user()->ensureCanManagePhoto($photo);

        Storage::disk('public')->delete($photo->file_path);
        Storage::disk('public')->delete($photo->preview_path);

        $photo->delete();

        return redirect()->route('dashboard.photos.index');
    }
    public function bulkMove(Request $request){
        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'exists:photos,id',
            'album_id' => 'nullable|exists:albums,id',
        ]);


        Photo::whereIn('id', $request->photos)
            ->update([
                'album_id' => $request->album_id
            ]);


        $count = count($request->photos);

    return back()
    ->with(
        'success',
        "✅ {$count} foto" . ($count > 1 ? 's' : '') . " movida" . ($count > 1 ? 's' : '') . " correctamente."
    );
    }

    public function bulkDelete(Request $request){
        $request->validate([
            'photos' => 'required|array|min:1',
            ]);
            
            $count = count($request->photos);
        $photos = Photo::whereIn(
            'id',
            $request->photos
        )->get();

        foreach ($photos as $photo) {

            if (!auth()->user()->canManagePhoto($photo)) {
                abort(403);
            }

        }

        Photo::whereIn(
            'id',
            $request->photos
        )->delete();

        

    return back()
    ->with(
        'success',
        "✅ {$count} foto" . ($count > 1 ? 's' : '') . " eliminada" . ($count > 1 ? 's' : '') . " correctamente."
    );
    }
}