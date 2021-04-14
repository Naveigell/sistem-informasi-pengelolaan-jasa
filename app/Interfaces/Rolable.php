<?php
namespace App\Interfaces;

interface Rolable
{
    /**
     * Run this if role admin
     *
     * @param array $data
     */
    public function admin(array $data);

    /**
     * Run this if role is technician
     *
     * @param array $data
     */
    public function technician(array $data);

    /**
     * Run this if role is user
     *
     * @param array $data
     */
    public function user(array $data);
}
