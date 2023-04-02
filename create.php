<?php

require_once("./validate/UserFormValidator.php");
require_once ("./validate/CaptchaValidator.php");
$app = require "./core/app.php";

header('Content-Type: application/json');

if(!CaptchaValidator::validateCaptcha()) {
    http_response_code(400);
    echo json_encode([
        'recaptcha' => 'reCAPTCHA verification failed!'
    ]);
} else {
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
    } else {
        // Insert it to database with POST data
        $user->insert($formData);
        http_response_code(200);
    }
}
