<?php require_once __DIR__ . '/../config/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Collaborative Budget</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="/collab-budget/dashboard.php">CollabBudget</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <?php if (isset($_SESSION['user_id'])): ?>
        <li class="nav-item"><a class="nav-link" href="/collab-budget/expenses/list.php">Expenses</a></li>
        <li class="nav-item"><a class="nav-link" href="/collab-budget/friends/list.php">Friends</a></li>
        <li class="nav-item"><a class="nav-link" href="/collab-budget/shared/list.php">Shared</a></li>
        <?php endif; ?>
      </ul>
      <ul class="navbar-nav">
        <?php if (isset($_SESSION['user_id'])): ?>
        <li class="nav-item"><a class="nav-link" href="/collab-budget/auth/logout.php">Logout</a></li>
        <?php else: ?>
        <li class="nav-item"><a class="nav-link" href="/collab-budget/auth/login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="/collab-budget/auth/register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
