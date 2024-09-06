<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transaksis')->insert([
            [
                'id' => 1,
                'barang_id' => 1,
                'stok_awal' => 100,
                'jumlah_terjual' => 10,
                'tanggal_transaksi' => '2021-05-01',
                'created_at' => Carbon::parse('2024-09-06 12:56:31'),
                'updated_at' => Carbon::parse('2024-09-06 12:56:31'),
            ],
            [
                'id' => 2,
                'barang_id' => 2,
                'stok_awal' => 100,
                'jumlah_terjual' => 19,
                'tanggal_transaksi' => '2021-05-05',
                'created_at' => Carbon::parse('2024-09-06 12:57:00'),
                'updated_at' => Carbon::parse('2024-09-06 12:57:00'),
            ],
            [
                'id' => 3,
                'barang_id' => 1,
                'stok_awal' => 90,
                'jumlah_terjual' => 15,
                'tanggal_transaksi' => '2021-05-10',
                'created_at' => Carbon::parse('2024-09-06 12:57:30'),
                'updated_at' => Carbon::parse('2024-09-06 12:57:30'),
            ],
            [
                'id' => 4,
                'barang_id' => 3,
                'stok_awal' => 100,
                'jumlah_terjual' => 20,
                'tanggal_transaksi' => '2021-05-11',
                'created_at' => Carbon::parse('2024-09-06 12:57:57'),
                'updated_at' => Carbon::parse('2024-09-06 12:57:57'),
            ],
            [
                'id' => 5,
                'barang_id' => 4,
                'stok_awal' => 100,
                'jumlah_terjual' => 30,
                'tanggal_transaksi' => '2021-05-11',
                'created_at' => Carbon::parse('2024-09-06 12:58:27'),
                'updated_at' => Carbon::parse('2024-09-06 12:58:27'),
            ],
            [
                'id' => 6,
                'barang_id' => 5,
                'stok_awal' => 100,
                'jumlah_terjual' => 25,
                'tanggal_transaksi' => '2021-05-12',
                'created_at' => Carbon::parse('2024-09-06 12:59:01'),
                'updated_at' => Carbon::parse('2024-09-06 12:59:01'),
            ],
            [
                'id' => 7,
                'barang_id' => 2,
                'stok_awal' => 81,
                'jumlah_terjual' => 5,
                'tanggal_transaksi' => '2021-05-12',
                'created_at' => Carbon::parse('2024-09-06 12:59:21'),
                'updated_at' => Carbon::parse('2024-09-06 12:59:21'),
            ],
        ]);
    }
}
