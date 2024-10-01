<?php
session_start();

if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// Menambahkan Task
if (isset($_POST['add_task'])) {
    $task = [
        'title' => $_POST['title'],
        'priority' => $_POST['priority'],
        'description' => $_POST['description'] ?? ''
    ];
    $_SESSION['tasks'][] = $task;

    // Menampilkan pesan notifikasi setelah berhasil ditambahkan
    $_SESSION['success_message'] = 'Task berhasil ditambahkan.';
    header('Location: index.php'); // Kembali ke halaman utama
    exit;
}

// Mengedit Task
if (isset($_POST['edit_task'])) {
    $index = $_POST['index'];
    $_SESSION['tasks'][$index] = [
        'title' => $_POST['title'],
        'priority' => $_POST['priority'],
        'description' => $_POST['description'] ?? ''
    ];

    // Menampilkan pesan notifikasi setelah berhasil diubah
    $_SESSION['success_message'] = 'Task berhasil diperbarui.';
    header('Location: index.php');
    exit;
}

// Menghapus Task
if (isset($_GET['delete'])) {
    $index = $_GET['delete'];
    unset($_SESSION['tasks'][$index]);
    $_SESSION['tasks'] = array_values($_SESSION['tasks']); // Reset index array setelah dihapus

    // Menampilkan pesan notifikasi setelah berhasil dihapus
    $_SESSION['success_message'] = 'Task berhasil dihapus.';
    header('Location: index.php');
    exit;
}

// Mengambil task yang akan diedit
$task_to_edit = null;
if (isset($_GET['edit'])) {
    $index = $_GET['edit'];
    $task_to_edit = $_SESSION['tasks'][$index];
}
?>