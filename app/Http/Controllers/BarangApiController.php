<?php

namespace App\Http\Controllers;

use App\Http\Resources\barangResource;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangApiController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return barangResource::collection($barang);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_barang_id' => 'required|integer|max:10',
            'nama' => 'required|string|max:255',
            'stok' => 'required|integer',
        ]);

        $barang = Barang::create([
            'jenis_barang_id' => $request->jenis_barang_id,
            'nama' => $request->nama,
            'stok' => $request->stok,
        ]);

        return response()->json($barang, 201);
    }

    public function show($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['error' => 'Barang not found'], 404);
        }

        return response()->json($barang);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_barang_id' => 'required|integer|max:10',
            'nama' => 'required|string|max:255',
            'stok' => 'required|integer|max:10',
        ]);

        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['error' => 'Barang not found'], 404);
        }

        $barang->update([
            'jenis_barang_id' => $request->jenis_barang_id,
            'nama' => $request->nama,
            'stok' => $request->stok,
        ]);

        return response()->json($barang);
    }

    public function destroy($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['error' => 'Barang not found'], 404);
        }

        $barang->delete();

        return response()->json(['message' => 'Barang deleted successfully']);
    }
}
