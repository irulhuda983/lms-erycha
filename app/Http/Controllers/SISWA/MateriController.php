<?php

namespace App\Http\Controllers\SISWA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

use App\Models\Materi;
use App\Models\MateriRead;
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

    public function show(Request $request, Materi $materi)
    {
        $user = $request->user();

        try{
            MateriRead::create([
                'id_siswa' => $user->pemilik->id,
                'id_materi' => $materi->id,
            ]);

            return new MateriResource($materi);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
