<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // 👥 listar usuarios (solo admin)
    public function index()
    {
        if (auth()->user()->role !== UserRole::ADMIN) {
            abort(403);
        }

        $users = User::latest()->get();

        return view('users.index', compact('users'));
    }

    // 👤 ver usuario (solo admin)
    public function show(User $user)
    {
        if (auth()->user()->role !== UserRole::ADMIN) {
            abort(403);
        }

        return view('users.show', compact('user'));
    }

    // ➕ crear usuario
    public function create()
    {
        if (auth()->user()->role !== UserRole::ADMIN) {
            abort(403);
        }

        return view('users.create');
    }

    // 💾 guardar usuario
    public function store(Request $request)
    {
        if (auth()->user()->role !== UserRole::ADMIN) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,photographer',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('users.index');
    }

    // ✏️ editar
    public function edit(User $user)
    {
        if (auth()->user()->role !== UserRole::ADMIN) {
            abort(403);
        }

        return view('users.edit', compact('user'));
    }

    // 🔄 update
    public function update(Request $request, User $user)
    {
        if (auth()->user()->role !== UserRole::ADMIN) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,photographer',
        ]);

        $user->update($validated);

        return redirect()->route('users.index');
    }

    // ❌ delete
    public function destroy(User $user)
    {
        if (auth()->user()->role !== UserRole::ADMIN) {
            abort(403);
        }

        $user->delete();

        return back();
    }
}