<?php
require_once '../includes/db.php';
$from = $to = "";
$rows = [];
$date_error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $from = $_POST['from'];
    $to = $_POST['to'];
    if ($from && $to && $from > $to) {
        $date_error = "'From' date must be before 'To' date.";
    } else {
        $sql = "SELECT i.invoice_no, i.date, c.first_name, c.last_name, d.district, i.item_count, i.amount
                FROM invoice i
                JOIN customer c ON i.customer = c.id
                JOIN district d ON c.district = d.id
                WHERE i.date BETWEEN ? AND ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $from, $to);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
<?php include '../includes/header.php'; ?>
<div class="container mt-4">
    <h2>Invoice Report</h2>
    <div class="card mb-4">
        <div class="card-body">
            <?php if ($date_error): ?>
                <div class="alert alert-danger mb-3"><?= $date_error ?></div>
            <?php endif; ?>
            <form method="post" class="row g-3 align-items-end" onsubmit="return validateDates();">
                <div class="col-md-4">
                    <label class="form-label">From:</label>
                    <input type="date" name="from" id="from" class="form-control" required value="<?= htmlspecialchars($from) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">To:</label>
                    <input type="date" name="to" id="to" class="form-control" required value="<?= htmlspecialchars($to) ?>">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Search</button>
                </div>
            </form>
        </div>
    </div>
    <script>
    function validateDates() {
        var from = document.getElementById('from').value;
        var to = document.getElementById('to').value;
        if (from && to && from > to) {
            alert("'From' date must be before 'To' date.");
            return false;
        }
        return true;
    }
    </script>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Invoice No</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>District</th>
                            <th>Item Count</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($rows as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['invoice_no']) ?></td>
                            <td><?= htmlspecialchars($row['date']) ?></td>
                            <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                            <td><?= htmlspecialchars($row['district']) ?></td>
                            <td><?= htmlspecialchars($row['item_count']) ?></td>
                            <td><?= htmlspecialchars($row['amount']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
            
</div>
<?php include '../includes/footer.php'; ?>
