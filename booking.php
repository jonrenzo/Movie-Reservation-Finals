<?php
session_start();
require_once './includes/config.php';

$movie_id = isset($_GET['movie_id']) ? $_GET['movie_id'] : null;

// Fetch movie details from the database
$movie_details = null;
if ($movie_id) {
    $sql = "SELECT movie_path, movie_name, movie_desc, movie_director, movie_trailer, movie_imdb, movie_price FROM movie WHERE movie_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $stmt->bind_result($movie_path, $movie_name, $movie_desc, $movie_director, $movie_trailer, $movie_imdb, $movie_price);
    $stmt->fetch();
    $stmt->close();

    $movie_details = [
        'movie_path' => $movie_path,
        'movie_name' => $movie_name,
        'movie_desc' => $movie_desc,
        'movie_director' => $movie_director,
        'movie_trailer' => $movie_trailer,
        'movie_imdb' => $movie_imdb,
        'movie_price' => $movie_price
    ];
}

// Fetch user details from the database
$user_details = null;
if (isset($_SESSION['uid'])) {
    $uid = $_SESSION['uid'];
    $sql = "SELECT first_name, last_name FROM user_details WHERE user_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $stmt->bind_result($first_name, $last_name);
    $stmt->fetch();
    $stmt->close();

    $user_details = [
        'name' => $first_name . ' ' . $last_name,
        'email' => $_SESSION['uemail']
    ];
}

// Fetch reserved seats from the database
$reserved_seats = [];
if ($movie_id) {
    $sql = "SELECT seat FROM reservation WHERE movie_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $reserved_seats[] = $row['seat'];
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="nord" class="font-poppins">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/output.css">
    <script src="./js/script.js"></script>
    <script src="https://kit.fontawesome.com/ef6e01e8ad.js" crossorigin="anonymous"></script>
    <link rel="icon" href="./images/logo.png" type="image/x-icon">
    <title>Los Mojito's Entertainment | Reserve</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .seat {
            width: 40px;
            height: 40px;
            margin: 5px;
            display: inline-block;
            text-align: center;
            line-height: 40px;
            border-radius: 5px;
            cursor: pointer;
        }

        .seat.available {
            background-color: #4A5568;
            color: #fff;
        }

        .seat.selected {
            background-color: #4299E1;
        }

        .seat.unavailable {
            background-color: #E53E3E;
            color: #fff;
            cursor: not-allowed;
        }

        .screen {
            width: 80%;
            height: 10px;
            background-color: #fff;
            margin: 20px auto;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">
    <?php include './includes/header.php'; ?>

    <div class="container mx-auto p-6">
        <?php if ($movie_details): ?>
            <!-- Movie Poster Header -->
            <div class="relative mb-8">
                <img src="<?php echo htmlspecialchars($movie_details['movie_path']); ?>" alt="<?php echo htmlspecialchars($movie_details['movie_name']); ?>" class="w-full h-96 object-cover rounded-lg shadow-lg">
                <div class="absolute inset-0 bg-black bg-opacity-50 rounded-lg"></div>
                <div class="absolute inset-0 flex flex-col items-start justify-center p-6 text-white">
                    <h1 class="text-5xl font-extrabold mb-4"><?php echo htmlspecialchars($movie_details['movie_name']); ?></h1>
                    <p class="text-lg mb-4"><?php echo htmlspecialchars($movie_details['movie_desc']); ?></p>
                    <p class="text-lg mb-2"><strong>Director:</strong> <?php echo htmlspecialchars($movie_details['movie_director']); ?></p>
                    <div class="flex space-x-4">
                        <a class="bg-white text-black px-4 py-2 rounded-lg hover:bg-gray-200" href="<?php echo htmlspecialchars($movie_details['movie_trailer']); ?>" target="_blank">Watch Trailer</a>
                        <a class="bg-transparent text-white border border-white px-4 py-2 rounded-lg hover:bg-white hover:text-black" href="<?php echo htmlspecialchars($movie_details['movie_imdb']); ?>" target="_blank">Details</a>
                    </div>
                </div>
            </div>

            <!-- Reservation Form -->
            <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Reserve Your Seat</h2>
                <form action="pay.php" method="POST">
                    <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($movie_id); ?>">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                        <input type="text" id="name" name="name" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required value="<?php echo htmlspecialchars($user_details['name'] ?? ''); ?>">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                        <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required value="<?php echo htmlspecialchars($user_details['email'] ?? ''); ?>">
                    </div>
                    <div class="mb-4">
                        <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Date:</label>
                        <input type="date" id="date" name="date" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4">
                        <label for="theater" class="block text-gray-700 text-sm font-bold mb-2">Theater:</label>
                        <select id="theater" name="theater" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="Theater 1">Theater 1</option>
                            <option value="Theater 2">Theater 2</option>
                            <option value="Theater 3">Theater 3</option>
                        </select>
                    </div>

                    <!-- Seat Selection -->
                    <div class="mb-4">
                        <label for="seats" class="block text-gray-700 text-sm font-bold mb-2">Select Your Seats:</label>
                        <div class="screen"></div>
                        <div class="seats-container">
                            <?php foreach (['A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'B1', 'B2', 'B3', 'B4', 'B5', 'B6', 'B7', 'B8'] as $seat): ?>
                                <div class="seat <?php echo in_array($seat, $reserved_seats) ? 'unavailable' : 'available'; ?>" data-seat="<?php echo $seat; ?>"><?php echo $seat; ?></div>
                            <?php endforeach; ?>
                        </div>
                        <input type="hidden" id="selected-seats" name="selected_seats" value="">
                    </div>

                    <!-- Price to Pay -->
                    <div class="mb-4">
                        <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Price to Pay:</label>
                        <div id="price" class="w-full px-3 py-2 border rounded-lg bg-gray-100 text-gray-700">₱0.00</div>
                        <input type="hidden" id="amount" name="amount" value="">
                    </div>

                    <div class="flex justify-center">
                        <button type="submit" name="pay" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Pay Now</button>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <p class="text-center text-red-500 text-lg">Movie not found.</p>
        <?php endif; ?>
    </div>

    <?php include './includes/footer.php'; ?>

    <script>
        const seats = document.querySelectorAll('.seat.available');
        const selectedSeatsInput = document.querySelector('#selected-seats');
        const priceDisplay = document.querySelector('#price');
        const amountInput = document.querySelector('#amount');
        const moviePrice = <?php echo htmlspecialchars($movie_details['movie_price']); ?>;

        seats.forEach(seat => {
            seat.addEventListener('click', function() {
                seat.classList.toggle('selected');
                updateSelectedSeats();
                updatePrice();
            });
        });

        function updateSelectedSeats() {
            const selectedSeats = [];
            seats.forEach(seat => {
                if (seat.classList.contains('selected')) {
                    selectedSeats.push(seat.dataset.seat);
                }
            });
            selectedSeatsInput.value = selectedSeats.join(',');
        }

        function updatePrice() {
            const selectedSeats = document.querySelectorAll('.seat.selected');
            const totalPrice = selectedSeats.length * moviePrice;
            priceDisplay.textContent = `₱${totalPrice.toFixed(2)}`;
            amountInput.value = totalPrice;
        }
    </script>
</body>

</html>