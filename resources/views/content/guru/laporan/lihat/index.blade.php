@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', $title)

@section('content')

<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Laporan /</span> Daftar Murid
</h4>

  <!-- Basic Bootstrap Table -->
  <div class="card">
    {{-- <button class="dt-button create-new btn btn-primary"><span><span class="d-none d-sm-inline-block"></span></span></button> --}}
 

    <div class="table-responsive text-nowrap"> 

      @if(count($daftar_murid) > 0)
      <table class="table">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Kelas</th> 
            <th></th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach($daftar_murid as $murid)
          <tr>
          <td>{{$murid->nama}}</td>
          <td class="desc">{{$murid->kelas}}</td> 
            <td>
              <a href="{{route('gurunda.laporan.lihat.cetak', [$laporan->id,$murid->id])}}" class="btn btn-sm btn-success">Lihat Laporan</a>  
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @else
        <h4 class="text-center">Murid Kosong</h4>
      @endif
    </div>
  </div>
  <!--/ Basic Bootstrap Table -->

@endsection
