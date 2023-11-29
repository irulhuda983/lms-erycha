<?php

namespace App\Http\Controllers\SISWA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

use App\Models\Ujian;
use App\Models\UjianSiswa;
use App\Models\Soal;
use App\Models\SoalItem;
use App\Models\Jawaban;
use App\Http\Resources\UjianResource;
use App\Http\Resources\UjianSiswaResource;
use App\Http\Resources\SoalItemResource;
use App\Http\Resources\JawabanResource;

class UjianController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Ujian::where('is_active', 1)->paginate(1000);

        return UjianResource::collection($query);
    }

    public function show(Ujian $ujian)
    {
        return new UjianResource($ujian);
    }

    public function getHasil(Request $request)
    {
        $user = $request->user();

        $query = UjianSiswa::where('id_siswa', $user->pemilik->id)->paginate($request->limit ?? 10);

        return UjianSiswaResource::collection($query);
    }

    public function mulaiUjian(Request $request, Ujian $ujian)
    {
        $user = $request->user();

        try{
            DB::beginTransaction();

            $lamaUjian = $ujian->lama_ujian .' minutes';

            $ujianSiswa = UjianSiswa::create([
                'id_ujian' => $ujian->id,
                'id_siswa' => $user->pemilik->id,
                'w_mulai' => Carbon::now('Asia/Jakarta'),
                'max_time' => Carbon::now('Asia/Jakarta')->add($lamaUjian),
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'success', 'data' => new UjianSiswaResource($ujianSiswa)], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }

    }

    public function getSoal(Request $request, Soal $soal)
    {
        $request->validate([
            'nomor_soal' => 'required',
        ]);

        $query = SoalItem::where('id_soal', $soal->id)->where('no_urut', $request->nomor_soal)->first();

        if(!$query) {
            return response()->json(['success' => false, 'message' => 'nor found', 'data' => null], 404);
        }

        return new SoalItemResource($query);
    }

    public function getAllJawaban(Request $request, UjianSiswa $ujianSiswa)
    {
        $request->forList = true;
        $jawaban = Jawaban::where('id_ujian_siswa', $ujianSiswa->id)->get();

        return JawabanResource::collection($jawaban);
    }

    public function getJawaban(Request $request, UjianSiswa $ujianSiswa)
    {
        $request->validate([
            'nomor_soal' => 'required',
        ]);

        $jawaban = Jawaban::select('jawaban.*')
                        ->join('soal_item', 'soal_item.id', '=', 'jawaban.id_soal_item')
                        ->where('jawaban.id_ujian_siswa', $ujianSiswa->id)
                        ->where('soal_item.no_urut', $request->nomor_soal)
                        ->first();

        if(!$jawaban) {
            return response()->json(['success' => false, 'message' => 'nor found', 'data' => null], 404);
        }

        return response()->json(['success' => true, 'message' => 'success', 'data' => new JawabanResource($jawaban)], 200);
    }

    public function jawabSoal(Request $request, UjianSiswa $ujianSiswa)
    {
        $user = $request->user();

        $request->validate([
            'id_soal' => 'required',
            'id_soal_item' => 'required',
            'is_ragu' => 'required|in:0,1',
            'jawaban' => 'required',
            'kunci' => 'required',
        ]);

        try{
            DB::beginTransaction();

            $cekJawab = Jawaban::where('id_ujian_siswa', $ujianSiswa->id)
                                ->where('id_soal_item', $request->id_soal_item)
                                ->first();
            $jawaban = null;
            if($cekJawab) {
                $cekJawab->update([
                    'jawaban' => $request->jawaban,
                    'is_ragu' => (int) $request->is_ragu,
                ]);

                $jawaban = $cekJawab;
            }else{
                $jawaban = Jawaban::create([
                    'id_ujian_siswa' => $ujianSiswa->id,
                    'id_siswa' => $user->id,
                    'id_soal' => $request->id_soal,
                    'id_soal_item' => $request->id_soal_item,
                    'jenis' => 'pg',
                    'jawaban' => $request->jawaban,
                    'kunci' => $request->kunci,
                    'is_ragu' => (int) $request->is_ragu,
                ]);
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'success', 'data' => new JawabanResource($jawaban)], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function selesaiTes(Request $request, UjianSiswa $ujianSiswa)
    {
        $request->validate([
            'jumlah_soal' => 'required',
        ]);

        try{
            DB::beginTransaction();

            $hasil = $this->hitungNilai($ujianSiswa->id, $request->jumlah_soal);

            $ujianSiswa->update([
                'w_selesai' => Carbon::now('Asia/Jakarta'),
                'jml_pg_benar' => $hasil['jml_benar'],
                'jml_pg_salah' => $hasil['jml_salah'],
                'skor_pg' => $hasil['nilai'],
                'total' => $hasil['nilai'],
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'success', 'data' => new UjianSiswaResource($ujianSiswa)], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function hitungNilai($idUjianSiswa, $jumlahSoal)
    {
        $arrBenar = [];
        $arrSalah = [];

        $jawaban = Jawaban::where('id_ujian_siswa', $idUjianSiswa)->get();

        if($jawaban) {
            foreach($jawaban as $jawab)
            {
                if($jawab->jawaban == $jawab->kunci) {
                    array_push($arrBenar, 1);
                }else{
                    array_push($arrSalah, 1);
                }
            }
        }

        return [
            'jml_benar' => count($arrBenar),
            'jml_salah' => count($arrSalah),
            'nilai' => count($arrBenar) > 0 ? (100 / $jumlahSoal) * count($arrBenar) : 0,
        ];
    }
}
