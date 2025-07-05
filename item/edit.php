<?php
require_once '../includes/db.php';
$id = $_GET['id'] ?? '';
if (!$id) die('Invalid item ID');

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_code = $_POST['item_code'];
    $item_category = $_POST['item_category'];
    $item_subcategory = $_POST['item_subcategory'];
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];

    if (!$item_code) $errors[] = "Item code required";
    if (!$item_name) $errors[] = "Item name required";
    if (!$item_category) $errors[] = "Category required";
    if (!$item_subcategory) $errors[] = "Subcategory required";
    if (!is_numeric($quantity) || $quantity < 0) $errors[] = "Quantity must be non-negative";
    if (!is_numeric($unit_price) || $unit_price < 0) $errors[] = "Unit price must be non-negative";

    if (!$errors) {
        $stmt = $conn->prepare("UPDATE item SET item_code=?, item_category=?, item_subcategory=?, item_name=?, quantity=?, unit_price=? WHERE id=?");
        $stmt->bind_param("ssssssi", $item_code, $item_category, $item_subcategory, $item_name, $quantity, $unit_price, $id);
        $stmt->execute();
        header("Location: list.php");
        exit;
    }
} else {
    $stmt = $conn->prepare("SELECT * FROM item WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $item = $stmt->get_result()->fetch_assoc();
    if (!$item) die('Item not found');
    $item_code = $item['item_code'];
    $item_category = $item['item_category'];
    $item_subcategory = $item['item_subcategory'];
    $item_name = $item['item_name'];
    $quantity = $item['quantity'];
    $unit_price = $item['unit_price'];
}
?>
<?php include '../includes/header.php'; ?>
<div class="container mt-4">
    <h2>Edit Item</h2>
    <?php if ($errors): ?>
        <div class="alert alert-danger"><?= implode("<br>", $errors) ?></div>
    <?php endif; ?>
    <form method="post" class="needs-validation" novalidate>
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
        <button type="submit" class="btn btn-primary">Update Item</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
