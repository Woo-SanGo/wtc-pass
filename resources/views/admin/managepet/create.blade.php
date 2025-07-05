@extends('layouts.admin')

@section('content')
<style>
    /* General styles for a modern look - Keep this consistent with the edit page */
    :root {
        --primary-color: #4CAF50; /* A friendly green */
        --primary-hover: #45a049;
        --secondary-color: #6c757d;
        --secondary-hover: #5a6268;
        --background-light: #f8f9fa;
        --card-background: #ffffff;
        --border-color: #e0e0e0;
        --text-color: #343a40;
        --label-color: #495057;
        --danger-color: #dc3545;
        --focus-ring-color: rgba(76, 175, 80, 0.25);
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--background-light);
        color: var(--text-color);
        line-height: 1.6;
    }

    .container {
        max-width: 800px;
        margin: 50px auto;
        padding: 0 15px;
    }

    .card {
        background-color: var(--card-background);
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        padding: 40px;
        border: none;
    }

    h2 {
        text-align: center;
        color: var(--primary-color);
        margin-bottom: 35px;
        font-weight: 700;
        font-size: 2.2em;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--label-color);
        font-size: 0.95em;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 1em;
        color: var(--text-color);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px var(--focus-ring-color);
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .form-control-file {
        display: block;
        width: 100%;
        padding: 12px 0;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--background-light);
        color: var(--label-color);
        cursor: pointer;
        transition: border-color 0.2s ease;
    }

    .form-control-file:hover {
        border-color: var(--secondary-color);
    }

    /* Button styles */
    .btn-group {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        justify-content: flex-end; /* Align buttons to the right */
    }

    .btn {
        padding: 12px 28px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: background-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
        font-size: 1em;
        text-align: center;
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: white;
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.2);
    }

    .btn-primary:hover {
        background-color: var(--primary-hover);
        transform: translateY(-2px);
    }

    .btn-primary:active {
        transform: translateY(0);
        box-shadow: 0 2px 5px rgba(76, 175, 80, 0.2);
    }

    .btn-secondary {
        background-color: var(--secondary-color);
        color: white;
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.1);
    }

    .btn-secondary:hover {
        background-color: var(--secondary-hover);
        transform: translateY(-2px);
    }

    .btn-secondary:active {
        transform: translateY(0);
        box-shadow: 0 2px 5px rgba(108, 117, 125, 0.1);
    }

    /* Alerts */
    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 25px;
        font-size: 0.95em;
        line-height: 1.5;
    }

    .alert-danger {
        background-color: #fdd;
        color: var(--danger-color);
        border: 1px solid var(--danger-color);
    }

    .alert ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .alert li {
        margin-bottom: 5px;
    }
</style>

<div class="container">
    <div class="card">
        <h2>Add New Pet</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.managepet.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Pet Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required placeholder="e.g., Buddy">
            </div>

            <div class="form-group">
                <label for="type">Type</label>
                <input type="text" name="type" id="type" value="{{ old('type') }}" class="form-control" required placeholder="e.g., Dog, Cat, Hamster">
            </div>

            <div class="form-group">
                <label for="age">Age</label>
                <input type="text" name="age" id="age" value="{{ old('age') }}" class="form-control" placeholder="e.g., 2 years, 6 months">
            </div>

            <div class="form-group">
                <label for="behavior">Behavior</label>
                <input type="text" name="behavior" id="behavior" value="{{ old('behavior') }}" class="form-control" placeholder="e.g., Playful, Calm, Energetic">
            </div>

            <div class="form-group">
                <label for="location">Location Link</label>
                <input type="text" name="location" id="location" value="{{ old('location') }}" class="form-control" placeholder="e.g., Google Maps link to shelter">
            </div>

            <div class="form-group">
                <label for="image">Upload Image</label>
                <input type="file" name="image" id="image" class="form-control-file">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="5" placeholder="Tell us more about this pet..."></textarea>
            </div>

            <div class="form-group">
                <label for="shelter_id">Select Shelter</label>
                <select name="shelter_id" id="shelter_id" class="form-control" required>
                    <option value="">-- Select a Shelter --</option>
                    @foreach ($shelters as $shelter)
                        <option value="{{ $shelter->id }}" {{ old('shelter_id') == $shelter->id ? 'selected' : '' }}>
                            {{ $shelter->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Save Pet</button>
                <a href="{{ route('admin.managepet.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection