<?php
require_once 'functions.php';

// Get the applicant's ID
$id = $_POST['id'] ?? null;

if (!$id) {
    // Redirect to index if ID is missing
    header("Location: index.php");
    exit;
}

// Handle deletion
$response = deleteApplicant($id);

// Redirect to index with a success or error message
if ($response['statusCode'] === 200) {
    header("Location: index.php?success=deleted");
} else {
    header("Location: index.php?error=not_found");
}
exit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Delete Applicant</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Delete Applicant</h1>

    <!-- Display System Message -->
    <?php if ($message): ?>
        <div class="message <?= $message['type'] ?>">
            <?= htmlspecialchars($message['text']) ?>
        </div>
    <?php endif; ?>

    <p>Are you sure you want to delete the applicant?</p>
    <p><strong><?= htmlspecialchars($applicant['firstName'] . ' ' . $applicant['lastName']) ?></strong></p>

    <form method="POST">
        <button type="submit">Yes, Delete</button>
        <a href="index.php">Cancel</a>
    </form>
</body>
</html>
