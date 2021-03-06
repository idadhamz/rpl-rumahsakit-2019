<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Input;
// use Request;
use Auth;

use App\Models\pegawai;
use App\Models\m_pasien;
use App\Models\m_poli;
use App\Models\registrasi_pasien;
use App\Models\vw_jadwal_dokter;
use App\Models\vw_dokter;
use App\Models\vw_pemeriksaan;

class PetugasPendaftaranController extends Controller
{
    // Data Jabatan
    public function index_pasien()
    {

        // $dokter = request('id_poli');
        // var_dump($dokter);

        // get data
        // $id_poli = Request::input('id_poli');

        $DataPasien = m_pasien::orderBy("created_at", "desc")->get();
        $DataPoli = m_poli::orderBy("nama_poli", "asc")->get();
        $DataDokter = vw_dokter::get();
 
        // mengirim data jabatan ke view index
        // return view('admin.DataPegawai.index',['jabatan' => $DataPegawai]);
        return view('petugas.petugasPendaftaran.dataPasien.index', compact('DataPasien','DataPoli','DataDokter'));
 
    }

    // Data Jabatan
    public function index_pasien_lama()
    {

        // $dokter = request('id_poli');
        // var_dump($dokter);

        // get data
        // $id_poli = Request::input('id_poli');

        $DataPasien = m_pasien::orderBy("nama_pasien", "asc")->get();
        $DataPoli = m_poli::orderBy("nama_poli", "asc")->get();
        $DataDokter = vw_dokter::get();
 
        // mengirim data jabatan ke view index
        // return view('admin.DataPegawai.index',['jabatan' => $DataPegawai]);
        return view('petugas.petugasPendaftaran.dataPasien.index_lama', compact('DataPasien','DataPoli','DataDokter'));
 
    }

    public function create_pasien(Request $request)
    {

        // $DataJabatan = m_pegawai::create([
        //     'id_jab' => $id_jab,
        //     'jabatan' => $request->jabatan,
        // ]);

        $prefix = 'PS';
        $get_last_kode = m_pasien::orderBy('id_pasien','desc')->first();
        $last_kode = ($get_last_kode) ? (int) substr($get_last_kode->id_pasien, strlen($prefix), 2)+1 : 1;
        $digit = 2;
        $id_pasien = $prefix.str_repeat("0", $digit-strlen($last_kode)).$last_kode;


        $rules = [
            'nama_pasien' => 'required',
            'tanggal_lahir' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
            'keluhan' => 'required',
        ];

        $validasi = [
            'nama_pasien.required' => 'Nama Pasien harus diisi!',
            'tanggal_lahir.required'  => 'Tanggal Lahir harus diisi!',
            'no_telp.required' => 'No Telp harus diisi!',
            'alamat.required'  => 'Alamat harus diisi!',
            'keluhan.required'  => 'Keluhan Pasien harus diisi!',
         ];

        $this->validate($request, $rules, $validasi);

        // $this->validate($request);
        $DataPasien = new m_pasien;
        $DataPasien->id_pasien = $id_pasien;
        $DataPasien->no_rekam_medis = Str::random(8);
        $DataPasien->nama_pasien = request('nama_pasien');
        // $DataPasien->id_jab = 1;
        $DataPasien->alamat = request('alamat');
        $DataPasien->tanggal_lahir = request('tanggal_lahir');
        $DataPasien->umur = request('umur');
        $DataPasien->jenis_kelamin = request('jenis_kelamin');
        $DataPasien->no_telp = request('no_telp');
        // if(request('role') == '2'){
        //     $DataPegawai->id_poli = request('id_poli');
        // } else {
        //     $DataPegawai->id_poli = null;
        // }   
        $DataPasien->created_at = now();
        $DataPasien->save();

        $prefix = 'RG';
        $get_last_kode = registrasi_pasien::orderBy('id_registrasi','desc')->first();
        $last_kode = ($get_last_kode) ? (int) substr($get_last_kode->id_registrasi, strlen($prefix), 2)+1 : 1;
        $digit = 2;
        $id_registrasi = $prefix.str_repeat("0", $digit-strlen($last_kode)).$last_kode;

        $DataRegistrasiPasien = new registrasi_pasien;
        $DataRegistrasiPasien->id_pasien = $DataPasien->id_pasien;
        $DataRegistrasiPasien->id_registrasi = $id_registrasi;
        $DataRegistrasiPasien->kode_user = Auth::user()->kode_user;
        $DataRegistrasiPasien->id_poli = request('id_poli');
        $DataRegistrasiPasien->tanggal_registrasi = now();
        $DataRegistrasiPasien->jam_registrasi = now();
        $DataRegistrasiPasien->keluhan = request('keluhan');
        $DataRegistrasiPasien->biaya_registrasi = request('biaya_registrasi');
        $DataRegistrasiPasien->status = 0;
        $DataRegistrasiPasien->created_at = now();
        $DataRegistrasiPasien->save();

        // dd($DataJabatan);

        return redirect('/dataPasienPendaftaran')->with('message', 'Data Berhasil diinput!');
    }

