<?php
require_once 'functions.php';

$message = null; // To store the system message
$searchTerm = ''; // To store the search term

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

// Handle search functionality
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
}

// Fetch all applicants (filtered by search term if any)
$applicantsResponse = getAllApplicants($searchTerm); // Pass the search term here
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant List</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Applicant List</h1>

    <!-- Search Form -->
    <form method="GET" action="index.php" style="margin-bottom: 20px;">
        <input type="text" name="search" value="<?= htmlspecialchars($searchTerm) ?>" placeholder="Search by name" style="padding: 5px;">
        <button type="submit" style="padding: 5px; background-color: #007bff; color: white; border: none;">Search</button>
    </form>

    <a href="create.php" style="display: inline-block; margin-bottom: 20px; text-decoration: none; color: white; background-color: #007bff; padding: 10px; border-radius: 5px;">Add New Applicant</a>

    <!-- Display System Message -->
    <?php if ($message): ?>
            <div id="system-message" class="message <?= $message['type'] ?>">
                <?= htmlspecialchars($message['text']) ?>
            </div>
    <?php endif; ?>

    <table border="1">
        <thead>
            <tr>
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
