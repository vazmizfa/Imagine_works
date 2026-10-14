<?php
require_once "config/db.php";

/* Only allow POST requests */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php#contact");
    exit;
}

/*--Get form data--*/
$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$subject = trim($_POST["subject"] ?? "");
$message = trim($_POST["message"] ?? "");

/*--Check required fields--*/
if ($name === "" || $email === "" || $message === "") {
    header("Location: index.php?error=required#contact");
    exit;
}

/*--Check email--*/
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: index.php?error=email#contact");
    exit;
}

/*--Insert message--*/
$stmt = $conn->prepare("
    INSERT INTO messages
    (name, email, subject, message)
    VALUES (?, ?, ?, ?)
");

if (!$stmt) {
    header("Location: index.php?error=prepare#contact");
    exit;
}

$stmt->bind_param(
    "ssss",
    $name,
    $email,
    $subject,
    $message
);

/*--Execute--*/
if ($stmt->execute()) {

    $stmt->close();

    header("Location: index.php?success=1#contact");
    exit;

} else {

    $stmt->close();

    header("Location: index.php?error=database#contact");
    exit;
}
?>