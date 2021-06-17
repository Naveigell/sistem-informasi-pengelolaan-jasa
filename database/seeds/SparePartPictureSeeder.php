<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Traits\Seeder\FakerFiles;
use Illuminate\Support\Str;

class SparePartPictureSeeder extends Seeder
{
    use FakerFiles;

    /**
     * @param array $array
     * @param array $pictures
     * @return array|mixed merge pictures array into one array from given pictures array
     */
    private function createPictures($array = [], $pictures = []) {

        foreach ($pictures as $picture) {
            array_push($array, $picture[0]);
        }

        return $array;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parse = $this->readFile('spare_part');
        $pictures = $parse->file;

        $picArray = $this->createPictures([], $pictures->hp->foto_spare_part);
        $picArray = $this->createPictures($picArray, $pictures->pc->foto_spare_part);

        for ($i = 0; $i < count($picArray); $i++) {
            try {
                $extension = explode('.', $picArray[$i])[1];
                $name = Str::random(60).date("YmdHis").".$extension";

                DB::table('foto_spare_part')->insert([
                    "foto_spare_part_id_spare_part"     => $i + 1,
                    "picture"                           => $name,
                    "created_at"                        => date("Y-m-d H:i:s"),
                    "updated_at"                        => date("Y-m-d H:i:s"),
                ]);

                File::copy(app_path("Dummy/Fakers/images/spareparts/$picArray[$i]"), public_path("img/spareparts/$name"));

                error_log("Pic : ".$picArray[$i]." Created");
            } catch (Exception $exception) {
                error_log($exception->getMessage());
            }
        }
    }
}
