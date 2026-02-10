<?php
require_once __DIR__ . '/includes/header.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: /collab-budget/auth/login.php');
    exit;
}
?>
<h1>Dashboard</h1>
<p>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>

<ul>
    <li><a href="/collab-budget/expenses/add.php">Add Expense</a></li>
    <li><a href="/collab-budget/expenses/list.php">View Expenses</a></li>
    <li><a href="/collab-budget/friends/invite.php">Invite Friend</a></li>
    <li><a href="/collab-budget/shared/add.php">Add Shared Expense</a></li>
</ul>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
