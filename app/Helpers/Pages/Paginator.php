<?php

if (!function_exists("set_current_page")) {
    /**
     * set current page of pagination
     *
     * @param int $current
     */
    function set_current_page($current = 1){
        \Illuminate\Pagination\Paginator::currentPageResolver(function () use ($current){
            return $current;
        });
    }
}
