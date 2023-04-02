<?php

require_once("./validate/UserFormValidator.php");
require_once("./validate/CaptchaValidator.php");
require_once("./validate/CSRFValidator.php");
$app = require "./core/app.php";

header('Content-Type: application/json');

if (!CaptchaValidator::validateCaptcha()) {
    http_response_code(400);
    echo json_encode(['other' => 'reCAPTCHA verification failed!']);
    exit;
}

if (!CSRFValidator::validateCSFR()) {
    http_response_code(400);
    echo json_encode(['other' => 'CSRF validation failed!']);
    exit;
}

// Create new instance of user
$user = new User($app->db);

$formData = [
    'name' => $_POST['name'],
    'email' => $_POST['email'],
    'city' => $_POST['city'],
    'phone' => $_POST['phone'],
];

$errorMessages = UserFormValidator::validate($formData);

if (count($errorMessages) !== 0) {
    http_response_code(400);
    echo json_encode($errorMessages);
    exit;
}

// Insert it to database with POST data
$user->insert($formData);
http_response_code(200);
