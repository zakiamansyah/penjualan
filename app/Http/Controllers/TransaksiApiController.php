<?php

namespace App\Http\Controllers;


use App\Http\Resources\transaksiResource;
use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiApiController extends Controller
{
    public function index(Request $request)
    {
        $transaksi = Transaksi::when($request->search, function($query) use ($request) {
            $barang = Barang::where('nama', 'like', '%'.$request->search.'%')
            ->select('id')
            ->pluck('id')
            ->toArray();
            $query->whereIn('barang_id', $barang);
        })
        ->when($request->filter_date, function($query) use ($request) {
            $query->whereDate('tanggal_transaksi', $request->filter_date);
        })
        ->when($request->sort, function($query) use ($request) {
            $barang = Barang::orderBy('nama', $request->sort)
            ->select('id')
            ->pluck('id')
            ->toArray();
            $query->whereIn('barang_id', $barang)->orderBy('barang_id', $request->sort);
        })
        ->get();
        return transaksiResource::collection($transaksi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|integer',
            'jumlah_terjual' => 'required|integer',
            'tanggal_transaksi' => 'required',
        ]);

        $barang = Barang::where('id', $request->barang_id)->first();

        $transaksi = Transaksi::create([
            'barang_id' => $request->barang_id,
            'stok_awal' => $barang->stok,
            'jumlah_terjual' => $request->jumlah_terjual,
            'tanggal_transaksi' => $request->tanggal_transaksi,
        ]);
        $barang->stok = $barang->stok - $request->jumlah_terjual;
        $barang->save();

        return response()->json($transaksi, 201);
    }

    public function show($id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json(['error' => 'Transaksi not found'], 404);
        }

        return response()->json($transaksi);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'required|integer|max:10',
            'jumlah_terjual' => 'required|integer|max:10',
            'tanggal_transaksi' => 'required|date',
        ]);

        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json(['error' => 'Transaksi not found'], 404);
        }

        $barang = Barang::where('id', $request->barang_id)->first();
        $barang->stok += $transaksi->jumlah_terjual;
        $barang->save();
        $barang = $barang->fresh();
        $transaksi->update([
            'barang_id' => $request->barang_id,
            'stok_awal' => $barang->stok,
            'jumlah_terjual' => $request->jumlah_terjual,
            'tanggal_transaksi' => $request->tanggal_transaksi,
        ]);

        $barang->stok = $barang->stok - $request->jumlah_terjual;
        $barang->save();

        return response()->json($transaksi);
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json(['error' => 'Transaksi not found'], 404);
        }

        $barang = Barang::where('id', $transaksi->barang_id)->first();
        $barang->stok += $transaksi->jumlah_terjual;
        $barang->save();

        $transaksi->delete();

        return response()->json(['message' => 'Transaksi deleted successfully']);
    }
}
