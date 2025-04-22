<?php
session_start();
require_once 'config/db.php';
$db = new Database();

$errors = [];
$success = false;
$worker = null;

if (isset($_SESSION['success'])) {
    $success = true;
    $success_message = $_SESSION['success'];
    unset($_SESSION['success']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify'])) {
    $mobile = $_POST['mobile'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($mobile) || empty($password)) {
        $errors[] = "Mobile number and password are required";
    } else {
        $query = "SELECT * FROM workers WHERE mobile = :mobile";
        $worker = $db->fetch($query, [':mobile' => $mobile]);
        
        if ($worker && password_verify($password, $worker['password'])) {
            $_SESSION['worker_id'] = $worker['id'];
            header("Location: update_profile.php");
            exit();
        } else {
            $errors[] = "Invalid mobile number or password";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    if (!isset($_SESSION['worker_id'])) {
        header("Location: update_profile.php");
        exit();
    }
    
    $worker_id = $_SESSION['worker_id'];
    $name = $_POST['name'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $landmark = $_POST['landmark'] ?? '';
    $village = $_POST['village'] ?? '';
    $sub_district = $_POST['sub_district'] ?? '';
    $district = $_POST['district'] ?? '';
    $area = $_POST['area'] ?? '';
    $pincode = $_POST['pincode'] ?? '';
    $state = $_POST['state'] ?? '';
    $profession = $_POST['profession'] ?? '';
    $new_password = $_POST['new_password'] ?? '';

    if (empty($name)) $errors[] = "Name is required";
    if (empty($mobile) || !preg_match('/^[0-9]{10}$/', $mobile)) $errors[] = "Valid mobile number is required";

    if (empty($errors)) {
        $query = "UPDATE workers SET 
                 name = :name,
                 mobile = :mobile,
                 landmark = :landmark,
                 village_city = :village,
                 sub_district = :sub_district,
                 district = :district,
                 working_area = :area,
                 pincode = :pincode,
                 state = :state,
                 profession = :profession";
        
        $params = [
            ':name' => $name,
            ':mobile' => $mobile,
            ':landmark' => $landmark,
            ':village' => $village,
            ':sub_district' => $sub_district,
            ':district' => $district,
            ':area' => $area,
            ':pincode' => $pincode,
            ':state' => $state,
            ':profession' => $profession,
            ':id' => $worker_id
        ];
        
        if (!empty($new_password)) {
            if (strlen($new_password) < 6) {
                $errors[] = "Password must be at least 6 characters";
            } else {
                $query .= ", password = :password";
                $params[':password'] = password_hash($new_password, PASSWORD_DEFAULT);
            }
        }
        
        $query .= " WHERE id = :id";
        
        if ($db->update($query, $params)) {
            $_SESSION['success'] = "Profile updated successfully!";
            header("Location: update_profile.php");
            exit();
        } else {
            $errors[] = "Failed to update profile. Please try again.";
        }
    }
}

if (isset($_SESSION['worker_id'])) {
    $worker = $db->fetch("SELECT * FROM workers WHERE id = :id", [':id' => $_SESSION['worker_id']]);
    if (!$worker) {
        unset($_SESSION['worker_id']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Worker Profile</title>
    <link rel="stylesheet" href="style1.css">
    <style>
    body {
        background: url('./assets/background.jpg') no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        padding: 0;
    }
    
    nav {
        position: fixed;
        top: 0;
        width: 100%;
        background-color: rgb(27, 27, 27);
        z-index: 1000;
        padding: 15px 0;
    }
    
    .main-content {
        padding-top: 80px; 
    }
    
    .header {
        padding: 40px 0;
        text-align: center;
        color: white;
        margin-top: 0;
    }
    
    .error-message {
        color: red;
        margin-bottom: 15px;
    }
    
    .success-message {
        color: green;
        margin-bottom: 15px;
        font-weight: bold;
    }
    
    .container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        position: relative;
        z-index: 1;
    }
    
    .form-group {
        margin-bottom: 15px;
    }
    
    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    
    input, select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    button {
        background-color: #3498db;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    
    button:hover {
        background-color: #2980b9;
    }
    
    .form-title {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 20px;
    }
    
    .verify-form {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #ddd;
    }
    </style>
</head>
<body>
    <nav>
        <div class="logo">
            <h1>Worker'sHub</h1>
        </div>
        <input type="checkbox" id="click">
        <label for="click" class="menu-btn">
            <i class="fas fa-bars"></i>
        </label>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="search.php">Search</a></li>
            <li><a href="registration.php">Register</a></li>
            <li><a href="about.php">About</a></li>
            <?php if (isset($_SESSION['worker_id'])): ?>
                <li><a href="logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <div class="main-content">
        <div class="header">
            <h1>Worker'sHub</h1>
            <p>Update your professional profile</p>
        </div>

        <div class="container">
            <h2 class="form-title">Update Profile</h2>
            
            <?php if (!empty($errors)): ?>
                <div class="error-message">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="success-message">
                    Profile updated successfully!
                </div>
            <?php endif; ?>
            
            <?php if (!isset($worker)): ?>
                <div class="verify-form">
                    <h3>Verify Your Identity</h3>
                    <form method="POST" action="update_profile.php">
                        <div class="form-group">
                            <label for="mobile">Mobile Number</label>
                            <input type="tel" id="mobile" name="mobile" placeholder="Enter your registered mobile number" required
                                   pattern="[0-9]{10}" title="Please enter a 10-digit mobile number">
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" name="verify">Verify</button>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <form method="POST" action="update_profile.php">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your full name" required
                               value="<?= htmlspecialchars($worker['name'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="mobile">Mobile Number</label>
                        <input type="tel" id="mobile" name="mobile" placeholder="Enter your 10-digit mobile number" required
                               pattern="[0-9]{10}" title="Please enter a 10-digit mobile number"
                               value="<?= htmlspecialchars($worker['mobile'] ?? '') ?>">
                    </div>

                    <h3 class="section-title">Address Details</h3>

                    <div class="form-group">
                        <label for="landmark">Landmark</label>
                        <input type="text" id="landmark" name="landmark" placeholder="Enter nearest landmark"
                               value="<?= htmlspecialchars($worker['landmark'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="village">Village/City</label>
                        <input type="text" id="village" name="village" placeholder="Enter your village or city" required
                               value="<?= htmlspecialchars($worker['village_city'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="sub-district">Sub-District</label>
                        <input type="text" id="sub-district" name="sub_district" placeholder="Enter sub-district" required
                               value="<?= htmlspecialchars($worker['sub_district'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="district">District</label>
                        <input type="text" id="district" name="district" placeholder="Enter district" required
                               value="<?= htmlspecialchars($worker['district'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="area">Working Area</label>
                        <input type="text" id="area" name="area" placeholder="Enter cities where you work (comma separated)"
                               value="<?= htmlspecialchars($worker['working_area'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="pincode">Pin Code</label>
                        <input type="text" id="pincode" name="pincode" placeholder="Enter 6-digit pin code" required
                               pattern="[0-9]{6}" title="Please enter a 6-digit pin code"
                               value="<?= htmlspecialchars($worker['pincode'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="state">State</label>
                        <select id="state" name="state" required>
                            <option value="" disabled>Select your state</option>
                            <option value="Andhra Pradesh" <?= ($worker['state'] ?? '') == 'Andhra Pradesh' ? 'selected' : '' ?>>Andhra Pradesh</option>
                            <option value="Maharashtra" <?= ($worker['state'] ?? '') == 'Maharashtra' ? 'selected' : '' ?>>Maharashtra</option>
                            <option value="Uttar Pradesh" <?= ($worker['state'] ?? '') == 'Uttar Pradesh' ? 'selected' : '' ?>>Uttar Pradesh</option>
                            <option value="West Bengal" <?= ($worker['state'] ?? '') == 'West Bengal' ? 'selected' : '' ?>>West Bengal</option>
                            <option value="Karnataka" <?= ($worker['state'] ?? '') == 'Karnataka' ? 'selected' : '' ?>>Karnataka</option>
                            <option value="Tamil Nadu" <?= ($worker['state'] ?? '') == 'Tamil Nadu' ? 'selected' : '' ?>>Tamil Nadu</option>
                            <option value="Other" <?= ($worker['state'] ?? '') == 'Other' ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="profession">Profession</label>
                        <input type="text" id="profession" name="profession" placeholder="Enter your profession (e.g., Plumber, Electrician)" required
                               value="<?= htmlspecialchars($worker['profession'] ?? '') ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password">New Password (leave blank to keep current)</label>
                        <input type="password" id="new_password" name="new_password" placeholder="Enter new password (min 6 characters)" minlength="6">
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" name="update">Update Profile</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>