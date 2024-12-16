<?php
require "./includes/config.php";

$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['username'])) {
    $username = $con->real_escape_string($data['username']);

    // Check for duplicate username
    $query = "SELECT COUNT(*) AS count FROM users WHERE username = '$username'";
    $result = $con->query($query);
    $row = $result->fetch_assoc();

    // Return JSON response
    if ($row['count'] > 0) {
        echo json_encode(["exists" => true]); // Username exists
    } else {
        echo json_encode(["exists" => false]); // Username is available
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
