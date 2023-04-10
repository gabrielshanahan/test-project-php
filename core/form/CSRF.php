<?php

require_once __DIR__ . "/Response.php";

class CSRF
{
    static function validate(string $token, array $definedTokens): bool {
        return $token != '' && in_array($token, $definedTokens);
    }
}

class InvalidCSRF extends BadRequest {
    public function __construct()
    {
        parent::__construct([
            Response::ERROR_KEY => "CSRF validation failed! Try refreshing the page. " .
                "Be aware that, by refreshing, you will lose the data you just tried to create, and will" .
                " have to enter it anew." .
                " Data that was already saved (i.e. is visible in the table bellow) will not be affected."
        ]);
    }
}