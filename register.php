<?php
require_once './includes/config.php';

$email = $username = $password = $confirm_password = "";
$email_err = $username_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Email Validation
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email address.";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format.";
    } else {
        $sql = "SELECT user_id FROM user WHERE email = ?";
        if ($stmt = mysqli_prepare($con, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            $param_email = trim($_POST["email"]);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = "This email is already registered.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    // Username Validation
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else {
        $sql = "SELECT user_id FROM user WHERE username = ?";

        if ($stmt = mysqli_prepare($con, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = trim($_POST["username"]);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    // Password Validation
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 8) {
        $password_err = "Password must be at least 8 characters long.";
    } else {
        $password = trim($_POST["password"]);
    }
    if (empty(trim($_POST["confirm-password"]))) {
        $confirm_password_err = "Please confirm your password.";
    } else {
        $confirm_password = trim($_POST["confirm-password"]);
        if ($password != $confirm_password) {
            $confirm_password_err = "Passwords do not match.";
        }
    }

    if (empty($email_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO user(email, username, pass) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($con, $sql)) {
            mysqli_stmt_bind_param($stmt, "sss", $param_email, $param_username, $param_password);
            $param_email = $email;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            if (mysqli_stmt_execute($stmt)) {
                header("location: login.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    if (empty($email_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO user_details(user_id) VALUES (?)";
        if ($stmt = mysqli_prepare($con, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_uid);
            $param_uid = $_SESSION['uid'];
            if (mysqli_stmt_execute($stmt)) {
                header("location: login.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }



    mysqli_close($con);
}
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
    <title>Los Mojito's Entertainment | Create an Account</title>
</head>

<body class="bg-white">
    <?php
    include './includes/header.php';
    ?>
    <div class="flex align-middle justify-center min-h-[calc(100vh-120px)] items-center px-4 pb-5 ">
        <div class="w-[90%] max-w-[600px] mx-auto">
            <div class="mt-7 bg-white border border-gray-200 rounded-xl shadow-xl">
                <div class="p-4 sm:p-7">
                    <div class="text-center">
                        <h1 class="block text-4xl font-bold text-gray-800">Sign up</h1>
                        <p class="mt-4 text-sm text-gray-600">
                            Already have an account?
                            <a class="text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium" href="./login.php">
                                Log in here
                            </a>
                        </p>
                    </div>

                    <div class="mt-5">
                        <button type="button" class="font-poppins w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                            <svg class="w-4 h-auto" width="46" height="47" viewBox="0 0 46 47" fill="none">
                                <path d="M46 24.0287C46 22.09 45.8533 20.68 45.5013 19.2112H23.4694V27.9356H36.4069C36.1429 30.1094 34.7347 33.37 31.5957 35.5731L31.5663 35.8669L38.5191 41.2719L38.9885 41.3306C43.4477 37.2181 46 31.1669 46 24.0287Z" fill="#4285F4" />
                                <path d="M23.4694 47C29.8061 47 35.1161 44.9144 39.0179 41.3012L31.625 35.5437C29.6301 36.9244 26.9898 37.8937 23.4987 37.8937C17.2793 37.8937 12.0281 33.7812 10.1505 28.1412L9.88649 28.1706L2.61097 33.7812L2.52296 34.0456C6.36608 41.7125 14.287 47 23.4694 47Z" fill="#34A853" />
                                <path d="M10.1212 28.1413C9.62245 26.6725 9.32908 25.1156 9.32908 23.5C9.32908 21.8844 9.62245 20.3275 10.0918 18.8588V18.5356L2.75765 12.8369L2.52296 12.9544C0.909439 16.1269 0 19.7106 0 23.5C0 27.2894 0.909439 30.8731 2.49362 34.0456L10.1212 28.1413Z" fill="#FBBC05" />
                                <path d="M23.4694 9.07688C27.8699 9.07688 30.8622 10.9863 32.5344 12.5725L39.1645 6.11C35.0867 2.32063 29.8061 0 23.4694 0C14.287 0 6.36607 5.2875 2.49362 12.9544L10.0918 18.8588C11.9987 13.1894 17.25 9.07688 23.4694 9.07688Z" fill="#EB4335" />
                            </svg>
                            Sign up with Google
                        </button>

                        <div class="py-3 flex items-center text-xs text-gray-400 uppercase before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6">Or</div>

                        <!-- Form -->
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="grid gap-y-4">
                                <!-- Email input with error handling -->
                                <div>
                                    <label for="email" class="block text-sm mb-2 font-poppins">Email address</label>
                                    <div class="relative">
                                        <input type="email" id="email" name="email"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 
                    <?php echo (!empty($email_err)) ? 'border-red-500' : ''; ?>"
                                            value="<?php echo $email; ?>"
                                            required
                                            aria-describedby="email-error">
                                        <?php if (!empty($email_err)): ?>
                                            <div class="absolute inset-y-0 end-0 pointer-events-none pe-3">
                                                <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-xs text-red-600 mt-2" id="email-error">
                                        <?php echo $email_err; ?>
                                    </p>
                                </div>

                                <!-- Username input with error handling -->
                                <div>
                                    <label for="username" class="block text-sm mb-2 font-poppins">Username</label>
                                    <div class="relative">
                                        <input type="text" id="username" name="username"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 
                    <?php echo (!empty($username_err)) ? 'border-red-500' : ''; ?>"
                                            value="<?php echo $username; ?>"
                                            required
                                            aria-describedby="username-error">
                                        <?php if (!empty($username_err)): ?>
                                            <div class="absolute inset-y-0 end-0 pointer-events-none pe-3">
                                                <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-xs text-red-600 mt-2" id="username-error">
                                        <?php echo $username_err; ?>
                                    </p>
                                </div>

                                <!-- Password input with error handling -->
                                <div>
                                    <label for="password" class="block text-sm mb-2 font-poppins">Password</label>
                                    <div class="relative">
                                        <input type="password" id="password" name="password"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 
                    <?php echo (!empty($password_err)) ? 'border-red-500' : ''; ?>"
                                            required
                                            aria-describedby="password-error">
                                        <?php if (!empty($password_err)): ?>
                                            <div class="absolute inset-y-0 end-0 pointer-events-none pe-3">
                                                <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-xs text-red-600 mt-2" id="password-error">
                                        <?php echo $password_err; ?>
                                    </p>
                                </div>

                                <!-- Confirm Password input with error handling -->
                                <div>
                                    <label for="confirm-password" class="block text-sm mb-2 font-poppins">Confirm Password</label>
                                    <div class="relative">
                                        <input type="password" id="confirm-password" name="confirm-password"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 
                    <?php echo (!empty($confirm_password_err)) ? 'border-red-500' : ''; ?>"
                                            required
                                            aria-describedby="confirm-password-error">
                                        <?php if (!empty($confirm_password_err)): ?>
                                            <div class="absolute inset-y-0 end-0 pointer-events-none pe-3">
                                                <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-xs text-red-600 mt-2" id="confirm-password-error">
                                        <?php echo $confirm_password_err; ?>
                                    </p>
                                </div>

                                <!-- Checkbox -->
                                <div class="flex items-center">
                                    <div class="flex">
                                        <input id="remember-me" name="remember-me" type="checkbox"
                                            class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500">
                                    </div>
                                    <div class="ms-3">
                                        <label for="remember-me" class="text-sm">I accept the <a class="text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium" href="#">Terms and Conditions</a></label>
                                    </div>
                                </div>
                                <!-- End Checkbox -->

                                <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none font-poppins">Sign up</button>
                            </div>
                        </form>
                        <!-- End Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include './includes/footer.php';
    ?>

    <script src="./node_modules/preline/dist/preline.js"></script>
</body>

</html>