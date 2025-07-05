@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Apply for Pet Adoption</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('applications.adoption-submit') }}">

        @csrf
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Pet Name</label>
            <input type="text" name="pet_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Why do you want to adopt?</label>
            <textarea name="reason" class="form-control" required></textarea>
        </div>
        <button class="btn btn-success mt-2">Submit Application</button>
    </form>
</div>
@endsection