<?php

if (!function_exists("sparepart_picture")) {
    /**
     * Insert a path from image string,
     * example : $name = "image.png",
     * sparepart_picture($name) will return "http://localhost:8000/img/spareparts/image.png"
     *
     * @param string $filename
     * @return string
     */
    function sparepart_picture($filename){
        return config("app.sparepart_picture_path").$filename;
    }
}
