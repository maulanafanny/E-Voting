<?php

namespace App\Http\Controllers;

use App\Models\Voters;
use App\Models\Pemilih;
use Illuminate\Http\Request;
use App\Exports\PemilihExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class VotersController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$periode = DB::table('periode')->first();
		$pemilih = DB::table('pemilih')
			->join('tbl_status', 'pemilih.status', '=', 'tbl_status.id')
			->select('pemilih.*', 'tbl_status.nama')
			->get();
		return view('dashboard/voter/voters', [
			'pemilih' => $pemilih,
			'periode' => $periode
		]);
	}

	public function tambah()
	{
		$periode = DB::table('periode')->first();
		return view('dashboard/voter/tambah', ['periode' => $periode]);
	}

	//  tampilkan menu hapus
	public function hapus()
	{
		$periode = DB::table('periode')->first();
		return view('dashboard/voter/hapus', ['periode' => $periode]);
	}
	
	public function store(Request $data)
	{
		$jumlah = $data->jumlah;
		for ($i = 0; $i < $jumlah; $i++) {
			$karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
			$string   = '';

			for ($x = 0; $x < 6; $x++) {

				$pos = rand(0, strlen($karakter) - 1);
				$string .= $karakter[$pos];
			}
			$token = strtoupper($string);

			// cek token sudah terdaftar atau belum
			$cek = Voters::find($token);

			if (empty($cek)) {
				Voters::create([
					'username' => $token,
					'periode'  => 1,
					'status'   => 2
				]);
			}
		}

		return redirect('/admin/voters');
	}

	// hapus token
	public function delete(Request $data)
	{
		$jumlah = $data->input('jumlah');
		$kriteria = $data->input('kriteria');
		if ($kriteria == 0) {
			DB::table('kandidat')->update([
				'jumlahsuara' => 0
			]);
			DB::table('pemilih')->delete();
			return redirect('/admin/voters');
		} else if ($kriteria == 1) {
			DB::table('kandidat')->update([
				'jumlahsuara' => 0
			]);
			DB::table('pemilih')->where('status', 1)->delete();
			return redirect('/admin/voters');
		} else if ($kriteria == 2) {
			DB::table('pemilih')->where('status', 2)->delete();
			return redirect('/admin/voters');
		}
	}

	public function export_excel()
	{
		return Excel::download(new PemilihExport, 'token.xlsx');
	}
}
