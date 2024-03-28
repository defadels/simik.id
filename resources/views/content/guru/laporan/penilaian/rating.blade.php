@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', $title)

@section('page-styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.4/dist/quill.snow.css" rel="stylesheet" />

@endsection
@section('page-script')
<script > 
  

  var options = {
          series: {!! json_encode($data) !!},
          chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        title: {
          text: '{{$judul_grafik}}',
          align: 'left'
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        yaxis: { 
          min : 0,
          max : 6,
          
      tickAmount: 6,
  },
@if($mata_pelajaran->kode_grafik == 2 ||$mata_pelajaran->kode_grafik == 1)
  annotations: { 
          xaxis: [
        @foreach($daftar_materi as $materi)
            {
            x: new Date("{{$materi->tanggal->format('Y-m-d')}}").getTime(),
            strokeDashArray: 0,
            borderColor: '#775DD0',
            opacity: 100,
            label: {
              borderColor: '#775DD0',
              position: 'left', 
              style: {
                color: '#fff',
                background: '#775DD0',
                fontSize:'12px',
                
              },
              text: "{{$materi->materi}}",
            }
          },
        @endforeach
          ],

        },
        xaxis :{ 
    type: "datetime"
  },
  @elseif($mata_pelajaran->kode_grafik == 3)  
  
  xaxis :{ 
    type: "datetime"
  },
         
  @endif
  
  
        };
          var chart = new ApexCharts(
      document.querySelector("#chart-apex"),
      options
  );
  chart.render(); 
    </script>

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.4/dist/quill.js"></script>
<script>
  var quill = new Quill('#editor', {
    theme: 'snow',
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
    <span class="text-muted fw-light">Laporan /</span> Penilaian /</span> Rating 
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
                Mata Pelajaran
              </td>
              <td class="desc">
                {{$mata_pelajaran->nama}} 
                <a href="{{route('gurunda.laporan.penilaian', [$laporan->id])}}" class="btn btn-sm btn-light waves-effect waves-light"> <i class="ti ti-edit"></i></a>
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
  <div class="card ">
  <div id="chart-apex"></div>
   </div>
   <br> 
  
 
  <form method="post" class="row g-3" action="{{route('gurunda.laporan.penilaian.rating',[$laporan->id, $mata_pelajaran->id])}}">
  @csrf
  <div class="mb-3">  
  <button type="submit" class="btn btn-danger mb-3"> Simpan Deskripsi</button> 
  <input type="hidden" name="id_murid" value="{{$murid->id}}"/> 
  <div>
  
  <input type="hidden" name="deskripsinya" value="{{$detil_laporan->deskripsi}}">
  <div id="editor" style="min-height: 160px;">{!!$detil_laporan->deskripsi!!}</div>
</div> 

  
 
</div>
</form>

 
 
@endsection
