<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Siswa;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siswa = Siswa::create([
            'nama' => 'Huda'
        ]);

        $siswa->auth()->create([
            'username' => 'peserta',
            'nama' => 'peserta',
            'password' => bcrypt('Lalisandi12'),
            'role' => 'siswa',
        ]);
    }
}
