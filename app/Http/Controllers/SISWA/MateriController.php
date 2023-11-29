<?php

namespace App\Http\Controllers\SISWA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Materi;
use App\Http\Resources\MateriResource;

class MateriController extends Controller
{
    
    public function index(Request $request)
    {
        $user = $request->user();

        $search = $request->search ?? null;
        list($col, $sort) = explode(':', $request->order ?? 'created_at:desc');
        $limit = $request->limit ?? 10;

        $idGuru = $user->role == 'guru' ? $user->pemilik->id : null;

        $query = Materi::search($search)->guru($idGuru)->orderBy($col, $sort);

        return MateriResource::collection($query->paginate($limit));
    }

    public function show(Materi $materi)
    {
        try{
            return new MateriResource($materi);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
