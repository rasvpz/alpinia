<?php
// contact_process.php
// This file handles form submissions from the contact page

// Check if the form was submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form inputs
    $name = isset($_POST["name"]) ? strip_tags(trim($_POST["name"])) : "";
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $subject = isset($_POST["subject"]) ? strip_tags(trim($_POST["subject"])) : "";
    $message = isset($_POST["message"]) ? trim($_POST["message"]) : "";
    
    // Validate inputs
    $errors = [];
    
    // Check if name is empty
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    // Check if email is valid
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    // Check if message is empty
    if (empty($message)) {
        $errors[] = "Message is required";
    }
    
    // If there are validation errors, redirect back with error status
    if (!empty($errors)) {
        header("Location: contact.php?status=error");
        exit;
    }
    
    // Set recipient email address
    $recipient = "rasvpz@gmail.com";
    
    // Set the email subject
    if (empty($subject)) {
        $email_subject = "New contact from $name via ALPINIA Greenings";
    } else {
        $email_subject = "Contact Form: " . $subject;
    }
    
    // Build the email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Subject: $subject\n\n";
    $email_content .= "Message:\n$message\n\n";
    $email_content .= "Sent from ALPINIA Greenings contact form on " . date('F j, Y \a\t g:i a');
    
    // Build the email headers
    $email_headers = "From: $name <$email>\r\n";
    $email_headers .= "Reply-To: $email\r\n";
    $email_headers .= "MIME-Version: 1.0\r\n";
    $email_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    // Try to send the email
    if (mail($recipient, $email_subject, $email_content, $email_headers)) {
        // Email sent successfully
        header("Location: contact.php?status=success");
    } else {
        // Failed to send email
        header("Location: contact.php?status=error");
    }
    
    exit;
} else {
    // If not a POST request, redirect to contact page
    header("Location: contact.php");
    exit;
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // For testing only - skip actual email sending
    header("Location: contact.php?status=success");
    exit;
} else {
    header("Location: contact.php");
    exit;
}
?>


