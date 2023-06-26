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


// Why do you have this here?
// In login.php you set $_SESSION["loggedin"] = true; so just check if ($_SESSION['loggedin']) and you don't need to query the database again...
// But if you wanted to do this here then use the following..

$username = $_SESSION['username']; // You will need to adjust this to how you're pulling the username (GET, POST, SESSION)
$password = $_SESSION['password']; // Same thing here...

// Changed to prepared statement
$query->$connection->prepare("SELECT password FROM users WHERE username = ?");
$query->bind_param('s', $username)

$query->execute();

$result = $query->get_result();
$row = $result->fetch_assoc();

// Use password verify to check that the password matches
// This was done because in forgot password and in signup you are hashing the password with password_hash, which is a one way hash.
// You cannot just check if the session password equals the database password. You need to check if the new password hash resolves to a matching result using password_verify.
if ($row && password_verify($password, $row['password']))
	$isLoggedIn = true;
else
	$isLoggedIn = false;

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
