<?php
require_once '../includes/db.php';
$id = $_GET['id'] ?? '';
if (!$id) die('Invalid item ID');
$stmt = $conn->prepare("DELETE FROM item WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
header("Location: list.php");
exit;
?>
