<?php
session_start();
require_once "../includes/config.php";

$stmt = $con->prepare("SELECT movie_id, movie_name, movie_director, movie_price, movie_path, movie_desc, movie_trailer, movie_imdb FROM movie");
$stmt->execute();
$result = $stmt->get_result();
$movies = $result->fetch_all(MYSQLI_ASSOC);

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_stmt = $con->prepare("DELETE FROM movie WHERE movie_id = ?");
    $delete_stmt->bind_param("i", $delete_id);
    if ($delete_stmt->execute()) {
        header("Location: view_movies.php");
        exit();
    } else {
        echo "<script>alert('Oops! Something went wrong. Please try again later.');</script>";
    }
    $delete_stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movieId = $_POST['movie_id'];
    $movieName = $_POST['movie_name'];
    $movieDirector = $_POST['movie_director'];
    $movieTrailer = $_POST['movie_trailer'];
    $movieIMDB = $_POST['movie_imdb'];
    $moviePrice = $_POST['movie_price'];
    $moviePath = $_POST['movie_path'];
    $movieDesc = $_POST['movie_desc'];

    $update_stmt = $con->prepare("UPDATE movie SET movie_name = ?, movie_director = ?, movie_price = ?, movie_path = ?, movie_desc = ?, movie_trailer = ?, movie_imdb = ? WHERE movie_id = ?");
    $update_stmt->bind_param("ssdssssi", $movieName, $movieDirector, $moviePrice, $moviePath, $movieDesc, $movieTrailer, $movieIMDB, $movieId);

    if ($update_stmt->execute()) {
        echo "<script>alert('Movie details updated successfully!');</script>";
        header("Location: view_movies.php");
        exit();
    } else {
        echo "<script>alert('Oops! Something went wrong. Please try again later.');</script>";
    }
    $update_stmt->close();
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
    <title>Los Mojito's Entertainment | Movies</title>
</head>

