<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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

    public function store(Request $request)
    {
        $user = $request->user();

        $rules = [
            'id_kelas' => 'nullable',
            'id_rombel' => 'nullable',
            'id_mapel' => 'required',
            'id_guru' => 'nullable',
            'judul' => 'required',
            'deskripsi' => 'nullable',
            'media_image' => 'nullable|image|mimes:jpg,jpeg,png,bmp|max:10240',
            'media_file' => 'nullable|file|mimes:pdf|max:10240',
            'media_video' => 'nullable|file|mimes:mp4,avi,3gp|max:30240',
        ];

        if($user->role == 'admin') {
            $rules['id_guru'] = 'required';
        }

        $request->validate($rules);

        $idGuru = $user->role == 'admin' ? $request->id_guru : $user->pemilik->id;
        $mediaImage = $request->media_image ? $request->file('media_image')->storeAs('media-materi', Str::random(40). '.'.$request->file('media_image')->extension()) : null;
        $mediaFile = $request->media_file ? $request->file('media_file')->storeAs('media-materi', Str::random(40). '.'.$request->file('media_file')->extension()) : null;
        $mediaVideo = $request->media_video ? $request->file('media_video')->storeAs('media-materi', Str::random(40). '.'.$request->file('media_video')->extension()) : null;

        try{
            DB::beginTransaction();

            // store materi
            Materi::create([
                'id_kelas' => $request->id_kelas,
                'id_rombel' => $request->id_rombel,
                'id_mapel' => $request->id_mapel,
                'id_guru' => $idGuru,
                'judul' => $request->judul,
                'slug' => Str::slug(Str::lower($request->judul)),
                'deskripsi' => $request->deskripsi,
                'media_image' => $mediaImage,
                'media_file' => $mediaFile,
                'media_video' => $mediaVideo,
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Materi $materi)
    {
        $user = $request->user();

        $rules = [
            'id_kelas' => 'nullable',
            'id_rombel' => 'nullable',
            'id_mapel' => 'required',
            'judul' => 'required',
            'deskripsi' => 'nullable',
            'media_image' => 'nullable|image|mimes:jpg,jpeg,png,bmp|max:10240',
            'media_file' => 'nullable|file|mimes:pdf|max:10240',
            'media_video' => 'nullable|file|mimes:mp4,avi,3gp|max:10240',
        ];

        if($user->role == 'admin') {
            $rules['id_guru'] = 'required';
        }

        $request->validate($rules);

        $idGuru = $user->role == 'admin' ? $request->id_guru : $user->pemilik->id;
        $mediaImage = $request->media_image ? $request->file('media_image')->storeAs('media-materi', Str::random(40). '.'.$request->file('media_image')->extension()) : $materi->media_image;
        $mediaFile = $request->media_file ? $request->file('media_file')->storeAs('media-materi', Str::random(40). '.'.$request->file('media_file')->extension()) : $materi->media_file;
        $mediaVideo = $request->media_video ? $request->file('media_video')->storeAs('media-materi', Str::random(40). '.'.$request->file('media_video')->extension()) : $materi->media_video;

        try{
            DB::beginTransaction();

            // store materi
            $materi->update([
                'id_kelas' => $request->id_kelas,
                'id_rombel' => $request->id_rombel,
                'id_mapel' => $request->id_mapel,
                'id_guru' => $idGuru,
                'judul' => $request->judul,
                'slug' => Str::slug(Str::lower($request->judul)),
                'deskripsi' => $request->deskripsi,
                'media_image' => $mediaImage,
                'media_file' => $mediaFile,
                'media_video' => $mediaVideo,
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, Materi $materi)
    {
        try{
            DB::beginTransaction();

            $materi->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'success'], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

}
