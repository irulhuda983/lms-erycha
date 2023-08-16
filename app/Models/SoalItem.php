<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalItem extends Model
{
    use HasFactory;

    protected $table = 'soal_item';

    protected $guarded = ['id'];

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'id_soal');
    }
}
