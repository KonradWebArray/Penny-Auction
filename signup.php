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
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];
	
// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errorMessage = "Invalid email format.";
    } else {

}

    // Check if the username or email already exists
    $checkQuery = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // Username or email already exists
        $errorMessage = "Username or email already exists.";
    } else {
        // Check if the password and confirm password match
        if ($password !== $confirmPassword) {
            $errorMessage = "Confirm password does not match.";
        } else {
            // Insert the user into the database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertQuery = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";

            // After successful user registration
            if ($conn->query($insertQuery) === TRUE) {
                // User registration successful

                // Set a cookie with the username
                setcookie("username", $username, time() + (86400 * 30), "/"); // Cookie expires in 30 days

                // Redirect to the login page or desired page
                header("Location: login.php?success=1");
                exit();
            } else {
                // Error inserting the user
                $errorMessage = "Error: " . $conn->error;
            }
        }
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
    <title>Penny Auction Website - Signup</title>
    <!-- Add your SEO meta tags here -->

    <!-- Import necessary scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Header -->
    <?php include 'header.php'; ?>

    <div class="container">
        <h1>Signup</h1>

        <?php if (isset($errorMessage)) { ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errorMessage; ?>
        </div>
        <?php } ?>

        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
                <small id="usernameMessage" style="color: red;"></small>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <small id="passwordMessage" style="color: red;"></small>
                <div class="progress mt-2">
                    <div id="passwordStrength" class="progress-bar" role="progressbar" style="width: 0%"></div>
                </div>
            </div>

            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                <small id="confirmPasswordMessage" style="color: red;"></small>
            </div>

            <div class="mb-3">
                <input type="checkbox" class="form-check-input" id="terms_conditions" name="terms_conditions" required>
                <label for="terms_conditions" class="form-check-label">I've read and accepted the terms and conditions</label>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Signup</button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <script>
        // Function to validate the username
        function validateUsername() {
            var usernameInput = document.getElementById("username");
            var usernameMessage = document.getElementById("usernameMessage");

            var username = usernameInput.value;

            if (username.length < 4) {
                usernameMessage.innerHTML = "Username must be at least 4 characters long.";
                usernameMessage.style.color = "red";
                return false;
            } else if (!/^[a-zA-Z0-9]+$/.test(username)) {
                usernameMessage.innerHTML = "Username cannot contain symbols.";
                usernameMessage.style.color = "red";
                return false;
            } else {
                usernameMessage.innerHTML = "";
                return true;
            }
        }

        // Function to update the password strength bar
        function updatePasswordStrength(password) {
            var strengthBar = document.getElementById("passwordStrength");
            var strength = 0;
            var progressBarClass = "";

            // Check if password length is at least 8 characters
            if (password.length >= 8) {
                strength += 1;
            }

            // Check if password contains at least one uppercase letter, one lowercase letter, one digit, and one special character
            if (/(?=.*[a-z])/.test(password)) {
                strength += 1;
            }
            if (/(?=.*[A-Z])/.test(password)) {
                strength += 1;
            }
            if (/(?=.*\d)/.test(password)) {
                strength += 1;
            }
            if (/(?=.*[@$!%*?&])/.test(password)) {
                strength += 1;
            }

            // Update the strength bar color based on password strength
            switch (strength) {
                case 1:
                    progressBarClass = "bg-danger";
                    break;
                case 2:
                    progressBarClass = "bg-warning";
                    break;
                case 3:
                case 4:
                    progressBarClass = "bg-success";
                    break;
                default:
                    progressBarClass = "";
                    break;
            }

            // Update the strength bar width and color
            strengthBar.style.width = (strength * 25) + "%";
            strengthBar.className = "progress-bar " + progressBarClass;
        }

        // Function to validate the password
        function validatePassword() {
            var passwordInput = document.getElementById("password");
            var passwordMessage = document.getElementById("passwordMessage");

            var password = passwordInput.value;

            // Update the password strength bar
            updatePasswordStrength(password);

            if (password.length < 8) {
                passwordMessage.innerHTML = "Password must be at least 8 characters long.";
                passwordMessage.style.color = "red";
                return false;
            } else if (!/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])/.test(password)) {
                passwordMessage.innerHTML = "Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character.";
                passwordMessage.style.color = "red";
                return false;
            } else {
                passwordMessage.innerHTML = "";
                return true;
            }
        }

        // Function to validate the confirm password
        function validateConfirmPassword() {
            var passwordInput = document.getElementById("password");
            var confirmPasswordInput = document.getElementById("confirm_password");
            var confirmPasswordMessage = document.getElementById("confirmPasswordMessage");

            var password = passwordInput.value;
            var confirmPassword = confirmPasswordInput.value;

            if (confirmPassword !== password) {
                confirmPasswordMessage.innerHTML = "Confirm password does not match.";
                confirmPasswordMessage.style.color = "red";
                return false;
            } else {
                confirmPasswordMessage.innerHTML = "";
                return true;
            }
        }

        // Add event listeners for form validation
        document.getElementById("username").addEventListener("input", validateUsername);
        document.getElementById("password").addEventListener("input", validatePassword);
        document.getElementById("confirm_password").addEventListener("input", validateConfirmPassword);
    </script>
</body>
</html>