<?php

class CSRFValidator
{
    static function validateCSFR(): bool {
        return isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token'];
    }
}