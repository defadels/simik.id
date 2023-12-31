<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalonMurid;


class CalonMuridController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $daftar_calon_murid = CalonMurid::get();

        return view('content.pages.calon-murid.index', compact('daftar_calon_murid'));
    }

    public function daftarTahapKedua(CalonMurid $calon_murid)
    {
      $title = 'Pendaftaran Tahap Kedua';
      $url = 'dashboard.calon-murid.tahap-kedua.update';
      $button = 'Simpan';
      return view('content.pages.calon-murid.daftar-kedua', compact('calon_murid','button', 'title', 'url'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
