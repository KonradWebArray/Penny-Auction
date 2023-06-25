CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
	is_logged_in TINYINT(1) NOT NULL DEFAULT 0,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert user data into the users table
INSERT INTO users (email, password, username)
VALUES ('user@example.com', 'password123', 'example_user');