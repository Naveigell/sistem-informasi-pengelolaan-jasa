<?php

use App\Traits\Random;
use App\Traits\Seeder\FakerFiles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComplaintSeeder extends Seeder
{
    use FakerFiles, Random;
    /**
     * Get random complaint
     *
     * @param array $complaints
     * @return mixed
     */
    private function randomComplaint(array $complaints) {
        return $complaints[array_rand($complaints)];
    }

    private function createComplaint($id_service, $id_user, $id_teknisi, $complaints)
    {
        $complaint = $this->randomComplaint($complaints);
        $technician = 0;
        $user = 0;
        $admin = 0;
        $rand = rand(0, 15);

        if ($rand > 12) {
            $admin = $user = $technician = 1;
        } else if ($rand > 9) {
            $user = $technician = 1;
        } else if ($rand > 6) {
            $technician = 1;
        }

        DB::beginTransaction();
        try {
            DB::table("pengaduan")->insert([
                "pengaduan_id_pelanggan"    => $id_user,
                "pengaduan_id_teknisi"      => $id_teknisi,
                "pengaduan_id_orders"       => $id_service,
                "isi"                       => $complaint->content,
                "stars"                     => rand(1, 5),
                "tipe"                      => "komplain",
                "dikerjakan_teknisi"        => $technician,
                "disetujui_pelanggan"       => $user,
                "disetujui_admin"           => $admin,
                "created_at"                => date("Y-m-d H:i:s"),
                "updated_at"                => date("Y-m-d H:i:s")
            ]);

            DB::commit();

            error_log("Complaint had been made");
        } catch (\Exception $exception) {
            DB::rollBack();

            error_log("Complaint error : ".$exception->getMessage());
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $complaints = $this->readFile("pengaduan")->file->pengaduan->komplain;

        $orders = DB::table("service")->select(["id_orders", "orders_id_user", "orders_id_teknisi", "status_service"])->get();
        foreach ($orders as $order) {
            DB::beginTransaction();
            try {
                $rand = rand(1, 10);
                if ($rand < 3) {
                    $this->createComplaint($order->id_service, $order->orders_id_user, $order->orders_id_teknisi, $complaints);
                }

                error_log("Complaint with id_service: $order->id_service created successfully, random value : $rand");

                DB::commit();
            } catch (Exception $exception) {
                DB::rollBack();

                error_log($exception->getMessage());
            }
        }
    }
}
