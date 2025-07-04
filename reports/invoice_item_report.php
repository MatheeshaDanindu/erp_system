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
    <form method="post" class="row g-3 mb-3">
        <div class="col-auto">
            <label>From:</label>
            <input type="date" name="from" class="form-control" required value="<?= htmlspecialchars($from) ?>">
        </div>
        <div class="col-auto">
            <label>To:</label>
            <input type="date" name="to" class="form-control" required value="<?= htmlspecialchars($to) ?>">
        </div>
        <div class="col-auto align-self-end">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const from = document.querySelector('input[name="from"]').value;
            const to = document.querySelector('input[name="to"]').value;
            if (from && to) {
                const fromDate = new Date(from);
                const toDate = new Date(to);
                if (fromDate >= toDate) {
                    alert('From date must be before To date.');
                    e.preventDefault();
                    return false;
                }
            }
        });
    </script>

    <?php if ($rows): ?>
    <table class="table table-bordered">
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
    <?php endif; ?>
</div>
<?php include '../includes/footer.php'; ?>
