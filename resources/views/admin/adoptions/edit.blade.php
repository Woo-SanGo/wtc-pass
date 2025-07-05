@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Edit Adoption Status</h2>

    <form action="{{ route('admin.adoptions.update', $adoption->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select">
                <option value="Pending" {{ $adoption->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Approved" {{ $adoption->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                <option value="Rejected" {{ $adoption->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('admin.adoptions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
