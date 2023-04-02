<?php

require_once("./validate/UserFormValidator.php");

$app = require "./core/app.php";

// Create new instance of user
$user = new User($app->db);

$formData = [
    'name' => $_POST['name'],
    'email' => $_POST['email'],
    'city' => $_POST['city']
];

$errorMessages = UserFormValidator::validate($formData);

header('Content-Type: application/json');

if (count($errorMessages) !== 0) {
    http_response_code(400);
    echo json_encode($errorMessages);
} else {
    // Insert it to database with POST data
    $user->insert($formData);
    http_response_code(200);
}
