<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

use App\Models\Ujian;
use App\Http\Resources\UjianResource;

class UjianController extends Controller
{
    
    public function index(Request $request)
    {
        $user = $request->user();

        $search = $request->search ?? null;
        list($col, $sort) = explode(':', $request->order ?? 'created_at:desc');
        $limit = $request->limit ?? 10;

        $idGuru = $user->role == 'guru' ? $user->pemilik->id : null;

        $query = Ujian::search($search)->orderBy($col, $sort);

        return UjianResource::collection($query->paginate($limit));
    }

    public function show(Ujian $ujian)
    {
        return new UjianResource($ujian);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_soal' => ['required', Rule::in( DB::table('soal')->select('id')->pluck('id')->all() )],
            'id_kelas' => ['nullable', Rule::in( DB::table('kelas')->select('id')->pluck('id')->all() )],
            'id_jenis_ujian' => ['required', Rule::in( DB::table('tipe_ujian')->select('id')->pluck('id')->all() )],
            'id_materi' => ['nullable', Rule::in( DB::table('materi')->select('id')->pluck('id')->all() )],
            'id_guru' => ['nullable', Rule::in( DB::table('guru')->select('id')->pluck('id')->all() )],
            'id_rombel' => ['nullable', Rule::in( DB::table('rombel')->select('id')->pluck('id')->all() )],
            'nama' => 'required',
            'lama_ujian' => 'required',
            'waktu_mulai' => 'required',
            'w_akhir' => 'required',
            'is_hasil' => 'required',
            'is_acak' => 'required',
        ]);

        try{
            DB::beginTransaction();

            $ujian = Ujian::create([
                'id_soal' => $request->id_soal,
                'id_kelas' => $request->id_kelas,
                'id_jenis_ujian' => $request->id_jenis_ujian,
                'id_materi' => $request->id_materi,
                'id_guru' => $request->id_guru,
                'id_rombel' => $request->id_rombel,
                'kode' => Str::upper(Str::random(16)),
                'nama' => $request->nama,
                'lama_ujian' => $request->lama_ujian,
                'waktu_mulai' => $request->waktu_mulai ? date( 'Y-m-d H:i:s', strtotime( str_replace('T', ' ', $request->waktu_mulai ) ) ) : null,
                'w_akhir' => $request->w_akhir ? date( 'Y-m-d H:i:s', strtotime( str_replace('T', ' ', $request->w_akhir ) ) ) : null,
                'is_active' => 1,
                'is_hasil' => $request->is_hasil,
                'is_acak' => $request->is_acak,
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Ujian $ujian)
    {
        $request->validate([
            'id_soal' => ['required', Rule::in( DB::table('soal')->select('id')->pluck('id')->all() )],
            'id_kelas' => ['required', Rule::in( DB::table('kelas')->select('id')->pluck('id')->all() )],
            'id_jenis_ujian' => ['required', Rule::in( DB::table('tipe_ujian')->select('id')->pluck('id')->all() )],
            'id_materi' => ['nullable', Rule::in( DB::table('materi')->select('id')->pluck('id')->all() )],
            'id_guru' => ['nullable', Rule::in( DB::table('guru')->select('id')->pluck('id')->all() )],
            'id_rombel' => ['nullable', Rule::in( DB::table('rombel')->select('id')->pluck('id')->all() )],
            'nama' => 'required',
            'lama_ujian' => 'required',
            'waktu_mulai' => 'required',
            'w_akhir' => 'required',
            'is_hasil' => 'required|in:0,1',
            'is_acak' => 'required|in:0,1',
        ]);

        try{
            DB::beginTransaction();

            $ujian->update([
                'id_soal' => $request->id_soal,
                'id_kelas' => $request->id_kelas,
                'id_jenis_ujian' => $request->id_jenis_ujian,
                'id_materi' => $request->id_materi,
                'id_guru' => $request->id_guru,
                'id_rombel' => $request->id_rombel,
                'nama' => $request->nama,
                'lama_ujian' => $request->lama_ujian,
                'waktu_mulai' => $request->waktu_mulai,
                'w_akhir' => $request->w_akhir,
                'is_hasil' => $request->is_hasil,
                'is_acak' => $request->is_acak,
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function activate(Request $request, Ujian $ujian)
    {
        try{
            DB::beginTransaction();

            $ujian->update([
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

    public function deactivate(Request $request, Ujian $ujian)
    {
        try{
            DB::beginTransaction();

            $ujian->update([
                'is_active' => 0,
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, Ujian $ujian)
    {
        try{
            DB::beginTransaction();

            $ujian->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
