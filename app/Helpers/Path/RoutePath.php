<?php

if (!function_exists("api_path_v1")) {
    /**
     * add the api url into given path string
     * @param string $path
     * @return string
     */
    function api_path_v1(string $path) {
        return url("/api/v1".$path);
    }
}
