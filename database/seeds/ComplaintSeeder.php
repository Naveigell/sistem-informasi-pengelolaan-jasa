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

        DB::table("pengaduan")->insert([
            "pengaduan_id_users"    => $id_user,
            "pengaduan_id_teknisi"  => $id_teknisi,
            "pengaduan_id_service"  => $id_service,
            "isi"                   => $complaint->content,
            "stars"                 => rand(1, 5),
            "tipe"                  => "komplain",
            "created_at"            => date("Y-m-d H:i:s"),
            "updated_at"            => date("Y-m-d H:i:s")
        ]);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $complaints = $this->readFile("pengaduan")->file->pengaduan->komplain;

        $orders = DB::table("service")->select(["id_service", "service_id_user", "service_id_teknisi"])->get();
        foreach ($orders as $order) {
            DB::beginTransaction();
            try {
                $this->createComplaint($order->id_service, $order->service_id_user, $order->service_id_teknisi, $complaints);

                error_log("Complaint with id_service: $order->id_service created successfully");

                DB::commit();
            } catch (Exception $exception) {
                DB::rollBack();

                error_log($exception->getMessage());
            }
        }
    }
}
