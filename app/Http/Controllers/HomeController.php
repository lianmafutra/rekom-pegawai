<?php

namespace App\Http\Controllers;

use App\Config\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    
      // $url = Config::get('global.url.bkd.pegawai');
      // $response = Http::withBasicAuth('absen', 'absen2022')->acceptJson()->get($url)->collect();
      // $pegawai = Cache::forever('pegawai', $response);
        return view('home');
    }
}
