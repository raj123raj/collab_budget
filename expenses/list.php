<?php
require_once __DIR__ . '/../includes/header.php';
if (!isset($_SESSION['user_id'])) { header('Location: /collab-budget/auth/login.php'); exit; }

$stmt = $pdo->prepare("SELECT * FROM expenses WHERE user_id = ? ORDER BY spent_on DESC");
$stmt->execute([$_SESSION['user_id']]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Your Expenses</h2>
<a class="btn btn-success mb-3" href="add.php">Add Expense</a>
<table class="table table-striped">
  <thead>
    <tr>
      <th>Date</th><th>Description</th><th>Amount</th><th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rows as $r): ?>
    <tr>
      <td><?php echo htmlspecialchars($r['spent_on']); ?></td>
      <td><?php echo htmlspecialchars($r['description']); ?></td>
      <td><?php echo htmlspecialchars($r['amount']); ?></td>
      <td>
        <a class="btn btn-sm btn-primary" href="edit.php?id=<?php echo $r['id']; ?>">Edit</a>
        <a class="btn btn-sm btn-danger" href="delete.php?id=<?php echo $r['id']; ?>"
           onclick="return confirm('Delete this expense?');">Delete</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
