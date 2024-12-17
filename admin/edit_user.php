<?php
session_start();
require_once '../includes/config.php';

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;
$user = null;

if ($user_id) {
    echo "User ID: $user_id<br>"; // Debugging output

    $sql = "SELECT ud.user_id, ud.first_name, ud.last_name, u.email, ud.gender, ud.phone_number
            FROM user_details ud
            JOIN user u ON ud.user_id = u.user_id
            WHERE ud.user_id = ?";
    $stmt = $con->prepare($sql);
    if ($stmt === false) {
        echo "Error preparing statement: " . $con->error . "<br>"; // Debugging output
    } else {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($user_id, $first_name, $last_name, $email, $gender, $phone_number);
        if ($stmt->fetch()) {
            $user = [
                'user_id' => $user_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'gender' => $gender,
                'phone_number' => $phone_number
            ];
        } else {
            echo "No user found with ID: $user_id<br>"; // Debugging output
        }
        $stmt->close();
    }
} else {
    echo "User ID is not set.<br>"; // Debugging output
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $phone_number = $_POST['phone_number'];

    // Update user_details table
    $sql = "UPDATE user_details SET first_name = ?, last_name = ?, gender = ?, phone_number = ? WHERE user_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssssi", $first_name, $last_name, $gender, $phone_number, $user_id);
    $stmt->execute();
    $stmt->close();

    // Update user table
    $sql = "UPDATE user SET email = ? WHERE user_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("si", $email, $user_id);
    $stmt->execute();
    $stmt->close();

    header("Location: users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="nord">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/output.css">
    <link rel="icon" href="../images/logo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/ef6e01e8ad.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../node_modules/apexcharts/src/assets/apexcharts.css">
    <title>Los Mojito's Entertainment | Edit User</title>
</head>

<body class="w-full pt-10 px-4 sm:px-6 md:px-8 lg:ps-72 font-poppins">
    <?php include 'header.php'; ?>

    <div>
        <h1 class="font-semibold font-poppins text-3xl">Edit User</h1>
    </div>

    <?php if ($user): ?>
        <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
            <form action="edit_user.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
                <div class="mb-4">
                    <label for="first_name" class="block text-gray-700 text-sm font-bold mb-2">First Name:</label>
                    <input type="text" id="first_name" name="first_name" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required value="<?php echo htmlspecialchars($user['first_name']); ?>">
                </div>
                <div class="mb-4">
                    <label for="last_name" class="block text-gray-700 text-sm font-bold mb-2">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required value="<?php echo htmlspecialchars($user['last_name']); ?>">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                    <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required value="<?php echo htmlspecialchars($user['email']); ?>">
                </div>
                <div class="mb-4">
                    <label for="gender" class="block text-gray-700 text-sm font-bold mb-2">Gender:</label>
                    <input type="text" id="gender" name="gender" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required value="<?php echo htmlspecialchars($user['gender']); ?>">
                </div>
                <div class="mb-4">
                    <label for="phone_number" class="block text-gray-700 text-sm font-bold mb-2">Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required value="<?php echo htmlspecialchars($user['phone_number']); ?>">
                </div>
                <div class="flex justify-center">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Update User</button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <p class="text-center text-red-500 text-lg">User not found.</p>
    <?php endif; ?>

    <!-- JavaScripts -->
    <script src="../node_modules/preline/dist/preline.js"></script>
    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="../node_modules/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../node_modules/preline/dist/helper-apexcharts.js"></script>
    <script src="./js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/preline/2.0.3/preline.min.js"></script>
</body>

</html>