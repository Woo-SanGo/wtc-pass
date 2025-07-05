@extends('layouts.admin')

@section('content')
<style>
    body {
        color: #333; /* Darker text for better readability */
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa; /* Light background */
    }

    .container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 30px; /* Increased padding */
        border-radius: 12px; /* More rounded corners */
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        background-color: white; /* White container */
        color: #333;
    }

    h1, h2 {
        color: #343a40; /* Darker heading */
        text-align: left;
        margin-bottom: 30px;
        font-size: 2.2em; /* Slightly smaller heading */
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
        background-color: #d1e7dd; /* Success background */
        color: #0f5132; /* Success text */
        border: 1px solid #badbcc;
    }

    .create-pet-btn {
        display: inline-block;
        background-color: #007bff;
        color: white;
        padding: 12px 24px; /* Larger button */
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600; /* Semi-bold */
        transition: background-color 0.3s ease;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Button shadow */
    }

    .create-pet-btn:hover {
        background-color: #0056b3;
    }

    /* Search form styles */
    form.search-form {
        margin-bottom: 20px;
        display: flex; /* Flexbox for layout */
        align-items: center; /* Vertically center items */
    }

    form.search-form input[type="text"] {
        padding: 10px 16px;
        width: 300px;
        border-radius: 8px;
        border: 1px solid #ced4da; /* Light border */
        font-size: 1em;
        transition: border-color 0.3s ease;
    }

    form.search-form input[type="text"]:focus {
        outline: none;
        border-color: #80bdff; /* Focused border color */
    }

    form.search-form button {
        padding: 10px 16px;
        border-radius: 8px;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        font-weight: bold;
        margin-left: 10px;
        transition: background-color 0.3s ease;
    }

    form.search-form button:hover {
        background-color: #0056b3;
    }

    form.search-form a.clear-btn {
        margin-left: 10px;
        color: #dc3545;
        font-weight: bold;
        text-decoration: none;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    form.search-form a.clear-btn:hover {
        text-decoration: underline;
        color: #c82333;
    }

    .pet-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        border-radius: 12px;
        overflow: hidden;
        color: #333;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Table shadow */
    }

    .pet-table th,
    .pet-table td {
        padding: 14px 18px; /* Increased padding */
        text-align: left;
        border-bottom: 1px solid #dee2e6; /* Light border */
        vertical-align: middle;
    }

    .pet-table th {
        font-weight: bold;
        text-transform: uppercase;
        font-size: 0.9em;
        background-color: #f2f2f2; /* Light gray header */
    }

    .pet-table tbody tr:hover {
        background-color: #f5f5f5; /* Light hover */
    }

    .actions-column a,
    .actions-column button {
        padding: 10px 16px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.9em;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
        margin-right: 5px;
        border: none;
        display: inline-block;
        color: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .actions-column a.edit-btn {
        background-color: #17a2b8;
    }
    .actions-column a.edit-btn:hover {
        background-color: #117a8b;
    }

    .actions-column button.delete-btn {
        background-color: #dc3545;
    }
    .actions-column button.delete-btn:hover {
        background-color: #c82333;
    }

    img.pet-thumb {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        object-position: center center;
        display: block;
        overflow: hidden;
        box-shadow: 0 0 8px rgba(0,0,0,0.2); /* Image shadow */
        cursor: pointer; /* Add cursor pointer to indicate it's clickable */
        transition: transform 0.2s ease-in-out;
    }

    img.pet-thumb:hover {
        transform: scale(1.1); /* Slight zoom on hover */
    }

    /* Styles for the image modal */
    .image-modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1000; /* Sit on top */
        padding-top: 50px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
    }

    .image-modal-content {
        margin: auto;
        display: block;
        max-width: 80%;
        max-height: 80%;
        object-fit: contain;
    }

    /* Close button */
    .close-modal {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close-modal:hover,
    .close-modal:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* Styles for the toggle button */
    .toggle-adopters-btn {
        background: none;
        border: none;
        font-size: 1.2em;
        cursor: pointer;
        transition: transform 0.2s ease-in-out;
        vertical-align: middle; /* Align with text */
        margin-left: 5px;
        color: #6c757d; /* A subtle color for the arrow */
    }

    .toggle-adopters-btn.rotated {
        transform: rotate(90deg); /* Rotate for expanded state */
    }

    .toggle-adopters-btn:hover {
        transform: scale(1.2); /* Slight zoom on hover */
    }

    /* Adopter details styles */
    .adopters-details-row {
        background-color: #fefefe; /* Very light background for the expanded row */
    }

    .adopters-list {
        list-style: none;
        padding: 0;
        margin: 10px 0 0 0; /* Adjusted margin */
        display: flex;
        flex-wrap: wrap; /* Allow items to wrap */
        gap: 15px; /* Spacing between adopter cards */
    }

    .adopter-card {
        flex: 1 1 calc(50% - 15px); /* Two columns, adjust as needed */
        min-width: 300px; /* Minimum width for cards */
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); /* More prominent shadow for cards */
        border: 1px solid #e9ecef; /* Light border */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .adopter-info {
        font-size: 0.95em;
        margin-bottom: 15px; /* Space between info and buttons */
    }

    .adopter-info div {
        margin-bottom: 5px; /* Space between individual info lines */
    }

    .adopter-info strong {
        color: #495057; /* Slightly darker for labels */
        font-weight: 600;
    }

    .adopter-status {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 5px;
        font-weight: bold;
        font-size: 0.85em;
        margin-left: 8px;
        text-transform: capitalize; /* Capitalize status text */
    }

    .adopter-status.Approved {
        background-color: #d4edda;
        color: #155724;
    }

    .adopter-status.Rejected {
        background-color: #f8d7da;
        color: #721c24;
    }

    .adopter-status.Pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .adopter-actions {
        display: flex;
        gap: 10px; /* Space between buttons */
        margin-top: 10px; /* Ensure space from info */
    }

    .adopter-actions button {
        flex: 1; /* Make buttons take equal width */
        padding: 10px 15px;
        border-radius: 8px;
        font-size: 0.9em;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease; /* Smooth transition for all properties */
    }

    .adopter-actions button[type="submit"][value="Approved"] { /* Targeting the Approve button */
        background-color: #28a745;
    }
    .adopter-actions button[type="submit"][value="Approved"]:hover {
        background-color: #218838;
        transform: translateY(-1px); /* Slight lift on hover */
    }

    .adopter-actions button[type="submit"][value="Rejected"] { /* Targeting the Reject button */
        background-color: #dc3545;
    }
    .adopter-actions button[type="submit"][value="Rejected"]:hover {
        background-color: #c82333;
        transform: translateY(-1px); /* Slight lift on hover */
    }

    /* Responsive adjustments for adopter cards */
    @media (max-width: 992px) {
        .adopter-card {
            flex: 1 1 calc(100% - 15px); /* Single column on smaller screens */
            min-width: unset;
        }
    }
