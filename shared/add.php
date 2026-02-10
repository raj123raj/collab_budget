<?php
require_once __DIR__ . '/../includes/header.php';
if (!isset($_SESSION['user_id'])) { header('Location: /collab-budget/auth/login.php'); exit; }

// Load groups where current user is member or creator
$stmt = $pdo->prepare(
"SELECT g.id, g.name
 FROM shared_groups g
 JOIN shared_group_members m ON m.group_id = g.id
 WHERE m.user_id = ?"
);
$stmt->execute([$_SESSION['user_id']]);
$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $group_id = $_POST['group_id'] ?? '';
    $desc     = trim($_POST['description'] ?? '');
    $amt      = $_POST['amount'] ?? '';
    $date     = $_POST['spent_on'] ?? '';
    if ($group_id === '' || $desc === '' || $amt === '' || $date === '') {
        $errors[] = "All fields required.";
    } else {
        $stmt = $pdo->prepare(
            "INSERT INTO shared_expenses (group_id,payer_id,description,amount,spent_on)
             VALUES (?,?,?,?,?)"
        );
        $stmt->execute([$group_id, $_SESSION['user_id'], $desc, $amt, $date]);
        header('Location: list.php');
        exit;
    }
}
?>
<h2>Add Shared Expense</h2>
<?php foreach ($errors as $e): ?>
<div class="alert alert-danger"><?php echo htmlspecialchars($e); ?></div>
<?php endforeach; ?>
<form method="post">
  <div class="mb-3">
    <label class="form-label">Group</label>
    <select name="group_id" class="form-control">
      <option value="">Select group</option>
      <?php foreach ($groups as $g): ?>
      <option value="<?php echo $g['id']; ?>"><?php echo htmlspecialchars($g['name']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
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
