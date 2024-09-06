<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('barangs')->insert([
            [
                'id' => 1,
                'nama' => 'Kopi',
                'stok' => 75,
                'jenis_barang_id' => 1,
                'created_at' => Carbon::parse('2024-09-06 11:03:47'),
                'updated_at' => Carbon::parse('2024-09-06 12:57:30'),
            ],
            [
                'id' => 2,
                'nama' => 'Teh',
                'stok' => 76,
                'jenis_barang_id' => 1,
                'created_at' => Carbon::parse('2024-09-06 11:04:45'),
                'updated_at' => Carbon::parse('2024-09-06 12:59:21'),
            ],
            [
                'id' => 3,
                'nama' => 'Pasta Gigi',
                'stok' => 80,
                'jenis_barang_id' => 2,
                'created_at' => Carbon::parse('2024-09-06 11:05:07'),
                'updated_at' => Carbon::parse('2024-09-06 12:57:57'),
            ],
            [
                'id' => 4,
                'nama' => 'Sabun Mandi',
                'stok' => 70,
                'jenis_barang_id' => 2,
                'created_at' => Carbon::parse('2024-09-06 11:05:42'),
                'updated_at' => Carbon::parse('2024-09-06 12:58:27'),
            ],
            [
                'id' => 5,
                'nama' => 'Sampo',
                'stok' => 75,
                'jenis_barang_id' => 2,
                'created_at' => Carbon::parse('2024-09-06 11:05:56'),
                'updated_at' => Carbon::parse('2024-09-06 12:59:01'),
            ],
        ]);
    }
}
