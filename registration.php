<?php
require_once 'config/db.php';
$db = new Database();

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    $password = $_POST['password'] ?? '';

    if (empty($name)) $errors[] = "Name is required";
    if (empty($mobile) || !preg_match('/^[0-9]{10}$/', $mobile)) $errors[] = "Valid mobile number is required";
    if (empty($village)) $errors[] = "Village/City is required";
    if (empty($sub_district)) $errors[] = "Sub-district is required";
    if (empty($district)) $errors[] = "District is required";
    if (empty($pincode) || !preg_match('/^[0-9]{6}$/', $pincode)) $errors[] = "Valid pincode is required";
    if (empty($state)) $errors[] = "State is required";
    if (empty($profession)) $errors[] = "Profession is required";
    if (empty($password) || strlen($password) < 6) $errors[] = "Password must be at least 6 characters";

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO workers (name, mobile, landmark, village_city, sub_district, district, working_area, pincode, state, profession, password) 
                  VALUES (:name, :mobile, :landmark, :village, :sub_district, :district, :area, :pincode, :state, :profession, :password)";
        
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
            ':password' => $hashed_password
        ];

        if ($db->insert($query, $params)) {
            $success = true;
        } else {
            $errors[] = "Failed to register. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Registration</title>
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
            <li><a class="active" href="registration.php">Register</a></li>
            <li><a href="about.php">About</a></li>
        </ul>
        <div class="menu-icon"></div>
    </nav>
    
    <div class="main-content">
        <div class="header">
            <h1>Worker'sHub</h1>
            <p>Register to join our network of skilled professionals</p>
        </div>

        <div class="container">
            <h2 class="form-title">Registration Form</h2>
            
            <?php if (!empty($errors)): ?>
                <div class="error-message">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="success-message">
                    Registration successful! Thank you for joining Worker'sHub.
                    <p>You can now <a href="update_profile.php">update your profile</a> using your mobile number and password.</p>
                </div>
            <?php else: ?>
            
            <form method="POST" action="registration.php">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your full name" required
                           value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="mobile">Mobile Number</label>
                    <input type="tel" id="mobile" name="mobile" placeholder="Enter your 10-digit mobile number" required
                           pattern="[0-9]{10}" title="Please enter a 10-digit mobile number"
                           value="<?= htmlspecialchars($_POST['mobile'] ?? '') ?>">
                </div>

                <h3 class="section-title">Address Details</h3>

                <div class="form-group">
                    <label for="landmark">Landmark</label>
                    <input type="text" id="landmark" name="landmark" placeholder="Enter nearest landmark"
                           value="<?= htmlspecialchars($_POST['landmark'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="village">Village/City</label>
                    <input type="text" id="village" name="village" placeholder="Enter your village or city" required
                           value="<?= htmlspecialchars($_POST['village'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="sub-district">Sub-District</label>
                    <input type="text" id="sub-district" name="sub_district" placeholder="Enter sub-district" required
                           value="<?= htmlspecialchars($_POST['sub_district'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="district">District</label>
                    <input type="text" id="district" name="district" placeholder="Enter district" required
                           value="<?= htmlspecialchars($_POST['district'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="area">Working Area</label>
                    <input type="text" id="area" name="area" placeholder="Enter cities where you work (comma separated)"
                           value="<?= htmlspecialchars($_POST['area'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="pincode">Pin Code</label>
                    <input type="text" id="pincode" name="pincode" placeholder="Enter 6-digit pin code" required
                           pattern="[0-9]{6}" title="Please enter a 6-digit pin code"
                           value="<?= htmlspecialchars($_POST['pincode'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="state">State</label>
                    <select id="state" name="state" required>
                        <option value="" selected disabled>Select your state</option>
                        <option value="Andhra Pradesh" <?= isset($_POST['state']) && $_POST['state'] == 'Andhra Pradesh' ? 'selected' : '' ?>>Andhra Pradesh</option>
                        <option value="Maharashtra" <?= isset($_POST['state']) && $_POST['state'] == 'Maharashtra' ? 'selected' : '' ?>>Maharashtra</option>
                        <option value="Uttar Pradesh" <?= isset($_POST['state']) && $_POST['state'] == 'Uttar Pradesh' ? 'selected' : '' ?>>Uttar Pradesh</option>
                        <option value="West Bengal" <?= isset($_POST['state']) && $_POST['state'] == 'West Bengal' ? 'selected' : '' ?>>West Bengal</option>
                        <option value="Karnataka" <?= isset($_POST['state']) && $_POST['state'] == 'Karnataka' ? 'selected' : '' ?>>Karnataka</option>
                        <option value="Tamil Nadu" <?= isset($_POST['state']) && $_POST['state'] == 'Tamil Nadu' ? 'selected' : '' ?>>Tamil Nadu</option>
                        <option value="Other" <?= isset($_POST['state']) && $_POST['state'] == 'Other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="profession">Profession</label>
                    <input type="text" id="profession" name="profession" placeholder="Enter your profession (e.g., Plumber, Electrician)" required
                           value="<?= htmlspecialchars($_POST['profession'] ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Create Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter a password (min 6 characters)" required minlength="6">
                </div>
                
                <div class="form-group">
                    <button type="submit">Complete Registration</button>
                </div>
            </form>
            
            <div style="text-align: center; margin-top: 20px;">
                <p>Already registered? Update your profile:</p>
                <a href="update_profile.php">
                    <button type="button">Update Profile</button>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>