<?php


namespace App\Interfaces\History;


interface MakeHistory
{
    /**
     * Create history
     *
     * @param array $data
     */
    public function createHistory(array $data);
}
