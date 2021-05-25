<?php

use Illuminate\Database\Seeder;

use App\Traits\Random;
use App\Traits\Seeder\FakerBiodata;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder {
    use Random, FakerBiodata;

    /**
     * @var int helper for generate gender
     */
    private static $gender = 1;

    /**
     * @param $first string
     * @param $second string
     * @return string Adding separator between first name and second name
     */
    private function addingUsernameSeparator(string $first, string $second) : string {
        return $first.$this->random(['_', '.', '', '__']).$second.rand(1, 999);
    }

    /**
     * @param $username string
     * @return string generate an email from username
     */
    private function makeEmail(string $username) : string {
        $parse = $this->readFile("internet");

        return $username.'@'.$this->random($parse->file->email);
    }

    /**
     * @return array get random list name from faker dummy
     */
    private function randomListName() : array{
        $parse = $this->readFile("nama");

        if (rand(0, 10) < 5) {
            static::$gender = 0;
            return $parse->file->nama->wanita;
        }

        static::$gender = 1;
        return $parse->file->nama->pria;
    }

    /**
     * @param string $name
     * @return bool create a new default image for data dummy
     */
    private function makeDefaultImage(string $name){

        $imgPath = public_path("img/users/default/placeholder.png");
        $extension = File::extension($imgPath);

//        $moved = Storage::disk("public")->put("users/image/$name.$extension", $img);
        $moved = File::copy($imgPath, public_path("/img/users/$name.$extension"));

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

                $role = $i < 7 ? "teknisi" : "pelanggan";
                $role = $i < 2 ? "admin" : $role;

                $imgName = Str::random(60).date("YmdHis");
                $imgCreated = $this->makeDefaultImage($imgName);

                DB::beginTransaction();
                try {
                    $id = $users->insertGetId([
                        "name"          => $name,
                        "username"      => $username,
                        "email"         => $email,
                        "password"      => Hash::make("123456"),
                        "role"          => $role
                    ]);

                    $biodata->insert([
                        "biodata_id_users"      => $id,
                        "jenis_kelamin"         => $gender,
                        "nomor_hp"              => $phone,
                        "profile_picture"       => $imgName.".png",
                        "alamat"                => $address
                    ]);

                    DB::commit();

                    error_log($name);
                    error_log($username);
                    error_log($email);
                    error_log($phone);
                    error_log($gender);
                    error_log($role);
                    error_log($address);
                    error_log($imgCreated ? "Image has been created" : "Image create failed");
                    error_log("--------------------------");
                } catch (Exception $exception) {
                    DB::rollBack();

                    error_log(strtoupper($exception->getMessage()));
                }
            });
        }
    }
}
