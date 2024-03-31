@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', $title)

@section('page-style')
<style>

@media print {
  .apexcharts-legend-marker:before {
    content: "\25CF";
    position: absolute;
    top: -3px;
    left: 0;
    display: block;
    line-height: 12px;
    font-size: 24px;
    
  }
}

#isi {
  text-align: justify;
  text-justify: inter-word;
  color:black !important;
}

h2 {  
    font-size: 15pt !important;
    margin-block-end: 0 !important;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    margin-top:20px !important;
    font-weight: bold !important; 
    color:black !important;
}

p {
  font-size: 13pt;
  margin-block-start: 0 !important;
  margin-block-end: 0 !important;
  margin-top: 0 !important;
  margin-bottom: 5px !important;
  color:black !important;
}

</style>
@endsection


@section('page-script')

<script> 
         var options1 = {
          series: [{
          data: {!!$data_adab->pluck("y")!!}
        }],
          chart: {
          type: 'bar',
          height: 380
        },
        plotOptions: {
          bar: {
            barHeight: '100%',
            distributed: true,
            horizontal: true,
            dataLabels: {
              position: 'bottom'
            },
          }
        },
        colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e',
          '#f48024', '#69d2e7'
        ],
  legend: {
    show: false
  },
        dataLabels: {
          enabled: true,
          textAnchor: 'start',
          style: {
            colors: ['#fff']
          },
          formatter: function (val, opt) {
            return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
          },
          offsetX: 0,
          dropShadow: {
            enabled: false
          }
        },
        stroke: {
          width: 1,
          colors: ['#fff']
        },
        xaxis: {
          categories: {!!$data_adab->pluck("x")!!},
          tickAmount: 6,
        },
        yaxis: {
          labels: {
            show: false
          }
        },  
        tooltip: {
          theme: 'dark',
          x: {
            show: false
          },
          y: {
            
            title: {
              formatter: function () {
                return ''
              }
            }
          }
        }
        };

        var chart1 = new ApexCharts(document.querySelector("#chart-apex-1"), options1);
        chart1.render();
      
</script>


