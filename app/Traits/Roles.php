<?php
namespace App\Traits;

use App\Interfaces\Rolable;

trait Roles
{
    /**
     * Check and run with role
     *
     * @param $role
     * @param array $data
     * @param Rolable $rolable
     */
    private function rolable(array $data, Rolable $rolable)
    {
        $role = auth("user")->user()->role;
        if ($role == "admin") {
            return $rolable->admin($data);
        } elseif ($role == "teknisi") {
            return $rolable->technician($data);
        } elseif ($role == "user") {
            return $rolable->user($data);
        }
        return null;
    }
}
