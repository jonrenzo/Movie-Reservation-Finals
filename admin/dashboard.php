<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en" data-theme="nord">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/output.css">
    <link rel="icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../node_modules/apexcharts/src/assets/apexcharts.css">
    <title>Los Mojito's Entertainment | Admin</title>
</head>

<body class="w-full pt-10 px-4 sm:px-6 md:px-8 lg:ps-72 font-poppins">
    <style type="text/css">
        .apexcharts-tooltip.apexcharts-theme-light {
            background-color: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }
    </style>
    <?php
    include 'header.php';
    ?>
    <!-- Content -->
    <div>
        <h1 class="font-semibold font-poppins text-3xl">Dashboard</h1>
    </div>
    <!-- End Content -->

    <!-- Card Section -->
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <!-- Card -->
            <div class="flex flex-col gap-y-3 lg:gap-y-5 p-4 md:p-5 bg-white border shadow-sm rounded-xl items-center justify-center">
                <div class="inline-flex justify-center items-center">
                    <span class="size-2 inline-block bg-gray-500 rounded-full me-2"></span>
                    <span class="text-xs font-semibold uppercase text-black">Movies</span>
                </div>

                <div class="text-center">
                    <h3 class="text-3xl sm:text-4xl lg:text-5xl font-semibold text-gray-600 mt-3">
                        [# of movies]
                    </h3>
                </div>
            </div>
            <!-- End Card -->

            <!-- Card -->
            <div class="flex flex-col items-center gap-y-3 lg:gap-y-5 p-4 md:p-5 bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-800">
                <div class="inline-flex justify-center items-center">
                    <span class="size-2 inline-block bg-green-500 rounded-full me-2"></span>
                    <span class="text-xs font-semibold uppercase text-white ">Users</span>
                </div>

                <div class="text-center">
                    <h3 class="text-3xl sm:text-4xl lg:text-5xl font-semibold text-gray-800 dark:text-neutral-200 mt-3">
                        [# of users]
                    </h3>
                </div>
            </div>
            <!-- End Card -->

            <!-- Card -->
            <div class="flex flex-col items-center justify-center gap-y-3 lg:gap-y-5 p-4 md:p-5 bg-white border shadow-sm rounded-xl">
                <div class="inline-flex justify-center items-center">
                    <span class="size-2 inline-block bg-red-500 rounded-full me-2"></span>
                    <span class="text-xs font-semibold uppercase text-black">Reservations Made</span>
                </div>

                <div class="text-center">
                    <h3 class="text-3xl sm:text-4xl lg:text-5xl font-semibold text-gray-800 mt-3">
                        [# of reservations]
                    </h3>
                </div>
            </div>
            <!-- End Card -->
        </div>
        <!-- End Grid -->
    </div>
    <!-- End Card Section -->

    <!-- Chart -->
    <!-- Card -->
    <div class="p-4 md:p-5 min-h-[410px] flex flex-col bg-white border shadow-sm rounded-xl">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-sm text-gray-500 dark:text-neutral-500">
                    Income
                </h2>
                <p class="text-xl sm:text-2xl font-medium text-gray-800">
                    ₱123,456,789
                </p>
            </div>

            <div>
                <span class="py-[5px] px-1.5 inline-flex items-center gap-x-1 text-xs font-medium rounded-md bg-teal-100 text-teal-800 dark:bg-teal-500/10 dark:text-teal-500">
                    <svg class="inline-block size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 5v14" />
                        <path d="m19 12-7 7-7-7" />
                    </svg>
                    25%
                </span>
            </div>
        </div>
        <!-- End Header -->

        <div id="hs-multiple-bar-charts"></div>
    </div>
    <!-- End Card -->


    <!-- JavaScripts -->
    <script src="../node_modules/preline/dist/preline.js"></script>
    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="../node_modules/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../node_modules/preline/dist/helper-apexcharts.js"></script>
    <script src="./js/script.js"></script>
    <script src="https://kit.fontawesome.com/ef6e01e8ad.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/preline/2.0.3/preline.min.js"></script>
</body>

</html>