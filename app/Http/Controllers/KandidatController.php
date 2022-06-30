<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use Illuminate\Http\Request;
use App\Exports\KandidatExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class KandidatController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$kandidat = DB::table('kandidat')->get();
		$periode = DB::table('periode')->first();
		return view('dashboard.kandidat.kandidat', [
			'kandidat' => $kandidat,
			'periode' => $periode
		]);
	}

	public function tambah()
	{
		$periode = DB::table('periode')->first();
		return view('dashboard.kandidat.tambahkandidat', ['periode' => $periode]);
	}

	public function store(Request $data)
	{
		$file = $data->file('gambar');
		$oriname = $data->file('gambar')->getClientOriginalName();
		$nama_file = time() . "_" . $oriname;

		$tujuan = 'foto_kandidat/';
		$file->move($tujuan, $nama_file);

		// insert ke database
		DB::table('kandidat')->insert([
			'nama'    => $data->nama,
			'visi'    => $data->visi,
			'misi'    => $data->misi,
			'periode' => 1,
			'foto'    => $nama_file,
			'jumlahsuara' => 0
		]);
		return redirect('/admin/kandidat');
	}

	public function detail($id)
	{
		$periode = DB::table('periode')->first();
		$detailkandidat = Kandidat::find($id);
		return view('dashboard.kandidat.kandidatdetail', [
			'detailkandidat' => $detailkandidat,
			'periode' => $periode
		]);
	}

	public function edit($id)
	{
		$periode = DB::table('periode')->first();
		$edit = Kandidat::find($id);
		return view('dashboard.kandidat.editkandidat', [
			'edit' => $edit,
			'periode' => $periode
		]);
	}

	public function update($id, Request $data)
	{
		$edit = Kandidat::find($id);
		$edit->nama = $data->nama;
		$edit->visi = $data->visi;
		$edit->misi = $data->misi;
		
		$file = $data->file('gambar');
		if ($file != NULL) {
			$oriname = $data->file('gambar')->getClientOriginalName();
			$nama_file = time() . "_" . $oriname;
			$tujuan = 'foto_kandidat/';
			$file->move($tujuan, $nama_file);
			$edit->foto = $nama_file;
		}

		$edit->save();
		return redirect('/admin/kandidat/detail/' . $id);
	}

	public function hapus($id)
	{
		$kandidat = Kandidat::find($id);
		$kandidat->delete();
		return redirect('/admin/kandidat');
	}

	public function export_excel()
	{
		return Excel::download(new KandidatExport, 'hasil.xlsx');
	}
}
