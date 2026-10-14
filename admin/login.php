<?php
session_start();
require_once "../config/db.php";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if ($username === "" || $password === "") {
        $error = "Please enter username and password.";
    } else {

        $stmt = $conn->prepare(
            "SELECT admin_id, username, password 
             FROM admin_users 
             WHERE username = ? 
             LIMIT 1"
        );

        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            if (password_verify($password, $admin["password"])) {
                $_SESSION["admin_id"] = $admin["admin_id"];
                $_SESSION["admin_username"] = $admin["username"];

                header("Location: dashboard.php");
                exit();

            } else {
                $error = "Invalid username or password.";
            }

        } else {
            $error = "Invalid username or password.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login | Imagine Works</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body 
        {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #0e0e0e;
            font-family: Arial, sans-serif;
            color: white;
        }

        .login-container 
        {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-box 
        {
            background: #181818;
            padding: 40px;
            border-radius: 15px;
            border: 1px solid #2b2b2b;
            box-shadow: 0 0 30px rgba(168, 85, 247, 0.15);
        }

        .logo 
        {
            text-align: center;
            color: #A855F7;
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        h2 
        {
            text-align: center;
            margin-bottom: 30px;
            font-size: 22px;
        }

        .form-group 
        {
            margin-bottom: 20px;
        }

        label 
        {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input 
        {
            width: 100%;
            padding: 13px;
            border-radius: 8px;
            border: 1px solid #333;
            background: #0e0e0e;
            color: white;
            outline: none;
        }

        input:focus 
        {
            border-color: #A855F7;
        }

        button 
        {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background: #A855F7;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover 
        {
            opacity: 0.9;
        }

        .error 
        {
            background: #351515;
            color: #ff8c8c;
            padding: 10px;
            border-radius: 7px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }

    </style>
</head>
<body>
<div class="login-container">
    <div class="login-box">
        <div class="logo">
            Imagine Works
        </div>

        <h2>Admin Login</h2>
        <?php if ($error !== ""): ?>
            <div class="error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Enter username"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter password"
                    required
                >
            </div>

            <button type="submit">
                Login
            </button>
        </form>
    </div>
</div>
</body>
</html>