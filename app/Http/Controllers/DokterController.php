<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Auth;

use App\Models\vw_pemeriksaan;
use App\Models\hasil_pemeriksaan;
use App\Models\rawat_inap;
use App\Models\rawat_jalan;
use App\Models\registrasi_pasien;

use App\Models\surat;

use App\Models\m_ruang;
use App\Models\m_obat;

class DokterController extends Controller
{

    // Rujukan
    public function buat_rujukan($id_hasil_pemeriksaan)
    {
        $dataHasilPemeriksaan = hasil_pemeriksaan::where('id_hasil_pemeriksaan', $id_hasil_pemeriksaan)->get();
        // passing data jabatan yang didapat ke view edit.blade.php
        return view('dokter.dataPemeriksaan.buatRujukan', compact('dataHasilPemeriksaan'));
    }

    public function create_rujukan(Request $request)
    {

        $prefix = 'SR';
        $get_last_kode = surat::orderBy('id_surat','desc')->first();
        $last_kode = ($get_last_kode) ? (int) substr($get_last_kode->id_surat, strlen($prefix), 2)+1 : 1;
        $digit = 2;
        $id_surat = $prefix.str_repeat("0", $digit-strlen($last_kode)).$last_kode;

        $rules = [
            'jenis' => 'required',
        ];

        $validasi = [
            'jenis.required'  => 'Jenis Surat harus diisi!',
        ];

        $this->validate($request, $rules, $validasi);

        $prefix = '00';
        $get_last_kode = surat::orderBy('no_surat','desc')->first();
        $last_kode = ($get_last_kode) ? (int) substr($get_last_kode->no_surat, strlen($prefix), 2)+1 : 1;
        $digit = 2;
        $no_surat = $prefix.str_repeat("0", $digit-strlen($last_kode)).$last_kode;

        $DataSuratRujukan = new surat;
        $DataSuratRujukan->id_surat = $id_surat;
        $DataSuratRujukan->id_hasil_pemeriksaan = request('id_hasil_pemeriksaan');
        $DataSuratRujukan->no_surat = $no_surat;
        $DataSuratRujukan->tanggal = now();
        $DataSuratRujukan->jenis = request('jenis');
        $DataSuratRujukan->created_at = now();
        $DataSuratRujukan->save();

        hasil_pemeriksaan::where('id_hasil_pemeriksaan', request('id_hasil_pemeriksaan'))->update([
            'id_surat' => $id_surat
        ]);

        return redirect('/hasilPemeriksaanPasien')->with('message', 'Data rujukan berhasil diinput!');

    }

    public function ubah_rujukan($id_hasil_pemeriksaan)
    {
        $dataSurat = surat::where('id_hasil_pemeriksaan', $id_hasil_pemeriksaan)->get();

        // passing data jabatan yang didapat ke view edit.blade.php
        return view('dokter.dataPemeriksaan.editRujukan', compact('dataSurat'));
    }

    public function update_rujukan(Request $request)
    {

        surat::where('id_hasil_pemeriksaan', $request->id_hasil_pemeriksaan)->update([
            'tanggal' => now(),
            'jenis' => $request->jenis,
            'updated_at' => now()
        ]);

        return redirect('/hasilPemeriksaanPasien')->with('message', 'Data rujukan berhasil diubah!');
    }

    // Data Pemeriksaan
    public function index_hasil_pemeriksaan()
    {

        // $dokter = request('id_poli');
        // var_dump($dokter);

        // get data
        $tujuan_poli = Auth::user()->id_poli;
        // $DataPasien = vw_pemeriksaan::where('id_poli', $tujuan_poli)->orderBy("jam_registrasi", "asc")->orderBy("status", "asc")->get();

        $DataHasilPemeriksaan = DB::table('hasil_pemeriksaan')
            ->join('vw_pemeriksaan', 'hasil_pemeriksaan.id_registrasi', '=', 'vw_pemeriksaan.id_registrasi')
            ->select('hasil_pemeriksaan.*', 'vw_pemeriksaan.*')
            ->where('vw_pemeriksaan.id_poli', $tujuan_poli)
            ->where('vw_pemeriksaan.status', 1)
            ->orderBy('hasil_pemeriksaan.tanggal_waktu', 'asc')
            ->get();
 
        // mengirim data jabatan ke view index
        // return view('admin.DataPegawai.index',['jabatan' => $DataPegawai]);
        return view('dokter.dataPemeriksaan.hasilPemeriksaan', compact('DataHasilPemeriksaan'));
 
    }

