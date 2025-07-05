<!-- resources/views/application/shelter-form.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Apply to Become a Shelter</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('applications.shelter-submit') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Organization Name</label>
            <input type="text" name="organization_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control">
        </div>
        <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Tell us about your shelter</label>
            <textarea name="message" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label>Upload License Document (PDF, JPG, PNG)</label>
            <input type="file" name="proof_document" class="form-control-file" required>
        </div>
        <button class="btn btn-success mt-2">Submit Shelter Application</button>
    </form>
</div>
@endsection
