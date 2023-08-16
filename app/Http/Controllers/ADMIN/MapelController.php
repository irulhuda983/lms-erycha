<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use App\Models\Mapel;
use App\Http\Resources\MapelResource;

class MapelController extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->search ?? null;
        list($col, $sort) = explode(':', $request->order ?? 'created_at:desc');
        $limit = $request->limit ?? 10;

        $query = Mapel::search($search)->orderBy($col, $sort);

        return MapelResource::collection($query->paginate($limit));
    }

    public function show(Mapel $mapel)
    {
        try{
            return new MapelResource($mapel);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'kode' => 'nullable',
            'nama' => 'required',
        ];

        $request->validate($rules);

        try{
            DB::beginTransaction();

            Mapel::create([
                'kode' => $request->kode,
                'nama' => $request->nama
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Mapel $mapel)
    {
        $rules = [
            'kode' => 'nullable',
            'nama' => 'required',
        ];

        $request->validate($rules);

        $id_jurusan = $request->jurusan ?? $mapel->id_jurusan;

        try{
            DB::beginTransaction();

            $mapel->update([
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

    public function destroy(Request $request, Mapel $mapel)
    {
        try{
            DB::beginTransaction();

            $mapel->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
