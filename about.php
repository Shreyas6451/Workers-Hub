<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker'sHub - Connecting Workers and Employers</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/3ab914e37c.js" crossorigin="anonymous"></script>
    <style>
        main {
            flex: 1;
            padding: 30px 20px;
            max-width: 1000px;
            margin: 80px auto 40px;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #ffcc00;
            text-align: center;
        }
        h2 {
            font-size: 1.8rem;
            margin: 30px 0 15px;
            color: #ffcc00;
        }
        p, li {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        ul, ol {
            padding-left: 30px;
            margin-bottom: 25px;
        }
        li {
            color: aliceblue;
            margin-bottom: 10px;
        }
        span.highlight {
            font-weight: 600;
            color: #ffcc00;
        }
        hr {
            border: none;
            height: 2px;
            background-color: #444;
            margin: 25px 0;
        }
    </style>
</head>
<body>
    <nav>
        <div class="logo">Worker'sHub</div>
        <div class="menu-btn" id="menuBtn">
            <i class="fas fa-bars"></i>
        </div>
        <ul class="nav-links" id="navLinks">
            <li><a href="index.php">Home</a></li>
            <li><a href="search.php">Search</a></li>
            <li><a href="registration.php">Register</a></li>
            <li><a class="active" href="about.php">About</a></li>
        </ul>
    </nav>

    <main>
        <h1>Connecting You with Skilled Workers</h1>
        <hr>
        <p>Worker'sHub is a platform designed to connect businesses and individuals with skilled workers across various industries. Find construction workers, electricians, plumbers, drivers, and more with ease.</p>
        <h2>Why Choose Worker'sHub?</h2>
        <ul>
            <li><span class="highlight">Access to Skilled Workers:</span> Find verified and experienced professionals</li>
            <li><span class="highlight">Fast Hiring:</span> Connect with workers quickly to reduce downtime</li>
            <li><span class="highlight">Easy to Use:</span> Simple search and filtering options</li>
            <li><span class="highlight">Reliable Service:</span> All workers are vetted for quality</li>
            <li><span class="highlight">Flexible Options:</span> Find workers for short-term or long-term needs</li>
        </ul>
        <h2>How It Works</h2>
        <ol>
            <li><span class="highlight">Post a Job:</span> Describe what you need</li>
            <li><span class="highlight">Find Workers:</span> Browse or get matched automatically</li>
            <li><span class="highlight">Hire:</span> Connect and agree on job details</li>
            <li><span class="highlight">Complete:</span> Finish the job with secure payment</li>
        </ol>
    </main>
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

    <script>
        const menuBtn = document.getElementById('menuBtn');
        const navLinks = document.getElementById('navLinks');
        
        menuBtn.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    </script>
</body>
</html>