<?php
session_start();
require_once '../includes/config.php';

// Fetch total number of reservations
$total_reservations = 0;
$sql_total = "SELECT COUNT(*) as total FROM reservation";
$stmt_total = $con->prepare($sql_total);
$stmt_total->execute();
$stmt_total->bind_result($total_reservations);
$stmt_total->fetch();
$stmt_total->close();

// Fetch number of reservations per movie
$movie_reservations = [];
$sql_movies = "SELECT m.movie_id, m.movie_name, COUNT(r.reservation_id) as reservation_count
               FROM movie m
               LEFT JOIN reservation r ON m.movie_id = r.movie_id
               GROUP BY m.movie_id, m.movie_name";
$stmt_movies = $con->prepare($sql_movies);
$stmt_movies->execute();
$stmt_movies->bind_result($movie_id, $movie_name, $reservation_count);
while ($stmt_movies->fetch()) {
    $movie_reservations[] = [
        'movie_id' => $movie_id,
        'movie_name' => $movie_name,
        'reservation_count' => $reservation_count
    ];
}
$stmt_movies->close();
?>

<!DOCTYPE html>
<html lang="en" data-theme="nord">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/output.css">
    <link rel="icon" href="../images/logo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/ef6e01e8ad.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../node_modules/apexcharts/src/assets/apexcharts.css">
    <title>Los Mojito's Entertainment | Reports</title>
</head>

<body class="w-full pt-10 px-4 sm:px-6 md:px-8 lg:ps-72 font-poppins">
    <?php include 'header.php'; ?>

    <div>
        <h1 class="font-semibold font-poppins text-3xl">Reports</h1>
    </div>

    <!-- Reports Section -->
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Card -->
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                        <!-- Header -->
                        <div class="px-5 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800">
                                    Reservation Reports
                                </h2>
                                <p class="text-sm text-gray-600">
                                    View reservation reports.
                                </p>
                            </div>
                            <div>
                                <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" href="export_reports.php?format=csv">
                                    Export as CSV
                                </a>
                                <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-green-600 text-white hover:bg-green-700 focus:outline-none focus:bg-green-700 disabled:opacity-50 disabled:pointer-events-none" href="export_reports.php?format=excel">
                                    Export as Excel
                                </a>
                            </div>
                        </div>
                        <!-- End Header -->

                        <!-- Total Reservations -->
                        <div class="px-5 py-4">
                            <h3 class="text-lg font-semibold text-gray-800">Total Reservations</h3>
                            <p class="text-sm text-gray-600"><?php echo htmlspecialchars($total_reservations); ?></p>
                        </div>

                        <!-- Reservations per Movie -->
                        <div class="px-5 py-4">
                            <h3 class="text-lg font-semibold text-gray-800">Reservations per Movie</h3>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-start">
                                            <div class="flex items-center gap-x-2">
                                                <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                                    Movie Name
                                                </span>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start">
                                            <div class="flex items-center gap-x-2">
                                                <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                                    Reservation Count
                                                </span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <?php foreach ($movie_reservations as $movie): ?>
                                        <tr>
                                            <td class="px-6 py-3">
                                                <span class="block text-sm text-gray-800"><?php echo htmlspecialchars($movie['movie_name']); ?></span>
                                            </td>
                                            <td class="px-6 py-3">
                                                <span class="block text-sm text-gray-800"><?php echo htmlspecialchars($movie['reservation_count']); ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Card -->
    </div>
    <!-- End Reports Section -->

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