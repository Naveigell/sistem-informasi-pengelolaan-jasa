<?php

namespace App\Traits\Seeder;

use Illuminate\Support\Facades\File;
use stdClass;

trait FakerFiles {
    /**
     * @return stdClass decoded json file
     */
    private function readFile(string $filename){
        $parse = new stdClass;
        $parse->file = json_decode(File::get(app_path("Dummy/Fakers/$filename.json")));

        return $parse;
    }
}
