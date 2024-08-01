
<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "marine";
$table = "contact_us";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Form validation
$errors = array();
$method = $_SERVER['REQUEST_METHOD'];

if ($method == "POST") {
    $name = sanitize_input($_POST["name"]);
    $email = sanitize_input($_POST["email"]);
    $subject = sanitize_input($_POST["subject"]);
    $message = sanitize_input($_POST["message"]);

    // Validate name
    if (empty($name)) {
        $errors['name'] = "Name cannot be empty";
    } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        $errors['name'] = "Only letters and white space allowed";
    }

    // Validate email
    if (empty($email)) {
        $errors['email'] = "Email cannot be empty";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    // Validate subject
    if (empty($subject)) {
        $errors['subject'] = "Subject cannot be empty";
    }

    // Validate message
    if (empty($message)) {
        $errors['message'] = "Message cannot be empty";
    }

    // If no errors, insert into database
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO $table (name, email, subject, message) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            // create table
            $sql = "CREATE TABLE $table (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(30) NOT NULL,
                email VARCHAR(50) NOT NULL,
                subject VARCHAR(50) NOT NULL,
                message TEXT NOT NULL,
                reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";
            if ($conn->query($sql) === TRUE) {
                echo "Table $table created successfully";
            } else {
                http_response_code(500);
                echo json_encode($conn->error);
                exit;
            }
            $stmt = $conn->prepare("INSERT INTO $table (name, email, subject, message) VALUES (?, ?, ?, ?)");
        }
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if ($stmt->execute()) {
            echo json_encode("New record created successfully");
        } else {
            
            http_response_code(400);
            echo json_encode($stmt->error);
        }

        $stmt->close();
    } else {
        http_response_code(400);
        echo json_encode($errors);
    }
}

$conn->close();
exit;
?>