<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Laporan;
use App\Models\User;

class PenilaianController extends Controller
{
    public function index()
    {
      $title="Laporan";

      $daftar_laporan = Laporan::get();
      return view('content.guru.penilaian.index', compact('daftar_laporan','title'));
 
    }
}
