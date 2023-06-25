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

    // Generate a new password
    $newPassword = generateRandomPassword();

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the user's password in the database
    $sql = "UPDATE users SET password = '$hashedPassword' WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        // Password updated successfully

        // Send the new password to the user's email
        sendNewPasswordByEmail($email, $newPassword);

        // Redirect to the login page with a success message
        header("Location: login.php?success=1");
        exit();
    } else {
        // Error occurred while updating the password
        $errorMessage = "Failed to update password. Please try again.";
    }
}

// Close the database connection
$conn->close();

// Function to generate a random password
function generateRandomPassword($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}

// Function to send the new password to the user's email
function sendNewPasswordByEmail($email, $newPassword) {
    // Use your preferred method to send an email with the new password to the user
    // For example, you can use PHPMailer or the built-in mail() function
    // Here's an example using the mail() function:

    $subject = "New Password for Your Account";
    $message = "Your new password is: $newPassword";
    $headers = "From: your-email@example.com" . "\r\n" .
        "Reply-To: your-email@example.com" . "\r\n" .
        "X-Mailer: PHP/" . phpversion();

    mail($email, $subject, $message, $headers);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penny Auction Website - Forgot Password</title>
    <!-- Add your SEO meta tags here -->

    <!-- Import necessary scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</head>
<body>
    <!-- Header -->
    <?php include 'header.php'; ?>

    <div class="container">
        <h1>Forgot Password</h1>

        <?php if (isset($errorMessage)) { ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errorMessage; ?>
        </div>
        <?php } ?>

        <!-- Forgot password form -->
        <form method="POST">
            <!-- Form fields -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>