<?php

namespace App\Http\Controllers\front_pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalonMurid;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Str;
use Validator;
use Auth;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('content.front-pages.daftar');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $rules = [
          'nama_anak' => ['required', 'string'],
          'nama_orangtua' => ['required', 'string'],
          'tgl_lahir_anak' => ['required'],
          'alamat' => ['required'],
          'nomor_hp' => ['required', 'regex:/^(^\+628\s?|^628)(\d{3,4}?){2}\d{2,4}$/','max:13']
        ];

        $messages = [
          'nama_anak.required' => 'Nama anak wajib diisi',
          'nama_orangtua.required' => 'Nama anak wajib diisi',
          'nomor_hp.required' => 'Nomor handphone wajib diisi',
          'nomor_hp.regex' => 'Format nomor handphone salah. Contoh: 6282273318016',
          'nomor_hp.max' => 'Nomor handphone maksimal 13 digit',
          'tgl_lahir_anak.required' => 'Tanggal lahir anak wajib diisi',
          'alamat.required' => 'Alamat lengkap wajib diisi'
        ];

        $validator = Validator::make($input, $rules, $messages)->validate();

        $password = Str::random(3);

        $user = User::create(
          [
            'nama' => $request->nama_orangtua,
            'username' => $request->nomor_hp,
            'email' => $request->email,
            'roles' => 'guest',
            'password' => Hash::make($password),
            'real_password' => $password,
            // 'remember' => true,
          ]
          );

        $calon_murid = CalonMurid::create(
          [
            'user_id' => $user->id,
            'nama_anak' => $request->nama_anak,
            'nama_orangtua' => $request->nama_orangtua,
            'alamat' => $request->alamat,
            'tgl_lahir_anak' => $request->tgl_lahir_anak,
            'nomor_hp' => $request->nomor_hp,
            'email' => $request->email,
          ]
          );

            $remember = $user->remember;

            if(Auth::login($user, $remember = true)){

            }

            $request->session()->regenerate();
            return redirect()->route('dashboard.calon-murid.tahap-kedua', $calon_murid->id);

            // if(Auth::attempt(['username' => $request->nomor_hp, 'password' => Hash::make($password), 'active' => 1])){
            //   $request->session()->regenerate();

            //   return redirect()->route('dashboard.calon-murid.tahap-kedua', $calon_murid->id);
            // }

          // return redirect()->route('home.terima-kasih')->with('messages', __('pesan.create', ['module' => $request->input('nama_anak')]));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
