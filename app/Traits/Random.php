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
     * @return string return a random serial number
     */
    private function serialNumber() : string
    {
        return  strtoupper(Str::random(4))."-".
                strtoupper(Str::random(6))."-".
                strtoupper(Str::random(1));
    }

    /**
     * @return string return a random part number
     */
    private function partNumber() : string
    {
        return  strtoupper(Str::random(3)).rand(100, 999).
                strtoupper(Str::random(3)).rand(100, 999).
                strtoupper(Str::random(3));
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

    /**
     * @param int $length
     * @return string create a random string for image, append random string with date
     */
    private function randomStringImage(int $length = 90){
        return Str::random($length).date("dmYHis").mt_rand(0, 100);
    }
}
