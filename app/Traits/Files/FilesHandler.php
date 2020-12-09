<?php
namespace App\Traits\Files;

use App\Traits\Random;

trait FilesHandler {
    use Random;

    /**
     * Storing multiple images into custom directory, return an array string of filename
     *
     * @param string $destination
     * @param array $images
     * @param array $accept
     * @return array
     */
    private function storeMultipleImages(string $destination, array $images, array $accept = ["jpg", "png", "jpeg"]) : array {
        // list to return all image name
        $list = [];

        foreach ($images as $image) {
            $filename       = $this->randomStringImage();
            $extension      = $image->getClientOriginalExtension();

            // simple backdoor protection
            if (in_array($extension, $accept)) {
                $fullFileName   = $filename.".".$extension;

                // move and store a new image name into $list variable
                if ($image->move($destination, $fullFileName)) {
                    array_push($list, $fullFileName);
                }
            }
        }

        return $list;
    }

    /**
     * Delete multiple images given by array of images name
     *
     * @param string $destination
     * @param array $images
     */
    private function deleteMultipleImages(string $destination, array $images) {
        foreach ($images as $image) {
            // use try catch because we don't care if the images was deleted or not
            // we must keep going
            try {
                if (file_exists(public_path("$destination/$image"))) {
                    unlink(public_path("$destination/$image"));
                }
            } catch (\Exception $exception) {}
        }
    }
}
