
<?php
require_once '../includes/db.php';
$id = $_GET['id'] ?? '';
if (!$id) die('Invalid item ID');
$stmt = $conn->prepare("DELETE FROM item WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
include '../includes/header.php';
?>
<div class="container mt-4">
    <div class="alert alert-success">Item deleted successfully. <a href="list.php" class="btn btn-primary btn-sm ms-2">Back to List</a></div>
</div>
<?php include '../includes/footer.php'; ?>
