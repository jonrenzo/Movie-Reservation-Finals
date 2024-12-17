<?php
session_start();
require './includes/config.php';

// Initialize variables
$err = "";
$msg = "";

// Fetch movies from the database
$sql = "SELECT * FROM movie";
$result = mysqli_query($con, $sql);
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
    <title>Los Mojito's Entertainment | Now Showing</title>
</head>

<body>
    <?php include './includes/header.php'; ?>

    <div class="flex items-center justify-center pt-5">
        <h1 class="w-max text-center font-extrabold font-poppins text-5xl text-red-600">Now Showing!</h1>
    </div>

    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl transition-transform duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg">
                        <div class="h-52 flex flex-col justify-center items-center bg-blue-600 rounded-t-xl bg-cover" style="background-image: url('<?php echo $row['movie_path']; ?>')">
                        </div>
                        <div class="p-4 md:p-6">
                            <span class="block mb-1 text-xs font-semibold uppercase text-blue-600">
                                <?php echo htmlspecialchars($row['movie_director']); ?>
                            </span>
                            <h3 class="text-xl font-semibold text-gray-800">
                                <?php echo htmlspecialchars($row['movie_name']); ?>
                            </h3>
                            <p class="mt-3 text-gray-500">
                                <?php echo htmlspecialchars($row['movie_desc']); ?>
                            </p>
                        </div>
                        <div class="mt-auto flex border-t border-gray-200 divide-x divide-gray-200">
                            <a class="font-poppins w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-es-xl bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50" href="<?php echo htmlspecialchars($row['movie_trailer']); ?>" target="_blank">
                                Watch Trailer!
                            </a>
                            <a class="text-green-600 font-poppins w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-ee-xl bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50" href="booking.php?movie_id=<?php echo urlencode($row['movie_id']); ?>&movie_name=<?php echo urlencode($row['movie_name']); ?>">
                                BUY TICKET
                            </a>

                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center text-gray-500">No movies currently showing.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php include './includes/footer.php'; ?>
</body>

</html>