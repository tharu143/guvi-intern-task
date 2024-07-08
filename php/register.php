<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    // Validate password
    if (strlen($password) < 8) {
        die("Password must be at least 8 characters long");
    }

    // Check if passwords match
    if ($password !== $confirmpassword) {
        die("Passwords do not match");
    }

    // Database connection details
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "guvitask";

    // Create a connection
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to insert data into database with plaintext password
    $sql = "INSERT INTO users (email, password) VALUES (?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password); // Note: $password is plaintext here

    // Execute the statement
    if ($stmt->execute()) {
        echo "Registration successful";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
