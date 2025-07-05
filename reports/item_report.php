<?php
require_once '../includes/db.php';
$sql = "SELECT DISTINCT it.item_name, ic.category, isc.sub_category, it.quantity
        FROM item it
        JOIN item_category ic ON it.item_category = ic.id
        JOIN item_subcategory isc ON it.item_subcategory = isc.id";
$result = $conn->query($sql);
?>
<?php include '../includes/header.php'; ?>
<div class="container mt-4">
    <h2>Item Report</h2>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['item_name']) ?></td>
                            <td><?= htmlspecialchars($row['category']) ?></td>
                            <td><?= htmlspecialchars($row['sub_category']) ?></td>
                            <td><?= htmlspecialchars($row['quantity']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
