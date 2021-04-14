<?php
namespace App\Helpers\Regex;

class RegexHelper {
    /**
     * Removing space from given text
     *
     * @param $value
     * @return string|string[]|null
     */
    public static function removeSpace($value) {
        return preg_replace('/\s+/', '', $value);
    }

    /**
     * Remove angle bracket and put </br> into text
     * it's like a content sanitizing
     *
     * @param $text
     * @return string
     */
    public static function toContent($text)
    {
        $text = self::sanitizeAngleBrackets($text);
        $text = nl2br($text);

        return $text;
    }

    /**
     * Sanitizing angle brackets '<' and '>'
     *
     * @param $text
     * @return string
     */
    public static function sanitizeAngleBrackets($text) : string
    {
        $text = preg_replace('/</', '&lt', $text);
        $text = preg_replace('/>/', '&gt', $text);

        return $text;
    }
}
