<?php

require_once __DIR__ . "/Response.php";

class Captcha
{

    static function validate(string $captchaToken, string $captchaSecret, ?string $remoteIp = null): bool
    {
        $data = array_merge(
            [
                'secret' => $captchaSecret,
                'response' => $captchaToken,
            ],
            $remoteIp !== null ? [ 'remoteip' => $remoteIp ] : []
        );

        $ch = curl_init("https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/x-www-form-urlencoded"]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        return $response->success && $response->score >= 0.5;
    }
}

class InvalidCaptcha extends BadRequest {
    public function __construct()
    {
        parent::__construct([
            Response::ERROR_KEY => "reCAPTCHA verification failed!"
        ]);
    }
}