<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JasaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listNama = [
            "Service laptop", "Rakit pc", "Service hp", "Service printer", "Instalasi Game"
        ];

        $listTipe = ["pc/komputer", "pc/komputer", "hp", "printer", "pc/komputer"];
        $listBiaya = ["80000", "12000", "50000", "60000", "10000"];

        $jasa = DB::table('jasa');

        for ($i = 0; $i < count($listNama); $i++) {
            $jasa->insert([
                "nama_jasa"         => $listNama[$i],
                "tipe"              => $listTipe[$i],
                "biaya_jasa"        => $listBiaya[$i],
                "created_at"        => date('Y-m-d H:i:s'),
                "updated_at"        => date('Y-m-d H:i:s')
            ]);
        }
    }
}
