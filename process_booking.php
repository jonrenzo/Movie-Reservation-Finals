<?php
session_start();
require './includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movie_id = $_POST['movie_id'];
    $movie_name = $_POST['movie_name'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $selectedSeats = $_POST['selectedSeats']; // Assuming you pass selected seats as a comma-separated string

    // Validate and sanitize input
    $name = mysqli_real_escape_string($con, $name);
    $email = mysqli_real_escape_string($con, $email);
    $phone = mysqli_real_escape_string($con, $phone);
    $selectedSeats = mysqli_real_escape_string($con, $selectedSeats);

    // Insert booking into the database
    $sql = "INSERT INTO reservation (movie_id, movie_name, name, email, phone, selected_seats) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "isssss", $movie_id, $movie_name, $name, $email, $phone, $selectedSeats);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "Booking successful!";
    } else {
        echo "Booking failed. Please try again.";
    }
}