</style>

<div class="container mt-4">
    <h2 class="mb-4">Pets Management</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('admin.managepet.index') }}" class="search-form">
        <input
            type="text"
            name="search"
            placeholder="Search pets by name"
            value="{{ request('search') }}"
        >
        <button type="submit">Search</button>

        @if(request('search'))
            <a href="{{ route('admin.managepet.index') }}" class="clear-btn">Clear</a>
        @endif
    </form>

    <a href="{{ route('admin.managepet.create') }}" class="create-pet-btn">+ Add New Pet</a>

    <table class="pet-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Type</th>
                <th>Age</th>
                <th>Behavior</th>
                <th>Shelter</th>
                <th>Location</th>
                <th style="width: 200px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pets as $index => $pet)
                <tr>
                    <td>{{ $index + $pets->firstItem() }}</td>
                    <td>
                        @if ($pet->image)
                    <img 
                        src="{{ asset('storage/' . $pet->image) }}" 
                        alt="{{ $pet->name }}" 
                        class="pet-thumb" 
                        data-full-src="{{ asset('storage/' . $pet->image) }}"
                        onerror="this.onerror=null;this.src='https://placehold.co/150x150/a78bfa/ffffff?text=No+Image';"
                    />
                @else
                    <span>No Image</span>
                @endif

                    </td>
                    <td>
                        {{ $pet->name }}
                        {{-- Toggle Button --}}
                        @php $adopters = $adoptionApplications->where('pet_name', $pet->name); @endphp
                        @if ($adopters->count() > 0)
                            <button onclick="toggleAdopters('adopters-{{ $pet->id }}', this)"
                                    class="toggle-adopters-btn">
                                &gt; </button>
                        @endif
                    </td>
                    <td>{{ $pet->type }}</td>
                    <td>{{ $pet->age ?? '-' }}</td>
                    <td>{{ $pet->behavior ?? '-' }}</td>
                    <td>{{ $pet->shelter ? $pet->shelter->name : 'N/A' }}</td>
                    <td>{{ $pet->location ?? '-' }}</td>
                    <td class="actions-column">
                        <a href="{{ route('admin.managepet.edit', $pet->id) }}" class="edit-btn">Edit</a>

                        <form action="{{ route('admin.managepet.destroy', $pet->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this pet?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>

                {{-- Hidden Row for Adopters --}}
                @if ($adopters->count() > 0)
                <tr id="adopters-{{ $pet->id }}" class="adopters-details-row" style="display: none;">
                    <td colspan="9">
                        <strong>Adoption Requests for {{ $pet->name }}:</strong>
                        <ul class="adopters-list">
                            @foreach ($adopters as $adopter)
                                <li class="adopter-card">
                                    <div class="adopter-info">
                                        <div><strong>Name:</strong> {{ $adopter->name }}</div>
                                        <div><strong>Email:</strong> {{ $adopter->email }}</div>
                                        <div><strong>Phone:</strong> {{ $adopter->phone }}</div>
                                        <div>
                                            <strong>Status:</strong>
                                            <span class="adopter-status {{ $adopter->status }}">
                                                {{ $adopter->status ?? 'Pending' }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="adopter-actions">
                                        <form action="{{ route('admin.adoptions.update', $adopter->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="Approved">
                                            <button type="submit" value="Approved">
                                                Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.adoptions.update', $adopter->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="Rejected">
                                            <button type="submit" value="Rejected">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                @endif
            @empty
                <tr>
                    <td colspan="9" class="text-center">No pets found.</td>
                </tr>
            @endforelse
        </tbody>

    </table>

    <div class="mt-3">
        {{ $pets->links() }}
    </div>
</div>

<div id="imageModal" class="image-modal">
    <span class="close-modal">&times;</span>
    <img class="image-modal-content" id="img01">
</div>

<script>
    // Get the modal
    var modal = document.getElementById("imageModal");

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var images = document.querySelectorAll(".pet-thumb");
    var modalImg = document.getElementById("img01");

    images.forEach(function(img) {
        img.onclick = function(){
            modal.style.display = "block";
            modalImg.src = this.getAttribute('data-full-src'); // Use data-full-src for full image
        }
    });

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close-modal")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the image, close the modal
    modal.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    function toggleAdopters(id, button) {
        const row = document.getElementById(id);
        if (row.style.display === 'none') {
            row.style.display = 'table-row';
            button.classList.add('rotated'); // Add class to rotate arrow
        } else {
            row.style.display = 'none';
            button.classList.remove('rotated'); // Remove class to unrotate arrow
        }
    }
</script>
@endsection