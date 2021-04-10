<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 50; $i++) {
            DB::table('mahasiswa')->insert([
                [
                    'nim' => '194172' . $faker->randomNumber(4),
                    'nama' => $faker->name(),
                    'email' => $faker->email,
                    'jurusan' => 'Teknologi Informasi',
                    'alamat' => 'Malang Blok C- ' . $faker->randomNumber(2),
                    'tgl_lahir' => $faker->date(),
                    'kelas_id' => 1,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]
            ]);
        }
    }
}
