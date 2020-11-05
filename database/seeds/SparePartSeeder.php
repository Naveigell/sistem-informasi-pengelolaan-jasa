<?php

use Illuminate\Database\Seeder;
use App\Traits\FakerFiles;

use Illuminate\Support\Facades\DB;

class SparePartSeeder extends Seeder
{
    use FakerFiles;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listNama = [
            // hp
            "OPPO Layar LCD Touch Screen", "ASUS Layar LCD Touch Screen", "Samsung Layar LCD Touch Screen",
            "Huawei Layar LCD Touch Screen", "Xiaomi Layar LCD Touch Screen", "Vivo Layar LCD Touch Screen",
            "Realme Layar LCD Touch Screen",

            // pc/laptop
            "RAM DDR 3 2GB KINGSTON", "RAM DDR 3 4GB", "RAM DDR 4 8GB KINGSTON", "RAM KINGSTON LONGDIMM DDR4 4GB PC19200",
            "Kipas CPU Computer Fan Casing 8cm Hitam", "Heatsink Fan HSF cpu Cooler Intel AMD", "Harddisk Seagate Internal PC 500GB HDD SATA 3.5\"",
            "Seagate Barracuda 1TB HDD / Hardisk / Harddisk Internal", "Kingston A400 120GB SATA3 2.5\" SSD Internal", "VGA ASUS TUF Gaming GTX 1650 Super OC 4gb"
        ];

        $listTipe = [
            "hp", "hp", "hp", "hp", "hp", "hp", "hp",
            "pc/komputer", "pc/komputer", "pc/komputer", "pc/komputer", "pc/komputer", "pc/komputer", "pc/komputer",
            "pc/komputer", "pc/komputer", "pc/komputer"
        ];

        $listStok = [
            // hp
            "10", "5", "3", "1", "2", "4", "9",

            // pc/laptop
            "1", "2", "1", "0", "1", "1", "3", "4", "1", "2"
        ];

        $listHarga = [
            // hp
            "271897", "521716", "1037329", "413407", "513000", "216000", "338712",

            // pc/laptop
            "182000", "155000", "415000", "218000", "17000", "174900", "175000", "715000", "455000", "2920000"
        ];

        $sparePart = DB::table('spare_part');

        for ($i = 0; $i < count($listNama); $i++) {
            $sparePart->insert([
                "nama_spare_part"   => $listNama[$i],
                "deskripsi"         => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec dapibus ac nunc eu mattis. Nunc rutrum arcu eget justo accumsan eleifend. Nulla a dui quis lorem luctus iaculis. Quisque vitae elementum mauris, vel sodales urna. Cras eget eleifend augue. Integer malesuada ante ut mollis ultrices. Proin facilisis tincidunt lacus, eget luctus dui porttitor ac. Mauris lacinia condimentum faucibus. Aliquam imperdiet feugiat nisi a tristique. Fusce venenatis commodo nulla, eu tincidunt nunc pharetra et. Aenean nec lobortis dui. Nulla pellentesque ligula nec tortor convallis, eget pharetra magna eleifend. Nulla sit amet tempus ipsum. Phasellus in sapien quis justo feugiat lacinia at vitae justo. Donec congue sagittis dui ullamcorper pellentesque. Morbi vel dui lacus. Nullam varius quam velit, vel faucibus odio dapibus et. In finibus dictum velit, et dignissim nunc tempus eget. Donec ac facilisis sem.",
                "tipe"              => $listTipe[$i],
                "stok"              => $listStok[$i],
                "terjual"           => rand(6, 15),
                "harga"             => $listHarga[$i]
            ]);
        }
    }
}
