@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', $title)

@section('page-styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.4/dist/quill.snow.css" rel="stylesheet" />

@endsection
@section('page-script')
 

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.4/dist/quill.js"></script>
<script>
  var quill = new Quill('#editor', {
    theme: 'snow',
    formats: ["bold", "italic","underline"],
    modules: {
      toolbar: [  
        ["bold", "italic","underline"],    
      ]
    },
  });
  quill.on('text-change', function(delta, oldDelta, source) {
    document.querySelector("input[name='deskripsinya']").value = quill.root.innerHTML;
  });
</script>
@endsection

@section('vendor-script')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.4/dist/quill.snow.css" rel="stylesheet" />

@endsection

@section('content')

<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Laporan /</span> Penilaian /</span> Opening Laporan
</h4>

  
  <!-- Basic Bootstrap Table -->
 
  <form class="row g-3">
  <div class="col-auto">
  <select name="id_murid" class="form-select" aria-label="Dafar Murid">
            <option selected>Pilih Nama Murid</option> 
            @foreach ($daftar_murid as $key => $value)
              <option value="{{ $key }}" {{ ( $key == $murid->id) ? 'selected' : '' }}> 
                  {{ $value }} 
              </option>
            @endforeach 
          </select>
  </div> 
  <div class="col-auto">
    <button type="submit" class="btn btn-primary mb-3"> Pilih Murid</button>
  </div>
</form>   
   
<div class="card">
 
 <div class="table-responsive text-nowrap"> 

   <table class="table">
      
     <tbody class="table-border-bottom-0"> 
     <tr>
           <td>
            Laporan
           </td>
           <td class="desc">
             {{$laporan->nama}}
           </td> 
       </tr> 
       <tr>
           <td>
           Periode
           </td>
           <td class="desc">
           {{$laporan->tanggal_awal->format ('d M Y')}} s.d. {{$laporan->tanggal_akhir->format ('d M Y')}}
           </td> 
       </tr> 
       <tr>
           <td>
             Orang Tua / Wali
           </td>
           <td class="desc">
             {{$murid->nama_wali}} 
            </td> 
       </tr> 
       <tr>
           <td>
             Nama Murid
           </td>
           <td class="desc">
             {{$murid->nama}}
           </td> 
       </tr> 
       <tr>
           <td>
             Kelas
           </td>
           <td class="desc">
             {{$murid->kelas}}
           </td> 
       </tr> 
     </tbody>
   </table> 
 </div>
</div>
<!--/ Basic Bootstrap Table -->
  
 
  <form method="post" class="row g-3" action="{{route('gurunda.laporan.penilaian.opening',$laporan->id)}}">
  @csrf
  <div class="mb-3">  
  <button type="submit" class="btn btn-danger mb-3"> Simpan Deskripsi Opening</button> 
  <input type="hidden" name="id_murid" value="{{$murid->id}}"/> 
  <div>
  
  <input type="hidden" name="deskripsinya" value="{{$detil_laporan->deskripsi}}">
  <div id="editor" style="min-height: 160px;">{!!$detil_laporan->deskripsi!!}</div>
</div> 

  
 
</div>
</form>

 
 
@endsection
