<?php
require_once __DIR__ . '/../includes/header.php';
if (!isset($_SESSION['user_id'])) { header('Location: /collab-budget/auth/login.php'); exit; }

$id = $_GET['id'] ?? null;
$stmt = $pdo->prepare("SELECT * FROM expenses WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$exp = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$exp) { echo "Not found"; require_once __DIR__ . '/../includes/footer.php'; exit; }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $desc  = trim($_POST['description'] ?? '');
    $amt   = $_POST['amount'] ?? '';
    $date  = $_POST['spent_on'] ?? '';
    if ($desc === '' || $amt === '' || $date === '') {
        $errors[] = "All fields required.";
    } else {
        $stmt = $pdo->prepare("UPDATE expenses SET description=?, amount=?, spent_on=? WHERE id=? AND user_id=?");
        $stmt->execute([$desc, $amt, $date, $id, $_SESSION['user_id']]);
        header('Location: list.php');
        exit;
    }
}
?>
<h2>Edit Expense</h2>
<?php foreach ($errors as $e): ?>
<div class="alert alert-danger"><?php echo htmlspecialchars($e); ?></div>
<?php endforeach; ?>
<form method="post">
  <div class="mb-3">
    <label class="form-label">Description</label>
    <input type="text" name="description" class="form-control"
           value="<?php echo htmlspecialchars($exp['description']); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Amount</label>
    <input type="number" step="0.01" name="amount" class="form-control"
           value="<?php echo htmlspecialchars($exp['amount']); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Date</label>
    <input type="date" name="spent_on" class="form-control"
           value="<?php echo htmlspecialchars($exp['spent_on']); ?>">
  </div>
  <button class="btn btn-primary">Update</button>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
