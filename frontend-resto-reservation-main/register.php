<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    if (empty($username) || empty($password) || empty($email)) {
        echo "All fields are required!";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO users (username, password, phone, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $phone, $email);

    if ($stmt->execute()) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                document.body.innerHTML += `
                <div id='successModal' style='
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    padding: 20px;
                    background-color: white;
                    border: 1px solid #ccc;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                    text-align: center;
                    z-index: 1000;'>
                    <p>Registration successful! <a href='login.php'>Login here</a></p>
                    <button onclick='closeModal()' style='
                        background-color: #007BFF;
                        color: white;
                        border: none;
                        padding: 10px 20px;
                        cursor: pointer;
                        border-radius: 5px;'>OK</button>
                </div>
                <div class='modal-overlay' onclick='closeModal()' style='
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.5);
                    z-index: 999;'></div>
                `;
            });

            function closeModal() {
                document.getElementById('successModal').remove();
                window.location.href = 'login.php';
            }
        </script>";
    } else {
        echo "Error: " . $stmt->error;
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
    <link rel="stylesheet" href="regstyle.css">
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
        <form action="register.php" method="post">
            <h2>REGISTER</h2>
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="input-box">
                <input type="tel" name="phone" placeholder="Phone Number" required>
                <i class='bx bxs-phone'></i>
            </div>
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required>
                <i class='bx bx-envelope'></i>
            </div>
            <button type="submit" class="btn">Register</button>
            <div class="register">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>
