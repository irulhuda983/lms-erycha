<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use App\Models\Kelas;
use App\Http\Resources\KelasResource;

class KelasController extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->search ?? null;
        list($col, $sort) = explode(':', $request->order ?? 'created_at:desc');
        $limit = $request->limit ?? 10;

        $query = Kelas::search($search)->orderBy($col, $sort);

        return KelasResource::collection($query->paginate($limit));
    }

    public function show(Kelas $kelas)
    {
        try{
            return new KelasResource($kelas);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'nullable',
            'nama' => 'required',
        ]);

        try{
            DB::beginTransaction();

            $kelas = Kelas::create([
                'kode' => $request->kode,
                'nama' => $request->nama,
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'kode' => 'nullable',
            'nama' => 'required',
        ]);

        try{
            DB::beginTransaction();

            $kelas->update([
                'kode' => $request->kode,
                'nama' => $request->nama,
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, Kelas $kelas)
    {
        try{
            DB::beginTransaction();

            $kelas->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
