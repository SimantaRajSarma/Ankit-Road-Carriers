<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <link
      href="assets/vendor/bootstrap/css/bootstrap.min.css"
      rel="stylesheet"
    />
</head>
<body>
    <div class="container text-center">
        <h1 class="text-success">Success!</h1>
        <p>Your data has been successfully submitted.</p>
        <p>Redirecting back to the previous page...</p>
    </div>

    <script>
        setTimeout(function() {
            window.history.back();
        }, 2000); // Redirect back after 2 seconds
    </script>
</body>
</html>