    // Data Pemeriksaan
    public function index_pemeriksaan()
    {

        // $dokter = request('id_poli');
        // var_dump($dokter);

        // get data
        $tujuan_poli = Auth::user()->id_poli;
        $DataPasien = vw_pemeriksaan::where('id_poli', $tujuan_poli)->where('status', 0)->orderBy("jam_registrasi", "asc")->orderBy("status", "asc")->get();

        // $DataPasien = DB::table('vw_pemeriksaan')
        //     ->join('hasil_pemeriksaan', 'vw_pemeriksaan.id_registrasi', '=', 'hasil_pemeriksaan.id_registrasi')
        //     ->select('vw_pemeriksaan.*', 'hasil_pemeriksaan.id_hasil_pemeriksaan')
        //     ->where('vw_pemeriksaan.id_poli', $tujuan_poli)
        //     ->orderBy('vw_pemeriksaan.jam_registrasi', 'asc')
        //     ->orderBy('vw_pemeriksaan.status', 'asc')
        //     ->get();
 
        // mengirim data jabatan ke view index
        // return view('admin.DataPegawai.index',['jabatan' => $DataPegawai]);
        return view('dokter.dataPemeriksaan.index', compact('DataPasien'));
 
    }

    public function buat_pemeriksaan($id_registrasi)
    {
        $dataPemeriksaan = vw_pemeriksaan::where('id_registrasi', $id_registrasi)->get();
        $dataRuang = m_ruang::where('kuota', '>', 0)->get();
        $dataObat = m_obat::get();
        // passing data jabatan yang didapat ke view edit.blade.php
        return view('dokter.dataPemeriksaan.pemeriksaan', compact('dataPemeriksaan', 'dataObat', 'dataRuang'));
    }

    public function ubah_pemeriksaan($id_registrasi)
    {
        $dataHasilPemeriksaan = hasil_pemeriksaan::where('id_registrasi', $id_registrasi)->get();
        $dataRawatInap = rawat_inap::where('id_registrasi', $id_registrasi)->get();
        $dataRawatJalan = rawat_jalan::where('id_registrasi', $id_registrasi)->get();
        // passing data jabatan yang didapat ke view edit.blade.php
        return view('dokter.dataPemeriksaan.editPemeriksaan', compact('dataHasilPemeriksaan','dataRawatInap','dataRawatJalan'));
    }

    public function update_pemeriksaan(Request $request)
    {

        hasil_pemeriksaan::where('id_registrasi', $request->id_registrasi)->update([
            'diagnosis' => $request->diagnosis,
            'anamnesis' => $request->anamnesis,
            'pemeriksaan_fisik' => $request->pemeriksaan_fisik,
            'tindakan' => $request->tindakan,
            'biaya' => $request->biaya,
            'jenis_perawatan' => $request->jenis_perawatan,
            'medis_penunjang' => $request->medis_penunjang,
            'updated_at' => now()
        ]);

        // if(request('jenis') == '1'){
        //     rawat_inap::where('id_registrasi', $request->id_registrasi)->update([
        //         'tanggal_masuk' => $request->tanggal_masuk,
        //         'tanggal_keluar' => $request->tanggal_keluar,
        //         'hari' => $request->hari,
        //         'biaya_rawat_inap' => $request->biaya_rawat_inap,
        //         'total_biaya_rawat_inap' => $request->total_biaya_rawat_inap,
        //         'ruang' => $request->ruang,
        //         'updated_at' => now()
        //     ]);
        // } else {
        //     rawat_jalan::where('id_registrasi', $request->id_registrasi)->update([
        //         'tanggal' => now(),
        //         'durasi' => $request->durasi,
        //         'updated_at' => now()
        //     ]);
        // }

        return redirect('/pemeriksaanPasien')->with('message', 'Data pemeriksaan berhasil diubah!');
    }