<body class="w-full pt-10 px-4 sm:px-6 md:px-8 lg:ps-72 font-poppins">
    <?php include 'header.php'; ?>

    <div>
        <h1 class="font-semibold font-poppins text-3xl">View Movies</h1>
    </div>

    <!-- Table Section -->
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Card -->
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                        <!-- Header -->
                        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800">
                                    Movies
                                </h2>
                                <p class="text-sm text-gray-600">
                                    List of all movies available in Los Mojito's Entertainment
                                </p>
                            </div>

                            <div>
                                <div class="inline-flex gap-x-2">
                                    <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" href="add_movies.php">
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12h14" />
                                            <path d="M12 5v14" />
                                        </svg>
                                        Add Movie
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- End Header -->
                        <!-- Table -->
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
                                                Director
                                            </span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                                Price
                                            </span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                                Path
                                            </span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                                ID
                                            </span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-end"></th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($movies as $movie): ?>
                                    <tr class="bg-white hover:bg-gray-50 movie-row" data-movie-id="<?php echo htmlspecialchars($movie['movie_id']); ?>">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="font-mono text-sm text-blue-600">
                                                <?php echo htmlspecialchars($movie['movie_name']); ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-600">
                                                <?php echo htmlspecialchars($movie['movie_director']); ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full">
                                                ₱<?php echo htmlspecialchars($movie['movie_price']); ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-600">
                                                <?php echo htmlspecialchars($movie['movie_path']); ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-600">
                                                <?php echo htmlspecialchars($movie['movie_id']); ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <button type="button" class="px-6 py-1.5" onclick="confirmDelete(<?php echo $movie['movie_id']; ?>)">
                                                <span class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm">
                                                    <svg class="w-4 h-4 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                    </svg>
                                                    Delete
                                                </span>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!-- End Table -->

                        <!-- Footer -->
                        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200">
                            <div>
                                <p class="text-sm text-gray-600">
                                    <span class="font-semibold text-gray-800"><?php echo count($movies); ?></span> results
                                </p>
                            </div>

                            <div>
                                <div class="inline-flex gap-x-2">
                                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                                        <svg class="size-3" width="16" height="16" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.506 1.64001L4.85953 7.28646C4.66427 7.48172 4.66427 7.79831 4.85953 7.99357L10.506 13.64" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                        Prev
                                    </button>

                                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                                        Next
                                        <svg class="size-3" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4.50598 2L10.1524 7.64645C10.3477 7.84171 10.3477 8.15829 10.1524 8.35355L4.50598 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- End Footer -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Card -->
    </div>
    <!-- End Table Section -->

    <!-- Modal Structure -->
    <div id="editMovieModal" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-xl font-semibold mb-4">Edit Movie</h2>
            <form id="editMovieForm" method="POST" action="view_movies.php">
                <input type="hidden" id="movieId" name="movie_id">
                <div class="mb-4">
                    <label for="movieName" class="block text-gray-700">Movie Name</label>
                    <input type="text" id="movieName" name="movie_name" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="movieDirector" class="block text-gray-700">Director</label>
                    <input type="text" id="movieDirector" name="movie_director" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="movieTrailer" class="block text-gray-700">Trailer Link</label>
                    <input type="text" id="movieTrailer" name="movie_trailer" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="movieIMDB" class="block text-gray-700">IMDB Link</label>
                    <input type="text" id="movieIMDB" name="movie_imdb" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="moviePrice" class="block text-gray-700">Price</label>
                    <input type="text" id="moviePrice" name="movie_price" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="moviePath" class="block text-gray-700">Path</label>
                    <input type="text" id="moviePath" name="movie_path" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="movieDesc" class="block text-gray-700">Description</label>
                    <textarea id="movieDesc" name="movie_desc" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" class="px-4 py-2 bg-gray-300 rounded-lg mr-2" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg ml-5" onclick="showSaveIndicator()">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Save Indicator -->
    <div id="saveIndicator" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <p class="text-xl font-semibold mb-4">Movie details updated successfully!</p>
            <button type="button" class="px-4 py-2 bg-blue-500 text-white rounded-lg" onclick="closeSaveIndicator()">OK</button>
        </div>
    </div>

    <!-- JavaScripts -->
    <script src="../node_modules/preline/dist/preline.js"></script>
    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="../node_modules/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../node_modules/preline/dist/helper-apexcharts.js"></script>
    <script src="./js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/preline/2.0.3/preline.min.js"></script>
    <script>
        function confirmDelete(movieId) {
            if (confirm('Are you sure you want to delete this movie?')) {
                window.location.href = 'view_movies.php?delete_id=' + movieId;
            }
        }

        function openModal(movie) {
            document.getElementById('movieId').value = movie.movie_id;
            document.getElementById('movieName').value = movie.movie_name;
            document.getElementById('movieDirector').value = movie.movie_director;
            document.getElementById('movieTrailer').value = movie.movie_trailer;
            document.getElementById('movieIMDB').value = movie.movie_imdb;
            document.getElementById('moviePrice').value = movie.movie_price;
            document.getElementById('moviePath').value = movie.movie_path;
            document.getElementById('movieDesc').value = movie.movie_desc;
            document.getElementById('editMovieModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('editMovieModal').classList.add('hidden');
        }

        function showSaveIndicator() {
            document.getElementById('saveIndicator').classList.remove('hidden');
        }

        function closeSaveIndicator() {
            document.getElementById('saveIndicator').classList.add('hidden');
            window.location.href = 'view_movies.php';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const movieRows = document.querySelectorAll('.movie-row');
            const movies = <?php echo json_encode($movies); ?>;
            movieRows.forEach(row => {
                row.addEventListener('click', function() {
                    const movieId = this.getAttribute('data-movie-id');
                    const movie = movies.find(m => m.movie_id == movieId);
                    openModal(movie);
                });
            });
        });
    </script>
</body>

</html>