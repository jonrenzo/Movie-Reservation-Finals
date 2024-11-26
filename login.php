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

    <div class="mx-auto max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8 min-h-svh">
        <div class="mx-auto max-w-lg flex flex-col bg-gradient-to-t from-white rounded-2xl">
            <i class=" text-center text-7xl text-red-600 fa-solid fa-film mb-3"></i>
            <h1 class="text-center text-2xl font-bold text-red-500 sm:text-3xl font-poppins">Log in to your Account</h1>

            <p class="mx-auto mt-4 max-w-md text-center text-gray-500 font-poppins italic text-sm">
                Lights, Camera, Reserve! Your movie adventure starts with us!
                We don't just book seats. We craft cinematic destinies.
            </p>

            <form action="#" class="mb-0 mt-6 space-y-4 rounded-2xl p-4 shadow-2xl sm:p-6 lg:p-8 ">
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
                        <input type="text" class="grow border-none rounded-md font-poppins" placeholder="Username" />
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
                        <input type="password" class="grow border-none font-poppins" placeholder="Password" />
                    </label>
                </div>

                <button
                    type="submit"
                    class="block w-full rounded-lg bg-green-500 px-5 py-3 text-sm font-medium text-white font-poppins mt-10">
                    Log In
                </button>

                <p class="text-center text-sm text-gray-500 font-poppins">
                    No account?
                    <a class="underline" href="#">Register</a>
                </p>
            </form>
        </div>
    </div>



    <?php
    include './includes/footer.php';
    ?>

</body>

</html>