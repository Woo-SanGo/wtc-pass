@extends('layouts.admin')

@section('content')
<style>
    .container-form {
        max-width: 600px;
        margin: 40px auto;
        padding: 30px 25px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        font-family: 'Arial', sans-serif;
        color: black;
    }

    h1 {
        margin-bottom: 30px;
        font-weight: 700;
        text-align: left;
        color: black;
    }

    label {
        font-weight: 600;
        color: #333;
        display: block;
        margin-bottom: 6px;
        margin-top: 15px;
    }

    input.form-control {
        width: 100%;
        border-radius: 5px;
        border: 1px solid #ced4da;
        padding: 10px 12px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    input.form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        outline: none;
    }

    .btn-primary {
        margin-top: 25px;
        font-weight: 700;
        padding: 10px 25px;
        border-radius: 5px;
        border: none;
        background-color: #007bff;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #842029;
        border-radius: 5px;
        padding: 15px 20px;
        margin-bottom: 25px;
        border: 1px solid #f5c2c7;
        font-weight: 600;
    }
</style>

<div class="container-form">
    <h1>Create User</h1>

    @if ($errors->any())
        <div class="alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <label for="name">Name <span style="color:red;">*</span></label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>

        <label for="address">Address</label>
        <input type="text" id="address" name="address" class="form-control" value="{{ old('address') }}">

        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}">

        <label for="email">Email <span style="color:red;">*</span></label>
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
