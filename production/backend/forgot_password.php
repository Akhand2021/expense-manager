<?php
require_once("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    // Generate a random password reset token and send it to the user's email
    $resetToken = bin2hex(random_bytes(16));

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
    $stmt->bind_param("ss", $resetToken, $email);

    if ($stmt->execute()) {
        // Send email with password reset link containing the $resetToken
        echo "Password reset link sent to your email!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
