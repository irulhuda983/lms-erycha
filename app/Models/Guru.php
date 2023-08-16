<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';

    protected $guarded = ['id'];

    public function auth() {
        return $this->morphOne(User::class, 'auth', 'jenis_pemilik', 'id_pemilik');
    }

    public function mapel()
    {
        return $this->belongsToMany(Mapel::class, 'mapel_guru', 'id_guru', 'id_mapel');
    }

    public function scopeSearch($query, $search)
    {
        if($search) {
            $query->where('nama', 'like', '%'.$search.'%');
        }

        return $query;
    }
}
