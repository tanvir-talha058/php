<?php
// --- Step 1: Connect to MySQL Server ---
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "";     // Your MySQL password
$dbname = "Donations";

// Create a connection to the MySQL server (without specifying a database yet)
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- Step 2: Create Database and Table if they don't exist ---
// Create the database if it doesn't already exist
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");

// Now, select the database
$conn->select_db($dbname);

// SQL to create the 'donors' table if it doesn't exist
$create_table_sql = "
CREATE TABLE IF NOT EXISTS donors (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    transaction_id VARCHAR(100) NOT NULL,
    donation_datetime DATETIME NOT NULL,
    phone VARCHAR(20) NULL,
    address TEXT NULL,
    anonymous VARCHAR(3) NOT NULL,
    submission_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";
$conn->query($create_table_sql);


// --- Step 3: Process Form Data ---
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Retrieve data from the submitted form
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];
    $transaction_id = $_POST['transaction_id'];
    $donation_datetime = $_POST['donation_datetime'];
    $phone = $_POST['phone'] ?? NULL;
    $address = $_POST['address'] ?? NULL;
    $anonymous = $_POST['anonymous'];

    // --- Step 4: Insert Data into Database ---
    // Prepare the SQL query to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO donors (fullname, email, amount, payment_method, transaction_id, donation_datetime, phone, address, anonymous) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Bind the form data to the query's placeholders
    $stmt->bind_param("ssdssssss", $fullname, $email, $amount, $payment_method, $transaction_id, $donation_datetime, $phone, $address, $anonymous);

    // Execute the query and provide feedback
    if ($stmt->execute()) {
        echo "<h1>Thank You!</h1>";
        echo "<p>Your donation has been successfully recorded.</p>";
        echo "<a href='index.html'>Make another donation</a>";
    } else {
        echo "<h1>Error</h1>";
        echo "<p>Could not record your donation. Error: " . $stmt->error . "</p>";
        echo "<a href='index.html'>Try again</a>";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
