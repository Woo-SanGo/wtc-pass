@extends('layouts.admin')

@section('content')
<style>
    body {
        color: black;
        font-family: 'Arial', sans-serif;
    }

    .container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        color: black;
    }

    h1 {
        color: black;
        text-align: left;
        margin-bottom: 30px;
        font-size: 2.5em;
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .create-user-btn {
        display: inline-block;
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.3s ease;
        margin-bottom: 20px;
    }

    .create-user-btn:hover {
        background-color: #0056b3;
    }

    .user-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        border-radius: 8px;
        overflow: hidden;
        color: black;
    }

    .user-table th,
    .user-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .user-table th {
        font-weight: bold;
        text-transform: uppercase;
        font-size: 0.9em;
    }

    .user-table tbody tr:hover {
        background-color: #e0e0e0;
    }

    .user-table tbody tr.banned-row {
        background-color: #f8d7da;
        color: black;
    }

    .user-table tbody tr.banned-row:hover {
        background-color: #f1b0b7;
    }

    .actions-column a,
    .actions-column button {
        padding: 8px 12px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 0.85em;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
        margin-right: 5px;
        border: none;
        display: inline-block;
        color: white;
    }

    .actions-column a {
        background-color: #17a2b8;
    }
    .actions-column a:hover {
        background-color: #117a8b;
    }

    .actions-column button.ban-btn {
        background-color: #28a745;
    }
    .actions-column button.ban-btn:hover {
        background-color: #218838;
    }

    .actions-column button.delete-btn {
        background-color: #dc3545;
    }
    .actions-column button.delete-btn:hover {
        background-color: #c82333;
    }

    .actions-column span {
        font-weight: bold;
        padding: 8px 12px;
        display: inline-block;
        color: black;
    }

    form {
        display: inline-block;
    }
</style>

<div class="container mt-4">
    <h2 class="mb-4">Users Management</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th> {{-- Added Phone Number --}}
                <th>Role</th>
                <th>Status</th>
                <th>Last Login</th>
                <th style="width: 280px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone ?? '-' }}</td> {{-- Display phone or dash if null --}}
                <td class="text-capitalize">{{ $user->role }}</td>
                <td>
                    @if ($user->is_banned)
                        <span class="badge bg-danger">Banned</span>
                    @else
                        <span class="badge bg-success">Active</span>
                    @endif
                </td>
                <td>
                    {{ $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i') : 'Never' }}
                </td>
                <td>
                    {{-- Edit Button --}}
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary me-1">
                        <i class="bi bi-pencil"></i> Edit
                    </a>

                    {{-- Delete Button --}}
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" 
                          onsubmit="return confirm('Are you sure you want to delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger me-1">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>

                    {{-- Ban/Unban Buttons --}}
                    @if (!$user->is_banned)
                        <form action="{{ route('admin.users.ban', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-warning" 
                                    onclick="return confirm('Ban this user?')">
                                <i class="bi bi-slash-circle"></i> Ban
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.users.unban', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success" 
                                    onclick="return confirm('Unban this user?')">
                                <i class="bi bi-check-circle"></i> Unban
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">No users found.</td> {{-- Updated colspan --}}
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


@endsection