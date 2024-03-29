@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', $title)

@section('content')

<h4 class="py-3 mb-4 d-print-none">
    <span class="text-muted fw-light">Laporan /</span> Cetak Laporan /</span> {{$murid->nama}}
</h4> 
  <!-- Basic Bootstrap Table -->
  <div class="card">
  <h2>LAPORAN PERKEMBANGAN ANAK</h2>
  <h2>SEKOLAH ISLAM MAKTAB IBNU KHALDUN</h2>

 <div class="row">

<div class="col-2">
NAMA
</div>
<div class="col-4">
: {{$murid->nama}}
</div>
<div class="col-2">
ORANG TUA/WALI
</div>
<div class="col-4">
: {{$murid->nama_wali}}
</div>

<div class="col-2">
TINGKAT
</div>
<div class="col-4">
@if($murid->kelas == 1)
: Maktab Awwal
@elseif ($murid->kelas ==2)
: Maktab Tsani
@endif

</div>
<div class="col-2">
TAHUN AJARAN
</div>
<div class="col-4">
: 2023/2024
</div>

<div class="col-2">
MUSYRIFAH
</div>
<div class="col-4">
@if($murid->kelas == 1)
: Alustadzah Mutiara
@elseif ($murid->kelas ==2)
: Alustadz AlMuttaqin Matondang
@endif
	
</div>
<div class="col-2">
PERIODE
</div>
<div class="col-4">
: Maret 2024
</div>
 </div>
  				
 				
 				
  
  {!! $detil_laporan->where("jenis","opening")->value("deskripsi") !!}
  <h2>A. Pembiasaan Adab</h2>
  {!! $detil_laporan->where("jenis","adab")->value("deskripsi") !!}
  <h2>B. Al-Quran (Karimah)</h2>
  {!! $detil_laporan->where("matapelajaran_id", 7 )->where("jenis","mapel")->value("deskripsi") !!}
  <h2>C. Keterampilan Bahasa Arab</h2>
  {!! $detil_laporan->where("matapelajaran_id", 3 )->where("jenis","mapel")->value("deskripsi") !!}
  <h2>D. Keterampilan Kepemimpinan</h2>
  {!! $detil_laporan->where("matapelajaran_id", 4 )->where("jenis","mapel")->value("deskripsi") !!}
  {!! $detil_laporan->where("matapelajaran_id", 8 )->where("jenis","mapel")->value("deskripsi") !!}
  <h2>E. Rubutiyah wal Ulum</h2>
  {!! $detil_laporan->where("matapelajaran_id", 11 )->where("jenis","mapel")->value("deskripsi") !!}
  {!! $detil_laporan->where("matapelajaran_id", 2 )->where("jenis","mapel")->value("deskripsi") !!}
  <h2>F. Khath wa Rasm</h2>
  {!! $detil_laporan->where("matapelajaran_id", 6 )->where("jenis","mapel")->value("deskripsi") !!}
  <h2>G. Riyadhiyat</h2>
  {!! $detil_laporan->where("matapelajaran_id", 5 )->where("jenis","mapel")->value("deskripsi") !!}
  <h2>H. Bahasa Indonesia</h2>
  {!! $detil_laporan->where("matapelajaran_id", 1 )->where("jenis","mapel")->value("deskripsi") !!}
  <h2>I. Adab wal Qoshosh</h2>
  {!! $detil_laporan->where("matapelajaran_id", 10 )->where("jenis","mapel")->value("deskripsi") !!}


      <table class="table">
        
        <tbody class="table-border-bottom-0"> 
       
        </tbody>
      </table>
        
  </div>
  <!--/ Basic Bootstrap Table -->

@endsection
