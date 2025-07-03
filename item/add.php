<?php
require_once '../includes/db.php';
$item_code = $item_name = $item_category = $item_subcategory = $quantity = $unit_price = "";
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_code = trim($_POST["item_code"]);
    $item_name = trim($_POST["item_name"]);
    $item_category = trim($_POST["item_category"]);
    $item_subcategory = trim($_POST["item_subcategory"]);
    $quantity = trim($_POST["quantity"]);
    $unit_price = trim($_POST["unit_price"]);

    if (empty($item_code)) $errors[] = "Item code required";
    if (empty($item_name)) $errors[] = "Item name required";
    if (empty($item_category)) $errors[] = "Category required";
    if (empty($item_subcategory)) $errors[] = "Subcategory required";
    if (!is_numeric($quantity) || $quantity < 0) $errors[] = "Quantity must be a non-negative number";
    if (!is_numeric($unit_price) || $unit_price < 0) $errors[] = "Unit price must be a non-negative number";

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO item (item_code, item_category, item_subcategory, item_name, quantity, unit_price) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $item_code, $item_category, $item_subcategory, $item_name, $quantity, $unit_price);
        if ($stmt->execute()) {
            header("Location: list.php");
            exit;
        } else {
            $errors[] = "Database error: " . $conn->error;
        }
    }
}
?>
<?php include '../includes/header.php'; ?>
<div class="container mt-4">
    <h2>Add Item</h2>
    <?php if ($errors): ?>
        <div class="alert alert-danger"><?php echo implode("<br>", $errors); ?></div>
    <?php endif; ?>
    <form class="needs-validation" method="post" novalidate>
        <div class="mb-3">
            <label class="form-label">Item Code</label>
            <input type="text" class="form-control" name="item_code" required value="<?= htmlspecialchars($item_code) ?>">
            <div class="invalid-feedback">Item code required.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Item Name</label>
            <input type="text" class="form-control" name="item_name" required value="<?= htmlspecialchars($item_name) ?>">
            <div class="invalid-feedback">Item name required.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Item Category</label>
            <select class="form-select" name="item_category" required>
                <option value="">Select</option>
                <?php
                $res = $conn->query("SELECT id, category FROM item_category");
                while ($row = $res->fetch_assoc()) {
                    echo "<option value='{$row['id']}'" . ($item_category==$row['id']?'selected':'') . ">{$row['category']}</option>";
                }
                ?>
            </select>
            <div class="invalid-feedback">Category required.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Item Subcategory</label>
            <select class="form-select" name="item_subcategory" required>
                <option value="">Select</option>
                <?php
                $res = $conn->query("SELECT id, sub_category FROM item_subcategory");
                while ($row = $res->fetch_assoc()) {
                    echo "<option value='{$row['id']}'" . ($item_subcategory==$row['id']?'selected':'') . ">{$row['sub_category']}</option>";
                }
                ?>
            </select>
            <div class="invalid-feedback">Subcategory required.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Quantity</label>
            <input type="number" class="form-control" name="quantity" min="0" required value="<?= htmlspecialchars($quantity) ?>">
            <div class="invalid-feedback">Quantity required.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Unit Price</label>
            <input type="number" step="0.01" class="form-control" name="unit_price" min="0" required value="<?= htmlspecialchars($unit_price) ?>">
            <div class="invalid-feedback">Unit price required.</div>
        </div>
        <button type="submit" class="btn btn-primary">Add Item</button>
    </form>
</div>
<script>
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>
<?php include '../includes/footer.php'; ?>
