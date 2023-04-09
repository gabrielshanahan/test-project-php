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
    echo json_encode([
        'other' => "CSRF validation failed! Try refreshing the page. " .
            "Be aware that, by refreshing, you will lose the data you just tried to create, and will" .
            " have to enter it anew." .
            " Data that was already saved (i.e. is visible in the table bellow) will not be affected."
    ]);
    exit;
}


// Create new instance of user
$user = new User($app->db);

function sanitizeInput($input): string {
    $input = strip_tags($input);
    $input = filter_var($input);
    $input = htmlspecialchars($input, ENT_QUOTES | ENT_HTML5);
    return trim($input);
}

$formData = [
    'name' => sanitizeInput($_POST['name']),
    'email' => sanitizeInput($_POST['email']),
    'city' => sanitizeInput($_POST['city']),
    'phone' => sanitizeInput($_POST['phone']),
];

$errorMessages = UserFormValidator::validate($formData);

if (count($errorMessages) !== 0) {
    http_response_code(400);
    echo json_encode($errorMessages);
    exit;
}

// Insert it to database with POST data
$user->insert($formData);
http_response_code(201);
