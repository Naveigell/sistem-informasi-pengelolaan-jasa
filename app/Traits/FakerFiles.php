<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;

trait FakerFiles {
    /**
     * @return \stdClass decoded json file
     */
    private function parseFile(string $filename){
        $parse = new \stdClass;
        $parse->file = json_decode(File::get(app_path("Dummy/Fakers/$filename.json")));

        return $parse;
    }
}
