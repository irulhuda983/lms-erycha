<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriRead extends Model
{
    use HasFactory;

    protected $table = 'materi_read';

    protected $guarded = ['id'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'id_materi');
    }
}
