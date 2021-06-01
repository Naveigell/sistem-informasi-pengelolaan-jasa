<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

use App\Traits\Seeder\FakerFiles;
use App\Traits\Random;

use Carbon\Carbon;

class OrdersSeeder extends Seeder
{
    use FakerFiles, Random;

    /**
     * @return stdClass make a random keluhan
     */
    private function makeKeluhan() {
        $obj = new stdClass();
        $parse = $this->readFile("service");

        // jika kurang dari 5, maka ambil keluhan kusus pc, selain itu hp
        if (rand(0, 10) < 5) {
            $obj->keluhan   = $this->random($parse->file->keluhan->perbaikan->pc);
            $obj->merk      = $this->random($parse->file->merk->pc);
            $obj->tipe      = "pc/komputer";
        } else {
            $obj->keluhan   = $this->random($parse->file->keluhan->perbaikan->hp);
            $obj->merk      = $this->random($parse->file->merk->hp);
            $obj->tipe      = "hp";
        }

        return $obj;
    }

    /**
     * @param $tipe string
     * @return mixed Buat teknisi secara random
     */
    private function makeTeknisi($tipe) {
        $listTeknisi        = DB::table('users')->select(["users.role", "users.id_users"])->where([
            "role"      => "teknisi"
        ])->get()->toArray();

        return $this->random($listTeknisi);
    }

    /**
     * @param int $hours additional hours to add, default 9
     * @return string
     */
    private function addingHoursFromNow($hours = 9) {
        return Carbon::now()->addHours($hours)->toDateTimeString();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $listUser       = DB::table('users')->where('role', 'user')
                            ->join('biodata', 'biodata.biodata_id_users', '=', 'users.id_users')->get();

        $listJasa       = DB::table("jasa")->select(["id_jasa", "biaya_jasa"])->get()->toArray();

        for ($i = 0; $i < count($listUser); $i++) {

            $user = $listUser[$i];

            $random     = rand(40, 70);
            $id         = $user->id_users;
            $name       = $user->name;
            $address    = $user->alamat;

            for ($j = 0; $j < $random; $j++) {
                $keluhan    = $this->makeKeluhan();

                // biaya total akan dijumlahkan dari $biayaPerbaikan + $biayaJasa yang random antara Rp30.000 hingga Rp500.000
                $jasa               = $this->random($listJasa);

                $status             = $this->random(["menunggu", "dicek", "perbaikan", "selesai", "terima"]);
                $uniqueID           = $this->randomID($id, 10);
                $teknisi            = $this->makeTeknisi($keluhan->tipe);

                $namaPerangkat      = strtoupper($keluhan->tipe." ".rand(100, 999));

                DB::beginTransaction();
                try {
                    DB::table('service')->insert([
                        "orders_id_teknisi"             => $teknisi->id_users,
                        "orders_id_pelanggan"           => $id,
                        "orders_id_jasa"                => $jasa->id_jasa,
                        "unique_id"                     => $uniqueID,
                        "nama_pelanggan"                => $name,
                        "alamat_pelanggan"              => $address,
                        "nama_perangkat"                => $namaPerangkat,
                        "keluhan"                       => $keluhan->keluhan,
                        "jenis_perangkat"               => $keluhan->tipe,
                        "merk"                          => $keluhan->merk,
                        "biaya_jasa"                    => 0,
                        "status_service"                => $status,
                        "created_at"                    => date("Y-m-d H:i:s"),
                        "updated_at"                    => date("Y-m-d H:i:s")
                    ]);
                    DB::commit();

                    error_log("Create success");
                } catch (Exception $e) {
                    error_log("Create error : ".$e->getMessage());
                    DB::rollBack();
                }

                error_log($uniqueID);
                error_log($teknisi->id_users);
                error_log($id);
                error_log($jasa->id_jasa);
                error_log($name);
                error_log($address);
                error_log($namaPerangkat);
                error_log($keluhan->keluhan." -> ($keluhan->tipe)");
                error_log($keluhan->merk);
                error_log($status);
                error_log("");
            }
            error_log("------------");
        }
    }
}