    public function create_pemeriksaan(Request $request)
    {

        $prefix = 'HP';
        $get_last_kode = hasil_pemeriksaan::orderBy('id_hasil_pemeriksaan','desc')->first();
        $last_kode = ($get_last_kode) ? (int) substr($get_last_kode->id_hasil_pemeriksaan, strlen($prefix), 2)+1 : 1;
        $digit = 2;
        $id_hasil_pemeriksaan = $prefix.str_repeat("0", $digit-strlen($last_kode)).$last_kode;

        $rules = [
            'diagnosis' => 'required',
            'anamnesis' => 'required',
            'pemeriksaan_fisik' => 'required',
            'tindakan' => 'required',
            'biaya' => 'required',
        ];

        $validasi = [
            'diagnosis.required' => 'Diagnosis Pasien harus diisi!',
            'anamnesis.required'  => 'Anamnesis Pasien harus diisi!',
            'pemeriksaan_fisik.required' => 'Pemeriksaan Fisik Pasien harus diisi!',
            'tindakan.required'  => 'Tindakan Pasien harus diisi!',
            'biaya.required'  => 'Biaya harus diisi!',
         ];

        $this->validate($request, $rules, $validasi);

        $DataPemeriksaan = new hasil_pemeriksaan;
        $DataPemeriksaan->id_hasil_pemeriksaan = $id_hasil_pemeriksaan;
        $DataPemeriksaan->id_registrasi = request('id_registrasi');
        $DataPemeriksaan->tanggal_waktu = date("Y-m-d H:i:s");
        $DataPemeriksaan->biaya = request('biaya');
        $DataPemeriksaan->jenis_perawatan = request('jenis_perawatan');
        $DataPemeriksaan->diagnosis = request('diagnosis');
        $DataPemeriksaan->anamnesis = request('anamnesis');
        $DataPemeriksaan->pemeriksaan_fisik = request('pemeriksaan_fisik');
        $DataPemeriksaan->tindakan = request('tindakan');
        $DataPemeriksaan->medis_penunjang = request('medis_penunjang');
        // if($request->get('medis_penunjang') == null){
        //   $DataPemeriksaan->medis_penunjang = 0;
        // } else {
        //   $DataPemeriksaan->medis_penunjang = request('medis_penunjang');
        // }
        $DataPemeriksaan->status = 0;
        $DataPemeriksaan->created_at = now();
        $DataPemeriksaan->save();

        // $prefix = 'RI';
        // $get_last_kode = rawat_inap::orderBy('id','desc')->first();
        // $last_kode = ($get_last_kode) ? (int) substr($get_last_kode->id, strlen($prefix), 2)+1 : 1;
        // $digit = 2;
        // $id_rawat_inap = $prefix.str_repeat("0", $digit-strlen($last_kode)).$last_kode;

        // $prefix = 'RJ';
        // $get_last_kode = rawat_jalan::orderBy('id','desc')->first();
        // $last_kode = ($get_last_kode) ? (int) substr($get_last_kode->id, strlen($prefix), 2)+1 : 1;
        // $digit = 2;
        // $id_rawat_jalan = $prefix.str_repeat("0", $digit-strlen($last_kode)).$last_kode;

        // if(request('jenis') == '1'){
        //     $RawatInap = new rawat_inap;
        //     $RawatInap->id_rawat_inap = $id_rawat_inap;
        //     $RawatInap->id_registrasi = request('id_registrasi');
        //     $RawatInap->id_hasil_pemeriksaan = $id_hasil_pemeriksaan;
        //     $RawatInap->tanggal_masuk = request('tanggal_masuk');
        //     $RawatInap->tanggal_keluar = request('tanggal_keluar');
        //     $RawatInap->hari = request('hari');
        //     $RawatInap->biaya_rawat_inap = request('biaya_rawat_inap');
        //     $RawatInap->total_biaya_rawat_inap = request('total_biaya_rawat_inap');
        //     $RawatInap->ruang = request('id_ruang');
        //     $RawatInap->created_at = now();
        //     $RawatInap->save();
        // } else {
        //     $RawatJalan = new rawat_jalan;
        //     $RawatJalan->id_rawat_jalan = $id_rawat_jalan;
        //     $RawatJalan->id_registrasi = request('id_registrasi');
        //     $RawatJalan->id_hasil_pemeriksaan = $id_hasil_pemeriksaan;
        //     $RawatJalan->tanggal = now();
        //     $RawatJalan->durasi = request('durasi');
        //     $RawatJalan->created_at = now();
        //     $RawatJalan->save();
        // }

        registrasi_pasien::where('id_registrasi', request('id_registrasi'))->update([
            'status' => 1
        ]);

        // m_ruang::where('id_ruang', request('id_ruang'))->update([
        //     'status' => 1
        // ]);

        return redirect('/hasilPemeriksaanPasien')->with('message', 'Data pemeriksaan berhasil diinput!');

    }

    public function delete_pemeriksaan($id_registrasi)
    {
        // menghapus data jabatan berdasarkan id yang dipilih
        hasil_pemeriksaan::where('id_registrasi', $id_registrasi)->delete();
        // rawat_inap::where('id_registrasi', $id_registrasi)->delete();
        // rawat_jalan::where('id_registrasi', $id_registrasi)->delete();

        registrasi_pasien::where('id_registrasi', $id_registrasi)->update([
            'status' => 0
        ]);
            
        // alihkan halaman ke halaman jabatan
        return redirect('/pemeriksaanPasien')->with('message_delete', 'Data pemeriksaan berhasil direset!');
    }

    // Data Pemeriksaan Penunjang
    public function index_pemeriksaan_penunjang()
    {

        // $dokter = request('id_poli');
        // var_dump($dokter);

        // get data
        $tujuan_poli = Auth::user()->id_poli;
        // $DataMedisPenunjang = hasil_pemeriksaan::where('medis_penunjang', 1)->orderBy("tanggal_waktu", "asc")->get();
        $DataMedisPenunjang = DB::table('hasil_pemeriksaan')
            ->join('vw_pemeriksaan', 'hasil_pemeriksaan.id_registrasi', '=', 'vw_pemeriksaan.id_registrasi')
            ->select('hasil_pemeriksaan.*', 'vw_pemeriksaan.*')
            ->where('hasil_pemeriksaan.medis_penunjang', 1)
            ->where('vw_pemeriksaan.id_poli', $tujuan_poli)
            ->orderBy('hasil_pemeriksaan.tanggal_waktu', 'asc')
            ->get();
 
        // mengirim data jabatan ke view index
        // return view('admin.DataPegawai.index',['jabatan' => $DataPegawai]);
        return view('dokter.dataPemeriksaanPenunjang.index', compact('DataMedisPenunjang'));
 
    }
}
