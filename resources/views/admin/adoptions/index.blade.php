@extends('layouts.admin')

@section('content')
<style>
    .container-fluid {
        max-width: 1200px;
        margin: 40px auto;
        padding: 30px;
        background: linear-gradient(to right, #fdfbfb, #ebedee);
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        color: #212529;
        font-family: 'Poppins', sans-serif;
    }

    h2 {
        font-size: 2rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 30px;
    }

    .btn-action-group {
        display: flex;
        gap: 15px;
        margin-bottom: 25px;
    }

    .btn-primary,
    .btn-success {
        font-weight: 600;
        padding: 10px 18px;
        border-radius: 10px;
        border: none;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: scale(1.03);
    }

    .btn-success {
        background-color: #28a745;
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
        transform: scale(1.03);
    }

    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
    }

    thead {
        background: linear-gradient(to right, #007bff, #6f42c1);
        color: white;
        text-transform: uppercase;
        font-size: 0.9rem;
    }

    thead th {
        padding: 14px 18px;
    }

    tbody td {
        padding: 14px 18px;
        border-bottom: 1px solid #f1f1f1;
    }

    tbody tr:hover {
        background-color: #f0f8ff;
        transition: 0.2s ease-in-out;
    }

    .btn-outline-primary,
    .btn-outline-danger {
        font-weight: 500;
        border-radius: 6px;
        padding: 5px 12px;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .btn-outline-primary:hover {
        background-color: #007bff;
        color: white;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }

    .text-muted {
        font-style: italic;
        color: #6c757d !important;
    }

    .btn-sm {
        margin-right: 5px;
    }
</style>

<div class="container-fluid">
    <h2>Manage Adopters</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Pet Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($adoptions as $adoption)
                    <tr>
    <td>{{ $adoption->name }}</td>
    <td>{{ $adoption->email }}</td>
    <td>{{ $adoption->phone }}</td>
    <td>{{ $adoption->pet_name }}</td>
    <td>
        <form action="{{ route('admin.adoptions.update', $adoption->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="Approved">
            <button type="submit" class="btn btn-sm btn-success">Approve</button>
        </form>

        <form action="{{ route('admin.adoptions.update', $adoption->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="Rejected">
            <button type="submit" class="btn btn-sm btn-danger">Reject</button>
        </form>
    </td>
    <td>
        <a href="{{ route('admin.adoptions.edit', $adoption->id) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('admin.adoptions.destroy', $adoption->id) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Delete this adoption?')" class="btn btn-sm btn-danger">Delete</button>
        </form>
    </td>
</tr>

                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No adoption records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
