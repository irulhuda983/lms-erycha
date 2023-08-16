<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Guru;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tendik = Guru::create([
            'nama' => 'M. Khoirul Huda',
            'gelar_depan' => null,
            'gelar_belakang' => 'S.Kom',
            'nik' => 3522022611960003,
            'niy' => null,
            'nuptk' => null,
            'nip' => null,
            'gender' => '1',
            'tempat_lahir' => 'bojonegoro',
            'tgl_lahir' => '1996-11-26',
            'jenis_ptk' => 'guru_mapel',
            'alamat' => 'Ds. Bulu',
            'rt' => '012',
            'rw' => '005',
            'desa' => 'Bulu',
            'kec' => 'Sugihwaras',
            'kab' => 'Bojonegoro',
            'prov' => 'Jawa Timur',
            'foto' => null
        ]);

        $tendik->auth()->create([
            'username' => 'sudo',
            'nama' => 'M. Khoirul Huda',
            'password' => bcrypt('Lalisandi12'),
            'role' => 'admin',
        ]);
    }
}
