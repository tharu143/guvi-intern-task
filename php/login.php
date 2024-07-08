<?php
// Database connection details 
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "guvitask";

// Attempt to establish connection 
$conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["upswd1"]; // Assuming "upswd1" is the name of your password input field

    // SQL query to fetch user from database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows == 1) {
        // User found, verify password
        $user = $result->fetch_assoc();
        if ($user['password'] === $password) {
            // Password is correct, redirect or set session variables
            session_start();
            $_SESSION['email'] = $email; // Example of setting session variable

            // Redirect to a logged-in page
            header("Location: profile.php");
            exit();
        } else {
            // Incorrect password
            echo "Wrong password";
        }
    } else {
        // User not found
        echo "User with this email does not exist";
    }

    // Close statement and connection
    $stmt->close();
}

// Close database connection
$conn->close();
?>
