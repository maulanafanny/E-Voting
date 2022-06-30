<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        if (DB::table('voting_status')->first()->status == 1) {
            return view('user.index');
        } else {
            return $this->hasil();
        }
    }

    public function votinglogin()
    {
        return view('user.votinglogin');
    }

    public function cektoken(Request $data)
    {
        $token = $data->input('usertoken');

        $cek = DB::table('pemilih')->where(['username' => $token])->first();
        $status = DB::table('pemilih')->where([
            'username' => $token,
            'status' => 2
        ])->first();

        if (!$cek) {
            Session::flash('Gagal', 'Token Tidak Ditemukan');
            return redirect('/votinglogin');
        } else {
            if (!$status) {
                Session::flash('Gagal', 'Token Yang Di Input Telah Digunakan');
                return redirect('/votinglogin');
            } else {
                $data->session()->put('token', $token);
                return redirect('/voting');
            }
        }
    }

    public function ApiCektoken(Request $data)
    {
        $token = $data->usertoken;

        $cek = DB::table('pemilih')->where(['username' => $token])->first();
        $status = DB::table('pemilih')->where([
            'username' => $token,
            'status' => 2
        ])->first();

        if (!$cek) {
            return response()->json([
                'success' => '0',
                'message' => 'Token Tidak Ditemukan'
            ]);
        } else {
            if (!$status) {
                return response()->json([
                    'success' => '0',
                    'message' => 'Token Telah Digunakan'
                ]);
            } else {
                return response()->json([
                    'success' => '1',
                    'message' => 'Berhasil Masuk',
                    'token'   => $token
                ]);
            }
        }
    }

    public function hasil()
    {
        return view('user.hasil');
    }

    public function hasilvoting()
    {
        $periode = DB::table('periode')->first();
        $jumlahsuara   = DB::select('select * FROM kandidat');
        $belumvoting   = DB::select('SELECT COUNT(status) as jumlahbelumvoting from pemilih where status = 2 GROUP by status');
        $kandidat       = DB::select('SELECT COUNT(nama) as jumlah FROM kandidat');
        $jumlahhaksuara = DB::select('SELECT COUNT(username) as jumlah FROM pemilih');
        $suaramasuk     = DB::select('SELECT COUNT(username) as suaramasuk FROM pemilih WHERE status = 1');
        //dd(json_encode($daftarkandidat));
        return view('user.hasilvoting', [
            'jumlahhaksuara' => $jumlahhaksuara,
            'jumlahkandidat' => $kandidat,
            'jumlahsuara'    => $jumlahsuara,
            'belumvoting'    => $belumvoting,
            'suaramasuk'     => $suaramasuk,
            'periode' => $periode
        ]);
    }
}
