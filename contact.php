<!-- contact.html -->
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Meta Information for character encoding, author, description, and viewport settings -->
  <meta charset="UTF-8" />
  <meta name="author" content="Group 2" />
  <meta name="description" content="Internet Programming - Assignment 2" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Page Title -->
  <title>Contact Us - Marine Plastic Recycling Awareness</title>
  <!-- Link to Google Fonts file for custom fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />
  <!-- Link to Bootstrap CSS for responsive design -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- jQuery and Bootstrap JS for interactive elements -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <!-- Link to FontAwesome for icons -->
  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css" />
  <!-- Link to external CSS file for custom styles -->
  <link rel="stylesheet" href="./CSS/contact.css" />
  <!-- Website Icon -->
  <link rel="shortcut icon" type="x-icon" href="./image/logo.png" />
</head>

<body>
  <!-- Header Section -->
  <header>
    <div class="wrapper">
      <!-- Navigation bar with responsive design -->
      <nav class="navbar navbar-expand-lg navbar-light">
        <!-- Logo link -->
        <a class="navbar-brand" href="./index.html">
          <!-- Logo Image -->
          <img src="./Image/logo.png" alt="Marine Logo" />
        </a>
        <!-- Toggle button for mobile view (hamburger menu) -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false">
          <i class="fa-sharp fa-solid fa-bars"></i>
        </button>
        <!-- Collapsible menu items -->
        <div class="collapse navbar-collapse" id="navbarNav">
          <!-- Navigation menu list -->
          <ul class="navbar-nav ml-auto text-right">
            <!-- Home page link (currently active) -->
            <li class="nav-item">
              <a class="nav-link active-home" href="./index.html">Home</a>
            </li>
            <!-- Facts page link -->
            <li class="nav-item">
              <a class="nav-link" href="./facts.html">Facts</a>
            </li>
            <!-- How to Help page link -->
            <li class="nav-item">
              <a class="nav-link" href="./help.html">How to Help</a>
            </li>
            <!-- Resources page link -->
            <li class="nav-item">
              <a class="nav-link" href="./resources.html">Resources</a>
            </li>
            <!-- Contact Us page link -->
            <li class="nav-item">
              <a class="nav-link" href="./contact.html">Contact Us</a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </header>
  <!-- Main Section -->
  <main>
    <div class="wrapper">
      <div class="contactus">
        <!-- Contactform for the form -->
        <div class="contactform">
          <form action="#" method="post">
            <h1>Contact US!</h1>
            <p>If you need help, kindly fill the forms.</p>

            <!-- Input field for Name -->
            <input name="name" type="text" class="input" placeholder="Your Name" id="name" required />
            <!-- Error messages for Name field -->
            <span id="name-error" class="hide required-color error-message">Invalid Input</span>
            <span id="empty-name" class="hide required-color error-message">Name Cannot Be Empty</span>

            <!-- Input field for Email -->
            <input name="email" type="email" class="input" placeholder="Your Email" id="email" required />
            <!-- Error messages for Email field -->
            <span id="email-error" class="hide required-color error-message">Invalid Email</span>
            <span id="empty-email" class="hide required-color error-message">Email Cannot Be Empty</span>

            <!-- Input field for Subject -->
            <input name="subject" type="text" class="input" placeholder="Your Subject" id="subject" required />

            <!-- Input field for Textarea -->
            <textarea name="message" class="input" cols="30" rows="5" placeholder="Your Message" id="message" required></textarea>

            <!-- Submit button -->
            <button class="input submit" type="submit" id="submit">
              Submit Form
            </button>
    
          </form>
          <!-- Map Section -->
          <div class="map-wrapper">
            <div class="map">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.888156455689!2d101.6564389749711!3d3.1242675968512374!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc490a92df9655%3A0xff1111a9234074dc!2sMalaysian%20Society%20of%20Marine%20Sciences%20(MSMS)!5e0!3m2!1sen!2smy!4v1721480911987!5m2!1sen!2smy" 
              width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>
        </div>
      </div>

    </div>

  </main>

  <!-- Popup message element, initially hidden -->
  <div id="popup" class="popup" style="display: none">
    <p>Message Sent!</p>
    <button onclick="closePopup()">Close</button>
  </div>

  <!-- Link to external JavaScript file for form validation and popup functionality -->
  <script src="./Javacript/contact.js"></script>
  <!-- Footer with copyright information -->
  <footer>
    <p>&copy; 2024 Marine Plastic Recycling Awareness</p>
  </footer>
</body>

</html>

<?php
// Database configuration
include 'api/db_config.php';

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
        $stmt = $conn->prepare("INSERT INTO $contact_table (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if ($stmt->execute()) {
            echo '<script>
                    var popup = document.getElementById("popup");
                    popup.style.display = "block";
                </script>';
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