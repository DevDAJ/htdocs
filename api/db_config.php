
<?php
// Database configuration
$servername = "localhost";
$username = "marine";
$password = "marine";
$dbname = "marine";
$contact_table = "contact_us";
$pledge_table = "pledge";

// Create Database on first run
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// CHECK IF DATABASE EXISTS
$sql = "SHOW DATABASES LIKE '$dbname'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    // Create databased
    $sql = "CREATE DATABASE IF NOT EXISTS marine";
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Database created successfully")</script>';
    } else {
        echo "Error creating database: " . $conn->error;
    }
}

$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SHOW TABLES LIKE '$pledge_table'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    // Create table
    $sql = "CREATE TABLE IF NOT EXISTS $pledge_table (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        email VARCHAR(50) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Table created successfully")</script>';
    } else {
        echo "Error creating table: " . $conn->error;
    }
}


$sql = "SHOW TABLES LIKE '$contact_table'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    // Create table
    $sql = "CREATE TABLE IF NOT EXISTS $contact_table (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        email VARCHAR(50) NOT NULL,
        subject VARCHAR(50) NOT NULL,
        message TEXT NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Table created successfully")</script>';
    } else {
        echo "Error creating table: " . $conn->error;
    }
}



$conn->close();
?>