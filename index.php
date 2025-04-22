<?php
require_once 'config/db.php';
$db = new Database();
$professions = $db->fetchAll("SELECT DISTINCT profession FROM workers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker'sHub</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/3ab914e37c.js" crossorigin="anonymous"></script>
    <script src="script.js"></script>
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
            <li><a class="active" href="index.php">Home</a></li>
            <li><a href="search.php">Search</a></li>
            <li><a href="registration.php">Register</a></li>
            <li><a href="about.php">About</a></li>
        </ul>
        <div class="menu-icon"></div>
    </nav>

    <main>
      <div id="a1">
        <div id="a2">Workers Hub Connecting You with Skilled Workers Effortlessly.</div>
        <p>Workers Hub is a smart and efficient platform designed to connect businesses and individuals with skilled workers across various industries. Whether you need construction workers, electricians, plumbers, drivers, or any other professionals, Workers Hub provides a seamless hiring experience.</p>
      </div>
    </main>

    <div class="wrapper">
        <i id="left" class="fa-solid fas fa-angle-left"></i>
        <ul class="carousel">
            <?php foreach ($professions as $prof): ?>
            <a href="search.php?profession=<?= urlencode($prof['profession']) ?>" class="card-link">
                <li class="card">
                    <div class="img">
                        <img src="assets/<?= strtolower(str_replace(' ', '-', $prof['profession'])) ?>.png" 
                             alt="<?= $prof['profession'] ?>" draggable="false">
                    </div>
                    <h2 style="color: green; font-weight:bold;"><?= $prof['profession'] ?></h2>
                    <span>Find skilled <?= strtolower($prof['profession']) ?>s near you</span>
                </li>
            </a>
            <?php endforeach; ?>
        </ul>
        <i id="right" class="fa-solid fas fa-angle-right"></i>
    </div>
    <footer class="footer">
        <div class="footer-container">
            <h2 class="footer-title">Worker'sHub</h2>
            
            <ul class="footer-links">
            <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="search.php">Search</a></li>
            </ul>
    
            <div class="footer-socials">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
    
            <p class="footer-copy">&copy; 2025 Worker'sHub. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>