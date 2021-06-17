<?php

namespace App\Console\Commands\Images;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class RefreshImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove unused images of spareparts and users to clear space';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->clearUsersImageFolder();
        echo "\n\n\n";
        $this->clearSparepartsImageFolder();
    }

    /**
     * Clearing spareparts images
     */
    private function clearSparepartsImageFolder()
    {
        if (Schema::hasTable("biodata")) {
            $images     = DB::table("foto_spare_part")->select("picture")->pluck("picture")->toArray();
            $path       = public_path("img/spareparts");
            $files      = File::allFiles($path);
            $total      = count($files);

            echo "\n";
            echo "====================================\n";
            echo "Trying to clearing spareparts images\n";
            echo "====================================\n";
            echo "Total images available : $total \n";
            echo "Total images to clear : ".($total - count($images));
            echo "\n\n";

            foreach ($files as $file) {
                $name = $file->getRelativePathname();

                if (!in_array($name, $images)) {
                    if (unlink($path."/".$name)) {
                        --$total;
                        echo "Image remove successfully, $total images remaining";
                    } else {
                        echo "Something wrong";
                    }
                    echo "\n";
                }
            }

            echo "Image cleared\n";
            echo "==============================\n";
        }
    }

    /**
     * Clearing users images
     */
    private function clearUsersImageFolder(){
        if (Schema::hasTable("biodata")) {
            $images     = DB::table("biodata")->select("profile_picture")->pluck("profile_picture")->toArray();
            $path       = public_path("img/users");
            $files      = File::allFiles($path);
            $total      = count($files);

            echo "\n";
            echo "===============================\n";
            echo "Trying to clearing users images\n";
            echo "===============================\n";
            echo "Total images available : $total \n";
            echo "Total images to clear : ".($total - count($images) - 1);
            echo "\n\n";

            foreach ($files as $file) {
                $name = $file->getRelativePathname();
                if ($name == "default\placeholder.png")
                    continue;

                if (!in_array($name, $images)) {
                    if (unlink($path."/".$name)) {
                        --$total;
                        echo "Image remove successfully, $total images remaining";
                    } else {
                        echo "Something wrong";
                    }
                    echo "\n";
                }
            }
            echo "Image cleared\n";
            echo "==============================\n";
        }
    }
}
