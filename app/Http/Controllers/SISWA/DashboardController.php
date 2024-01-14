<?php

namespace App\Http\Controllers\SISWA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Materi;
use App\Models\UjianSiswa;
use App\Http\Resources\MateriResource;
use App\Http\Resources\UjianSiswaResource;

class DashboardController extends Controller
{
    
    public function popularMateri(Request $request)
    {
        $query = Materi::orderBy('created_at', 'desc')->get();

        return MateriResource::collection($query);
    }

    public function nilaiTertinggi()
    {
        $query = UjianSiswa::all();

        return UjianSiswaResource::collection($query);
    }
}