<script > 
  var options2 = {
          series: {!! json_encode($data_quran) !!},
          chart: { 
          height: 250,
          offsetX:"25px",
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
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        yaxis: { 
          title: {
          text: "Nilai",
          offsetX:6
          },
          min : 0,
          max : 6,
          decimalsInFloat:0,
          tickAmount: 6,
          labels: {
            show: true,
            align: 'right', 
            offsetX: -10,
          }
        },xaxis :{ 
          type: "datetime"
        }};
  var chart2 = new ApexCharts(
            document.querySelector("#chart-apex-2"),
            options2
            );
chart2.render(); 
</script>

<script > 
  var options3 = {
          series: {!! json_encode($data_arab) !!},
          chart: { 
          height: 300,
          offsetX:"25px",
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
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        yaxis: { 
          title: {
          text: "Nilai",
          offsetX:6
          },
          min : 0,
          max : 6,
          decimalsInFloat:0,
          tickAmount: 6,
          labels: {
            show: true,
            align: 'right', 
            offsetX: -10,
          }
        },annotations: { 
          xaxis: [
        @foreach($daftar_materi_arab as $materi)
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

        },xaxis :{ 
          type: "datetime"
        }};
  var chart3 = new ApexCharts(
            document.querySelector("#chart-apex-3"),
            options3
            );
chart3.render(); 
</script>


<script > 
  var options4 = {
          series: {!! json_encode($data_kepemimpinan) !!},
          chart: { 
          height: 250,
          offsetX:"25px",
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
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        yaxis: { 
          title: {
          text: "Nilai",
          offsetX:6
          },
          min : 0,
          max : 6,
          decimalsInFloat:0,
          tickAmount: 6,
          labels: {
            show: true,
            align: 'right', 
            offsetX: -10,
          }
        },annotations: { 
          xaxis: [
        @foreach($daftar_materi_kepemimpinan as $materi)
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

        },xaxis :{ 
          type: "datetime"
        }};
  var chart4 = new ApexCharts(
            document.querySelector("#chart-apex-4"),
            options4
            );
chart4.render(); 
</script>


<script > 
  var options5 = {
          series: {!! json_encode($data_rubut) !!},
          chart: { 
          height: 300,
          offsetX:"25px",
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
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        yaxis: { 
          title: {
          text: "Nilai",
          offsetX:6
          },
          min : 0,
          max : 6,
          decimalsInFloat:0,
          tickAmount: 6,
          labels: {
            show: true,
            align: 'right', 
            offsetX: -10,
          }
        },annotations: { 
          xaxis: [
        @foreach($daftar_materi_rubut as $materi)
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

        },xaxis :{ 
          type: "datetime"
        }};
  var chart5 = new ApexCharts(
            document.querySelector("#chart-apex-5"),
            options5
            );
chart5.render(); 
</script>


<script > 
  var options6 = {
          series: {!! json_encode($data_khat) !!},
          chart: { 
          height: 250,
          offsetX:"25px",
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
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        yaxis: { 
          title: {
          text: "Nilai",
          offsetX:6
          },
          min : 0,
          max : 6,
          decimalsInFloat:0,
          tickAmount: 6,
          labels: {
            show: true,
            align: 'right', 
            offsetX: -10,
          }
        },xaxis :{ 
          type: "datetime"
        }};
  var chart6 = new ApexCharts(
            document.querySelector("#chart-apex-6"),
            options6
            );
chart6.render(); 
</script>


<script > 
  var options7 = {
          series: {!! json_encode($data_mtk) !!},
          chart: { 
          height: 300,
          offsetX:"25px",
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
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        yaxis: { 
          title: {
          text: "Nilai",
          offsetX:6
          },
          min : 0,
          max : 6,
          decimalsInFloat:0,
          tickAmount: 6,
          labels: {
            show: true,
            align: 'right', 
            offsetX: -10,
          }
        },annotations: { 
          xaxis: [
        @foreach($daftar_materi_mtk as $materi)
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

        },xaxis :{ 
          type: "datetime"
        }};
  var chart7 = new ApexCharts(
            document.querySelector("#chart-apex-7"),
            options7
            );
chart7.render(); 
</script>


<script > 
  var options8 = {
          series: {!! json_encode($data_bind) !!},
          chart: { 
          height: 300,
          offsetX:"25px",
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
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        yaxis: { 
          title: {
          text: "Nilai",
          offsetX:6
          },
          min : 0,
          max : 6,
          decimalsInFloat:0,
          tickAmount: 6,
          labels: {
            show: true,
            align: 'right', 
            offsetX: -10,
          }
        },annotations: { 
          xaxis: [
        @foreach($daftar_materi_bind as $materi)
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

        },xaxis :{ 
          type: "datetime"
        }};
  var chart8 = new ApexCharts(
            document.querySelector("#chart-apex-8"),
            options8
            );
chart8.render(); 
</script>


<script > 
  var options9 = {
          series: {!! json_encode($data_qishah) !!},
          chart: { 
          height: 250,
          offsetX:"25px",
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
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        yaxis: { 
          title: {
          text: "Nilai",
          offsetX:6
          },
          min : 0,
          max : 6,
          decimalsInFloat:0,
          tickAmount: 6,
          labels: {
            show: true,
            align: 'right', 
            offsetX: -10,
          }
        },annotations: { 
          xaxis: [
        @foreach($daftar_materi_qishah as $materi)
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

        },xaxis :{ 
          type: "datetime"
        }};
  var chart9 = new ApexCharts(
            document.querySelector("#chart-apex-9"),
            options9
            );
chart9.render(); 
</script>
@endsection

@section('content')

<h4 class="py-3 mb-4 d-print-none">
    <span class="text-muted fw-light">Laporan /</span> Cetak Laporan /</span> {{$murid->nama}}
</h4> 
  <!-- Basic Bootstrap Table -->
 
  <img class="mx-auto d-block mb-3" height="130px" src="/logo/kopsur.png"/>
  <h2 class="text-center">LAPORAN PERKEMBANGAN ANAK</h2>
  <h2 class="text-center">SEKOLAH ISLAM MAKTAB IBNU KHALDUN</h2>
<br>
 <div class="row" style="font-size:13pt;">

    <div class="col-2">
    Nama Murid
    </div>
    <div class="col-5">
    : {{$murid->nama}}
    </div>
    <div class="col-2">
    Tingkat
    </div>
    <div class="col-3">
    @if($murid->kelas == 1)
    : Maktab Awwal
    @elseif ($murid->kelas ==2)
    : Maktab Tsani
    @endif

    </div>
    <div class="col-2">
    Orang Tua 
    </div>
    <div class="col-5">
    : {{$murid->nama_wali}}
    </div>

    
<div class="col-2">
Tahun Ajaran
</div>
<div class="col-3">
: 2023/2024
</div>

@if($murid->kelas == 1)

<div class="col-2">
Musyrifah
</div>
<div class="col-5">
: Alustadzah Mutiara
</div>
@elseif ($murid->kelas ==2)

<div class="col-2">
Musyrif
</div>
<div class="col-5"> 
: Alustadz Al-Muttaqin Matondang
</div>
@endif




<div class="col-2">
Periode
</div>
<div class="col-3">
: Januari - Maret 2024
</div>

 </div> 
<br>			
  <div id="isi" style="text-align: justify; text-justify: inter-word;">
  {!! $detil_laporan->where("jenis","opening")->value("deskripsi") !!}
  <h2>A. Pembiasaan Adab</h2>
  <div id="chart-apex-1"></div>
  {!! $detil_laporan->where("jenis","adab")->value("deskripsi") !!}
  
  <div style="page-break-inside: avoid;">
  <h2>B. Al-Quran (Karimah)</h2>
  <div id="chart-apex-2"></div>
  {!! $detil_laporan->where("matapelajaran_id", 7 )->where("jenis","mapel")->value("deskripsi") !!}
  </div>

  <div style="page-break-inside: avoid;">
  <h2>C. Keterampilan Bahasa Arab</h2>
  <div id="chart-apex-3"></div>
  {!! $detil_laporan->where("matapelajaran_id", 3 )->where("jenis","mapel")->value("deskripsi") !!}
  </div>

<div style="page-break-inside: avoid;">
  <h2>D. Keterampilan Kepemimpinan</h2>
  <div id="chart-apex-4"></div>
  {!! $detil_laporan->where("matapelajaran_id", 4 )->where("jenis","mapel")->value("deskripsi") !!}
  {!! $detil_laporan->where("matapelajaran_id", 8 )->where("jenis","mapel")->value("deskripsi") !!}

  </div>

<div style="page-break-inside: avoid;">
  <h2>E. Rubutiyah wal Ulum</h2>
  <div id="chart-apex-5"></div>
  {!! $detil_laporan->where("matapelajaran_id", 11 )->where("jenis","mapel")->value("deskripsi") !!}
  {!! $detil_laporan->where("matapelajaran_id", 2 )->where("jenis","mapel")->value("deskripsi") !!}

  </div>

  <div style="page-break-inside: avoid;">
    <h2>F. Khath wa Rasm</h2>
  <div id="chart-apex-6"></div>
  {!! $detil_laporan->where("matapelajaran_id", 6 )->where("jenis","mapel")->value("deskripsi") !!}
  </div>

  <div style="page-break-inside: avoid;">
  
  <h2>G. Riyadhiyat</h2>
  <div id="chart-apex-7"></div>
  {!! $detil_laporan->where("matapelajaran_id", 5 )->where("jenis","mapel")->value("deskripsi") !!}
  </div>

  <div style="page-break-inside: avoid;">
  
  <h2>H. Bahasa Indonesia</h2>
  <div id="chart-apex-8"></div>
  {!! $detil_laporan->where("matapelajaran_id", 1 )->where("jenis","mapel")->value("deskripsi") !!}
  </div>

  <div style="page-break-inside: avoid;">
  
  <h2>I. Adab wal Qoshosh</h2>
  <div id="chart-apex-9"></div>
  {!! $detil_laporan->where("matapelajaran_id", 10 )->where("jenis","mapel")->value("deskripsi") !!}
          </div>
</div>
 
@endsection
