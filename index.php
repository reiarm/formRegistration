<?php
session_start();

// Mengambil task yang akan diedit
$task_to_edit = null;
$index = null;
if (isset($_GET['edit'])) {
    $index = $_GET['edit'];
    if (isset($_SESSION['tasks'][$index])) {
        $task_to_edit = $_SESSION['tasks'][$index];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Manajemen Task (To-Do List)</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4">To-Do List</h1>

    <!-- Pesan Sukses Sweet Alert -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Success!',
                    text: '<?= $_SESSION['success_message'] ?>',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            });
        </script>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <form method="post" action="task.php" class="mb-4">
        <input type="hidden" name="index" value="<?= isset($index) ? $index : '' ?>">

        <div class="mb-3">
            <label for="title" class="form-label">Task Title:</label>
            <input type="text" name="title" id="title" value="<?= $task_to_edit['title'] ?? '' ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="priority" class="form-label">Priority:</label>
            <select name="priority" id="priority" class="form-select" required>
                <option value="Low" <?= isset($task_to_edit) && $task_to_edit['priority'] == 'Low' ? 'selected' : '' ?>>Low</option>
                <option value="Medium" <?= isset($task_to_edit) && $task_to_edit['priority'] == 'Medium' ? 'selected' : '' ?>>Medium</option>
                <option value="High" <?= isset($task_to_edit) && $task_to_edit['priority'] == 'High' ? 'selected' : '' ?>>High</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Task Description:</label>
            <textarea name="description" id="description" class="form-control" rows="3"><?= $task_to_edit['description'] ?? '' ?></textarea>
        </div>

        <button type="submit" name="<?= isset($task_to_edit) ? 'edit_task' : 'add_task' ?>" class="btn btn-primary w-100">
            <?= isset($task_to_edit) ? 'Update Task' : 'Add Task' ?>
        </button>
    </form>

    <!-- List Task -->
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Task Title</th>
                <th>Priority</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($_SESSION['tasks'])): ?>
                <?php foreach ($_SESSION['tasks'] as $index => $task): ?>
                    <tr>
                        <td><?= htmlspecialchars($task['title']) ?></td>
                        <td><?= htmlspecialchars($task['priority']) ?></td>
                        <td>
                            <a href="task_detail.php?id=<?= $index ?>" class="btn btn-sm btn-info">Detail</a>
                            <a href="index.php?edit=<?= $index ?>" class="btn btn-sm btn-warning">Edit</a>
                            <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $index ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">Tidak ada task yang tersedia</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- SweetAlert2 untuk Konfirmasi Delete -->
<script>
function confirmDelete(index) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Task ini akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "task.php?delete=" + index;
        }
    });
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>