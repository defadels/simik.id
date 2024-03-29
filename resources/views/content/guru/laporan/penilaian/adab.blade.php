@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', $title)

@section('page-styles')

@endsection
@section('page-script')
 
<script>

$(function () {
 
  $('.rate_adab').each(function () {
    var rating = $(this).data('rating');
    $(this).rateYo({ 
   numStars: 6,
   maxValue:6,
   rating: rating,
   fullStar: true,
   onSet: function (rating, rateYoInstance) {
    var idnilai = $(this).attr("penilaian_id");
    $("#nilai_rating_"+idnilai).val(rating);
    } 

 });
  });
 

});
</script>
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
 
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/rateyo/rateyo.css')) }}" />
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.4/dist/quill.snow.css" rel="stylesheet" />
<script src="{{ asset(mix('assets/vendor/libs/rateyo/rateyo.js'))}}"></script> 
@endsection

@section('content')

<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Laporan /</span> Penilaian /</span> Pembiasaan Adab Murid
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
   <br>
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
  <br>
   
<div class="card">
 
 <div class="table-responsive text-nowrap"> 

 <table class="table">
        <thead>
          <tr>
            <th>Adab</th>
            <th>Rating</th>  
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
        <tr>
       @foreach($daftar_penilaian_adab as $penilaian)
       <tr>
           <td>
           {{$penilaian->penilaian}}
           </td>
           <td class="desc">
              <div id="rate_{{$penilaian->id}}" class="rate_adab" data-rating="{{$daftar_rating->where('penilaian_adab_id',$penilaian->id)->value('rating')?$daftar_rating->where('penilaian_adab_id',$penilaian->id)->value('rating'):0}}" penilaian_id="{{$penilaian->id}}"></div>
          </td> 
       </tr> 
       @endforeach
     </tbody>
   </table> 
 </div>
</div>
<!--/ Basic Bootstrap Table -->
  
<br>
 
  <form method="post" class="row g-3" action="{{route('gurunda.laporan.penilaian.adab',$laporan->id)}}">
  @csrf
  <div class="mb-3">  
  <input type="hidden" name="id_murid" value="{{$murid->id}}"/> 
  <div>
  @foreach($daftar_penilaian_adab as $penilaian) 
  <input type="hidden" id="nilai_rating_{{$penilaian->id}}" name="rating[]" value="{{$daftar_rating->where('penilaian_adab_id',$penilaian->id)->value('rating')?$daftar_rating->where('penilaian_adab_id',$penilaian->id)->value('rating'):0}}">
  @endforeach
  <input type="hidden" name="deskripsinya" value="{{$detil_laporan->deskripsi}}">

  <div id="editor" style="min-height: 160px;">{!!$detil_laporan->deskripsi!!}</div>
  <br>
  <button type="submit" class="btn btn-danger mb-3"> Simpan</button> 
  
</div> 

  
 
</div>
</form>

 
 
@endsection