    public function create_pasien_lama(Request $request)
    {

        // $DataJabatan = m_pegawai::create([
        //     'id_jab' => $id_jab,
        //     'jabatan' => $request->jabatan,
        // ]);


        $rules = [
            'keluhan' => 'required',
        ];

        $validasi = [
            'keluhan.required'  => 'Keluhan Pasien harus diisi!',
         ];

        $this->validate($request, $rules, $validasi);

        $prefix = 'RG';
        $get_last_kode = registrasi_pasien::orderBy('id_registrasi','desc')->first();
        $last_kode = ($get_last_kode) ? (int) substr($get_last_kode->id_registrasi, strlen($prefix), 2)+1 : 1;
        $digit = 2;
        $id_registrasi = $prefix.str_repeat("0", $digit-strlen($last_kode)).$last_kode;

        $DataRegistrasiPasien = new registrasi_pasien;
        $DataRegistrasiPasien->id_pasien = request('id_pasien');
        $DataRegistrasiPasien->id_registrasi = $id_registrasi;
        $DataRegistrasiPasien->kode_user = Auth::user()->kode_user;
        $DataRegistrasiPasien->id_poli = request('id_poli');
        $DataRegistrasiPasien->tanggal_registrasi = now();
        $DataRegistrasiPasien->jam_registrasi = now();
        $DataRegistrasiPasien->keluhan = request('keluhan');
        $DataRegistrasiPasien->biaya_registrasi = request('biaya_registrasi');
        $DataRegistrasiPasien->status = 0;
        $DataRegistrasiPasien->created_at = now();
        $DataRegistrasiPasien->save();

        // dd($DataJabatan);

        return redirect('/dataTujuanPoliklinik')->with('message', 'Data Berhasil diinput!');
    }   

    public function delete_pasien($id_pasien)
    {
        // menghapus data jabatan berdasarkan id yang dipilih
        m_pasien::where('id_pasien' ,$id_pasien)->delete();
            
        // alihkan halaman ke halaman jabatan
        return redirect('/RegistrasiPasien')->with('message_delete', 'Data Berhasil dihapus!');
    }

    public function index_data_pasien()
    {

        // get data
        $DataPasien = m_pasien::orderBy('created_at', 'asc')->get();
 
        // mengirim data jabatan ke view index
        // return view('admin.DataPegawai.index',['jabatan' => $DataPegawai]);
        return view('petugas.petugasPendaftaran.dataPasien.view', compact('DataPasien'));
 
    }

    public function cetak_data_pasien($id_pasien)
    {

        // get data
        $DataPasien = m_pasien::where('id_pasien', $id_pasien)->get();
 
        // mengirim data jabatan ke view index
        // return view('admin.DataPegawai.index',['jabatan' => $DataPegawai]);
        return view('petugas.petugasPendaftaran.dataPasien.kartu_pasien', compact('DataPasien'));
 
    }

