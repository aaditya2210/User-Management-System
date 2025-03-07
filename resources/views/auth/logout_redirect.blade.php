<!DOCTYPE html>
<html>
<head>
    <title>Logging Out</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
</head>
<body>
    <h2>Logging out...</h2>
    
    <script>
        // The key solution: wipe the browser history state
        window.onload = function() {
            // Clear all history and state by assigning a new empty history object
            window.history.pushState(null, null, '/login');
            window.history.replaceState(null, null, '/login');
            
            // Use window.location.replace instead of redirect
            // This removes the current page from history
            window.location.replace('/login');
            
            // Extra protection if the above fails
            setTimeout(function() {
                // If somehow they're still on this page, force navigation
                window.location.href = '/login';
            }, 100);
        };
    </script>
</body>
</html>