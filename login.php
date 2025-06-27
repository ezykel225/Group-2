<?php
session_start();
include("db.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

$error = "";
$school_email = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $school_email = isset($_POST['school_email']) ? trim($_POST['school_email']) : "";
    $password = isset($_POST['password']) ? trim($_POST['password']) : "";

    if (empty($school_email) || empty($password)) {
        $error = "All fields are required.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM students WHERE school_email = ?");
        
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        
        $stmt->bind_param("s", $school_email);
        
        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
        
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows === 1) {
            $student = $result->fetch_assoc();
            if (!empty($student['password']) && password_verify($password, $student['password'])) {
                $_SESSION['student'] = $student; // Store entire student array
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Email not found.";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Student Information System</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="feedback.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:700,400&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="logo-section">
            <img src="assets/Logo.png" alt="Asian College Logo" class="logo">
            <div>
                <h1>
                    <span>Student</span><br>
                    <span>Information</span><br>
                    <span>System</span>
                </h1>
            </div>
        </div>  
        <nav>
            <ul>
                <li><a href="index.php" class="nav-link">Home</a></li>
                <li><a href="about.php" class="nav-link">About</a></li>
                <li class="active"><a href="login.php" class="nav-link">Login<div class="underline"></div></a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="login-section">
            <div class="login-card">
                <h2>Login to SIS</h2>
                <?php if (!empty($error)): ?>
                    <div style="background-color: #ffdddd; border-left: 5px solid #f44336; color: #a94442; padding: 12px; margin-bottom: 16px; border-radius: 6px; text-align: center;">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="">
                    <label for="school_email">School Email</label>
                    <input type="text" id="school_email" name="school_email" required value="<?= htmlspecialchars($school_email) ?>" autocomplete="off" oncopy="return false" onpaste="return false" oncut="return false">
                    
                    <label for="password">Password</label>
                    <div style="position: relative;">
                        <input type="password" id="password" name="password" required autocomplete="off" oncopy="return false" onpaste="return false" oncut="return false">
                        <span id="togglePassword" style="position: absolute; right: 10px; top: 12px; cursor: pointer;">
                            👁️
                        </span>
                    </div>

                    <button type="submit">Login</button>
                </form>

                <div class="login-help">
                    <p>Forgot your password?
                        <a href="#" onclick="showModal(); return false;">Contact support</a>
                    </p>
                </div>
            </div>
        </section>
    </main>

    <?php include 'feedback.php'; ?>

    <div id="support-modal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="custom-modal-title">Important!</span>
            <p>Go to the Technical Support office located on the 3rd floor at the ACSAT premises.</p>
            <button onclick="closeModal()" class="modal-button">OK</button>
        </div>
    </div>

    <script>
        function showModal() {
            document.getElementById('support-modal').style.display = 'flex';
        }
        function closeModal() {
            document.getElementById('support-modal').style.display = 'none';
        }

        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    </script>
</body>
</html>