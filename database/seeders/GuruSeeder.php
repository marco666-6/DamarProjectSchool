<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            ['nip' => '199001012015011001', 'nama' => 'Ahmad Fauzi, S.Pd.',       'email' => 'ahmad.fauzi@biis.sch.id',    'gender' => 'L', 'pendidikan' => 'S1 Pendidikan Matematika'],
            ['nip' => '199205152016012002', 'nama' => 'Siti Aminah, S.Pd.',       'email' => 'siti.aminah@biis.sch.id',    'gender' => 'P', 'pendidikan' => 'S1 Pendidikan Bahasa Indonesia'],
            ['nip' => '198803222014011003', 'nama' => 'Muhammad Rizki, S.Ag.',    'email' => 'm.rizki@biis.sch.id',        'gender' => 'L', 'pendidikan' => 'S1 Pendidikan Agama Islam'],
            ['nip' => '199107082017012004', 'nama' => 'Dewi Lestari, S.Pd.',      'email' => 'dewi.lestari@biis.sch.id',  'gender' => 'P', 'pendidikan' => 'S1 Pendidikan IPA'],
            ['nip' => '199306202018011005', 'nama' => 'Hendra Kusuma, S.Kom.',    'email' => 'hendra.kusuma@biis.sch.id', 'gender' => 'L', 'pendidikan' => 'S1 Teknik Informatika'],
        ];

        foreach ($teachers as $t) {
            $user = User::updateOrCreate(['email' => $t['email']], [
                'name'     => $t['nama'],
                'email'    => $t['email'],
                'password' => Hash::make('guru123'),
                'role'     => 'guru',
            ]);

            Guru::updateOrCreate(['email' => $t['email']], [
                'user_id'             => $user->id,
                'nip'                 => $t['nip'],
                'nama_guru'           => $t['nama'],
                'email'               => $t['email'],
                'jenis_kelamin'       => $t['gender'],
                'pendidikan_terakhir' => $t['pendidikan'],
                'alamat'              => 'Batam, Kepulauan Riau',
                'is_active'           => true,
            ]);
        }
    }
}