@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Edit Shelter Application</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.shelters.update', $shelter->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="organization_name" class="form-label">Organization Name</label>
            <input type="text" name="organization_name" id="organization_name" class="form-control" value="{{ old('organization_name', $shelter->organization_name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $shelter->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $shelter->phone) }}">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" id="address" class="form-control" rows="3">{{ old('address', $shelter->address) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="pending" {{ old('status', $shelter->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ old('status', $shelter->status) === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ old('status', $shelter->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Application</button>
        <a href="{{ route('admin.shelters.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
