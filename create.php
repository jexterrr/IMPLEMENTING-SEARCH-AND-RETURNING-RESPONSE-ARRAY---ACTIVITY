<?php
require_once 'functions.php';

$message = null; // To store the system message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate form data
    $firstName = filter_var($_POST['firstName'], FILTER_SANITIZE_STRING);
    $lastName = filter_var($_POST['lastName'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $yearsOfExperience = filter_var($_POST['yearsOfExperience'], FILTER_SANITIZE_NUMBER_INT);
    $specialization = filter_var($_POST['specialization'], FILTER_SANITIZE_STRING);
    $favoriteDBMS = filter_var($_POST['favoriteDBMS'], FILTER_SANITIZE_STRING);
    $favoriteFrontendFramework = filter_var($_POST['favoriteFrontendFramework'], FILTER_SANITIZE_STRING);

    // Check if email is valid
    if (!$email) {
        $message = [
            'text' => 'Please provide a valid email address.',
            'type' => 'error'
        ];
    } else {
        // Prepare data for insertion
        $data = [
            ':firstName' => $firstName,
            ':lastName' => $lastName,
            ':email' => $email,
            ':phone' => $phone,
            ':yearsOfExperience' => $yearsOfExperience,
            ':specialization' => $specialization,
            ':favoriteDBMS' => $favoriteDBMS,
            ':favoriteFrontendFramework' => $favoriteFrontendFramework
        ];

        // Call function to create new applicant
        $response = createApplicant($data);

        // Set message based on the response
        if ($response['statusCode'] === 200) {
            // Redirect to index if creation is successful
            header("Location: index.php?success=created");
            exit;
        } else {
            $message = [
                'text' => $response['message'],
                'type' => 'error'
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Applicant</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Create New Applicant</h1>
    <!-- Display System Message -->
    <?php if ($message): ?>
        <div class="message <?= $message['type'] ?>">
            <?= htmlspecialchars($message['text']) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="create.php">
        <input type="text" name="firstName" placeholder="First Name" required>
        <input type="text" name="lastName" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Phone" required>
        <input type="number" name="yearsOfExperience" placeholder="Years of Experience" required>
        <input type="text" name="specialization" placeholder="Specialization" required>
        <input type="text" name="favoriteDBMS" placeholder="Favorite DBMS">
        <input type="text" name="favoriteFrontendFramework" placeholder="Favorite Frontend Framework">
        <button type="submit">Create</button>
    </form>
</body>
</html>
