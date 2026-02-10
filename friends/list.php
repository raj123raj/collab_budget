<?php
require_once __DIR__ . '/../includes/header.php';
if (!isset($_SESSION['user_id'])) { header('Location: /collab-budget/auth/login.php'); exit; }

$stmt = $pdo->prepare(
"SELECT f.id, u.name, u.email, f.status
 FROM friends f
 JOIN users u ON u.id = f.friend_id
 WHERE f.user_id = ?"
);
$stmt->execute([$_SESSION['user_id']]);
$friends = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Your Friends</h2>
<a class="btn btn-success mb-3" href="invite.php">Invite Friend</a>
<a class="btn btn-success mb-3" href="accept.php">Accept Friend</a>
<table class="table">
  <thead>
    <tr><th>Name</th><th>Email</th><th>Status</th></tr>
  </thead>
  <tbody>
    <?php foreach ($friends as $fr): ?>
    <tr>
      <td><?php echo htmlspecialchars($fr['name']); ?></td>
      <td><?php echo htmlspecialchars($fr['email']); ?></td>
      <td><?php echo htmlspecialchars($fr['status']); ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
