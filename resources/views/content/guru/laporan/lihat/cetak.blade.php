@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', $title)

@section('page-style')
<style> !important

#isi {
  text-align: justify;
  text-justify: inter-word;
  color:black !important;
}

h2 {  
    font-size: 12pt !important;
    margin-block-end: 0 !important;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold !important; 
    color:black !important;
}

p {
  font-size: 10pt;
  margin-block-start: 0 !important;
  margin-block-end: 0 !important;
  margin-top: 0 !important;
  margin-bottom: 5px !important;
  color:black !important;
}

</style>
@endsection

@section('content')

<h4 class="py-3 mb-4 d-print-none">
    <span class="text-muted fw-light">Laporan /</span> Cetak Laporan /</span> {{$murid->nama}}
</h4> 
  <!-- Basic Bootstrap Table -->
 
  <img class="mx-auto d-block mb-3" height="100px" src="/logo/kopsur.png"/>
  <h2 class="text-center">LAPORAN PERKEMBANGAN ANAK</h2>
  <h2 class="text-center">SEKOLAH ISLAM MAKTAB IBNU KHALDUN</h2>
<br>
 <div class="row" style="font-size:11pt;">

    <div class="col-2">
    NAMA
    </div>
    <div class="col-4">
    : {{$murid->nama}}
    </div>
    <div class="col-3">
    ORANG TUA/WALI
    </div>
    <div class="col-3">
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
<div class="col-3">
TAHUN AJARAN
</div>
<div class="col-3">
: 2023/2024
</div>

@if($murid->kelas == 1)

<div class="col-2">
MUSYRIFAH
</div>
<div class="col-4">
: Alustadzah Mutiara
</div>
@elseif ($murid->kelas ==2)

<div class="col-2">
MUSYRIF
</div>
<div class="col-4"> 
: Alustadz Al-Muttaqin 
</div>
@endif




<div class="col-3">
PERIODE
</div>
<div class="col-3">
: Januari - Maret 2024
</div>

 </div> 
<br>			
  <div id="isi" style="text-align: justify; text-justify: inter-word;">
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
</div>
 
@endsection
