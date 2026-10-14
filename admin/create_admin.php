<?php
require_once "../config/db.php";
$username = "admin";
$password = "Admin@123";
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare(
    "INSERT INTO admin_users (username, password) VALUES (?, ?)"
);

$stmt->bind_param("ss", $username, $hashed_password);
if ($stmt->execute()) 
    {
    echo "Admin account created successfully!";
    echo "<br>Username: admin";
    echo "<br>Password: Admin@123";
} 
else 
{
    echo "Error: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>