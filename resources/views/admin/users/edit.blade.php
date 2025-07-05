@extends('layouts.admin')

@section('content')
<style>
    .edit-container {
        max-width: 600px;
        margin: 40px auto;
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        font-family: Arial, sans-serif;
        color: black;
    }

    h1 {
        font-size: 2em;
        margin-bottom: 20px;
        color: #333;
        text-align: center;
    }

    form label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    form input[type="text"],
    form input[type="email"],
    form select {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    form button {
        background-color: #007bff;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
        width: 100%;
    }

    form button:hover {
        background-color: #0056b3;
    }
</style>

<div class="edit-container">
    <h1>Edit User</h1>

    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required>

        <label for="email">Email:</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required>

        <label for="role">Role:</label>
        <select name="role" required>
            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
            <option value="shelter" {{ $user->role == 'shelter' ? 'selected' : '' }}>Shelter</option>
        </select>

        <button type="submit">Update</button>
    </form>
</div>
@endsection
