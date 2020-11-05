<?php

namespace App\Traits\Seeder;
use App\Traits\Seeder\FakerFiles;

trait FakerBiodata {
    use FakerFiles;

    /**
     * @return string create random phone number
     */
    private function makePhoneNumber(){
        return "08".mt_rand(100000000, 999999999);
    }

    /**
     * @return string create random address
     */
    private function makeAddress(){
        $parse = $this->readFile("alamat");

        $jalan = $this->random($parse->file->jalan);
        $nama = $this->random($parse->file->nama);
        $gang = $this->random($parse->file->gang);

        $needGang = rand(0, 10) < 5;
        $needX = rand(0, 10) < 5;

        $address = $jalan." ".$nama;
        // cek jika diperlukan nama gang
        if ($needGang)
            $address .= " Gang ".$gang;

        // masukkan nomor rumah
        $address .= " No.".rand(1, 999);

        // apakah butuh X dibelakangnya, misal: No 30X, No 2X
        if ($needX)
            $address .= "X";

        return $address;
    }
}
