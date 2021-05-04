<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin\AdminModel;
use App\Models\Order\OrderModel;
use App\Models\Sparepart\SparepartModel;
use App\Models\Suggestion\SuggestionModel;
use App\Models\Technician\TechnicianModel;
use App\Models\User\UserModel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $auth, $role;
    private OrderModel $order;

    public function __construct()
    {
        $this->auth = auth("user");
        // make auth user is ready to take the role
        $this->middleware(function (Request $request, $next) {
            $this->role = auth("user")->user()->role;
            return $next($request);
        });
        $this->order = new OrderModel();
    }

    /**
     * Get all total of orders, technicians and users
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function total()
    {
        if ($this->role === "admin") {
            return json($this->admin());
        } else if ($this->role === "teknisi") {
            return json($this->technician());
        } else if ($this->role === "user") {
            return json($this->user());
        }
    }

    /**
     * Return total data of user dashboard
     *
     * @return \array[][]
     */
    private function user()
    {
        return [
            "total"         => [
                "orders"        => [
                    "count"     => $this->order->total($this->auth->id(), $this->role),
                    "text"      => "Orders",
                    "route"     => "/orders",
                    "icon"      => "fa-shopping-cart"
                ],
                "technicians"   => [
                    "count"     => (new TechnicianModel())->total(),
                    "text"      => "Teknisi",
                    "route"     => "/technician",
                    "icon"      => "fa-users"
                ],
                "admin"         => [
                    "count"     => (new AdminModel())->total(),
                    "text"      => "Admin",
                    "route"     => "/admin",
                    "icon"      => "fa-user"
                ],
                "messages"      => [
                    "count"     => (new SuggestionModel())->total($this->auth->id(), $this->role),
                    "text"      => "Saran",
                    "route"     => "/suggestions",
                    "icon"      => "fa-envelope"
                ]
            ]
        ];
    }

    /**
     * Return total data of technician dashboard
     *
     * @return \array[][]
     */
    private function technician()
    {
        return [
            "total" => [
                "orders"        => [
                    "count"     => $this->order->total($this->auth->id(), $this->role),
                    "text"      => "Orders",
                    "route"     => "/orders",
                    "icon"      => "fa-shopping-cart"
                ],
                "spareparts"    => [
                    "count"     => (new SparepartModel())->count(),
                    "text"      => "Sparepart",
                    "route"     => "/spareparts",
                    "icon"      => "fa-cogs"
                ],
            ]
        ];
    }

    /**
     * Return total data of admin dashboard
     *
     * @return \array[][]
     */
    private function admin()
    {
        return [
            "total" => [
                "orders"        => [
                    "count"     => $this->order->total($this->auth->id(), $this->role),
                    "text"      => "Orders",
                    "route"     => "/orders",
                    "icon"      => "fa-shopping-cart"
                ],
                "technicians"   => [
                    "count"     => (new TechnicianModel())->total(),
                    "text"      => "Teknisi",
                    "route"     => "/technician",
                    "icon"      => "fa-users"
                ],
                "users"         => [
                    "count"     => (new UserModel())->total(),
                    "text"      => "Pengguna",
                    "route"     => "/users",
                    "icon"      => "fa-user"
                ],
                "messages"      => [
                    "count"     => (new SuggestionModel())->total($this->auth->id(), $this->role),
                    "text"      => "Saran",
                    "route"     => "/suggestions",
                    "icon"      => "fa-envelope"
                ]
            ]
        ];
    }
}
