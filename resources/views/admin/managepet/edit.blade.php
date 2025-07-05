@extends('layouts.admin')

@section('content')
<style>
    /* General styles for a modern look */
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
        font-family: 'Inter', sans-serif; /* Assuming Inter is linked, otherwise use a system font */
        background-color: var(--background-light);
        color: var(--text-color);
        line-height: 1.6;
    }

    .container {
        max-width: 800px;
        margin: 50px auto;
        padding: 0 15px; /* Add some horizontal padding */
    }

    .card {
        background-color: var(--card-background);
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08); /* More pronounced, modern shadow */
        padding: 40px; /* Increased padding inside the card */
        border: none; /* Remove default border */
    }

    h2 {
        text-align: center;
        color: var(--primary-color);
        margin-bottom: 35px; /* More space below heading */
        font-weight: 700;
        font-size: 2.2em; /* Slightly larger heading */
    }

    .form-group {
        margin-bottom: 25px; /* More vertical space between form fields */
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--label-color);
        font-size: 0.95em; /* Slightly smaller label text */
    }

    .form-control {
        width: 100%;
        padding: 12px 15px; /* Increased padding for input fields */
        border: 1px solid var(--border-color);
        border-radius: 8px; /* Rounded corners for inputs */
        font-size: 1em;
        color: var(--text-color);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px var(--focus-ring-color); /* Focus ring */
    }

    textarea.form-control {
        min-height: 120px; /* Min height for description */
        resize: vertical;
    }

    .form-control-file {
        display: block;
        width: 100%;
        padding: 12px 0; /* Adjust padding for file input */
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--background-light); /* Light background for file input */
        color: var(--label-color);
        cursor: pointer;
        transition: border-color 0.2s ease;
    }

    .form-control-file:hover {
        border-color: var(--secondary-color);
    }

    /* Style for current image preview */
    .current-image-preview {
        margin-top: 10px;
        margin-bottom: 25px;
        padding: 15px;
        background-color: var(--background-light);
        border-radius: 8px;
        border: 1px dashed var(--border-color);
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .current-image-preview img {
        max-width: 120px;
        height: auto;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .current-image-preview span {
        font-style: italic;
        color: var(--label-color);
    }

    /* Button styles */
    .btn-group {
        display: flex;
        gap: 15px; /* Space between buttons */
        margin-top: 30px;
        justify-content: flex-end; /* Align buttons to the right */
    }

    .btn {
        padding: 12px 28px; /* Larger padding for buttons */
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
        list-style: none; /* Remove bullet points */
    }

    .alert li {
        margin-bottom: 5px;
    }
</style>

<div class="container">
    <div class="card">
        <h2>Edit Pet: {{ $pet->name }}</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.managepet.update', $pet->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Pet Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $pet->name) }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="type">Type</label>
                <input type="text" name="type" id="type" value="{{ old('type', $pet->type) }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="age">Age</label>
                <input type="text" name="age" id="age" value="{{ old('age', $pet->age) }}" class="form-control" placeholder="e.g., 2 years, 6 months">
            </div>

            <div class="form-group">
                <label for="behavior">Behavior</label>
                <input type="text" name="behavior" id="behavior" value="{{ old('behavior', $pet->behavior) }}" class="form-control" placeholder="e.g., Playful, Calm, Energetic">
            </div>

            <div class="form-group">
                <label for="location">Location Link</label>
                <input type="text" name="location" id="location" value="{{ old('location', $pet->location) }}" class="form-control" placeholder="e.g., Google Maps link to shelter">
            </div>

            <div class="form-group">
                <label>Current Image</label>
                <div class="current-image-preview">
                    @if ($pet->image)
                        <img src="{{ asset('storage/' . $pet->image) }}" alt="{{ $pet->name }}">
                    @else
                        <span>No image uploaded</span>
                    @endif
                </div>
                <label for="image">Upload New Image (optional)</label>
                <input type="file" name="image" id="image" class="form-control-file">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="5" placeholder="Tell us more about {{ $pet->name }}...">{{ old('description', $pet->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="shelter_id">Select Shelter</label>
                <select name="shelter_id" id="shelter_id" class="form-control" required>
                    <option value="">-- Select a Shelter --</option> {{-- Added placeholder option --}}
                    @foreach ($shelters as $shelter)
                        <option value="{{ $shelter->id }}" {{ $pet->shelter_id == $shelter->id ? 'selected' : '' }}>
                            {{ $shelter->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Update Pet</button>
                <a href="{{ route('admin.managepet.index') }}" class="btn btn-secondary">Cancel</a>
            </div>

        </form>
    </div>
</div>
@endsection