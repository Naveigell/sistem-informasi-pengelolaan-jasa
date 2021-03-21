<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order\OrderModel;
use App\Models\Technician\TechnicianModel;
use App\Models\User\UserModel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Get all total of orders, technicians and users
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function total()
    {
        return json([
            "total" => [
                "orders"        => OrderModel::all()->count(),
                "technicians"   => (new TechnicianModel())->total(),
                "users"         => (new UserModel())->total()
            ],
        ]);
    }
}
