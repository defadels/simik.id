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
            <th>Mata Pelajaran</th>
            <th>Keterangan</th> 
            <th></th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
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
        <h4 class="text-center">Mata Pelajaran Kosong</h4>
      @endif
    </div>
  </div>
  <!--/ Basic Bootstrap Table -->

@endsection
