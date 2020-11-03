<?php

use Illuminate\Database\Seeder;
use App\Traits\ArrayRandom;
use App\Traits\FakerFiles;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder {
    use ArrayRandom;
    use FakerFiles;

    /**
     * @var int helper for generate gender
     */
    private static $gender = 1;

    /**
     * @param $first string
     * @param $second string
     * @return string Adding separator between first name and second name
     */
    private function addingUsernameSeparator($first, $second) : string {
        return $first.$this->random(['_', '.', '', '__']).$second.rand(1, 999);
    }

    /**
     * @param $username string
     * @return string generate an email from username
     */
    private function makeEmail($username) : string {
        $parse = $this->parseFile("internet");

        return $username.'@'.$this->random($parse->file->email);
    }

    /**
     * @return array get random list name from faker dummy
     */
    private function randomListName() : array{
        $parse = $this->parseFile("nama");

        if (rand(0, 10) < 5) {
            static::$gender = 0;
            return $parse->file->nama->wanita;
        }

        static::$gender = 1;
        return $parse->file->nama->pria;
    }

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
        $parse = $this->parseFile("alamat");

        $jalan = $this->random($parse->file->jalan);
        $nama = $this->random($parse->file->nama);
        $gang = $this->random($parse->file->gang);

        $needGang = rand(0, 10) < 5;
        $needX = rand(0, 10) < 5;

        $full = $jalan." ".$nama;
        // cek jika diperlukan nama gang
        if ($needGang)
            $full .= " Gang ".$gang;

        // masukkan nomor rumah
        $full .= " No.".rand(1, 999);

        // apakah butuh X dibelakangnya, misal: No 30X, No 2X
        if ($needX)
            $full .= "X";

        return $full;
    }

    /**
     * @param string $name
     * @return bool create a new default image for data dummy
     */
    private function makeDefaultImage(string $name){

        $imgPath = public_path("img/users/default/placeholder.png");
        $img = File::get($imgPath);
        $extension = File::extension($imgPath);

        $moved = Storage::disk("public")->put("users/image/$name.$extension", $img);

        return $moved;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $users = DB::table('users');
        $biodata = DB::table('biodata');

        for ($i = 0; $i < 90; $i++) {

            DB::transaction(function () use($i, $users, $biodata) {
                $list = $this->randomListName();

                // first name and second name
                $first = strtolower($this->random($list));
                $second = strtolower($this->random($list));

                while ($first == $second) {
                    $second = strtolower($this->random($list));
                }

                $name       = ucfirst($first)." ".ucfirst($second);
                $username   = $this->addingUsernameSeparator($first, $second);
                $email      = $this->makeEmail($username);
                $phone      = $this->makePhoneNumber();
                $gender     = static::$gender == 1 ? "Laki - laki" : "Perempuan";
                $address    = $this->makeAddress();

                $role = $i < 7 ? "teknisi" : "user";
                $role = $i < 2 ? "admin" : $role;

                $imgName = Str::random(60).date("YmdHis");
                $imgCreated = $this->makeDefaultImage($imgName);

                $id = $users->insertGetId([
                    "name"          => $name,
                    "username"      => $username,
                    "email"         => $email,
                    "password"      => Hash::make("123456"),
                    "role"          => $role,
                    "created_at"    => date("Y-m-d H:i:s"),
                    "updated_at"    => date("Y-m-d H:i:s")
                ]);

                $biodata->insert([
                    "biodata_id_users"      => $id,
                    "jenis_kelamin"         => $gender,
                    "nomor_hp"              => $phone,
                    "profile_picture"       => $imgName.".png",
                    "alamat"                => $address,
                    "created_at"            => date("Y-m-d H:i:s"),
                    "updated_at"            => date("Y-m-d H:i:s")
                ]);

                error_log($name);
                error_log($username);
                error_log($email);
                error_log($phone);
                error_log($gender);
                error_log($role);
                error_log($address);
                error_log($imgCreated ? "Image has been created" : "Image create failed");
                error_log("--------------------------");
            });
        }
    }
}
