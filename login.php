<?php
session_start();

// MySQL database configuration
$servername = "localhost";
$username = "root";
$password = "9586";
$dbname = "penny_auction";

// Create a new MySQL connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // SQL query to check if the user exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, verify the password
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];

        if (password_verify($password, $hashedPassword)) {
            // Password is correct, login successful

            // Set session variables
            $_SESSION["email"] = $email;
            $_SESSION["loggedin"] = true;

            // Set a cookie to remember the user for 30 days
            $cookieName = "user";
            $cookieValue = $email;
            $cookieExpiration = time() + (30 * 24 * 60 * 60); // 30 days
            setcookie($cookieName, $cookieValue, $cookieExpiration, "/");

            // Redirect to the dashboard or desired page
            header("Location: dashboard.php");
            exit();
        } else {
            // Password is incorrect
            $errorMessage = "Invalid email or password.";
        }
    } else {
        // User does not exist
        $errorMessage = "Invalid email or password.";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penny Auction Website - Login</title>
    <!-- Add your SEO meta tags here -->

    <!-- Import necessary scripts -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</head>
<body>
    <!-- Header -->
    <?php include 'header.php'; ?>

    <div class="container">
        <h1>Login</h1>

        <?php
        // Check if success message exists in the URL
        if (isset($_GET["success"]) && $_GET["success"] == 1) {
            echo '<div class="alert alert-success" role="alert">You have successfully signed up!</div>';
        }
        ?>

        <?php if (isset($errorMessage)) { ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errorMessage; ?>
        </div>
        <?php } ?>

        <!-- Login form -->
        <form method="POST">
            <!-- Form fields -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
			<a href="forgot_password.php">Forgot Password?</a>
        </form>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
