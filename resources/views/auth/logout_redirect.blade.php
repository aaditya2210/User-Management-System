<!DOCTYPE html>
<html>
<head>
    <title>Logging Out</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
</head>
<body>
    <h1>Logging out...</h1>
    <p>Please wait while you are redirected to the login page.</p>

    <script>
        // Clear browser history
        window.history.pushState(null, document.title, location.href);
        window.addEventListener('popstate', function (event) {
            window.history.pushState(null, document.title, location.href);
        });
        
        // Redirect to login
        window.location.replace("{{ $loginUrl }}");
    </script>
</body>
</html>