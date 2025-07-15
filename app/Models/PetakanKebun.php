<?php
namespace App\Models;
use App\Models\Kebun;

use Illuminate\Database\Eloquent\Model;

class PetakanKebun extends Model
{
    protected $table = 'tb_petakan_kebun';
    protected $fillable = ['nama', 'ukuran', 'penanggung_jawab', 'status', 'kebun_id'];

    public function kebun()
    {
        return $this->belongsTo(Kebun::class, 'kebun_id');
    }
}

