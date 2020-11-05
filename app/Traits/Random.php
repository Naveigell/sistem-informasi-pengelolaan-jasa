<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Random {
    /**
     * @param array $array
     * @return mixed return a value inside an array
     */
    private function random($array = []){
        return $array[array_rand($array)];
    }

    /**
     * @param null $additional
     * @param int $length length of random array, default is 12
     * @return string create some id with additional
     */
    private function randomID($additional = null, int $length = 12) {
        $unique = strtoupper(Str::random($length));

        if (is_null($additional))
            return $unique;

        return $unique.$additional;
    }
}
