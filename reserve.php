<?php
session_start();
require_once './includes/config.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movie_id = $_POST['movie_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $theater = $_POST['theater'];
    $selected_seats = $_POST['selected_seats'];

    $seats = explode(',', $selected_seats);

    foreach ($seats as $seat) {
        $sql = "INSERT INTO reservation (movie_id, seat, date, theater, name, email) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("isssss", $movie_id, $seat, $date, $theater, $name, $email);
        $stmt->execute();
    }

    $sql = "SELECT movie_name FROM movie WHERE movie_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $stmt->bind_result($movie_name);
    $stmt->fetch();
    $stmt->close();

    $subject = "Your Movie Reservation Confirmation";
    $message = "Dear $name,\n\n";
    $message .= "Thank you for reserving your seat with Los Mojito's Entertainment. Here are your reservation details:\n\n";
    $message .= "Movie: $movie_name\n";
    $message .= "Date: $date\n";
    $message .= "Theater: $theater\n";
    $message .= "Seats: " . implode(', ', $seats) . "\n\n";
    $message .= "We look forward to seeing you at the movie!\n\n";
    $message .= "Best regards,\nLos Mojito's Entertainment";

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username = '5651b1eea5ecc9';
        $mail->Password = '879c0b1de00677';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 2525;
        $mail->setFrom('no-reply@losmojitosentertainment.com', 'Los Mojito\'s Entertainment');
        $mail->addAddress($email, $name);
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->send();

        header('Location: reservation_success.php');
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
