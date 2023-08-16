<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use App\Models\Rombel;
use App\Http\Resources\RombelResource;

class RombelController extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->search ?? null;
        list($col, $sort) = explode(':', $request->order ?? 'created_at:desc');
        $limit = $request->limit ?? 10;

        $query = Rombel::search($search)->orderBy($col, $sort);

        return RombelResource::collection($query->paginate($limit));
    }

    public function show(Rombel $rombel)
    {
        try{
            return new RombelResource($rombel);
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
            'id_kelas' => 'required',
        ];

        $request->validate($rules);

        try{
            DB::beginTransaction();

            Rombel::create([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'id_kelas' => $request->id_kelas,
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Rombel $rombel)
    {
        $rules = [
            'kode' => 'nullable',
            'nama' => 'required',
            'id_kelas' => 'required',
        ];

        $request->validate($rules);

        try{
            DB::beginTransaction();

            $rombel->update([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'id_kelas' => $request->id_kelas,
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, Rombel $rombel)
    {
        try{
            DB::beginTransaction();

            $rombel->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
