<?php
session_start();
require_once "../includes/config.php";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movie_name = $_POST['movie_name'];
    $movie_director = $_POST['movie_director'];
    $movie_description = $_POST['movie_description'];
    $movie_trailer = $_POST['movie_trailer'];
    $movie_imdb = $_POST['movie_imdb'];
    $movie_price = $_POST['movie_price'];

    // Handle movie image upload
    $movie_image = $_FILES['movie_img']['name'];
    $target_dir = "../images/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($movie_image);
    if (move_uploaded_file($_FILES['movie_img']['tmp_name'], $target_file)) {
        $movie_image_path = $target_file;
    } else {
        $movie_image_path = '';
    }

    // Insert movie data into the database
    $stmt = $con->prepare("INSERT INTO movie (movie_name, movie_director, movie_desc, movie_path, movie_trailer, movie_imdb movie_price) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssd", $movie_name, $movie_director, $movie_description, $movie_image_path, $movie_trailer, $movie_imdb, $movie_price);
    if ($stmt->execute()) {
        echo "<script>alert('Movie added successfully!');</script>";
    } else {
        echo "<script>alert('Oops! Something went wrong. Please try again later.');</script>";
    }
    $stmt->close();
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
        <h1 class="font-semibold font-poppins text-3xl">Add Movies</h1>
    </div>

    <!-- Card Section -->
    <div class="max-w-4xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <form method="POST" enctype="multipart/form-data" id="movieForm">
            <!-- Card -->
            <div class="bg-white rounded-xl shadow">
                <div class="pt-0 p-4 sm:pt-0 sm:p-7">
                    <!-- Grid -->
                    <div class="space-y-4 sm:space-y-6">
                        <div class="space-y-2">
                            <label for="movie_name" class="inline-block text-sm font-medium text-black mt-2.5">
                                Movie Name
                            </label>
                            <input id="movie_name" name="movie_name" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter movie name">
                        </div>

                        <div class="space-y-2">
                            <label for="movie_director" class="inline-block text-sm font-medium text-black mt-2.5">
                                Movie Director
                            </label>
                            <input id="movie_director" name="movie_director" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter movie director">
                        </div>

                        <div class="space-y-2">
                            <label for="movie_img" class="inline-block text-sm font-medium text-gray-800 mt-2.5">
                                Preview image
                            </label>
                            <label for="movie_img" class="group p-4 sm:p-7 block cursor-pointer text-center border-2 border-dashed border-gray-200 rounded-lg focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-500 focus-within:ring-offset-2">
                                <input id="movie_img" name="movie_img" type="file" class="sr-only">
                                <svg class="size-10 mx-auto text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2z" />
                                    <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z" />
                                </svg>
                                <span class="mt-2 block text-sm text-gray-800">
                                    Browse your device or <span class="group-hover:text-blue-700 text-blue-600">drag 'n drop</span>
                                </span>
                                <span class="mt-1 block text-xs text-gray-500">
                                    Maximum file size is 2 MB
                                </span>
                            </label>
                            <div id="uploadIndicator" class="hidden mt-2 text-sm text-blue-600"></div>
                        </div>

                        <div class="space-y-2">
                            <label for="movie_description" class="inline-block text-sm font-medium text-gray-800 mt-2.5">
                                Movie Description
                            </label>
                            <textarea id="movie_description" name="movie_description" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" rows="6" placeholder="A detailed summary will better explain your products to the audiences. Our users will see this in your dedicated product page."></textarea>
                        </div>

                        <div class="space-y-2">
                            <label for="movie_trailer" class="inline-block text-sm font-medium text-black mt-2.5">
                                Movie Trailer Link
                            </label>
                            <input id="movie_trailer" name="movie_trailer" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter movie director">
                        </div>

                        <div class="space-y-2">
                            <label for="movie_imdb" class="inline-block text-sm font-medium text-black mt-2.5">
                                Movie IMDB Link
                            </label>
                            <input id="movie_imdb" name="movie_imdb" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter movie director">
                        </div>

                        <div class="space-y-2">
                            <label for="movie_price" class="inline-block text-sm font-medium text-black mt-2.5">
                                Movie Price
                            </label>
                            <input id="movie_price" name="movie_price" type="number" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter movie price">
                        </div>
                    </div>
                    <!-- End Grid -->

                    <div class="mt-5 flex justify-center gap-x-2">
                        <button type="submit" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            Add Movie
                        </button>
                    </div>
                </div>
            </div>
            <!-- End Card -->
        </form>
    </div>
    <!-- End Card Section -->

    <!-- JavaScripts -->
    <script src="../node_modules/preline/dist/preline.js"></script>
    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="../node_modules/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../node_modules/preline/dist/helper-apexcharts.js"></script>
    <script src="./js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/preline/2.0.3/preline.min.js"></script>
    <script>
        document.getElementById('movie_img').addEventListener('change', function() {
            document.getElementById('uploadIndicator').classList.remove('hidden');
            document.getElementById('uploadIndicator').textContent = "Selected: " + this.files[0].name;
        });

        document.getElementById('movieForm').addEventListener('submit', function(event) {
            document.getElementById('uploadIndicator').classList.add('hidden');
        });
    </script>
</body>

</html>