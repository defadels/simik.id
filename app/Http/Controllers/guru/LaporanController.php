<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;

use App\Models\Laporan;
use App\Models\User;

use App\Models\Murid;
use App\Models\NilaiMurid;
use App\Models\MataPelajaran;
use App\Models\DetilLaporan;

use DB;

class LaporanController extends Controller
{
    public function index()
    {
      $title="Laporan";

      $daftar_laporan = Laporan::get();
      return view('content.guru.laporan.index', compact('daftar_laporan','title'));
 
    }

    public function lihat($id)
    {
      $title="Daftar Murid";
      
      $laporan = Laporan::findOrFail($id);
      $daftar_murid = Murid::orderBy("kelas","asc")->orderBy("nama","asc")->get();
      return view('content.guru.laporan.lihat.index', compact('daftar_murid','title','laporan'));
 
    }

    public function penilaian($id)
    {
      $title="Daftar Penilaian";

      $laporan = Laporan::findOrFail($id);
      $daftar_mata_pelajaran = MataPelajaran::get();
      return view('content.guru.laporan.penilaian.index', compact('daftar_mata_pelajaran','title','laporan'));
 
    }

    public function rating(Request $req, $id_laporan,$id_mapel)
    {
      $title="Daftar Penilaian";
      $murid = Murid::find($req->id_murid);
      if (!$murid) {
        $murid = Murid::first();
      }
      $laporan = Laporan::findOrFail($id_laporan);
      $mata_pelajaran = MataPelajaran::findOrFail($id_mapel);
      $daftar_murid = Murid::orderBy("nama","asc")->pluck('nama','id');


      $nilai = NilaiMurid:: where('murid_id',$murid->id)
                                ->where('matapelajaran_id',$mata_pelajaran->id)
                                ->where('tanggal','>=',$laporan->tanggal_awal)
                                ->where('tanggal','<=',$laporan->tanggal_akhir) 
                                ->where('tanggal','!=',0)
                                ->where(function ( $query) {
                                  $query->orWhere('indikator_1_nilai', '>', 0)
                                        ->orWhere('indikator_2_nilai', '>', 0)
                                        ->orWhere('indikator_3_nilai', '>', 0);
                                })->orderBy('tanggal','asc');
      

    
      $label_1 = $mata_pelajaran->label_1;
      if(!$label_1){$label_1 = "Indikator 1";}
      $label_2 = $mata_pelajaran->label_2;
      if(!$label_2){$label_2 = "Indikator 2";}
      $label_3 = $mata_pelajaran->label_3;
      if(!$label_3){$label_3 = "Indikator 3";}
       


      $daftar_materi  = NilaiMurid:: where('murid_id',$murid->id)
                                ->where('matapelajaran_id',$mata_pelajaran->id)
                                ->where('tanggal','>=',$laporan->tanggal_awal)
                                ->where('tanggal','<=',$laporan->tanggal_akhir) 
                                ->where('tanggal','!=',0)
                                ->where(function ( $query) {
                                  $query->orWhere('indikator_1_nilai', '>', 0)
                                        ->orWhere('indikator_2_nilai', '>', 0)
                                        ->orWhere('indikator_3_nilai', '>', 0);
                                })->select('materi',DB::raw('min(tanggal) as tanggal'))
                                ->groupBy('materi')
                                ->orderBy('tanggal','asc')
                                ->get();
           
      $data = collect();
      $series1 = [];
      $series2 = [];
      $series3 = [];
      $series4 = [];
      if ($mata_pelajaran->kode_grafik == 2){
      $indikator1 = $nilai->select(DB::raw('DATE_FORMAT(tanggal, "%Y-%m-%d") as x , indikator_1_nilai as y')
                           )->get();
      $indikator2 = $nilai->select(DB::raw('DATE_FORMAT(tanggal, "%Y-%m-%d") as x , indikator_2_nilai as y')
                           )->get();
      $indikator3 = $nilai->select(DB::raw('DATE_FORMAT(tanggal, "%Y-%m-%d") as x , indikator_3_nilai as y')
                           )->get();
      $rata2 = $nilai->select(DB::raw('DATE_FORMAT(tanggal, "%Y-%m-%d") as x , rata_rata_nilai as y')
                           )->get();
        $series1 = array("name"=> $label_1, "data"=>$indikator1);
        $series2 = array("name"=> $label_2, "data"=>$indikator2);
        $series3 = array("name"=> $label_3, "data"=>$indikator3); 
        $series4 = array("name"=>"Nilai Rata-rata", "data"=>$rata2); 
         
        $data->push($series1);  
        $data->push($series2);  
        $data->push($series3); 
        $data->push($series4);  
      } else if ($mata_pelajaran->kode_grafik == 1) {
        $rata2 = $nilai->select(DB::raw('DATE_FORMAT(tanggal, "%Y-%m-%d") as x , rata_rata_nilai as y')
        )->get();

          $series4 = array("name"=>"Nilai Rata-rata", "data"=>$rata2); 
          $data->push($series4); 
      } else if ($mata_pelajaran->kode_grafik == 3) {

        $daftar_mat = NilaiMurid:: where('murid_id',$murid->id)
        ->where('matapelajaran_id',$mata_pelajaran->id)
        ->where('tanggal','>=',$laporan->tanggal_awal)
        ->where('tanggal','<=',$laporan->tanggal_akhir) 
        ->where('tanggal','!=',0)
        ->where(function ( $query) {
          $query->orWhere('indikator_1_nilai', '>', 0)
                ->orWhere('indikator_2_nilai', '>', 0)
                ->orWhere('indikator_3_nilai', '>', 0);
        })->select('materi')->distinct()->get(); 
        foreach ($daftar_mat as $mat){
            $rata2rata = NilaiMurid:: where('murid_id',$murid->id)
            ->where('matapelajaran_id',$mata_pelajaran->id)
            ->where('tanggal','>=',$laporan->tanggal_awal)
            ->where('tanggal','<=',$laporan->tanggal_akhir) 
            ->where('tanggal','!=',0)
            ->where('materi',$mat->materi)
            ->where(function ( $query) {
              $query->orWhere('indikator_1_nilai', '>', 0)
                    ->orWhere('indikator_2_nilai', '>', 0)
                    ->orWhere('indikator_3_nilai', '>', 0);
            })->select(DB::raw('DATE_FORMAT(tanggal, "%Y-%m-%d") as x , rata_rata_nilai as y')) 
            ->orderBy('tanggal','asc')
            ->get();
            $series1 = array("name"=> $mat->materi, "data"=>$rata2rata);
            $data->push($series1);
        }  
 
      }
      
 
      $detil_laporan = DetilLaporan::updateOrCreate(
                            ['laporan_id' =>  $laporan->id,
                            'murid_id' => $murid->id,
                            'matapelajaran_id' => $mata_pelajaran->id,
                            'jenis' => 'mapel'],
                            ['deskripsi'=>$req->deskripsinya]
                        );
      
      $judul_grafik = "Grafik Perkembangan ".$mata_pelajaran->nama;
 
      return view('content.guru.laporan.penilaian.rating', 
      compact('mata_pelajaran','title','laporan','daftar_murid','murid','data','judul_grafik','daftar_materi','detil_laporan'));
 
    }
 
}
