<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeUjian extends Model
{
    use HasFactory;

    protected $table = 'tipe_ujian';

    protected $guarded = ['id'];
}
