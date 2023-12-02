<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models\Soal;
use App\Http\Resources\SoalResource;

class SoalController extends Controller
{
    
    public function index(Request $request)
    {
        $user = $request->user();

        $search = $request->search ?? null;
        list($col, $sort) = explode(':', $request->order ?? 'created_at:desc');
        $limit = $request->limit ?? 10;

        $idGuru = $user->role == 'guru' ? $user->pemilik->id : null;

        $query = Soal::search($search)->guru($idGuru)->orderBy($col, $sort);

        return SoalResource::collection($query->paginate($limit));
    }

    public function show(Request $request, Soal $soal)
    {
        try{
            $request->withSoalItem = true;
            return new SoalResource($soal);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $rules = [
            'id_mapel' => 'required',
            'id_kelas' => 'required',
            'id_rombel' => 'nullable',
            'kode' => 'nullable',
            'tipe_mapel_soal' => 'nullable',
            'tipe_soal' => 'required|in:pg_essay,essay,pg',
            'nama' => 'required',
            'jml_pg' => 'nullable',
            'jml_essay' => 'nullable',
            'bobot_pg' => 'nullable',
            'bobot_essay' => 'nullable',
            'jml_pil_pg' => 'nullable',
            'kkm' => 'required',
            'is_agama' => 'nullable|in:0,1',
            'is_active' => 'nullable|in:0,1',
        ];

        if($user->role == 'admin') {
            $rules['id_guru'] = 'required';
        }

        $request->validate($rules);

        $idGuru = $user->role == 'admin' ? $request->id_guru : $user->pemilik->id;

        try{
            DB::beginTransaction();

            // store soal
            Soal::create([
                'id_mapel' => $request->id_mapel,
                'id_kelas' => $request->id_kelas,
                'id_rombel' => $request->id_rombel,
                'id_guru' => $idGuru,
                'kode' => Str::upper(Str::random(16)),
                'tipe_mapel_soal' => $request->tipe_mapel_soal,
                'tipe_soal' => $request->tipe_soal,
                'nama' => $request->nama,
                'jml_pg' => $request->jml_pg,
                'jml_essay' => $request->jml_essay,
                'bobot_pg' => $request->bobot_pg,
                'bobot_essay' => $request->bobot_essay,
                'jml_pil_pg' => $request->jml_pil_pg,
                'kkm' => $request->kkm,
                'is_agama' => $request->is_agama,
                'is_active' => 1,
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Soal $soal)
    {
        $user = $request->user();

        $rules = [
            'id_mapel' => 'required',
            'id_kelas' => 'nullable',
            'id_rombel' => 'nullable',
            'kode' => 'nullable',
            'tipe_mapel_soal' => 'nullable',
            'tipe_soal' => 'required|in:pg_essay,essay,pg',
            'nama' => 'required',
            'jml_pg' => 'nullable',
            'jml_essay' => 'nullable',
            'bobot_pg' => 'nullable',
            'bobot_essay' => 'nullable',
            'jml_pil_pg' => 'nullable',
            'kkm' => 'required',
            'is_agama' => 'nullable|in:0,1',
            'is_active' => 'nullable|in:0,1',
        ];

        if($user->role == 'admin') {
            $rules['id_guru'] = 'required';
        }

        $request->validate($rules);

        $idGuru = $user->role == 'admin' ? $request->id_guru : $user->pemilik->id;

        try{
            DB::beginTransaction();

            // store soal
            $soal->update([
                'id_mapel' => $request->id_mapel,
                'id_kelas' => $request->id_kelas,
                'id_rombel' => $request->id_rombel,
                'id_guru' => $idGuru,
                'tipe_mapel_soal' => $request->tipe_mapel_soal,
                'nama' => $request->nama,
                'jml_pg' => $request->jml_pg,
                'jml_essay' => $request->jml_essay,
                'bobot_pg' => $request->bobot_pg,
                'bobot_essay' => $request->bobot_essay,
                'jml_pil_pg' => $request->jml_pil_pg,
                'kkm' => $request->kkm,
                'is_agama' => $request->is_agama,
                'is_active' => 1,
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, Soal $soal)
    {
        try{
            DB::beginTransaction();

            $soal->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

}
