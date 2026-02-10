<?php
require_once __DIR__ . '/../includes/header.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: /collab-budget/auth/login.php');
    exit;
}

// id of the friends row
$friend_request_id = $_GET['id'] ?? null;

if ($friend_request_id) {
    // Ensure that the logged-in user is the one being invited (friend_id)
    $stmt = $pdo->prepare(
        "UPDATE friends 
         SET status = 'accepted' 
         WHERE id = ? AND friend_id = ? AND status = 'pending'"
    );
    $stmt->execute([$friend_request_id, $_SESSION['user_id']]);
}

header('Location: list.php');
exit;
