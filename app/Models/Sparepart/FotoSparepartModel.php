<?php

namespace App\Models\Sparepart;

use Illuminate\Database\Eloquent\Model;

class FotoSparepartModel extends Model
{
    protected $table = "foto_spare_part";
    protected $primaryKey = "id_foto_spare_part";

    public function sparepart(){
        return $this->belongsTo(SparepartModel::class,"id_spare_part", "foto_spare_part_id_spare_part");
    }
}
