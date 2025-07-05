
<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-4 mb-3">Welcome to the ERP System</h1>
            <p class="lead">Use the navigation bar to manage Customers, Items, and view Reports.</p>
        </div>
    </div>
    <div class="row g-4 justify-content-center">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-people-fill display-4 text-primary mb-2"></i>
                    <h5 class="card-title">Customers</h5>
                    <a href="customer/list.php" class="btn btn-primary w-100">Manage</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-box-seam display-4 text-success mb-2"></i>
                    <h5 class="card-title">Items</h5>
                    <a href="item/list.php" class="btn btn-success w-100">Manage</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-receipt display-4 text-info mb-2"></i>
                    <h5 class="card-title">Invoice Report</h5>
                    <a href="reports/invoice_report.php" class="btn btn-info w-100">View</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-clipboard-data display-4 text-secondary mb-2"></i>
                    <h5 class="card-title">Item Report</h5>
                    <a href="reports/item_report.php" class="btn btn-secondary w-100">View</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
