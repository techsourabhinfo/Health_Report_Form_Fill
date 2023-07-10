<?php
// Database connection configuration
$servername = "localhost";
$username = "<username>";
$password = "<password>";
$database = "<database>";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve email ID from the form
    $email = $_POST["email"];

    // Fetch user's health report based on email ID
    $sql = "SELECT health_report FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $healthReport = $row["health_report"];

        // Download the health report
        $filePath = "uploads/" . $healthReport;
        if (file_exists($filePath)) {
            header("Content-Type: application/pdf");
            header("Content-Disposition: attachment; filename=" . $healthReport);
            readfile($filePath);
            exit;
        } else {
            echo "Health report not found.";
        }
    } else {
        echo "No user found with the provided email ID.";
    }
}

// Close the database connection
$conn->close();
?>