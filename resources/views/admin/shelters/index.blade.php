@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Manage Shelter Applications</h2>
        {{-- Optional: Add a button to create a new shelter application if applicable --}}
        {{-- <a href="{{ route('admin.shelters.create') }}" class="btn btn-success">Add New Shelter</a> --}}
    </div>
<a href="{{ route('admin.shelters.export') }}" class="btn btn-success">Export as Excel</a>


    {{-- Session-based alerts --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Status Filter --}}
    <div class="mb-3">
        <form action="{{ route('admin.shelters.index') }}" method="GET" class="d-flex align-items-center gap-2">
            <label for="statusFilter" class="form-label mb-0">Filter by Status:</label>
            <select class="form-select w-auto" id="statusFilter" name="status" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Organization</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($shelters as $shelter)
                    <tr>
                        <td>{{ $shelter->id }}</td>
                        <td>{{ $shelter->organization_name }}</td>
                        <td>{{ $shelter->email }}</td>
                        <td>
                            {{-- Single form for status update --}}
                            {{-- Single form for status update --}}
                        <form action="{{ route('admin.shelters.update', $shelter->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <select 
                                name="status" 
                                class="form-select form-select-sm rounded-pill border-0 shadow-sm px-3 py-1 small transition focus:ring-2 focus:ring-primary focus:border-primary" 
                                style="min-width: 120px; background-color: #f8f9fa;"
                                onchange="this.form.submit()"
                            >
                                <option value="pending" {{ $shelter->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $shelter->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $shelter->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </form>

                        </td>
                        <td>{{ $shelter->created_at->format('Y-m-d') }}</td>
                        <td class="text-center">
                            {{-- View/Edit Button --}}
                            <a href="{{ route('admin.shelters.show', $shelter->id) }}" class="btn btn-sm btn-info me-1" title="View Details">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <a href="{{ route('admin.shelters.edit', $shelter->id) }}" class="btn btn-sm btn-warning me-1" title="Edit">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>

                            {{-- Delete Form --}}
                            <form action="{{ route('admin.shelters.destroy', $shelter->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this shelter application? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-info-circle me-1"></i> No shelter applications found for the selected filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection