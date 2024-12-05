<?php
require '../includes/config.php';
global $con;
session_start();
$error = "";
$msg = "";

if (isset($_REQUEST['submit'])) {
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    if (!empty($username) && !empty($password)) {
        $sql = "SELECT * FROM admin WHERE user='$username' && pass='$password'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        if ($row) {
            $_SESSION['admin_id'] = $row['admin_id'];
            $_SESSION['admin'] = $row['user'];
            header("location:dashboard.php");
        } else {
            $error = "    <div class='fixed top-0 left-0 w-full z-50 flex justify-center p-4'>
        <div id='error-alert' role='alert' class='alert bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded relative max-w-md w-full flex items-center space-x-4'>
            <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6 text-yellow-400 stroke-current shrink-0' fill='none' viewBox='0 0 24 24'>
                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z' />
            </svg>
            <span class='font-medium'>Warning: Invalid username or password!</span>
        </div>
    </div>    
    <script>
        setTimeout(() => {
            const errorAlert = document.getElementById('error-alert');
            if (errorAlert) {
                errorAlert.remove();
            }
        }, 5000);
    </script>";
        }
    } else {
        $error = "<p class='alert alert-warning'>Please Fill all the fields</p>";
    }
}
echo $error;
?>


<!DOCTYPE html>
<html lang="en" data-theme='nord'>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/output.css">
    <script src="./js/script.js"></script>
    <script src="https://kit.fontawesome.com/ef6e01e8ad.js" crossorigin="anonymous"></script>
    <link rel="icon" href="../images/logo.png" type="image/x-icon">
    <title>Los Mojito's Entertainment | Login</title>
</head>

<body>
    <div class="flex items-center justify-center min-h-screen bg-background">
        <div class="bg-white shadow-lg rounded-lg p-8 w-96">
            <h2 class="text-center text-3xl font-bold font-poppins mb-6 text-black">Login</h2>
            <form>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-muted-foreground font-poppins" for="username">Username</label>
                    <input type="text" name="username" id="username" class="font-poppins mt-1 block w-full border border-border rounded-md p-2 focus:outline-none focus:ring focus:ring-ring" placeholder="Enter your username" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-muted-foreground font-poppins" for="password">Password</label>
                    <input type="password" name="password" id="password" class="font-poppins mt-1 block w-full border border-border rounded-md p-2 focus:outline-none focus:ring focus:ring-ring" placeholder="Enter your password" required>
                </div>
                <button type="submit" name="submit" id="submit" class="w-full bg-primary text-white hover:bg-primary/80 py-2 rounded-md mt-5 font-poppins">Submit</button>
            </form>
        </div>
    </div>
</body>

</html>