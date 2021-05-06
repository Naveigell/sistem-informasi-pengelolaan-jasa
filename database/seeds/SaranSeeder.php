<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Traits\Seeder\FakerFiles;
use App\Traits\Random;

class SaranSeeder extends Seeder
{
    use FakerFiles, Random;

    /**
     * Get random suggestions
     *
     * @param array $suggestions
     * @return mixed
     */
    private function randomSuggestion(array $suggestions)
    {
        return $suggestions[array_rand($suggestions)];
    }

    private function createANumberOfSuggestion(int $id, int $count, array $suggestions)
    {
        $random = rand(10, 10 + $count);
        error_log("User with id: $id has a $random of suggestions");
        for ($i = 0; $i < $random; $i++) {
            $suggestion = $this->randomSuggestion($suggestions);

            DB::beginTransaction();
            try {
                DB::table("pengaduan")->insert([
                    "pengaduan_id_users"    => $id,
                    "isi"                   => $suggestion->content,
                    "stars"                 => rand(1, 5),
                    "tipe"                  => "saran",
                    "created_at"            => date("Y-m-d H:i:s"),
                    "updated_at"            => date("Y-m-d H:i:s")
                ]);

                DB::commit();

                error_log("User with id: $id has = '".$suggestion->content."'");
            } catch (\Exception $exception) {
                DB::rollBack();

                error_log("Something error with id: $id, ".$exception->getMessage());
            }
        }
        error_log("");
        error_log("");
        error_log("");
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $suggestions = $this->readFile("pengaduan")->file->pengaduan->saran;
        error_log(print_r($this->randomSuggestion($suggestions)));

        $users = DB::table("users")->select(["id_users"])->where("role", "user")->get();
        foreach ($users as $user) {
            DB::beginTransaction();
            try {
                $this->createANumberOfSuggestion($user->id_users, 10, $suggestions);

                error_log("User with id: $user->id_users created successfully");

                DB::commit();
            } catch (Exception $exception) {
                DB::rollBack();

                error_log($exception->getMessage());
            }
        }
    }
}
