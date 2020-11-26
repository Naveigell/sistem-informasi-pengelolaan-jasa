<?php

if (!function_exists("sparepart_api")) {
    /**
     * @param string $path
     * @return string
     */
    function api_path_v1($path) {
        return config('app.url').":".config('app.port')."/api/v1".$path;
    }
}
