<?php
require_once 'config/db.php';
$db = new Database();

$profession = $_GET['profession'] ?? '';
$location = $_GET['location'] ?? '';

$workers = [];
if ($profession || $location) {
    $query = "SELECT * FROM workers WHERE 1=1";
    $params = [];
    
    if ($profession) {
        $query .= " AND profession = :profession";
        $params[':profession'] = $profession;
    }
    
    if ($location) {
        $query .= " AND (village_city LIKE :location OR district LIKE :location OR sub_district LIKE :location OR working_area LIKE :location)";
        $params[':location'] = "%$location%";
    }
    
    $workers = $db->fetchAll($query, $params);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Worker'sHub</title>
    <script src="https://kit.fontawesome.com/3ab914e37c.js" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            min-height: 100vh;
            padding: 100px 35px 35px;
            background: url('./assets/background.jpg') no-repeat center center fixed;
            background-size: cover;
            transition: 0.3s;
        }
        nav {
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            height: 80px;
            background-color: rgb(27, 27, 27);
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            z-index: 1000;
        }
        .logo {
            font-size: 33px;
            font-weight: 600;
        }
        nav ul {
            display: flex;
            list-style: none;
            margin-left: auto;
        }
        nav ul li {
            margin: 0 5px;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            font-weight: 500;
            letter-spacing: 1px;
            padding: 8px 18px;
            border-radius: 5px;
        }
        nav ul li a:hover,
        nav ul li a.active {
            background: #fff;
            color: #1b1b1b;
        }
        .menu-btn {
            display: none;
            position: absolute;
            top: 25px;
            right: 20px;
            cursor: pointer;
        }
        .menu-btn i {
            color: #fff;
            font-size: 26px;
            cursor: pointer;
        }
        #click {
            display: none;
        }
        @media (max-width: 840px) {
            .menu-btn {
                display: block;
            }
            nav ul {
                position: fixed;
                top: 80px;
                left: -100%;
                background: #111;
                height: 100vh;
                width: 100%;
                display: block;
                text-align: center;
                transition: 0.3s;
                z-index: 999;
            }
            #click:checked ~ ul {
                left: 0%;
            }
            nav ul li {
                margin: 40px 0;
            }
            nav ul li a {
                font-size: 20px;
            }
            nav ul li a:hover,
            nav ul li a.active {
                background: none;
                color: cyan;
            }
        }
        
        .results-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .search-info {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .search-info h2 {
            color: green;
            margin-bottom: 10px;
        }
        
        .worker-card {
            padding: 15px;
            border-bottom: 1px solid #eee;
            margin-bottom: 15px;
        }
        
        .worker-card h3 {
            color: green;
            margin-bottom: 10px;
        }
        
        .worker-info {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }
        
        .worker-info i {
            margin-right: 10px;
            color: #666;
        }
        
        .no-results {
            text-align: center;
            padding: 20px;
            color: #666;
        }
        
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: green;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        
        .back-button:hover {
            background: darkgreen;
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
        </ul>
    </nav>

    <div class="results-container">
        <div class="search-info">
            <h2>Search Results</h2>
            <?php if ($profession): ?>
                <p><strong>Profession:</strong> <?= htmlspecialchars($profession) ?></p>
            <?php endif; ?>
            <?php if ($location): ?>
                <p><strong>Location:</strong> <?= htmlspecialchars($location) ?></p>
            <?php endif; ?>
        </div>
        
        <?php if (count($workers) > 0): ?>
            <?php foreach ($workers as $worker): ?>
            <div class="worker-card">
                <h3><?= htmlspecialchars($worker['profession']) ?></h3>
                <div class="worker-info">
                    <i class="fas fa-user"></i>
                    <span><?= htmlspecialchars($worker['name']) ?></span>
                </div>
                <div class="worker-info">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>
                        <?= htmlspecialchars($worker['village_city']) ?>, 
                        <?= htmlspecialchars($worker['district']) ?>
                    </span>
                </div>
                <div class="worker-info">
                    <i class="fas fa-phone"></i>
                    <span><?= htmlspecialchars($worker['mobile']) ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-results">
                No workers found matching your criteria.
            </div>
        <?php endif; ?>
        
        <a href="search.php" class="back-button">New Search</a>
    </div>
</body>
</html>