<?php
require './includes/config.php';
global $con;
session_start();
$error = "";
$msg = "";

if (isset($_REQUEST['login'])) {
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    if (!empty($username) && !empty($password)) {
        // Use prepared statement to prevent SQL injection
        $stmt = mysqli_prepare($con, "SELECT user_id, email, pass FROM user WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        // Verify password using password_verify()
        if ($row && password_verify($password, $row['pass'])) {
            $_SESSION['uid'] = $row['user_id'];
            $_SESSION['uemail'] = $row['email'];
            header("location:now_showing.php");
            exit(); // Always exit after header redirect
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
<html lang="en" data-theme="nord">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/output.css">
    <script src="./js/script.js"></script>
    <script src="https://kit.fontawesome.com/ef6e01e8ad.js" crossorigin="anonymous"></script>
    <link rel="icon" href="./images/logo.png" type="image/x-icon">
    <title>Los Mojito's Entertainment | Login</title>
</head>

<body>
    <?php
    include './includes/header.php';
    ?>

    <div class="mx-auto max-w-screen-xl px-4 py-9 sm:px-6 lg:px-8 min-h-svh">
        <div class="mx-auto max-w-lg flex flex-col bg-gradient-to-t from-white rounded-2xl">
            <img src="./images/logo-black.png" class="w-60 mx-auto">
            <h1 class="text-center text-2xl font-bold text-red-500 sm:text-3xl font-poppins">Log in to your Account</h1>

            <p class="mx-auto mt-4 max-w-md text-center text-gray-500 font-poppins italic text-sm">
                Lights, Camera, Reserve! Your movie adventure starts with us!
                We don't just book seats. We craft cinematic destinies.
            </p>

            <form action="#" method="POST" class="mb-0 mt-6 space-y-4 rounded-2xl p-4 shadow-2xl sm:p-6 lg:p-8 ">
                <div>
                    <label class="input flex items-center gap-2 shadow-lg border-none rounded-lg">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 16 16"
                            fill="currentColor"
                            class="h-4 w-4 opacity-70">
                            <path
                                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                        </svg>
                        <input type="text" class="grow border-none rounded-md font-poppins" name="username" placeholder="Username" required />
                    </label>
                </div>

                <div class="pb-4">
                    <label class="input flex items-center gap-2 shadow-lg border-none rounded-lg">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 16 16"
                            fill="currentColor"
                            class="h-4 w-4 opacity-70">
                            <path
                                fill-rule="evenodd"
                                d="M14 6a4 4 0 0 1-4.899 3.899l-1.955 1.955a.5.5 0 0 1-.353.146H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2.293a.5.5 0 0 1 .146-.353l3.955-3.955A4 4 0 1 1 14 6Zm-4-2a.75.75 0 0 0 0 1.5.5.5 0 0 1 .5.5.75.75 0 0 0 1.5 0 2 2 0 0 0-2-2Z"
                                clip-rule="evenodd" />
                        </svg>
                        <input type="password" class="grow border-none font-poppins" name="password" placeholder="Password" required />
                    </label>
                </div>

                <button
                    name="login"
                    type="submit"
                    class="block w-full rounded-lg bg-green-500 px-5 py-3 text-sm font-medium text-white font-poppins mt-10">
                    Log In
                </button>

                <p class="text-center text-sm text-gray-500 font-poppins">
                    No account?
                    <a class="underline" href="register.php">Register</a>
                </p>
            </form>
        </div>
    </div>

    <?php
    include './includes/footer.php';
    ?>
    <script src="./js/script.js"></script>

</body>

</html>
