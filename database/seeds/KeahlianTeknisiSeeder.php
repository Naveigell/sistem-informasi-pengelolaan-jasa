<?php

use Illuminate\Database\Seeder;
use App\Traits\Random;
use Illuminate\Support\Facades\DB;

class KeahlianTeknisiSeeder extends Seeder
{
    use Random;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listTeknisi = DB::table('users')->where('role', 'teknisi')->get();
        $listKeahlian = [
            'instalasi_printer', 'perbaikan_printer', 'pembersihan_printer',
            'instalasi_pc', 'perbaikan_pc', 'pembersihan_pc',
            'perbaikan_hp'
        ];

        $keahlianTeknisi = DB::table('keahlian_teknisi');

        foreach ($listTeknisi as $teknisi) {
            $id = $teknisi->id_users;
            $rand = rand(1, count($listKeahlian) - 1);

            error_log($id);
            for ($i = 0; $i < $rand; $i++) {

                $keahlian   = $listKeahlian[array_rand($listKeahlian)];
                $tipe       = 'hp';

                if (in_array('pc/komputer', ['instalasi_pc', 'perbaikan_pc', 'pembersihan_pc'])) {
                    $tipe = "pc/komputer";
                } elseif (in_array('hp', ['instalasi_printer', 'perbaikan_printer', 'pembersihan_printer'])) {
                    $tipe = "hp";
                }

                $data = [
                    "keahlian_teknisi_id_users" => $id,
                    "keahlian"                  => $keahlian,
                    "tipe"                      => $tipe
                ];

                $exists = DB::table('keahlian_teknisi')->where($data)->exists();

                if (!$exists) {
                    $inserted = $keahlianTeknisi->insert($data);

                    if ($inserted) {
                        error_log($keahlian);
                        error_log($tipe);
                    }
                }
            }
            error_log("----------------");
        }
    }
}
