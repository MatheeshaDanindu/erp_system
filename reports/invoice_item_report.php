<?php
require_once '../includes/db.php';
$from = $to = "";
$rows = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $from = $_POST['from'];
    $to = $_POST['to'];
    $sql = "SELECT im.invoice_no, i.date, c.first_name, c.last_name, it.item_name, it.item_code, ic.category, im.unit_price
            FROM invoice_master im
            JOIN invoice i ON im.invoice_no = i.invoice_no
            JOIN customer c ON i.customer = c.id
            JOIN item it ON im.item_id = it.id
            JOIN item_category ic ON it.item_category = ic.id
            WHERE i.date BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $from, $to);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<?php include '../includes/header.php'; ?>
<div class="container mt-4">
    <h2>Invoice Item Report</h2>
    <div class="card mb-4">
        <div class="card-body">
            <form method="post" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">From:</label>
                    <input type="date" name="from" class="form-control" required value="<?= htmlspecialchars($from) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">To:</label>
                    <input type="date" name="to" class="form-control" required value="<?= htmlspecialchars($to) ?>">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Search</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Invoice No</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Item Name</th>
                            <th>Item Code</th>
                            <th>Category</th>
                            <th>Unit Price</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($rows as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['invoice_no']) ?></td>
                            <td><?= htmlspecialchars($row['date']) ?></td>
                            <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                            <td><?= htmlspecialchars($row['item_name']) ?></td>
                            <td><?= htmlspecialchars($row['item_code']) ?></td>
                            <td><?= htmlspecialchars($row['category']) ?></td>
                            <td><?= htmlspecialchars($row['unit_price']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
            
</div>
<?php include '../includes/footer.php'; ?>
