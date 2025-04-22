<?php
require_once 'config/db.php';
$db = new Database();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mobile = $_POST['mobile'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($mobile) || !preg_match('/^[0-9]{10}$/', $mobile)) {
        $errors[] = "Valid mobile number is required";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }

    if (empty($errors)) {
        $query = "SELECT * FROM workers WHERE mobile = :mobile";
        $worker = $db->query($query, [':mobile' => $mobile]);
        
        if ($worker && password_verify($password, $worker['password'])) {
            session_start();
            $_SESSION['worker_id'] = $worker['id'];
            $_SESSION['worker_mobile'] = $worker['mobile'];
            header("Location: update_profile.php");
            exit();
        } else {
            $errors[] = "Invalid mobile number or password";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Worker</title>
    <style>
    body {
        background: url('./assets/background.jpg') no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }
    
    .container {
        max-width: 500px;
        margin: 100px auto;
        padding: 30px;
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    
    h2 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 20px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }
    
    input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }
    
    button {
        background-color: #3498db;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        font-size: 16px;
    }
    
    button:hover {
        background-color: #2980b9;
    }
    
    .error-message {
        color: red;
        margin-bottom: 15px;
    }
    
    .back-link {
        display: block;
        text-align: center;
        margin-top: 20px;
    }
    </style>
</head>
<body>
    <div class="container">
        <h2>Verify Your Identity</h2>
        
        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="verify_worker.php">
            <div class="form-group">
                <label for="mobile">Mobile Number</label>
                <input type="tel" id="mobile" name="mobile" placeholder="Enter your registered mobile number" required
                       pattern="[0-9]{10}" title="Please enter a 10-digit mobile number"
                       value="<?= htmlspecialchars($_POST['mobile'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            
            <div class="form-group">
                <button type="submit">Verify and Update Profile</button>
            </div>
        </form>
        
        <a href="registration.php" class="back-link">Not registered yet? Register here</a>
    </div>
</body>
</html>