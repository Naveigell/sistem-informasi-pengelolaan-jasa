<?php

namespace App\Helpers\Arrays;

class Arrays
{
    /**
     * Replace array key, example, replace keys of variable $array, with
     * $replacement
     *
     * $array = [
     *      "table_id"          => "1",
     *      "table_quantity"    => 5
     * ]
     *
     * $replacements = [
     *      "table_id"          => "id",
     *      "table_quantity"    => "quantity"
     * ]
     *
     * The output will be
     *
     * $array = [
     *      "id"                => "1",
     *      "quantity"          => 5
     * ]
     *
     * @param array $replacements
     * @param array|null $array $array
     * @return array
     */
    public static function replaceKey(array $replacements, array $array = null)
    {
        if ($array == null)
            return $array;

        if (self::isMultiDimensional($array)) {
            return (new Arrays())->mapping($replacements, $array);
        } else {
            return (new Arrays())->single($replacements, $array);
        }
    }

    /**
     * Check if given array is multidimensional
     *
     * @param array|null $array $array
     * @return bool
     */
    public static function isMultiDimensional(array $array = null) : bool
    {
        if ($array == null)
            return false;

        foreach ($array as $arr) {
            if (!is_array($arr)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Replace key
     *
     * @param array $replacements
     * @param $item
     * @return array
     */
    private function single(array $replacements, $item)
    {
        $keys = array_keys($replacements);
        foreach ($keys as $key) {
            if (!array_key_exists($key, $item)) {
                continue;
            }

            if (!empty($item[$key]) || is_null($item[$key])) {
                $item[$replacements[$key]] = $item[$key];
                unset($item[$key]);
            }
        }

        return $item;
    }

    /**
     * Map array and check one by one if is multidimensional array
     *
     * @param array $replacements
     * @param array $array
     * @return array
     */
    private function mapping(array $replacements, array $array) : array
    {
        return array_map(function ($item) use ($replacements) {
            return $this->single($replacements, $item);
        }, $array);
    }
}