    public function index_data_tujuan()
    {

        // get data
        $DataTujuan = vw_pemeriksaan::get();
 
        // mengirim data jabatan ke view index
        // return view('admin.DataPegawai.index',['jabatan' => $DataPegawai]);
        return view('petugas.petugasPendaftaran.dataPasien.view_tujuan', compact('DataTujuan'));
 
    }

    public function edit_data_pasien($id_pasien)
    {

        $DataPasien = m_pasien::where('id_pasien', $id_pasien)->get();
        $DataRegistrasi = registrasi_pasien::where('id_pasien', $id_pasien)->get();
        $DataPoli = m_poli::orderBy("nama_poli", "asc")->get();
        // passing data jabatan yang didapat ke view edit.blade.php
        return view('petugas.petugasPendaftaran.dataPasien.edit', compact('DataPasien','DataRegistrasi','DataPoli'));
 
    }

    public function update_data_pasien(Request $request)
    {

        m_pasien::where('id_pasien', $request->id_pasien)->update([
            'nama_pasien' => $request->nama_pasien,
            'tanggal_lahir' => $request->tanggal_lahir,
            'umur' => $request->umur,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'updated_at' => now()
        ]);

        return redirect('/dataPasienPendaftaran')->with('message', 'Data Berhasil diubah!');
 
    }

    public function edit_data_tujuan($id_pasien)
    {

        $DataPasien = m_pasien::where('id_pasien', $id_pasien)->get();
        $DataRegistrasi = registrasi_pasien::where('id_pasien', $id_pasien)->get();
        $DataPoli = m_poli::orderBy("nama_poli", "asc")->get();
        // passing data jabatan yang didapat ke view edit.blade.php
        return view('petugas.petugasPendaftaran.dataPasien.edit_tujuan', compact('DataPasien','DataRegistrasi','DataPoli'));
 
    }

    public function update_data_tujuan(Request $request)
    {

        m_pasien::where('id_pasien', $request->id_pasien)->update([
            'nama_pasien' => $request->nama_pasien,
            'tanggal_lahir' => $request->tanggal_lahir,
            'umur' => $request->umur,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'updated_at' => now()
        ]);

        registrasi_pasien::where('id_pasien', $request->id_pasien)->update([
            'id_poli' => $request->id_poli,
            'keluhan' => $request->keluhan,
            'biaya_registrasi' => $request->biaya_registrasi,
            'updated_at' => now()
        ]);

        return redirect('/dataTujuanPoliklinik')->with('message', 'Data Berhasil diubah!');
 
    }

    // Data Jadwal Dokter
    public function index_jadwal_dokter()
    {

        // get data
        $DataJadwalDokter = vw_jadwal_dokter::orderBy('hari', 'asc')->get();
 
        // mengirim data jabatan ke view index
        // return view('admin.DataPegawai.index',['jabatan' => $DataPegawai]);
        return view('petugas.petugasPendaftaran.dataJadwalDokter.index', compact('DataJadwalDokter'));
 
    }

    public function view_jadwal_dokter(Request $request)
    {
        if(request('nama_dokter') == null ){
            $hari = request('hari');
            $DataJadwalDokter = vw_jadwal_dokter::where('hari', $hari)->get();
        } 
        if(request('hari') == null ){
            $nama_dokter = request('nama_dokter');
            $DataJadwalDokter = vw_jadwal_dokter::where('nama_pegawai', 'like', '%' . $nama_dokter . '%')->get();
        }
 
        // mengirim data jabatan ke view index
        // return view('admin.DataPegawai.index',['jabatan' => $DataPegawai]);
        return view('petugas.petugasPendaftaran.dataJadwalDokter.view', compact('DataJadwalDokter'));
 
    }
}
