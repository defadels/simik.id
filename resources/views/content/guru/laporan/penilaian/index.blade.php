@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', $title)

@section('content')

<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Laporan /</span> Penilaian
</h4>

  <!-- Basic Bootstrap Table -->
  <div class="card">
    {{-- <button class="dt-button create-new btn btn-primary"><span><span class="d-none d-sm-inline-block"></span></span></button> --}}
 

    <div class="table-responsive text-nowrap"> 

      @if(count($daftar_mata_pelajaran) > 0)
      <table class="table">
        <thead>
          <tr>
            <th>Peniliaian</th>
            <th>Keterangan</th> 
            <th></th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
        <tr>
          <td>Pembukaan / Kesimpulan Keseluruhan Penilaian <span class="badge bg-warning">New</span> <span class="badge bg-secondary text-dark">Mohon Cepat diisi</span></td>
          <td class="desc"></td> 
            <td>
              <a href="{{route('gurunda.laporan.penilaian.opening', $laporan->id)}}" class="btn btn-sm btn-success">Nilai</a>  
            </td>
          </tr>
          <tr>
          <td>Pembiasaan Adab <span class="badge bg-warning">New</span> <span class="badge bg-secondary text-dark">Harap Cepat diisi</span></td>
          <td class="desc"></td> 
            <td>
              <a href="{{route('gurunda.laporan.penilaian.adab', $laporan->id)}}" class="btn btn-sm btn-success">Nilai</a>  
            </td>
          </tr>
          @foreach($daftar_mata_pelajaran as $mata_pelajaran)
          <tr>
          <td>{{$mata_pelajaran->nama}}</td>
          <td class="desc"></td> 
            <td>
              <a href="{{route('gurunda.laporan.penilaian.rating', [$laporan->id,$mata_pelajaran->id])}}" class="btn btn-sm btn-success">Nilai</a>  
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @else
        <h4 class="text-center">Penilaian Kosong</h4>
      @endif
    </div>
  </div>
  <!--/ Basic Bootstrap Table -->

@endsection
