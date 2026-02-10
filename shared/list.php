<?php
require_once __DIR__ . '/../includes/header.php';
if (!isset($_SESSION['user_id'])) { header('Location: /collab-budget/auth/login.php'); exit; }

$stmt = $pdo->prepare(
"SELECT se.*, g.name AS group_name, u.name AS payer_name
 FROM shared_expenses se
 JOIN shared_groups g ON g.id = se.group_id
 JOIN users u ON u.id = se.payer_id
 JOIN shared_group_members m ON m.group_id = g.id
 WHERE m.user_id = ?
 ORDER BY se.spent_on DESC"
);
$stmt->execute([$_SESSION['user_id']]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Shared Expenses</h2>
<a class="btn btn-success mb-3" href="add.php">Add Shared Expense</a>
<table class="table table-striped">
  <thead>
    <tr><th>Group</th><th>Date</th><th>Description</th><th>Amount</th><th>Payer</th></tr>
  </thead>
  <tbody>
    <?php foreach ($rows as $r): ?>
    <tr>
      <td><?php echo htmlspecialchars($r['group_name']); ?></td>
      <td><?php echo htmlspecialchars($r['spent_on']); ?></td>
      <td><?php echo htmlspecialchars($r['description']); ?></td>
      <td><?php echo htmlspecialchars($r['amount']); ?></td>
      <td><?php echo htmlspecialchars($r['payer_name']); ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
