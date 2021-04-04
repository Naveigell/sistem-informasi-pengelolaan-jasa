<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Traits\Seeder\FakerFiles;
use App\Traits\Random;

class ServiceSparePartSeeder extends Seeder
{
    use Random, FakerFiles;

    /**
     * @param $perangkat
     * @return array create a random new sparepart
     */
    private function makeSparePart($perangkat) {
        $table = DB::table('spare_part')->where('tipe', $perangkat)->get()->toArray();

        $sparePartNeededCount   = rand(1, 3);
        $sparePartNeeded        = [];

        for ($i = 0; $i < $sparePartNeededCount; $i++) {
            $sparePart = $this->random($table);

            while (in_array($sparePart->id_spare_part, $sparePartNeeded)) {
                $sparePart = $this->random($table);
            }

            array_push($sparePartNeeded, $sparePart->id_spare_part);
        }

        return $sparePartNeeded;
    }

    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $services   = DB::table('service')->get();

        foreach ($services as $service) {

            $sparePartNeeded = $this->makeSparePart($service->jenis_perangkat);

            $spareParts = DB::table('spare_part')->select(['id_spare_part', 'nama_spare_part', 'harga'])
                                                      ->whereIn('id_spare_part', $sparePartNeeded)
                                                      ->get()->toArray();

            DB::transaction(function () use ($spareParts, $service, $sparePartNeeded){

                error_log($service->keluhan);
                error_log("Jenis perangkat : ".$service->jenis_perangkat);
                error_log("Jumlah spare part dibutuhkan : ".count($sparePartNeeded));

                foreach ($spareParts as $sparePart) {

                    $jumlah = rand(1, 2);

                    $data = [
                        "service_spare_part_id_spare_part"  => $sparePart->id_spare_part,
                        "service_spare_part_id_service"     => $service->id_service,
                        "nama_spare_part"                   => $sparePart->nama_spare_part,
                        "jumlah"                            => $jumlah,
                        "harga"                             => $sparePart->harga
                    ];

                    $inserted = DB::table('service_spare_part')->insert($data);
                    if ($inserted) {
                        error_log("Spare part dengan nama : [$sparePart->nama_spare_part] berhasil dimasukkan");
                    }
                    else {
                        error_log("Spare part dengan nama : [$sparePart->nama_spare_part] GAGAL dimasukkan");
                    }
                }
            });

            error_log("---------------");
        }
    }
}
