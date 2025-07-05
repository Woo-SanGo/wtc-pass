<!DOCTYPE html>
<html>
<head>
    <title>Add Pet</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #28A745;
            --text-color: #333;
            --light-gray: #f5f5f5;
            --border-color: #e0e0e0;
            --error-color: #dc3545;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-gray);
            color: var(--text-color);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            max-width: 550px;
            margin: 30px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        h2 {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 30px;
            font-weight: 700;
            font-size: 1.8em;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            font-size: 0.95em;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        textarea,
        select {
            width: calc(100% - 20px); /* Account for padding */
            padding: 12px 10px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1em;
            color: var(--text-color);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            box-sizing: border-box; /* Include padding in width */
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.2); /* Light primary color glow */
            outline: none;
        }

        textarea {
            resize: vertical;
            min-height: 90px;
        }

        input[type="file"] {
            padding: 8px 10px; /* Slightly less padding for file input */
        }

        button {
            width: 100%;
            padding: 14px 25px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: 600;
            transition: background-color 0.2s ease, transform 0.2s ease;
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.2);
        }

        button:hover {
            background-color: #218838; /* A slightly darker green */
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(40, 167, 69, 0.2);
        }

        .error {
            color: var(--error-color);
            background-color: #ffebe8; /* Light red background for errors */
            border: 1px solid #ffccc7;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.95em;
        }

        .error ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .error li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add a New Pet</h2>
        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif
        <form action="{{ route('pets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="shelter_id" value="{{ Auth::id() }}">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" required placeholder="Enter pet's name">
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <input type="text" name="type" id="type" required placeholder="e.g., Dog, Cat, Hamster">
            </div>
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" name="age" id="age" min="0" placeholder="Enter age in years">
            </div>
            <div class="form-group">
                <label for="behavior">Behavior</label>
                <input type="text" name="behavior" id="behavior" placeholder="e.g., Playful, Shy, Calm">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" placeholder="Tell us more about the pet..."></textarea>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" placeholder="Where is the pet located?">
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" accept="image/*">
            </div>
            <button type="submit">Add Pet</button>
        </form>
    </div>
</body>
</html>