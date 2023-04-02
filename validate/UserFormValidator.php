<?php

class UserFormValidator
{

    /**
     * Kudos 2 https://stackoverflow.com/a/201378
     */
    private const EMAIL_PATTERN = "/(?:[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*|\"(?:[\x01-" .
    "\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*" .
    "[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}" .
    "(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a" .
    "\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";

    static function validate($data): array
    {
        return array_filter([
            "name" => self::validateName($data["name"]),
            "email" => self::validateEmail($data["email"]),
            "city" => self::validateCity($data["city"]),
        ]);
    }

    private static function validateName(string $name): array
    {
        return self::standardValidations("a name", $name);
    }

    private static function validateEmail(string $email): array
    {
        return array_merge(
            preg_match(self::EMAIL_PATTERN, $email)
                ? []
                : ["entered value is not a valid e-mail address"],
            self::standardValidations("an e-mail", $email)
        );
    }

    private static function validateCity(string $city): array
    {
        return self::standardValidations("a city", $city);
    }

    private static function standardValidations($subject, $str): array {
        $errorMessages = [];
        if(!$str || strlen($str) == 0) {
            $errorMessages[] = "you need to enter $subject";
        }

        if(strlen($str) > 65535) {
            $errorMessages[] = "$subject must be less than 65535 characters; you entered " . strlen($str);
        }

        return array_merge(
            $errorMessages,
            self::validateWhitespace($subject, $str)
        );
    }

    private static function validateWhitespace($subject, $str): array
    {
        $errorMessages = [];

        if(trim($str) === "") {
            $errorMessages[] = "$subject cannot contain only whitespace";
        } else {
            if(ctype_space($str[0])) {
                $errorMessages[] = "$subject cannot start with whitespace";
            }

            if(ctype_space($str[strlen($str) - 1])) {
                $errorMessages[] = "$subject cannot end with whitespace";
            }
        }

        return $errorMessages;
    }


}