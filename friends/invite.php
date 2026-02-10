<?php
require_once __DIR__ . '/../includes/header.php';
if (!isset($_SESSION['user_id'])) { header('Location: /collab-budget/auth/login.php'); exit; }

$errors = [];
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if ($email === '') {
        $errors[] = "Email required.";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $friend = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$friend) {
            $errors[] = "No user with that email (ask your friend to register first).";
        } else {
            if ($friend['id'] == $_SESSION['user_id']) {
                $errors[] = "You cannot invite yourself.";
            } else {
                $stmt = $pdo->prepare(
                    "INSERT INTO friends (user_id,friend_id,status) VALUES (?,?, 'pending')
                     ON DUPLICATE KEY UPDATE status='pending'"
                );
                // for ON DUPLICATE KEY to work you'd add a unique index on (user_id,friend_id)
                try {
                    $stmt->execute([$_SESSION['user_id'], $friend['id']]);
                    $success = "Friend invited (recorded as pending).";
                } catch (PDOException $e) {
                    $errors[] = "Error inviting friend.";
                }
            }
        }
    }
}
?>
<h2>Invite Friend</h2>
<?php if ($success): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
<?php foreach ($errors as $e): ?>
<div class="alert alert-danger"><?php echo htmlspecialchars($e); ?></div>
<?php endforeach; ?>
<form method="post">
  <div class="mb-3">
    <label class="form-label">Friend's Email</label>
    <input type="email" name="email" class="form-control">
  </div>
  <button class="btn btn-primary">Send Invite</button>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
