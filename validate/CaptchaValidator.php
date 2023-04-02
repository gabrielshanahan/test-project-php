<?php

class CaptchaValidator
{
    static function validateCaptcha(): bool
    {
        $data = array(
            'secret' => "<SECRET>",
            'response' => $_POST['captchaToken'],
            'remoteip' => $_SERVER['REMOTE_ADDR'],
        );

        $ch = curl_init("https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        if ($response->success && $response->score >= 0.5) {
            return true;
        } else {
            return false;
        }
    }

}