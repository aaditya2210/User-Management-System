<!DOCTYPE html>
<html>
<head>
    <title>Logging Out</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <style>
        body { 
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 100px;
        }
    </style>
</head>
<body>
    <h1>Logging out...</h1>
    <p>Please wait while you are redirected to the login page.</p>

    <script>
        // Extremely aggressive approach to prevent back navigation
        (function() {
            // 1. Clear out local browser history as much as possible
            if (window.history && window.history.pushState) {
                // First, try clearing all history entries
                const historyLength = window.history.length;
                for (let i = 0; i < historyLength; i++) {
                    window.history.pushState(null, null, window.location.href);
                }
                
                // Now replace current state with login
                window.history.replaceState(null, null, "{{ $loginUrl }}");
            }
            
            // 2. Redirect to login
            window.location.replace("{{ $loginUrl }}");
            
            // 3. If user somehow stays on this page or tries to go back
            window.addEventListener('popstate', function() {
                window.location.replace("{{ $loginUrl }}");
            });
            
            // 4. Additional check for mobile browsers
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    window.location.replace("{{ $loginUrl }}");
                }
            });
            
            // 5. Final fallback
            setTimeout(function() {
                window.location.href = "{{ $loginUrl }}";
            }, 250);
        })();
    </script>
</body>
</html>