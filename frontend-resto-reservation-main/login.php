<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            header('Location: welcomepage.php');
            exit;
        } else {
            $error_message = "Incorrect Username or Password!";
        }
    } else {
        $error_message = "User not found!";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOIRÉIR</title>
    <link rel="stylesheet" href="/frontend-resto-reservation-main/styling.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Forum&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/jpg" href="images/icon.png">
</head>

<body>
    <header class="hero">
        <div class="overlay">
            <h1 class="title">SOIRÉIR</h1>
        </div>
    </header>

    <div class="wrapper">
        <form action="login.php" method="post">
            <h2>LOGIN</h2>
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>
            
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>

            <button type="submit" class="btn">Login</button>

            <div class="register">
                <p>Don't have an account? <a href="register.php">Create Account</a></p>
            </div>
        </form>
    </div>

    <?php if (isset($error_message)): ?>
        <div id="errorModal" class="modal">
            <div class="modal-content">
                <p><?php echo $error_message; ?></p>
                <button onclick="closeModal()">OK</button>
            </div>
            <div class="modal-overlay" onclick="closeModal()"></div>
        </div>
    <?php endif; ?>

    <script>
        function closeModal() {
            document.getElementById('errorModal').style.display = 'none';
        }
        window.onload = function() {
            if (document.getElementById('errorModal')) {
                document.getElementById('errorModal').style.display = 'block';
            }
        }
    </script>

    <style>
        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            z-index: 1000;
            display: none;
        }
        .modal-content {
            position: relative;
            z-index: 1001;
        }
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</body>
</html>
