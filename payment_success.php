<?php
session_start();
require_once './includes/config.php';
require 'vendor/autoload.php'; // Include the Composer autoloader for PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_GET['user']) && isset($_GET['amount']) && isset($_GET['movie_id']) && isset($_GET['name']) && isset($_GET['email']) && isset($_GET['date']) && isset($_GET['theater']) && isset($_GET['selected_seats'])) {
    $user = $_GET['user'];
    $amount = $_GET['amount'];
    $movie_id = $_GET['movie_id'];
    $name = $_GET['name'];
    $email = $_GET['email'];
    $date = $_GET['date'];
    $theater = $_GET['theater'];
    $selected_seats = $_GET['selected_seats'];

    $seats = explode(',', $selected_seats);

    // Insert reservation details into the database
    foreach ($seats as $seat) {
        $sql = "INSERT INTO reservation (movie_id, seat, date, theater, name, email) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("isssss", $movie_id, $seat, $date, $theater, $name, $email);
        $stmt->execute();
    }

    // Fetch movie details for the email
    $sql = "SELECT movie_name FROM movie WHERE movie_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $stmt->bind_result($movie_name);
    $stmt->fetch();
    $stmt->close();

    // Prepare the email content
    $subject = "Your Movie Reservation Confirmation";
    $message = "Dear $name,\n\n";
    $message .= "Thank you for reserving your seat with Los Mojito's Entertainment. Here are your reservation details:\n\n";
    $message .= "Movie: $movie_name\n";
    $message .= "Date: $date\n";
    $message .= "Theater: $theater\n";
    $message .= "Seats: " . implode(', ', $seats) . "\n\n";
    $message .= "We look forward to seeing you at the movie!\n\n";
    $message .= "Best regards,\nLos Mojito's Entertainment";

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io'; // Use your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = '5651b1eea5ecc9'; // Your email address
        $mail->Password = '879c0b1de00677'; // Your email password or App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 2525;

        // Recipients
        $mail->setFrom('no-reply@losmojitosentertainment.com', 'Los Mojito\'s Entertainment');
        $mail->addAddress($email, $name);

        // Content
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Send the email
        $mail->send();

        // Redirect to reservation_success.php
        header('Location: reservation_success.php');
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
