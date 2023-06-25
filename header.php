<?php
// Create a MySQL connection
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your MySQL username
$password = "9586"; // Replace with your MySQL password
$database = "penny_auction"; // Replace with your database name

// Create a connection
$connection = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if the user is logged in
$isLoggedIn = false; // Assuming the user is not logged in initially

// Perform a SQL query to check the user's login status
// Replace 'users' with the actual table name and 'username' and 'password' with the appropriate column names in your database
$query = "SELECT COUNT(*) AS count FROM users WHERE username = 'username_value' AND password = 'password_value'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

if ($row['count'] > 0) {
    // The user is logged in
    $isLoggedIn = true;
}
?>

<header>
    <!-- Import necessary scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <!-- Import necessary stylesheets -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="/header.css">
    <link rel="stylesheet" href="/footer.css">
</header>

<body>
    <header>
        <div class="container">
            <a class="navbar-brand" href="/index.php">Penny Auction Website</a>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container">
                    <!-- Other header content -->
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Home</a>
                                <?php if (!$isLoggedIn) { ?>
                                <a class="nav-link" href="login.php">Login</a>
                                <a class="nav-link" href="signup.php">Signup</a>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <!-- Rest of the header code -->
</body>