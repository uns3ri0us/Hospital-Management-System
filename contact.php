<?php
// Database connection
$con = mysqli_connect("localhost", "root", "", "myhmsdb");

if (isset($_POST['btnSubmit'])) {
    // Sanitize and validate inputs
    $name = htmlspecialchars(trim($_POST['txtName']));
    $email = filter_var(trim($_POST['txtEmail']), FILTER_SANITIZE_EMAIL);
    $contact = htmlspecialchars(trim($_POST['txtPhone']));
    $message = htmlspecialchars(trim($_POST['txtMsg']));

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script type="text/javascript">';
        echo 'alert("Invalid email format!");';
        echo 'window.location.href = "contact.html";';
        echo '</script>';
        exit;
    }

    // Prepare an SQL statement to prevent SQL injection
    $stmt = $con->prepare("INSERT INTO contact (name, email, contact, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $contact, $message);
    
    // Execute the statement and check if insertion is successful
    if ($stmt->execute()) {
        echo '<script type="text/javascript">';
        echo 'alert("Message sent successfully!");';
        echo 'window.location.href = "contact.html";';
        echo '</script>';
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Error: Unable to send message. Please try again later.");';
        echo 'window.location.href = "contact.html";';
        echo '</script>';
    }

    // Close the statement and connection
    $stmt->close();
}
?>