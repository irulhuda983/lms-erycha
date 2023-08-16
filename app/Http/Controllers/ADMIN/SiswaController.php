<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models\Siswa;
use App\Http\Resources\SiswaResource;

class SiswaController extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->search ?? null;
        list($col, $sort) = explode(':', $request->order ?? 'created_at:desc');
        $limit = $request->limit ?? 10;

        $query = Siswa::search($search)->orderBy($col, $sort);

        return SiswaResource::collection($query->paginate($limit));
    }

    public function show(Siswa $siswa)
    {
        try{
            return new SiswaResource($siswa);
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
            'id_kelas' => 'nullable',
            'id_rombel' => 'nullable',
            'nama' => 'required',
            'nik' => 'nullable',
            'no_peserta' => 'nullable',
            'nisn' => 'nullable',
            'gender' => 'required|in:l,p',
            'tempat_lahir' => 'nullable|date',
            'tgl_lahir' => 'nullable',
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

            // store siswa
            $siswa = Siswa::create([
                'id_kelas' => $request->id_kelas,
                'id_rombel' => $request->id_rombel,
                'nama' => $request->nama,
                'nik' => $request->nik,
                'no_peserta' => $request->no_peserta,
                'nisn' => $request->nisn,
                'gender' => $request->gender,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'alamat' => $request->alamat,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'desa' => $request->desa,
                'kec' => $request->kec,
                'kab' => $request->kab,
                'prov' => $request->prov,
                'foto' => $foto,
            ]);

            $siswa->auth()->create([
                'nama' => $request->nama,  
                'username' => $request->username,  
                'password' => Hash::make($request->password),  
                'password_view' => $request->password,  
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Siswa $siswa)
    {
        $rules = [
            'username' => 'required',
            'id_kelas' => 'nullable',
            'id_rombel' => 'nullable',
            'nama' => 'required',
            'nik' => 'nullable',
            'no_peserta' => 'nullable',
            'nisn' => 'nullable',
            'gender' => 'required|in:l,p',
            'tempat_lahir' => 'nullable|date',
            'tgl_lahir' => 'nullable',
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

        $foto = $request->foto ? $request->file('foto')->storeAs('foto', Str::random(40). '.'.$request->file('foto')->extension()) : $siswa->foto;

        try{
            DB::beginTransaction();

            // store siswa
            $siswa->update([
                'id_kelas' => $request->id_kelas,
                'id_rombel' => $request->id_rombel,
                'nama' => $request->nama,
                'nik' => $request->nik,
                'no_peserta' => $request->no_peserta,
                'nisn' => $request->nisn,
                'gender' => $request->gender,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'alamat' => $request->alamat,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'desa' => $request->desa,
                'kec' => $request->kec,
                'kab' => $request->kab,
                'prov' => $request->prov,
                'foto' => $foto,
            ]);

            $siswa->auth()->update([
                'nama' => $request->nama,  
                'username' => $request->username,
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, Siswa $siswa)
    {
        try{
            DB::beginTransaction();

            $siswa->auth()->delete();
            $siswa->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

}
