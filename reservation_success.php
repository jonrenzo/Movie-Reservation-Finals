<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en" data-theme="nord" class="font-poppins">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/output.css">
    <script src="./js/script.js"></script>
    <script src="https://kit.fontawesome.com/ef6e01e8ad.js" crossorigin="anonymous"></script>
    <link rel="icon" href="./images/logo.png" type="image/x-icon">
    <title>Los Mojito's Entertainment | Reservation Success</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 text-gray-800">
    <?php include './includes/header.php'; ?>

    <div class="container mx-auto p-6">
        <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg text-center">
            <h2 class="text-2xl font-semibold text-green-600 mb-4">Reservation and Payment Successful!</h2>
            <p class="text-lg mb-6">Thank you for reserving your seat with Los Mojito's Entertainment. We look forward to seeing you at the movie!</p>
            <a href="now_showing.php" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Go Back to Home</a>
        </div>
    </div>

    <?php include './includes/footer.php'; ?>
</body>

</html>