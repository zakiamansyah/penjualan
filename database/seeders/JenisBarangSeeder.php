<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JenisBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jenis_barangs')->insert([
            [
                'id' => 1,
                'nama' => 'Konsumsi',
                'created_at' => Carbon::parse('2024-09-06 10:44:19'),
                'updated_at' => Carbon::parse('2024-09-06 10:44:19'),
            ],
            [
                'id' => 2,
                'nama' => 'Pembersih',
                'created_at' => Carbon::parse('2024-09-06 10:44:33'),
                'updated_at' => Carbon::parse('2024-09-06 10:47:17'),
            ],
        ]);
    }
}
