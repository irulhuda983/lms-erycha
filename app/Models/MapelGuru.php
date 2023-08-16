<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapelGuru extends Model
{
    use HasFactory;

    protected $table = 'mapel_guru';

    protected $guarded = ['id'];
}
