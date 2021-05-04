<?php


namespace App\Interfaces\Total;


interface Countable
{
    /**
     * Count the total of data
     *
     * @param $id
     * @param $role
     * @return mixed
     */
    public function total($id, $role);
}
