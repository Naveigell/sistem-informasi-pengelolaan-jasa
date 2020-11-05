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

        $listDeskripsi = [
            "Oneya Solutions memberikan jasa reparasi atau service laptop dengan bermacam keluhkesah kerusakan. Tenaga teknisi handal serta profesional dan sedia menolong seluruh keluhkesah dari kerusakan fitur laptop kamu",
            "Oneya Solutions memberikan jasa rakit pc sesuai dengan keinginan kamu ataupun dengan saran kami. Tenaga teknisi kami handal juga profesional",
            "Oneya Solutions memberikan jasa service hp dimulai dari hp lama hinggal hp jenis terbaru",
            "Oneya Solutions memberikan jasa service printer bagi printer kamu yang memiliki masalah, segera service di tempat kami dengan keamanan yang terjamin",
            "Oneya Solutions memberikan jasa instalasi game baik itu di steam, unplay, origin ataupun sesuai dengan permintaan kamu"
        ];

        $listTipe = ["pc/komputer", "pc/komputer", "hp", "printer", "pc/komputer"];
        $listBiaya = ["80000", "12000", "50000", "60000", "10000"];

        $jasa = DB::table('jasa');

        for ($i = 0; $i < count($listNama); $i++) {
            $jasa->insert([
                "nama_jasa"         => $listNama[$i],
                "deskripsi"         => $listDeskripsi[$i],
                "tipe"              => $listTipe[$i],
                "biaya_jasa"        => $listBiaya[$i],
                "created_at"        => date('Y-m-d H:i:s'),
                "updated_at"        => date('Y-m-d H:i:s')
            ]);
        }
    }
}
