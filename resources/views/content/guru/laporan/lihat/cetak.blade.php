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
    {{-- <button class="dt-button create-new btn btn-primary"><span><span class="d-none d-sm-inline-block"></span></span></button> --}}
 
 
 
      <table class="table">
        
        <tbody class="table-border-bottom-0"> 
          @foreach($detil_laporan as $laporan)
          <tr> 
          
          <td>{!!$laporan->deskripsi!!}</td>
</tr>
          @endforeach
        </tbody>
      </table>
        
  </div>
  <!--/ Basic Bootstrap Table -->

@endsection
