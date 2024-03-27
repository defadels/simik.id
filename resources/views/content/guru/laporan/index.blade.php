@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', $title)

@section('content')

<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Laporan /</span> Daftar Laporan
  </h4>

  <!-- Basic Bootstrap Table -->
  <div class="card">
    {{-- <button class="dt-button create-new btn btn-primary"><span><span class="d-none d-sm-inline-block"></span></span></button> --}}
 

    <div class="table-responsive text-nowrap"> 

      @if(count($daftar_laporan) > 0)
      <table class="table">
        <thead>
          <tr>
            <th>Judul</th>
            <th>Keterangan</th>
            <th>Periode</th>
            <th></th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach($daftar_laporan as $laporan)
          <tr>
          <td>{{$laporan->nama}}</td>
          <td class="desc">{{$laporan->keterangan}}</td>
          <td class="desc">{{$laporan->tanggal_awal->format ('d M Y')}} s.d. {{$laporan->tanggal_akhir->format ('d M Y')}}</td>
            <td>
              <a href="{{route('gurunda.laporan.lihat', $laporan->id)}}" class="btn btn-sm btn-success">Lihat</a> 
              <a href="{{route('gurunda.laporan.penilaian', $laporan->id)}}" class="btn btn-sm btn-info">Penilaian</a> 
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @else
        <h4 class="text-center">Laporan Kosong</h4>
      @endif
    </div>
  </div>
  <!--/ Basic Bootstrap Table -->

@endsection
