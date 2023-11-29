<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Rombel;
use App\Models\TipeUjian;
use App\Models\Guru;
use App\Models\Materi;
use App\Models\Soal;

class OptController extends Controller
{
    
    public function kelas(Request $request)
    {
        $query = Kelas::select('id', 'nama as text')->search($request->search)->orderBy('nama', 'asc')->get();

        return response()->json(['data' => $query], 200);
    }

    public function mapel(Request $request)
    {
        $query = Mapel::select('id', 'nama as text')->search($request->search)->orderBy('nama', 'asc')->get();

        return response()->json(['data' => $query], 200);
    }

    public function rombel(Request $request)
    {
        $query = Rombel::select('id', 'nama as text')->search($request->search)->orderBy('nama', 'asc')->get();

        return response()->json(['data' => $query], 200);
    }

    public function tipeUjian(Request $request)
    {
        $query = TipeUjian::select('id', 'nama as text')->search($request->search)->orderBy('nama', 'asc')->get();

        return response()->json(['data' => $query], 200);
    }

    public function guru(Request $request)
    {
        $query = Guru::select('id', 'nama as text')->search($request->search)->orderBy('nama', 'asc')->get();

        return response()->json(['data' => $query], 200);
    }

    public function materi(Request $request)
    {
        $query = Materi::select('id', 'judul as text')->search($request->search)->orderBy('judul', 'asc')->get();

        return response()->json(['data' => $query], 200);
    }

    public function soal(Request $request)
    {
        $query = Soal::select('id', 'id_mapel', 'id_guru', 'id_kelas', 'id_rombel', 'nama as text')->search($request->search)->orderBy('nama', 'asc')->get();

        return response()->json(['data' => $query], 200);
    }
}
