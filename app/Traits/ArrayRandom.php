<?php

namespace App\Traits;

trait ArrayRandom {
    private function random($array = []){
        return $array[array_rand($array)];
    }
}
