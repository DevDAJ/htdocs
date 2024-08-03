
<?php
// Database configuration
include 'db_config.php';


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

    // If no errors, insert into database
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO $pledge_table (name, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $email);

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