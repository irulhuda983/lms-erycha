<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\SoalItem;
use App\Http\Resources\SoalItemResource;

class SoalItemController extends Controller
{
    
    public function index(Request $request)
    {
        $user = $request->user();

        $search = $request->search ?? null;
        list($col, $sort) = explode(':', $request->order ?? 'created_at:desc');
        $limit = $request->limit ?? 10;

        $idGuru = $user->role == 'guru' ? $user->pemilik->id : null;

        $query = SoalItem::search($search)->orderBy($col, $sort);

        return SoalItemResource::collection($query->paginate($limit));
    }

    public function show(SoalItem $soalItem)
    {
        return new SoalItemResource($soalItem);
    }

    public function getSingleItem(Request $request)
    {
        $soalItem = SoalItem::where([
            ['id_soal', '=', $request->id_soal],
            ['jenis_soal', '=', $request->jenis_soal],
            ['no_urut', '=', $request->no_urut]
        ])->first();

        if(!$soalItem) {
            return response()->json([
                'data' => null,
            ], 200);
        }

        return new SoalItemResource($soalItem);
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'id_soal' => 'required',
            'jenis_soal' => 'required',
            'no_urut' => 'required',
            'text_soal' => 'required',
            'pil_a' => 'required',
            'pil_b' => 'required',
            'pil_c' => 'required',
            'pil_d' => 'required',
            'pil_e' => 'nullable',
            'file_soal' => 'nullable',
            'file_pila' => 'nullable',
            'file_pilb' => 'nullable',
            'file_pilc' => 'nullable',
            'file_pild' => 'nullable',
            'file_pile' => 'nullable',
            'kunci_jawaban' => 'required',
        ]);

        try{
            DB::beginTransaction();

            $soalItem = SoalItem::updateOrCreate(
                ['id_soal' => $request->id_soal, 'jenis_soal' => $request->jenis_soal, 'no_urut' => $request->no_urut],
                [
                    'text_soal' => $request->text_soal,
                    'pil_a' => $request->pil_a,
                    'pil_b' => $request->pil_b,
                    'pil_c' => $request->pil_c,
                    'pil_d' => $request->pil_d,
                    'pil_e' => $request->pil_e,
                    'file_soal' => $request->file_soal,
                    'file_pila' => $request->file_pila,
                    'file_pilb' => $request->file_pilb,
                    'file_pilc' => $request->file_pilc,
                    'file_pild' => $request->file_pild,
                    'file_pile' => $request->file_pile,
                    'kunci_jawaban' => $request->kunci_jawaban,
                ]
            );

            DB::commit();
            return response()->json(['success' => true, 'message' => 'success', 'data' => $soalItem], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(SoalItem $soalItem)
    {
        try{
            DB::beginTransaction();

            $soalItem->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
