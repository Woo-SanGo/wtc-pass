<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pet->name }} Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #28A745; /* Your specified green */
            --text-color: #333;
            --light-gray: #f5f5f5;
            --border-color: #e0e0e0;
            --dark-gray-text: #4a5568; /* For detail labels */
            --red-love: #e74c3c; /* For love button */
            --blue-follow: #3498db; /* For follow button */
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
            max-width: 700px; /* Slightly wider container for details */
            margin: 30px auto;
            padding: 35px; /* Increased padding */
            border-radius: 12px; /* Consistent rounded corners */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); /* Consistent shadow */
            overflow: hidden; /* Ensures content respects border-radius */
            display: flex; /* Use flexbox for internal layout */
            flex-direction: column; /* Stack items vertically */
        }

        h2 {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 25px; /* Spacing below title */
            font-weight: 700;
            font-size: 2.2em; /* Larger, more prominent title */
        }

        .pet-image-wrapper {
            width: 100%;
            max-height: 400px; /* Adjusted max height for images for better aspect ratio */
            overflow: hidden;
            border-radius: 10px; /* Slightly rounded image corners */
            margin-bottom: 30px; /* Space below image */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05); /* Soft shadow for image */
            display: flex; /* Use flexbox to center image vertically/horizontally */
            justify-content: center;
            align-items: center;
            background-color: #e9ecef; /* Placeholder background for image area */
        }

        .pet-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensures image fills space without distortion */
            display: block; /* Removes extra space below image */
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr; /* Single column by default */
            gap: 15px; /* Space between detail items */
            margin-bottom: 25px; /* Space before description */
        }

        @media (min-width: 600px) { /* Two columns on larger screens */
            .detail-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        .detail-item {
            display: flex;
            flex-direction: column; /* Stack label and value */
            padding: 12px 15px;
            background-color: var(--light-gray);
            border-radius: 8px; /* Rounded detail items */
            font-size: 1em;
            line-height: 1.5;
        }

        .detail-label {
            font-weight: 600;
            color: var(--dark-gray-text);
            margin-bottom: 5px; /* Space between label and value */
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .detail-value {
            color: var(--text-color);
            font-weight: 500;
        }

        .description-section {
            background-color: var(--light-gray);
            padding: 20px;
            border-radius: 8px;
            margin-top: 15px; /* Space after other details */
        }

        .description-label {
            font-weight: 600;
            color: var(--dark-gray-text);
            margin-bottom: 10px;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .description-text {
            color: var(--text-color);
            line-height: 1.6;
        }

        .actions {
            display: flex;
            flex-wrap: wrap; /* Allow buttons to wrap on smaller screens */
            justify-content: flex-end; /* Aligns buttons to the right */
            gap: 15px; /* Space between buttons */
            margin-top: 30px;
        }

        @media (max-width: 600px) {
            .actions {
                justify-content: center; /* Center buttons on small screens */
            }
            .back-button {
                margin-right: 0; /* Remove auto margin on small screens */
                width: 100%; /* Make back button full width */
                margin-bottom: 15px; /* Add space below back button */
            }
            .btn-adopt, .btn-love, .btn-follow {
                flex-grow: 1; /* Allow other buttons to grow and fill space */
            }
        }


        .back-button, .btn-adopt, .btn-love, .btn-follow {
            display: inline-flex; /* Changed to inline-flex to center icon/text */
            align-items: center; /* Vertically center icon/text */
            justify-content: center; /* Horizontally center icon/text */
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .back-button {
            background-color: #6c757d; /* A neutral gray for back button */
            color: white;
            box-shadow: 0 4px 10px rgba(108, 117, 125, 0.2);
            margin-right: auto; /* Pushes back button to the left */
        }

        .back-button:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }
        .back-button:active {
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(108, 117, 125, 0.2);
        }

        .btn-adopt {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.2);
        }

        .btn-adopt:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }
        .btn-adopt:active {
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(40, 167, 69, 0.2);
        }

        .btn-love {
            background-color: #f8d7da; /* Light red background by default */
            color: var(--red-love); /* Red text/icon color by default */
            box-shadow: 0 4px 10px rgba(231, 76, 60, 0.2);
            border: 1px solid var(--red-love); /* Border for outlined look */
            padding: 12px 20px; /* Adjust padding slightly for icon */
        }

        .btn-love:hover {
            background-color: #f5c6cb; /* Slightly darker light red on hover */
            transform: translateY(-2px);
        }
        .btn-love:active {
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(231, 76, 60, 0.2);
        }

        /* Styles for the SVG icon within the button */
        .btn-love .icon {
            width: 20px;
            height: 20px;
            margin-right: 8px; /* Space between icon and text */
            transition: fill 0.2s ease, stroke 0.2s ease; /* Smooth transition for icon color */
        }

        /* Style for when the love button is 'loved' (clicked) */
        .btn-love.is-loved {
            background-color: var(--red-love); /* Solid red background */
            color: white; /* White text/icon */
        }

        .btn-love.is-loved .icon {
            fill: white !important; /* Fill the heart with white */
            stroke: none !important; /* Remove stroke */
        }
        .btn-love.is-loved:hover {
            background-color: #c0392b; /* Darker red on hover when loved */
        }


        .btn-follow {
            background-color: #d4e7f7; /* Light blue background by default */
            color: var(--blue-follow); /* Blue text/icon color by default */
            box-shadow: 0 4px 10px rgba(52, 152, 219, 0.2);
            border: 1px solid var(--blue-follow); /* Border for outlined look */
            padding: 12px 20px; /* Adjust padding slightly for icon/emoji */
        }

        .btn-follow:hover {
            background-color: #bfdcf2; /* Slightly darker light blue on hover */
            transform: translateY(-2px);
        }
        .btn-follow:active {
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(52, 152, 219, 0.2);
        }

        /* Styles for the emoji within the button */
        .btn-follow .emoji {
            font-size: 1.2em; /* Adjust emoji size */
            margin-right: 8px; /* Space between emoji and text */
            transition: color 0.2s ease; /* Smooth transition for emoji color */
        }

        /* Style for when the follow button is 'followed' (clicked) */
        .btn-follow.is-followed {
            background-color: var(--blue-follow); /* Solid blue background */
            color: white; /* White text/emoji */
        }

        .btn-follow.is-followed .emoji {
            color: white !important; /* Make emoji white when followed */
        }
        .btn-follow.is-followed:hover {
            background-color: #2980b9; /* Darker blue on hover when followed */
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Meet {{ $pet->name }}!</h2>
        
        <div class="pet-image-wrapper">
            {{-- The `src` attribute is the key. It should point to the public URL of your image. --}}
            <img 
                src="{{ $pet->image ? asset('storage/' . $pet->image) : 'https://placehold.co/700x400/a78bfa/ffffff?text=Image+Not+Available' }}" 
                alt="{{ $pet->name }}" 
                {{-- Removed redundant width attribute here, as CSS handles sizing --}}
                onerror="this.onerror=null;this.src='https://placehold.co/700x400/a78bfa/ffffff?text=Image+Not+Available';"
            >
        </div>

        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label">Type</span>
                <span class="detail-value">{{ $pet->type }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Age</span>
                <span class="detail-value">{{ $pet->age ?? 'N/A' }} years old</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Behavior</span>
                <span class="detail-value">{{ $pet->behavior ?? 'N/A' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Location</span>
                <span class="detail-value">{{ $pet->location ?? 'N/A' }}</span>
            </div>
        </div>

        <div class="description-section">
            <h3 class="description-label">About {{ $pet->name }}</h3>
            <p class="description-text">{{ $pet->description ?? 'No detailed description available at this time.' }}</p>
        </div>

        <div class="actions">
            <a href="{{ url()->previous() }}" class="back-button">Back to All Pets</a>
            <a href="#" id="loveBtn" class="btn-love">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
                <span>Love</span>
            </a>
            <a href="#" id="followBtn" class="btn-follow">
                <span class="emoji">👤</span> <span>Follow</span>
            </a>
            <a href="{{ url('/adoption') }}" class="btn-adopt">Adopt</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loveButton = document.getElementById('loveBtn');
            const followButton = document.getElementById('followBtn');
            
            // Initial states (in a real app, these would come from the server)
            // You might load these from a data attribute or a server-side variable
            let isLoved = false; 
            let isFollowed = false;

            // Love Button Logic
            loveButton.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default link behavior
                
                loveButton.classList.toggle('is-loved');
                isLoved = loveButton.classList.contains('is-loved'); 

                if (isLoved) {
                    console.log('Pet loved!');
                    // Example AJAX: fetch('/api/pets/{{ $pet->id }}/love', { method: 'POST' });
                } else {
                    console.log('Pet unloved!');
                    // Example AJAX: fetch('/api/pets/{{ $pet->id }}/unlove', { method: 'POST' });
                }
            });

            // Follow Button Logic
            followButton.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default link behavior
                
                followButton.classList.toggle('is-followed');
                isFollowed = followButton.classList.contains('is-followed'); 

                const emojiSpan = followButton.querySelector('.emoji');
                const textSpan = followButton.querySelector('span:not(.emoji)'); // Target the text span

                if (isFollowed) {
                    emojiSpan.textContent = '👥'; 
                    textSpan.textContent = 'Following'; 
                    console.log('Pet followed!');
                    // Example AJAX: fetch('/api/pets/{{ $pet->id }}/follow', { method: 'POST' });
                } else {
                    emojiSpan.textContent = '👤'; 
                    textSpan.textContent = 'Follow'; 
                    console.log('Pet unfollowed!');
                    // Example AJAX: fetch('/api/pets/{{ $pet->id }}/unfollow', { method: 'POST' });
                }
            });
        });
    </script>
</body>
</html>