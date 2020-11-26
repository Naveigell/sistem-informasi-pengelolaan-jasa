<?php

namespace App\Http\Controllers\Api\User\Account;

use App\Http\Controllers\Controller;

use App\Http\Requests\User\Account\Biodata\BiodataUpdateRequest;
use App\Http\Requests\User\Account\Biodata\ProfilePictureUpdateRequest;
use Illuminate\Http\Request;

use App\Models\User\Account\BiodataModel;

use App\Traits\Random;

class BiodataController extends Controller {

    use Random;

    private $biodataTable;

    public function __construct()
    {
        $this->biodataTable = new BiodataModel();
    }

    public function index() {
        return view('user.account.biodata');
    }

    /**
     *  update user biodata
     *
     * @param BiodataUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateBiodata(BiodataUpdateRequest $request) {
        $code = $this->biodataTable->updateBiodata(auth("user")->id(), $request->alamat, $request->email, $request->jenis_kelamin, $request->name, $request->nomor_hp, $request->username);
        $message = ["biodata" => "Biodata berhasil diubah"];

        // check if username, email or phone are duplicated
        if ($code == 409) {
            return error(null, ["biodata" => ["Username atau email sudah digunakan"]], $code);
        }

        return json($message);
    }

    /**
     * retrieve user biodata
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieveBiodata() {
        $user       = auth("user");
        $biodata    = $this->biodataTable->retrieveBiodata($user->id());

        if (is_null($biodata)) {
            return error(null, ["biodata" => "Data tidak ditemukan"], 404);
        }

        // make profile picture an url
        $biodata->profile_picture = $this->addImagePath($biodata->profile_picture);

        return json(["biodata" => $biodata]);
    }

    /**
     * update just profile picture
     *
     * @param ProfilePictureUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfilePicture(ProfilePictureUpdateRequest $request)
    {
        if ($request->has('image')) {
            $image      = $request->file('image');
            $extension  = $image->getClientOriginalExtension();
            $name       = $this->randomStringImage(90);
            $imagename  = $name.".".$extension;

            // check agar tidak ada backdoor
            if (!in_array($extension, ["png", "jpg", "jpeg"])) {
                return error(null, ["image" => "File yang disupport adalah yang bertipe .png, .jpg, dan .jpeg"], 400);
            }

            // move img
            if ($image->move(public_path("/img/users"), $imagename)) {

                $userId     = auth("user")->id();
                $newImage   = $this->addImagePath($imagename);
                // retrieve old image before profile updated
                $oldImage   = $this->addImagePath($this->biodataTable->retrieveProfilePicture(auth("user")->id())->profile_picture);

                $this->deleteOldImage($oldImage);

                if ($this->biodataTable->updateProfilePicture($userId, $imagename)) {
                    return json([
                        "new_image" => $newImage,
                        "old_image" => $oldImage
                    ]);
                }
            }
            return error(null, ["image" => "Terjadi masalah saat mengupload file"], 500);
        }
        return json(null, null, 422);
    }

    /**
     * check if file exists, then delete
     *
     * @param $imagename
     */
    private function deleteOldImage($imagename) {
        if (file_exists(public_path("/img/users/$imagename"))) {
            unlink(public_path("/img/users/$imagename"));
        }
    }

    /**
     * create a path for stored images
     *
     * @param $filename
     * @return string
     */
    private function addImagePath($filename)
    {
        return config("app.profile_picture_path").$filename;
    }
}
