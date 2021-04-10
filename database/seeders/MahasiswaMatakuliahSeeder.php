<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaMatakuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mahasiswa_matakuliah')->insert([
            [
                'mahasiswa_id' => Mahasiswa::min('nim'),
                'matakuliah_id' => MataKuliah::min('id'),
                'nilai' => 'A',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'mahasiswa_id' => Mahasiswa::min('nim'),
                'matakuliah_id' => MataKuliah::min('id') + 1,
                'nilai' => 'A',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'mahasiswa_id' => Mahasiswa::min('nim'),
                'matakuliah_id' => MataKuliah::min('id') + 2,
                'nilai' => 'A',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'mahasiswa_id' => Mahasiswa::min('nim'),
                'matakuliah_id' => MataKuliah::min('id') + 3,
                'nilai' => 'A',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);

        for ($i = 0; $i < 10; $i++) {
            $nim = Mahasiswa::inRandomOrder()->first()->nim;
            $nilai = ['A', 'B', 'B+', 'C', 'C+'];

            DB::table('mahasiswa_matakuliah')->insert([
                [
                    'mahasiswa_id' => $nim,
                    'matakuliah_id' => MataKuliah::min('id'),
                    'nilai' => $nilai[array_rand($nilai)],
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'mahasiswa_id' => $nim,
                    'matakuliah_id' => MataKuliah::min('id') + 1,
                    'nilai' => $nilai[array_rand($nilai)],
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'mahasiswa_id' => $nim,
                    'matakuliah_id' => MataKuliah::min('id') + 2,
                    'nilai' => $nilai[array_rand($nilai)],
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'mahasiswa_id' => $nim,
                    'matakuliah_id' => MataKuliah::min('id') + 3,
                    'nilai' => $nilai[array_rand($nilai)],
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]
            ]);
        }
    }
}