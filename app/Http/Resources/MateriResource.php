<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MateriResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'id_kelas' => $this->id_kelas,
            'kelas' => optional($this->kelas)->nama,
            'id_rombel' => $this->id_rombel,
            'rombel' => optional($this->kelas)->nama,
            'id_mapel' => $this->id_mapel,
            'mapel' => optional($this->mapel)->nama,
            'id_guru' => $this->id_guru,
            'guru' => optional($this->guru)->nama,
            'judul' => $this->judul,
            'excerpt' => Str::limit($this->deskripsi, 20, ' ...'),
            'slug' => $this->slug,
            'deskripsi' => $this->deskripsi,
            'media_image' => $this->media_image ? url('api/upload/' . $this->media_image) : null,
            'media_file' => $this->media_file ? url('api/upload/' . $this->media_file) : null,
            'media_video' => $this->media_video ? url('api/upload/' . $this->media_video) : null,
            'jumlah_dibaca' => $this->materiRead->count(),
            'created_at' => date('Y-m-d', strtotime($this->created_at)),
            'date_created' => $this->created_at->diffForHumans()
        ];
    }
}
