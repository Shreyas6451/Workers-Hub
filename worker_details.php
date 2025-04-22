<?php
require_once 'config/db.php';
$db = new Database();

$id = $_GET['id'] ?? null;

if ($id) {
    $worker = $db->fetch("SELECT * FROM workers WHERE id = :id", [':id' => $id]);
} else {
    header("Location: search.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Worker Details</title>
    <link rel="stylesheet" href="https://kit.fontawesome.com/3ab914e37c.css" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }
        .details-card {
            max-width: 600px;
            margin: auto;
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
        }
        .details-card h2 {
            margin-bottom: 20px;
            color: green;
        }
        .worker-info {
            margin: 10px 0;
            display: flex;
            align-items: center;
        }
        .worker-info i {
            margin-right: 10px;
            color: #666;
        }
    </style>
</head>
<body>

<?php if ($worker): ?>
<div class="details-card">
    <h2><?= htmlspecialchars($worker['name']) ?> (<?= htmlspecialchars($worker['profession']) ?>)</h2>
    <div class="worker-info">
        <i class="fas fa-map-marker-alt"></i>
        <span><?= htmlspecialchars($worker['village_city']) ?>, <?= htmlspecialchars($worker['sub_district']) ?>, <?= htmlspecialchars($worker['district']) ?></span>
    </div>
    <div class="worker-info">
        <i class="fas fa-phone"></i>
        <span><?= htmlspecialchars($worker['mobile']) ?></span>
    </div>
    <div class="worker-info">
        <i class="fas fa-briefcase"></i>
        <span><?= htmlspecialchars($worker['working_area']) ?></span>
    </div>
</div>
<?php else: ?>
<p style="text-align:center;">Worker not found.</p>
<?php endif; ?>

</body>
</html>
