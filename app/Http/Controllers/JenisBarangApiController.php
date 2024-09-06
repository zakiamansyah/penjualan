<?php

namespace App\Http\Controllers;

use App\Models\JenisBarang;
use Illuminate\Http\Request;

class JenisBarangApiController extends Controller
{
    public function index()
    {
        $jenisBarang = JenisBarang::all();
        return response()->json($jenisBarang);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $jenisBarang = JenisBarang::create([
            'nama' => $request->nama,
        ]);

        return response()->json($jenisBarang, 201);
    }

    public function show($id)
    {
        $jenisBarang = JenisBarang::find($id);

        if (!$jenisBarang) {
            return response()->json(['error' => 'Jenis Barang not found'], 404);
        }

        return response()->json($jenisBarang);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255'
        ]);

        $jenisBarang = JenisBarang::find($id);

        if (!$jenisBarang) {
            return response()->json(['error' => 'Jenis Barang not found'], 404);
        }

        $jenisBarang->update([
            'nama' => $request->nama,
        ]);

        return response()->json($jenisBarang);
    }

    public function destroy($id)
    {
        $jenisBarang = JenisBarang::find($id);

        if (!$jenisBarang) {
            return response()->json(['error' => 'Jenis Barang not found'], 404);
        }

        $jenisBarang->delete();

        return response()->json(['message' => 'Jenis Barang deleted successfully']);
    }
}
