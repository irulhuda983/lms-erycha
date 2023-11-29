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

    public function scopeIsPg($query)
    {
        return $query->where('jenis_soal', 'pg');
    }

    public function scopeIsEssay($query)
    {
        return $query->where('jenis_soal', 'essay');
    }

    public function scopeSearch($query, $search)
    {
        if($search) {
            $query->where('text_soal', 'like', '%'.$search.'%');
        }

        return $query;
    }
}
