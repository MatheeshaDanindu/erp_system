<?php
require_once '../includes/db.php';
$result = $conn->query("SELECT it.*, ic.category AS category_name, isc.sub_category AS subcategory_name 
                        FROM item it
                        LEFT JOIN item_category ic ON it.item_category = ic.id
                        LEFT JOIN item_subcategory isc ON it.item_subcategory = isc.id");
?>
<?php include '../includes/header.php'; ?>
<div class="container mt-4">
    <h2>Items</h2>
    <a href="add.php" class="btn btn-success mb-2">Add Item</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['item_code']) ?></td>
                <td><?= htmlspecialchars($row['item_name']) ?></td>
                <td><?= htmlspecialchars($row['category_name']) ?></td>
                <td><?= htmlspecialchars($row['subcategory_name']) ?></td>
                <td><?= htmlspecialchars($row['quantity']) ?></td>
                <td><?= htmlspecialchars($row['unit_price']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this item?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include '../includes/footer.php'; ?>
