<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kebun extends Model
{
    protected $table = 'tb_kebun';
    protected $fillable = ['nama', 'lokasi'];

    public function petakan()
    {
        return $this->hasMany(PetakanKebun::class, 'kebun_id');
    }
}
