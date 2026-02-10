<?php
require_once __DIR__ . '/../includes/header.php';
if (!isset($_SESSION['user_id'])) { header('Location: /collab-budget/auth/login.php'); exit; }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $desc  = trim($_POST['description'] ?? '');
    $amt   = $_POST['amount'] ?? '';
    $date  = $_POST['spent_on'] ?? '';

    if ($desc === '' || $amt === '' || $date === '') {
        $errors[] = "All fields required.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO expenses (user_id,description,amount,spent_on) VALUES (?,?,?,?)");
        $stmt->execute([$_SESSION['user_id'], $desc, $amt, $date]);
        header('Location: list.php');
        exit;
    }
}
?>
<h2>Add Expense</h2>
<?php foreach ($errors as $e): ?>
<div class="alert alert-danger"><?php echo htmlspecialchars($e); ?></div>
<?php endforeach; ?>
<form method="post">
  <div class="mb-3">
    <label class="form-label">Description</label>
    <input type="text" name="description" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">Amount</label>
    <input type="number" step="0.01" name="amount" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">Date</label>
    <input type="date" name="spent_on" class="form-control">
  </div>
  <button class="btn btn-primary">Save</button>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
