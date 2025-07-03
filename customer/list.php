<?php
require_once '../includes/db.php';
$result = $conn->query("SELECT c.*, d.district AS district_name FROM customer c LEFT JOIN district d ON c.district = d.id");
?>
<?php include '../includes/header.php'; ?>
<div class="container mt-4">
    <h2>Customers</h2>
    <a href="add.php" class="btn btn-success mb-2">Add Customer</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Contact No</th>
                <th>District</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['first_name']) ?></td>
                <td><?= htmlspecialchars($row['last_name']) ?></td>
                <td><?= htmlspecialchars($row['contact_no']) ?></td>
                <td><?= htmlspecialchars($row['district_name']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this customer?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include '../includes/footer.php'; ?>
