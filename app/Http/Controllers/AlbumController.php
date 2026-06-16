<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AlbumController extends Controller
{
    // listado público de álbumes
    public function index()
    {
       $albums = Album::with([
            'user',
            'photos'
        ])->latest()->get();

        return view('albums.index', compact('albums'));
    }

    // ver álbum
    public function show(Album $album)
{
    $user = auth()->user();

    $canAccessPrivateAlbum =
        $user &&
        (
            $user->id === $album->user_id ||
            $user->role === UserRole::ADMIN
        );

    if (
        $album->is_private &&
        !$canAccessPrivateAlbum &&
        !session()->has('album_access_' . $album->id)
    ) {
        return view('albums.password', compact('album'));
    }

    $album->load('photos');

    return view('albums.show', compact('album'));
}
//validar contraseña para álbum privado
    public function access(Request $request, Album $album)
    {
        $request->validate([
            'password' => 'required'
        ]);

        if (!Hash::check($request->password, $album->password)) {

            return back()->withErrors([
                'password' => 'Contraseña incorrecta'
            ]);
        }

        session([
            'album_access_' . $album->id => true
        ]);

        return redirect()->route('albums.show', $album);
    }

    // form crear álbum
    public function create()
    {
        return view('albums.create');
    }

    //guardar álbum
   public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255|unique:albums,title',
        'description' => 'nullable|string',
        'password' => 'nullable|string|min:4',
        'cover_image' => 'nullable|image|max:20480',
    ]);

    $coverPath = null;

    if ($request->hasFile('cover_image')) {
        $coverPath = $request->file('cover_image')->store('covers', 'public');
    }

    $album = Album::create([
        'user_id' => auth()->id(),
        'title' => $validated['title'],
        'url' => Str::slug($validated['title']),
        'description' => $validated['description'] ?? null,
        'password' => !empty($validated['password'])
            ? Hash::make($validated['password'])
            : null,
        'is_private' => !empty($validated['password']),
        'cover_image' => $coverPath,
    ]);

    return redirect()->route('albums.show', $album);
}

    // editar álbum
   public function edit(Album $album)
{
    $this->checkOwnership($album);

    $album->load('photos');

    return view('albums.edit', compact('album'));
}

    //update álbum
    public function update(Request $request, Album $album)
{
    $this->checkOwnership($album);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'cover_photo_id' => 'nullable|exists:photos,id',
        'cover_image' => 'nullable|image|max:20480',
    ]);

    $album->title = $validated['title'];
    $album->description = $validated['description'] ?? null;

    $album->is_private = $request->has('is_private');

    if ($request->filled('password')) {
        $album->password = Hash::make($request->password);
    }

    if (!$request->has('is_private')) {
        $album->password = null;
    }

    // subir nueva imagen de portada
    if ($request->hasFile('cover_image')) {
        $path = $request->file('cover_image')->store('covers', 'public');
        $album->cover_image = $path;
    }

    // seleccionar foto existente como portada
    if ($request->filled('cover_photo_id')) {
        $photo = $album->photos()->find($request->cover_photo_id);

        if ($photo) {
            $album->cover_image = $photo->preview_path;
        }
    }

    $album->save();

    return redirect()->route('albums.show', $album);
}
    //borrar álbum
    public function destroy(Album $album)
    {
        $this->checkOwnership($album);

        $album->delete();

        return redirect()->route('dashboard.albums');
    }

    // helper ownership
    private function checkOwnership(Album $album){
        $user = auth()->user();

        if (
            $album->user_id !== $user->id &&
            $user->role !== UserRole::ADMIN
        ) {
            abort(403);
        }
    }
    public function ajaxStore(Request $request){
            $validated = $request->validate([
                'title' => 'required|string|max:255|unique:albums,title',
                'description' => 'nullable|string',
                'password' => 'nullable|string|min:4',
            ], 
            [
                'title.required' => 'El título es obligatorio.',
                'title.unique' => 'Ya existe un álbum con ese título.',
                'password.min' => 'La contraseña debe tener al menos 4 caracteres.',
            ]);

            $album = Album::create([
                'user_id' => auth()->id(),

                'title' => $validated['title'],

                'url' => Str::slug($validated['title']),

                'description' => $validated['description'] ?? null,

                'password' => !empty($validated['password'])
                    ? Hash::make($validated['password'])
                    : null,

                'is_private' => !empty($validated['password']),
            ]);

            return response()->json([
                'id' => $album->id,
                'title' => $album->title,
            ]);
        }
}