<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penny Auction Website - Dashboard</title>
    <!-- Add your SEO meta tags here -->

    <!-- Import necessary scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/js/bootstrap.min.js"></script>
</head>
<body>
    <!-- Header -->
    <?php include 'header.php'; ?>

    <div class="container">
        <h1>Welcome to the Dashboard</h1>
        <p>This is the dashboard page for the logged-in user: <?php echo $_SESSION["username"]; ?></p>
        <!-- Add your dashboard content here -->
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!-- Include your JavaScript files here -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/js/bootstrap.min.js"></script>
</body>
</html>