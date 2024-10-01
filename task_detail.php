<?php
session_start();

// Mengambil index task dari query string
$index = $_GET['id'] ?? null;
$task_detail = null;

if ($index !== null && isset($_SESSION['tasks'][$index])) {
    $task_detail = $_SESSION['tasks'][$index];
} else {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Task Detail</h1>
    <div class="card mx-auto">
        <div class="card-body">
            <h2 class="card-title text-center"><?= htmlspecialchars($task_detail['title']) ?></h2>
            <h5 class="card-text text-center"><strong>Priority:</strong> <?= htmlspecialchars($task_detail['priority']) ?></h5>
            <hr>
            <h5 class="card-text text-center"><strong>Description:</strong></h5>
            <p class="card-text"> <?= nl2br(htmlspecialchars($task_detail['description'] ?? 'Tidak ada deskripsi')) ?></p>
            <a href="index.php" class="btn btn-primary btn-lg" style="width: 100%;">Kembali</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>