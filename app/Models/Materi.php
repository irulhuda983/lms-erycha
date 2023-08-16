<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';

    protected $guarded = ['id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'id_rombel');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function scopeSearch($query, $search)
    {
        if($search) {
            $query->where('judul', 'like', '%'.$search.'%');
        }

        return $query;
    }

    public function scopeGuru($query, $idGuru)
    {
        if($idGuru) {
            $query->where('id_guru', $idGuru);
        }

        return $query;
    }
}
