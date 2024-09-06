<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JenisBarangController extends Controller
{
    public function index()
    {
        return view('jenis_barang.index');
    }
}
