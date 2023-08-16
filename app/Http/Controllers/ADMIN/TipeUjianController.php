<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use App\Models\TipeUjian;
use App\Http\Resources\TipeUjianResource;

class TipeUjianController extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->search ?? null;
        list($col, $sort) = explode(':', $request->order ?? 'created_at:desc');
        $limit = $request->limit ?? 10;

        $query = TipeUjian::search($search)->orderBy($col, $sort);

        return TipeUjianResource::collection($query->paginate($limit));
    }

    public function show(TipeUjian $tipeUjian)
    {
        try{
            return new TipeUjianResource($tipeUjian);
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

            $tipeUjian = TipeUjian::create([
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

    public function update(Request $request, TipeUjian $tipeUjian)
    {
        $request->validate([
            'kode' => 'nullable',
            'nama' => 'required',
        ]);

        try{
            DB::beginTransaction();

            $tipeUjian->update([
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

    public function destroy(Request $request, TipeUjian $tipeUjian)
    {
        try{
            DB::beginTransaction();

            $tipeUjian->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
}
