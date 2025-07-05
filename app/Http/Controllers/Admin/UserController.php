<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // List all users except admins, ordered by role (custom order: shelter first, then user)
    public function index()
    {
        $users = User::where('role', '!=', 'admin')
            ->orderByRaw("FIELD(role, 'shelter', 'user')")
            ->get();

        return view('admin.users.index', compact('users'));
    }

    // Show form to create user
    public function create()
    {
        return view('admin.users.create');
    }

    // Store new user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20|unique:users,phone',
            'role'  => 'required|string|in:user,shelter',
        ]);

        $validated['password'] = bcrypt('defaultpassword'); // You can customize this
        $validated['is_banned'] = false;

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    // Show form to edit user
    public function edit($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            abort(403);
        }

        return view('admin.users.edit', compact('user'));
    }

    // Update user info
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20|unique:users,phone,' . $user->id,
            'role'  => 'required|string|in:user,shelter',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    // Ban user
    public function ban($id)
    {
        $user = User::findOrFail($id);
        $user->is_banned = true;
        $user->save();

        return redirect()->back()->with('success', 'User banned successfully.');
    }

    // Unban user
    public function unban($id)
    {
        $user = User::findOrFail($id);
        $user->is_banned = false;
        $user->save();

        return redirect()->back()->with('success', 'User unbanned successfully.');
    }

    // Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            abort(403);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
