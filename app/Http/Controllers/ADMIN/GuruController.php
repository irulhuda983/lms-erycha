<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models\Guru;
use App\Models\MapelGuru;
use App\Http\Resources\GuruResource;

class GuruController extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->search ?? null;
        list($col, $sort) = explode(':', $request->order ?? 'created_at:desc');
        $limit = $request->limit ?? 10;

        $query = Guru::search($search)->orderBy($col, $sort);

        return GuruResource::collection($query->paginate($limit));
    }

    public function show(Guru $guru)
    {
        try{
            return new GuruResource($guru);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
            'nama' => 'required',
            'gelar_depan' => 'nullable',
            'gelar_belakang' => 'nullable',
            'nik' => 'nullable',
            'niy' => 'nullable',
            'nuptk' => 'nullable',
            'nip' => 'nullable',
            'gender' => 'required|in:l,p',
            'tempat_lahir' => 'nullable|date',
            'tgl_lahir' => 'nullable',
            'jenis_ptk' => 'nullable',
            'alamat' => 'nullable',
            'rt' => 'nullable',
            'rw' => 'nullable',
            'desa' => 'nullable',
            'kec' => 'nullable',
            'kab' => 'nullable',
            'prov' => 'nullable',
            'foto' => 'nullable|image',
        ];

        $request->validate($rules);

        $foto = $request->foto ? $request->file('foto')->storeAs('foto', Str::random(40). '.'.$request->file('foto')->extension()) : null;

        try{
            DB::beginTransaction();

            // store guru
            $guru = Guru::create([
                'nama' => $request->nama,
                'gelar_depan' => $request->gelar_depan,
                'gelar_belakang' => $request->gelar_belakang,
                'nik' => $request->nik,
                'niy' => $request->niy,
                'nuptk' => $request->nuptk,
                'nip' => $request->nip,
                'gender' => $request->gender,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'jenis_ptk' => $request->jenis_ptk,
                'alamat' => $request->alamat,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'desa' => $request->desa,
                'kec' => $request->kec,
                'kab' => $request->kab,
                'prov' => $request->prov,
                'foto' => $foto,
            ]);

            $guru->auth()->create([
                'nama' => $request->nama,  
                'username' => $request->username,  
                'password' => Hash::make($request->password),  
            ]);

            $mapel = json_decode($request->mapel, true);

            foreach($mapel as $item) {
                MapelGuru::create([
                    'id_guru' => $item->id_guru,
                    'id_mapel' => $item->id_mapel,
                    'id_kelas' => $item->id_kelas,
                ]);
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Guru $guru)
    {
        $rules = [
            'username' => 'required',
            'nama' => 'required',
            'gelar_depan' => 'nullable',
            'gelar_belakang' => 'nullable',
            'nik' => 'nullable',
            'niy' => 'nullable',
            'nuptk' => 'nullable',
            'nip' => 'nullable',
            'gender' => 'required|in:l,p',
            'tempat_lahir' => 'nullable|date',
            'tgl_lahir' => 'nullable',
            'jenis_ptk' => 'nullable',
            'alamat' => 'nullable',
            'rt' => 'nullable',
            'rw' => 'nullable',
            'desa' => 'nullable',
            'kec' => 'nullable',
            'kab' => 'nullable',
            'prov' => 'nullable',
            'foto' => 'nullable|image',
        ];

        $request->validate($rules);

        $foto = $request->foto ? $request->file('foto')->storeAs('foto', Str::random(40). '.'.$request->file('foto')->extension()) : $guru->foto;

        try{
            DB::beginTransaction();

            // store guru
            $guru->update([
                'nama' => $request->nama,
                'gelar_depan' => $request->gelar_depan,
                'gelar_belakang' => $request->gelar_belakang,
                'nik' => $request->nik,
                'niy' => $request->niy,
                'nuptk' => $request->nuptk,
                'nip' => $request->nip,
                'gender' => $request->gender,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'jenis_ptk' => $request->jenis_ptk,
                'alamat' => $request->alamat,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'desa' => $request->desa,
                'kec' => $request->kec,
                'kab' => $request->kab,
                'prov' => $request->prov,
                'foto' => $foto,
            ]);

            $guru->auth()->update([
                'nama' => $request->nama,  
                'username' => $request->username,  
            ]);

            if($request->mapel) {
                $mapel = json_decode($request->mapel, true);

                MapelGuru::where('id_guru', $guru->id)->delete();
                foreach($mapel as $item) {
                    MapelGuru::create([
                        'id_guru' => $item->id_guru,
                        'id_mapel' => $item->id_mapel,
                        'id_kelas' => $item->id_kelas,
                    ]);
                }
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, Guru $guru)
    {
        try{
            DB::beginTransaction();

            $cek = MapelGuru::where('id_guru', $guru->id)->first();

            if($cek) {
                MapelGuru::where('id_guru', $guru->id)->delete();
            }

            $guru->auth()->delete();
            $guru->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

}
