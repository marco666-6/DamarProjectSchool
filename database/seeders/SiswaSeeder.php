<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $parentUser  = User::where('email', 'orang.tua@gmail.com')->first();
        $parentUser2 = User::where('email', 'parent2@gmail.com')->first();

        $siswaData = [
            // Class 6A
            ['nisn'=>'0123456001','nis'=>'2401','nama'=>'Ahmad Zaki Maulana',    'ortu'=>'Budi Santoso',    'kelas'=>'6A','jk'=>'L','user'=>$parentUser?->id],
            ['nisn'=>'0123456002','nis'=>'2402','nama'=>'Aisyah Putri Rahayu',   'ortu'=>'Siti Rahayu',     'kelas'=>'6A','jk'=>'P','user'=>$parentUser2?->id],
            ['nisn'=>'0123456003','nis'=>'2403','nama'=>'Daffa Arya Pratama',    'ortu'=>'Heri Pratama',    'kelas'=>'6A','jk'=>'L','user'=>null],
            ['nisn'=>'0123456004','nis'=>'2404','nama'=>'Fatimah Az-Zahra',      'ortu'=>'Ahmad Fathoni',   'kelas'=>'6A','jk'=>'P','user'=>null],
            ['nisn'=>'0123456005','nis'=>'2405','nama'=>'Hafidz Nurul Iman',     'ortu'=>'Nurul Huda',      'kelas'=>'6A','jk'=>'L','user'=>null],
            // Class 6B
            ['nisn'=>'0123456006','nis'=>'2406','nama'=>'Intan Permata Sari',    'ortu'=>'Yusuf Permata',   'kelas'=>'6B','jk'=>'P','user'=>null],
            ['nisn'=>'0123456007','nis'=>'2407','nama'=>'Khairul Anwar',         'ortu'=>'Anwar Ibrahim',   'kelas'=>'6B','jk'=>'L','user'=>null],
            ['nisn'=>'0123456008','nis'=>'2408','nama'=>'Laila Nur Fadhilah',    'ortu'=>'Fadhil Rahman',   'kelas'=>'6B','jk'=>'P','user'=>null],
            ['nisn'=>'0123456009','nis'=>'2409','nama'=>'Muhammad Hafidh',       'ortu'=>'Syahrul Anwar',   'kelas'=>'6B','jk'=>'L','user'=>null],
            ['nisn'=>'0123456010','nis'=>'2410','nama'=>'Nayla Salsabila',       'ortu'=>'Salman Alfarisi', 'kelas'=>'6B','jk'=>'P','user'=>null],
            // Class 5A
            ['nisn'=>'0123456011','nis'=>'2301','nama'=>'Omar Abdul Aziz',       'ortu'=>'Abdul Aziz',      'kelas'=>'5A','jk'=>'L','user'=>null],
            ['nisn'=>'0123456012','nis'=>'2302','nama'=>'Putri Aulia Rahma',     'ortu'=>'Rahmat Hidayat',  'kelas'=>'5A','jk'=>'P','user'=>null],
            ['nisn'=>'0123456013','nis'=>'2303','nama'=>'Qoyyim Firdaus',        'ortu'=>'Firdaus Azhari',  'kelas'=>'5A','jk'=>'L','user'=>null],
            ['nisn'=>'0123456014','nis'=>'2304','nama'=>'Rania Azzahra',         'ortu'=>'Azzahra Kamil',   'kelas'=>'5A','jk'=>'P','user'=>null],
            ['nisn'=>'0123456015','nis'=>'2305','nama'=>'Sabri Muttaqin',        'ortu'=>'Muttaqin Saleh',  'kelas'=>'5A','jk'=>'L','user'=>null],
        ];

        foreach ($siswaData as $s) {
            Siswa::updateOrCreate(['nisn' => $s['nisn']], [
                'nisn'          => $s['nisn'],
                'nis'           => $s['nis'],
                'nama_siswa'    => $s['nama'],
                'nama_orangtua' => $s['ortu'],
                'alamat'        => 'Batam, Kepulauan Riau',
                'kelas'         => $s['kelas'],
                'jenis_kelamin' => $s['jk'],
                'tahun_masuk'   => $s['kelas'][0] === '6' ? 2019 : 2020,
                'is_active'     => true,
                'user_id'       => $s['user'],
            ]);
        }
    }
}