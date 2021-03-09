<?php
namespace App\Helpers\Url;

class QueryString {

    /**
     * Create a params for url by given array, example
     * $array = [
     *      "a" => "foo",
     *      "b" => "bar",
     *      "c"
     * ]
     *
     * will be ?a=foo&b=bar
     * c will ignore because c didn't have a value
     *
     * @param array $array
     * @return string
     */
    public static function parse($array = []) : string
    {
        $keys = array_keys($array);
        $query = "";

        // first for loop is just to remove key which is not has a value
        // second for loop is to parse the array into query string
        foreach ($keys as $key) {
            // if theres no value and key, remove it from array
            if (!is_string($key)) {
                unset($array[$key]);
            }
        }

        $keys = array_keys($array);
        for ($i = 0; $i < count($keys); $i++) {

            if ($array[$keys[$i]] == null) continue;

            // insert & between key and value
            // example a=foo&b=1
            $query .= $keys[$i]."=".$array[$keys[$i]];
            if ($i < count($keys) - 1) {
                if ($array[$keys[$i + 1]] !== null) {
                    $query .= "&";
                }
            }
        }

        return "?".$query;
    }
}
