<?php
require_once 'config/db.php';
$db = new Database();

$profession = $_GET['profession'] ?? '';
$location = $_GET['location'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Workers - Worker'sHub</title>
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

        .search-container {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .search-container h2 {
            margin-bottom: 20px;
            color: green;
        }

        .search-box, .dropdown {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 16px;
        }

        .search-button {
            width: 100%;
            padding: 12px;
            background: green;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }

        .search-button:hover {
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
            <li><a class="active" href="search.php">Search</a></li>
            <li><a href="registration.php">Register</a></li>
            <li><a href="about.php">About</a></li>
        </ul>
    </nav>

    <div class="search-container">
        <h2>Find a Worker</h2>
        <form method="GET" action="search_results.php">
            <select class="dropdown" name="profession">
                <option value="">Select Profession</option>
                <?php 
                $allProfessions = $db->fetchAll("SELECT DISTINCT profession FROM workers");
                foreach ($allProfessions as $prof): ?>
                <option value="<?= htmlspecialchars($prof['profession']) ?>" <?= $profession == $prof['profession'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($prof['profession']) ?>
                </option>
                <?php endforeach; ?>
            </select>
            
            <input type="text" class="search-box" name="location" placeholder="Enter Location (City, Village)" 
                   value="<?= htmlspecialchars($location) ?>">
            
            <button type="submit" class="search-button">Search</button>
        </form>
    </div>
</body>
</html>