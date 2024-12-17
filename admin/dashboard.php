<?php
session_start();
require_once "../includes/config.php";

$stmt = $con->prepare("SELECT COUNT(*) AS total_movies FROM movie");
$stmt->execute();
$result = $stmt->get_result();
$movies_count = $result->fetch_assoc()['total_movies'];

$stmt = $con->prepare("SELECT COUNT(*) AS total_users FROM user");
$stmt->execute();
$result = $stmt->get_result();
$users_count = $result->fetch_assoc()['total_users'];


$stmt = $con->prepare("SELECT COUNT(*) AS total_reservations FROM reservation");
$stmt->execute();
$result = $stmt->get_result();
$reservation_count = $result->fetch_assoc()['total_reservations'];

$stmt = $con->prepare("SELECT DATE(date) AS reservation_date, COUNT(*) AS reservation_count FROM reservation GROUP BY DATE(date) ORDER BY reservation_date");
$stmt->execute();
$result = $stmt->get_result();
$chart_data = [];
while ($row = $result->fetch_assoc()) {
    $chart_data[] = [
        'x' => $row['reservation_date'],
        'y' => $row['reservation_count']
    ];
}
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
    <?php include 'header.php'; ?>

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
                    <h3 class="text-3xl sm:text-4xl lg:text-5xl font-semibold text-gray-800 mt-3">
                        <?php echo $movies_count; ?> movies
                    </h3>
                </div>
            </div>
            <!-- End Card -->

            <!-- Card -->
            <div class="flex flex-col gap-y-3 lg:gap-y-5 p-4 md:p-5 bg-white border shadow-sm rounded-xl items-center justify-center dark:bg-neutral-900 dark:border-neutral-800">
                <div class="inline-flex justify-center items-center">
                    <span class="size-2 inline-block bg-green-500 rounded-full me-2"></span>
                    <span class="text-xs font-semibold uppercase text-white ">Users</span>
                </div>

                <div class="text-center">
                    <h3 class="text-3xl sm:text-4xl lg:text-5xl font-semibold text-gray-800 dark:text-neutral-200 mt-3">
                        <?php echo $users_count; ?> users
                    </h3>
                </div>
            </div>
            <!-- End Card -->

            <!-- Card -->
            <div class="flex flex-col gap-y-3 lg:gap-y-5 p-4 md:p-5 bg-white border shadow-sm rounded-xl items-center justify-center">
                <div class="inline-flex justify-center items-center">
                    <span class="size-2 inline-block bg-red-500 rounded-full me-2"></span>
                    <span class="text-xs font-semibold uppercase text-black">Reservations Made</span>
                </div>

                <div class="text-center">
                    <h3 class="text-3xl sm:text-4xl lg:text-5xl font-semibold text-gray-800  mt-3">
                        <?php echo $reservation_count; ?> chairs
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
                    Reservations Over Time
                </h2>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/preline/2.0.3/preline.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var options = {
                series: [{
                    name: 'Reservations',
                    data: <?php echo json_encode($chart_data); ?>
                }],
                chart: {
                    height: 350,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: <?php echo json_encode(array_column($chart_data, 'x')); ?>,
                },
                yaxis: {
                    title: {
                        text: 'Reservations'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#hs-multiple-bar-charts"), options);
            chart.render();
        });
    </script>
</body>

</html>