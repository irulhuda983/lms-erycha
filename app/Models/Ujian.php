<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    use HasFactory;

    protected $table = 'soal';

    protected $guarded = ['id'];

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'id_soal');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'id_rombel');
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'id_materi');
    }

    public function tipeUjian()
    {
        return $this->belongsTo(TipeUjian::class, 'id_jenis_ujian');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function scopeSearch($query, $search)
    {
        if($search) {
            $query->where('nama', 'like', '%'.$search.'%');
        }

        return $query;
    }
}
