<?php
require_once 'functions.php';

$message = null; // To store the system message

// Check for success messages based on query parameters
if (isset($_GET['success'])) {
    if ($_GET['success'] == 'created') {
        $message = [
            'text' => 'Applicant successfully created.',
            'type' => 'success'
        ];
    } elseif ($_GET['success'] == 'updated') {
        $message = [
            'text' => 'Applicant successfully updated.',
            'type' => 'success'
        ];
    } elseif ($_GET['success'] == 'deleted') {
        $message = [
            'text' => 'Applicant successfully deleted.',
            'type' => 'success'
        ];
    }
}

// Fetch all applicants
$applicantsResponse = getAllApplicants();
$applicants = [];

if ($applicantsResponse['statusCode'] === 200) {
    $applicants = $applicantsResponse['querySet'];
} else {
    $message = [
        'text' => $applicantsResponse['message'],
        'type' => 'error'
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Applicant List</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Applicant List</h1>

    <!-- Display System Message -->
    <?php if ($message): ?>
        <div id="system-message" class="message <?= $message['type'] ?>">
            <?= htmlspecialchars($message['text']) ?>
        </div>
    <?php endif; ?>

    <a href="create.php" style="display: inline-block; margin-bottom: 20px; text-decoration: none; color: white; background-color: #007bff; padding: 10px; border-radius: 5px;">Add New Applicant</a>

    <table border="1">
        <thead>
            <tr>
                <!-- Adjust table headers based on your database columns -->
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Years of Experience</th>
                <th>Specialization</th>
                <th>Favorite DBMS</th>
                <th>Favorite Frontend Framework</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($applicants)): ?>
                <?php foreach ($applicants as $applicant): ?>
                    <tr>
                        <td><?= htmlspecialchars($applicant['id']) ?></td>
                        <td><?= htmlspecialchars($applicant['firstName']) ?></td>
                        <td><?= htmlspecialchars($applicant['lastName']) ?></td>
                        <td><?= htmlspecialchars($applicant['email']) ?></td>
                        <td><?= htmlspecialchars($applicant['phone']) ?></td>
                        <td><?= htmlspecialchars($applicant['yearsOfExperience']) ?></td>
                        <td><?= htmlspecialchars($applicant['specialization']) ?></td>
                        <td><?= htmlspecialchars($applicant['favoriteDBMS']) ?></td>
                        <td><?= htmlspecialchars($applicant['favoriteFrontendFramework']) ?></td>
                        <td>
                            <a href="update.php?id=<?= htmlspecialchars($applicant['id']) ?>" style="color: blue;">Update</a> |
                            <form action="delete.php" method="POST" style="display: inline;">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($applicant['id']) ?>">
                                <button type="submit" style="color: red; border: none; background: none; cursor: pointer; padding: 0;">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10">No applicants found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        const messageDiv = document.getElementById('system-message');
        if (messageDiv) {
            setTimeout(() => {
                messageDiv.style.display = 'none';
            }, 3000); 
        }

        window.history.replaceState(null, document.title, window.location.pathname);
    </script>
</body>
</html>
