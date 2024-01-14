<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Materi;
use App\Models\Ujian;
use App\Models\UjianSiswa;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Soal;
use App\Http\Resources\MateriResource;
use App\Http\Resources\UjianSiswaResource;

class DashboardController extends Controller
{

    public function getJumlah(Request $request)
    {
        $jumlahPeserta = Siswa::count();
        $jumlahMateri = Materi::count();
        $jumlahSoal = Soal::count();
        $jumlahGuru = Guru::count();

        return response()->json([
            'peserta' => $jumlahPeserta,
            'materi' => $jumlahMateri,
            'soal' => $jumlahSoal,
            'guru' => $jumlahGuru,
        ], 200);
    }

    public function getDataChart(Request $request)
    {
        $label = [];
        $data = [];
        $ujian = Ujian::orderBy('waktu_mulai', 'DESC')->first();

        $siswa = Siswa::all();

        foreach($siswa as $sw) {
            $ujianSiswa = UjianSiswa::where('id_ujian', $ujian->id)->where('id_siswa', $sw->id)->first();
            $nilai = $ujianSiswa ? (float) number_format($ujianSiswa->total, 2) : 0;
            array_push($label, $sw->nama);
            array_push($data, $nilai);
        }

        return response()->json([
            'data' => [
                [
                    'name' => $ujian->nama,
                    'data' => $data,
                ]
            ],
            'label' => $label
        ], 200);
    }
    
    public function popularMateri(Request $request)
    {
        $query = Materi::orderBy('created_at', 'desc')->get();

        return MateriResource::collection($query);
    }
}
