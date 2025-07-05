function init() {
    try {
        // Set the coordinates for the location (Melbourne Zoo as an example)
        var myLatlng = new google.maps.LatLng(-37.81627997975159, 144.95373531531676);

        var mapOptions = {
            zoom: 7,
            center: myLatlng,
            scrollwheel: false,
            styles: [
                {
                    "featureType": "administrative.country",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "visibility": "simplified"
                        },
                        {
                            "hue": "#ff0000"
                        }
                    ]
                }
            ]
        };

        // Get the HTML DOM element that will contain the map
        var mapElement = document.getElementById('map');
        if (!mapElement) {
            console.error("Map element not found!");
            return;
        }

        // Create the Google Map using the element and options defined above
        var map = new google.maps.Map(mapElement, mapOptions);

        // Add a marker at the specified location
        new google.maps.Marker({
            position: myLatlng,
            map: map,
            icon: 'images/loc.png'
        });
    } catch (error) {
        console.error("Error initializing Google Map:", error);
    }
}

// Initialize the map when the window loads
window.addEventListener('load', init);