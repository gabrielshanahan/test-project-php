<?php

/** @var App $app */
$app = require __DIR__ . "/core/app.php";

require_once __DIR__ . "/validate/UserFormValidator.php";
require_once __DIR__ . "/core/form/FormHandler.php";
require_once __DIR__ . "/core/form/Response.php";


class CreateUserFormHandler extends FormHandler {

    protected function validate($sanitizedFormData): array
    {
        return UserFormValidator::validate($sanitizedFormData);
    }

    protected function handle($validatedFormData): Response
    {
        $user = new User($this->app->db);
        $user->insert($validatedFormData);

        return new Created();
    }
}

$app->handleFormAndExit(CreateUserFormHandler::class, $_POST);