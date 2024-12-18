<!-- resources/views/errors/404.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <!-- Include SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <!-- Include SweetAlert2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Check if searchedTerm exists and use it
        var searchedTerm = @json($searchedTerm ?? ''); // Fallback to empty string if undefined
        
        Swal.fire({
            imageUrl: '{{ asset('logo.png') }}',
            imageWidth: 50,
            imageHeight: 46,
            title: 'Oops...',
            text: 'No ' + searchedTerm + ' found! Please go back.',
            confirmButtonText: 'Go Back'
        }).then((result) => {
            if (result.isConfirmed) {
                window.history.back();
            }
        });
    </script>

<script>
    // Function to check if the browser is offline
    function checkInternetConnection() {
        if (!navigator.onLine) {
            // If no internet connection, show a message
            showNoInternetMessage();
        }
    }

    // Function to show a "No Internet" message using SweetAlert2
    function showNoInternetMessage() {
        Swal.fire({
            title: 'No Internet Connection',
            text: 'Please check your connection and reload the page.',
            icon: 'warning',
            confirmButtonText: 'Reload',
            allowOutsideClick: false, // Prevents closing by clicking outside
            allowEscapeKey: false // Prevents closing by using the escape key
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload(); // Reload the page on confirmation
            }
        });
    }

    // Initial check on page load
    checkInternetConnection();

    // Listen for offline events
    window.addEventListener('offline', showNoInternetMessage);
</script>

</body>
</html>