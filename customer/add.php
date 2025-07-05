<?php
require_once '../includes/db.php';
$title = $first_name = $middle_name = $last_name = $contact_no = $district = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $first_name = trim($_POST["first_name"]);
    $middle_name = trim($_POST["middle_name"]);
    $last_name = trim($_POST["last_name"]);
    $contact_no = trim($_POST["contact_no"]);
    $district = trim($_POST["district"]);

    // Validation
    if (empty($title)) $errors[] = "Title is required";
    if (empty($first_name)) $errors[] = "First name is required";
    if (empty($middle_name)) $errors[] = "Middle name is required";
    if (empty($last_name)) $errors[] = "Last name is required";
    if (!preg_match('/^\d{10}$/', $contact_no)) $errors[] = "Contact number must be 10 digits";
    if (empty($district)) $errors[] = "District is required";

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO customer (title, first_name, middle_name, last_name, contact_no, district) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $title, $first_name, $middle_name, $last_name, $contact_no, $district);
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
    <h2>Add Customer</h2>
    <?php if ($errors): ?>
        <div class="alert alert-danger"><?php echo implode("<br>", $errors); ?></div>
    <?php endif; ?>
    <form class="needs-validation" method="post" novalidate>
        <div class="mb-3">
            <label class="form-label">Title</label>
            <select class="form-select" name="title" required>
                <option value="">Select</option>
                <option value="Mr" <?= $title=='Mr'?'selected':'' ?>>Mr</option>
                <option value="Mrs" <?= $title=='Mrs'?'selected':'' ?>>Mrs</option>
                <option value="Miss" <?= $title=='Miss'?'selected':'' ?>>Miss</option>
                <option value="Dr" <?= $title=='Dr'?'selected':'' ?>>Dr</option>
            </select>
            <div class="invalid-feedback">Please select a title.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text" class="form-control" name="first_name" required value="<?= htmlspecialchars($first_name) ?>">
            <div class="invalid-feedback">First name required.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Middle Name</label>
            <input type="text" class="form-control" name="middle_name" required value="<?= htmlspecialchars($middle_name) ?>">
            <div class="invalid-feedback">Middle name required.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text" class="form-control" name="last_name" required value="<?= htmlspecialchars($last_name) ?>">
            <div class="invalid-feedback">Last name required.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Contact Number</label>
            <input type="text" class="form-control" name="contact_no" pattern="\d{10}" required value="<?= htmlspecialchars($contact_no) ?>">
            <div class="invalid-feedback">10-digit contact number required.</div>
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
            <div class="invalid-feedback">Please select a district.</div>
        </div>
        <button type="submit" class="btn btn-primary">Add Customer</button>
    </form>
</div>
<script>
// Bootstrap validation JS
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
