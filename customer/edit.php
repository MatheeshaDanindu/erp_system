<?php
require_once '../includes/db.php';
$id = $_GET['id'] ?? '';
if (!$id) die('Invalid customer ID');

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $contact_no = $_POST['contact_no'];
    $district = $_POST['district'];

    // Validation
    if (!$title) $errors[] = "Title required";
    if (!$first_name) $errors[] = "First name required";
    if (!$last_name) $errors[] = "Last name required";
    if (!preg_match('/^\d{10}$/', $contact_no)) $errors[] = "Contact number must be 10 digits";
    if (!$district) $errors[] = "District required";

    if (!$errors) {
        $stmt = $conn->prepare("UPDATE customer SET title=?, first_name=?, middle_name=?, last_name=?, contact_no=?, district=? WHERE id=?");
        $stmt->bind_param("ssssssi", $title, $first_name, $middle_name, $last_name, $contact_no, $district, $id);
        $stmt->execute();
        header("Location: list.php");
        exit;
    }
} else {
    $stmt = $conn->prepare("SELECT * FROM customer WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $customer = $stmt->get_result()->fetch_assoc();
    if (!$customer) die('Customer not found');
    $title = $customer['title'];
    $first_name = $customer['first_name'];
    $middle_name = $customer['middle_name'];
    $last_name = $customer['last_name'];
    $contact_no = $customer['contact_no'];
    $district = $customer['district'];
}
?>
<?php include '../includes/header.php'; ?>
<div class="container mt-4">
    <h2>Edit Customer</h2>
    <?php if ($errors): ?>
        <div class="alert alert-danger"><?= implode("<br>", $errors) ?></div>
    <?php endif; ?>
    <form method="post" class="needs-validation" novalidate>
        <div class="mb-3">
            <label class="form-label">Title</label>
            <select class="form-select" name="title" required>
                <option value="">Select</option>
                <option value="Mr" <?= $title=='Mr'?'selected':'' ?>>Mr</option>
                <option value="Mrs" <?= $title=='Mrs'?'selected':'' ?>>Mrs</option>
                <option value="Miss" <?= $title=='Miss'?'selected':'' ?>>Miss</option>
                <option value="Dr" <?= $title=='Dr'?'selected':'' ?>>Dr</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text" class="form-control" name="first_name" required value="<?= htmlspecialchars($first_name) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Middle Name</label>
            <input type="text" class="form-control" name="middle_name" value="<?= htmlspecialchars($middle_name) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text" class="form-control" name="last_name" required value="<?= htmlspecialchars($last_name) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Contact Number</label>
            <input type="text" class="form-control" name="contact_no" pattern="\d{10}" required value="<?= htmlspecialchars($contact_no) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">District</label>
            <select class="form-select" name="district" required>
                <option value="">Select</option>
                <?php
                $res = $conn->query("SELECT id, district FROM district WHERE active='yes'");
                while ($row = $res->fetch_assoc()) {
                    echo "<option value='{$row['id']}'" . ($district==$row['id']?'selected':'') . ">{$row['district']}</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Customer</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
