<?php
session_start();
require_once './includes/config.php';

if (isset($_POST['pay'])) {
    $user = $_SESSION['uid'];
    $amount = $_POST['amount'];
    $movie_id = $_POST['movie_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $theater = $_POST['theater'];
    $selected_seats = $_POST['selected_seats'];

    $sql = "SELECT movie_name FROM movie WHERE movie_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $stmt->bind_result($movie_name);
    $stmt->fetch();
    $stmt->close();

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.paymongo.com/v1/checkout_sessions",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'data' => [
                'attributes' => [
                    'send_email_receipt' => true,
                    'show_description' => true,
                    'show_line_items' => true,
                    'cancel_url' => 'http://localhost/now_showing.php',
                    'line_items' => [
                        [
                            'currency' => 'PHP',
                            'amount' => $amount * 100, // PayMongo expects the amount in cents
                            'description' => 'Movie Reservation for ' . $movie_name,
                            'quantity' => 1,
                            'name' => 'Los Mojito\'s Movie Reservation'
                        ]
                    ],
                    'statement_descriptor' => 'Los Mojitos', // This field sets the merchant name in the header
                    'success_url' => 'http://localhost:3000/payment_success.php?user=' . urlencode($user) . '&amount=' . urlencode($amount) . '&movie_id=' . urlencode($movie_id) . '&name=' . urlencode($name) . '&email=' . urlencode($email) . '&date=' . urlencode($date) . '&theater=' . urlencode($theater) . '&selected_seats=' . urlencode($selected_seats),
                    'payment_method_types' => [
                        'card',
                        'gcash',
                        'paymaya'
                    ],
                    'description' => 'Movie Reservation for ' . $movie_name
                ]
            ]
        ]),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "accept: application/json",
            "authorization: Basic c2tfdGVzdF92ZkhrSm96TkZmNGd1MjlLNTd5dnJtZmc6"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $responseData = json_decode($response, true);

        if (isset($responseData['data']['attributes']['checkout_url'])) {
            header('Location: ' . $responseData['data']['attributes']['checkout_url']);
        } else {
            // Print the full response for debugging
            echo "<pre>";
            print_r($responseData);
            echo "</pre>";
            echo json_encode(['error' => 'Failed to create a payment link']);
        }
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
