<?php
namespace App\Helpers\Regex;

class RegexHelper {
    public static function removeSpace($value) {
        return preg_replace('/\s+/', '', $value);
    }
}
