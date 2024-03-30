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
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\PenilaianAdab;
use App\Models\RatingAdab;


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


    public function lihat_cetak ($id_laporan,$id_murid) {

      
      $title="Laporan Murid"; 
      $murid = Murid::findOrFail($id_murid); 
      $laporan = Laporan::findOrFail($id_laporan);

      $detil_laporan = DetilLaporan::where('laporan_id',$laporan->id)
                                    ->where('murid_id',$murid->id)->get();

      // grafik adab
      $data_adab = RatingAdab::join('penilaian_adab', 'penilaian_adab.id', '=', 'rating_adab.penilaian_adab_id')
                              ->select('penilaian_adab.penilaian as x', 'rating_adab.rating as y')
                              ->where('murid_id',$murid->id)
                              ->get(); 
 

      // data untuk grafik mata pelajaran
      $daftar_mapel = MataPelajaran::get();

     // mapel alquran. --------------------------------------------------------------------
     $mapel_id = 7;
     $mapel = $daftar_mapel->where('id',$mapel_id)->first();

     $data = collect();
     $series1 = [];
     $series2 = [];
     $series3 = [];
     $series4 = []; 

     $label_1 = $mapel->label_1;
     if(!$label_1){$label_1 = "Indikator 1";}
     $label_2 = $mapel->label_2;
     if(!$label_2){$label_2 = "Indikator 2";}
     $label_3 = $mapel->label_3;
     if(!$label_3){$label_3 = "Indikator 3";} 

     $nilai = NilaiMurid:: where('murid_id',$murid->id)
         ->where('matapelajaran_id',$mapel->id)
         ->where('tanggal','>=',$laporan->tanggal_awal)
         ->where('tanggal','<=',$laporan->tanggal_akhir) 
         ->where('tanggal','!=',0)
         ->where(function ( $query) {
           $query->orWhere('indikator_1_nilai', '>', 0)
                 ->orWhere('indikator_2_nilai', '>', 0)
                 ->orWhere('indikator_3_nilai', '>', 0);
         })->orderBy('tanggal','asc');

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
     
       $data_quran = $data;



    // mapel bahasa arab ---------------------------------------------
    $mapel_id = 3;
    $mapel = $daftar_mapel->where('id',$mapel_id)->first();

    $daftar_materi_arab  = NilaiMurid:: where('murid_id',$murid->id)
                                ->where('matapelajaran_id',$mapel->id)
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

    $series4 = []; 
    $nilai = NilaiMurid:: where('murid_id',$murid->id)
    ->where('matapelajaran_id',$mapel->id)
    ->where('tanggal','>=',$laporan->tanggal_awal)
    ->where('tanggal','<=',$laporan->tanggal_akhir) 
    ->where('tanggal','!=',0)
    ->where(function ( $query) {
      $query->orWhere('indikator_1_nilai', '>', 0)
            ->orWhere('indikator_2_nilai', '>', 0)
            ->orWhere('indikator_3_nilai', '>', 0);
    })->orderBy('tanggal','asc');

    $rata2 = $nilai->select(DB::raw('DATE_FORMAT(tanggal, "%Y-%m-%d") as x , rata_rata_nilai as y')
      )->get();

        $series4 = array("name"=>"Nilai Rata-rata", "data"=>$rata2); 
        $data->push($series4); 
        $data_arab = $data;
     
      // mapel kepemimpinan ---------------------------------------------
      if($murid->kelas == 1){
        $mapel_id = 4;
        $mapel = $daftar_mapel->where('id',$mapel_id)->first();
      } else if ($murid->kelas == 2){
        $mapel_id = 8;
        $mapel = $daftar_mapel->where('id',$mapel_id)->first();
      }


      $daftar_materi_kepemimpinan  = NilaiMurid:: where('murid_id',$murid->id)
      ->where('matapelajaran_id',$mapel->id)
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

      $series4 = []; 
      $nilai = NilaiMurid:: where('murid_id',$murid->id)
      ->where('matapelajaran_id',$mapel->id)
      ->where('tanggal','>=',$laporan->tanggal_awal)
      ->where('tanggal','<=',$laporan->tanggal_akhir) 
      ->where('tanggal','!=',0)
      ->where(function ( $query) {
        $query->orWhere('indikator_1_nilai', '>', 0)
              ->orWhere('indikator_2_nilai', '>', 0)
              ->orWhere('indikator_3_nilai', '>', 0);
      })->orderBy('tanggal','asc');
 
      $rata2 = $nilai->select(DB::raw('DATE_FORMAT(tanggal, "%Y-%m-%d") as x , rata_rata_nilai as y')
        )->get();

          $series4 = array("name"=>"Nilai Rata-rata", "data"=>$rata2); 
          $data->push($series4); 
          $data_kepemimpinan = $data;
 
      // rubutiyah ulum --------------------------------------------------

      
      
      if($murid->kelas == 1){
        $mapel_id = 11;
        $mapel = $daftar_mapel->where('id',$mapel_id)->first();


       

      $data = collect();
      $series1 = [];
      $series2 = [];
      $series3 = [];
      $series4 = []; 

      $label_1 = $mapel->label_1;
      if(!$label_1){$label_1 = "Indikator 1";}
      $label_2 = $mapel->label_2;
      if(!$label_2){$label_2 = "Indikator 2";}
      $label_3 = $mapel->label_3;
      if(!$label_3){$label_3 = "Indikator 3";} 
 
      $nilai = NilaiMurid:: where('murid_id',$murid->id)
          ->where('matapelajaran_id',$mapel->id)
          ->where('tanggal','>=',$laporan->tanggal_awal)
          ->where('tanggal','<=',$laporan->tanggal_akhir) 
          ->where('tanggal','!=',0)
          ->where(function ( $query) {
            $query->orWhere('indikator_1_nilai', '>', 0)
                  ->orWhere('indikator_2_nilai', '>', 0)
                  ->orWhere('indikator_3_nilai', '>', 0);
          })->orderBy('tanggal','asc');

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
      
        $data_rubut = $data;
      } else if ($murid->kelas == 2){
        $mapel_id = 2;
        $mapel = $daftar_mapel->where('id',$mapel_id)->first();

        $data = collect();

        $series4 = []; 
        $nilai = NilaiMurid:: where('murid_id',$murid->id)
        ->where('matapelajaran_id',$mapel->id)
        ->where('tanggal','>=',$laporan->tanggal_awal)
        ->where('tanggal','<=',$laporan->tanggal_akhir) 
        ->where('tanggal','!=',0)
        ->where(function ( $query) {
          $query->orWhere('indikator_1_nilai', '>', 0)
                ->orWhere('indikator_2_nilai', '>', 0)
                ->orWhere('indikator_3_nilai', '>', 0);
        })->orderBy('tanggal','asc');
   
        $rata2 = $nilai->select(DB::raw('DATE_FORMAT(tanggal, "%Y-%m-%d") as x , rata_rata_nilai as y')
          )->get();
  
            $series4 = array("name"=>"Nilai Rata-rata", "data"=>$rata2); 
            $data->push($series4);  
  
        $data_rubut = $data;
        
      }

      
      $daftar_materi_rubut  = NilaiMurid:: where('murid_id',$murid->id)
      ->where('matapelajaran_id',$mapel->id)
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

      
      // khat wa rasm ------------------------------------------------------
      $mapel_id = 6;
      $mapel = $daftar_mapel->where('id',$mapel_id)->first();
      $data = collect();

      $series1 = []; 
      $daftar_mat = NilaiMurid:: where('murid_id',$murid->id)
        ->where('matapelajaran_id',$mapel->id)
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
            ->where('matapelajaran_id',$mapel->id)
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

          $data_khat = $data;

 

           // riyadhiyat -----------------------------------------------
      $mapel_id = 5;
      $mapel = $daftar_mapel->where('id',$mapel_id)->first();
 
      $daftar_materi_mtk  = NilaiMurid:: where('murid_id',$murid->id)
      ->where('matapelajaran_id',$mapel->id)
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

      $series4 = []; 
      $nilai = NilaiMurid:: where('murid_id',$murid->id)
      ->where('matapelajaran_id',$mapel->id)
      ->where('tanggal','>=',$laporan->tanggal_awal)
      ->where('tanggal','<=',$laporan->tanggal_akhir) 
      ->where('tanggal','!=',0)
      ->where(function ( $query) {
        $query->orWhere('indikator_1_nilai', '>', 0)
              ->orWhere('indikator_2_nilai', '>', 0)
              ->orWhere('indikator_3_nilai', '>', 0);
      })->orderBy('tanggal','asc');
 
      $rata2 = $nilai->select(DB::raw('DATE_FORMAT(tanggal, "%Y-%m-%d") as x , rata_rata_nilai as y')
        )->get();

          $series4 = array("name"=>"Nilai Rata-rata", "data"=>$rata2); 
          $data->push($series4); 
          $data_mtk = $data;

      // bahasa indonesia -------------------------------------------------
      $mapel_id = 1;
      $mapel = $daftar_mapel->where('id',$mapel_id)->first();

      $daftar_materi_bind  = NilaiMurid:: where('murid_id',$murid->id)
      ->where('matapelajaran_id',$mapel->id)
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

      $series4 = []; 
      $nilai = NilaiMurid:: where('murid_id',$murid->id)
      ->where('matapelajaran_id',$mapel->id)
      ->where('tanggal','>=',$laporan->tanggal_awal)
      ->where('tanggal','<=',$laporan->tanggal_akhir) 
      ->where('tanggal','!=',0)
      ->where(function ( $query) {
        $query->orWhere('indikator_1_nilai', '>', 0)
              ->orWhere('indikator_2_nilai', '>', 0)
              ->orWhere('indikator_3_nilai', '>', 0);
      })->orderBy('tanggal','asc');
 
      $rata2 = $nilai->select(DB::raw('DATE_FORMAT(tanggal, "%Y-%m-%d") as x , rata_rata_nilai as y')
        )->get();

          $series4 = array("name"=>"Nilai Rata-rata", "data"=>$rata2); 
          $data->push($series4); 
          $data_bind = $data;

  
      // adab wal qashash ---------------------------------------------------
      $mapel_id = 10;
      $mapel = $daftar_mapel->where('id',$mapel_id)->first();

      $daftar_materi_qishah  = NilaiMurid:: where('murid_id',$murid->id)
      ->where('matapelajaran_id',$mapel->id)
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

      $label_1 = $mapel->label_1;
      if(!$label_1){$label_1 = "Indikator 1";}
      $label_2 = $mapel->label_2;
      if(!$label_2){$label_2 = "Indikator 2";}
      $label_3 = $mapel->label_3;
      if(!$label_3){$label_3 = "Indikator 3";} 
 
      $nilai = NilaiMurid:: where('murid_id',$murid->id)
          ->where('matapelajaran_id',$mapel->id)
          ->where('tanggal','>=',$laporan->tanggal_awal)
          ->where('tanggal','<=',$laporan->tanggal_akhir) 
          ->where('tanggal','!=',0)
          ->where(function ( $query) {
            $query->orWhere('indikator_1_nilai', '>', 0)
                  ->orWhere('indikator_2_nilai', '>', 0)
                  ->orWhere('indikator_3_nilai', '>', 0);
          })->orderBy('tanggal','asc');

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
    
      $data_qishah = $data;


      // end data untuk grafik mata pelajaran.
      return view('content.guru.laporan.lihat.cetak', 
      compact(
        'title',
        'murid',
        'laporan',
        'detil_laporan',
        'data_quran',
        'data_qishah',
        'daftar_materi_qishah',
        'data_rubut',
        'daftar_materi_rubut',
        'data_arab',
        'daftar_materi_arab',
        'data_bind',
        'daftar_materi_bind',
        'data_kepemimpinan',
        'daftar_materi_kepemimpinan',
        'data_khat',
        'data_mtk',
        'daftar_materi_mtk',
        'data_adab'
      ));

 

















    }

    public function penilaian ($id)
    {
      $title="Daftar Penilaian";

      $laporan = Laporan::findOrFail($id);
      $daftar_mata_pelajaran = MataPelajaran::get();
      return view('content.guru.laporan.penilaian.index', compact('daftar_mata_pelajaran','title','laporan'));
 
    }

    public function adab (Request $req, $id_laporan){
      $title="Daftar Penilaian Pembiasaan Adab";
      $murid = Murid::find($req->id_murid);
      if (!$murid) {
        $murid = Murid::first();
      }
      $laporan = Laporan::findOrFail($id_laporan); 
      $daftar_murid = Murid::orderBy("nama","asc")->pluck('nama','id');
     
        $daftar_penilaian_adab = PenilaianAdab::
                  where('laporan_id',$laporan->id)->get();
 
        if ($req->rating){
        $daftar_rating = collect(); 
        foreach($req->rating as $key=>$value){
          $daftar_rating->push([
            'murid_id'=>$murid->id, 
            'penilaian_adab_id' => $daftar_penilaian_adab[$key]->id,
            'rating'=> $value
          ]); 
        }
        RatingAdab::upsert($daftar_rating->toArray(), ['murid_id', 'penilaian_adab_id'], ['rating']);
      } 


       $daftar_rating = RatingAdab::whereIn('penilaian_adab_id',$daftar_penilaian_adab->pluck('id'))->where('murid_id',$murid->id)
                                  ->get();
         
      if ($req->deskripsinya){
        $detil_laporan = DetilLaporan::updateOrCreate(
                              ['laporan_id' =>  $laporan->id,
                              'murid_id' => $murid->id,
                              'matapelajaran_id' => null,
                              'jenis' => 'adab'],
                              ['deskripsi'=>$req->deskripsinya]
                          );
        } else {
          $detil_laporan = DetilLaporan::firstOrCreate(
            ['laporan_id' =>  $laporan->id,
            'murid_id' => $murid->id,
            'jenis' => 'adab',
            'matapelajaran_id' => null,
            ],
            []
        );
  
        }

        return view('content.guru.laporan.penilaian.adab', 
      compact( 'title','laporan','daftar_murid','murid','detil_laporan','daftar_penilaian_adab','daftar_rating'));

    }

    public function opening (Request $req, $id_laporan){
      $title="Daftar Penilaian";
      $murid = Murid::find($req->id_murid);
      if (!$murid) {
        $murid = Murid::first();
      }
      $laporan = Laporan::findOrFail($id_laporan); 
      $daftar_murid = Murid::orderBy("nama","asc")->pluck('nama','id');

      if ($req->deskripsinya){
        $detil_laporan = DetilLaporan::updateOrCreate(
                              ['laporan_id' =>  $laporan->id,
                              'murid_id' => $murid->id,
                              'matapelajaran_id' => null,
                              'jenis' => 'opening'],
                              ['deskripsi'=>$req->deskripsinya]
                          );
        } else {
          $detil_laporan = DetilLaporan::firstOrCreate(
            ['laporan_id' =>  $laporan->id,
            'murid_id' => $murid->id,
            'matapelajaran_id' => null,
            ],
            ['jenis' => 'opening']
        );
  
        }

        return view('content.guru.laporan.penilaian.opening', 
      compact( 'title','laporan','daftar_murid','murid','detil_laporan'));

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
      
      if ($req->deskripsinya){
      $detil_laporan = DetilLaporan::updateOrCreate(
                            ['laporan_id' =>  $laporan->id,
                            'murid_id' => $murid->id,
                            'matapelajaran_id' => $mata_pelajaran->id,
                            'jenis' => 'mapel'],
                            ['deskripsi'=>$req->deskripsinya]
                        );
      } else {
        $detil_laporan = DetilLaporan::firstOrCreate(
          ['laporan_id' =>  $laporan->id,
          'murid_id' => $murid->id,
          'matapelajaran_id' => $mata_pelajaran->id,
          ],
          ['jenis' => 'mapel']
      );

      }
      
      $judul_grafik = "Grafik Perkembangan ".$mata_pelajaran->nama; 
 
      return view('content.guru.laporan.penilaian.rating', 
      compact('mata_pelajaran','title','laporan','daftar_murid','murid','data','judul_grafik','daftar_materi','detil_laporan'));
 
    }
 
}
