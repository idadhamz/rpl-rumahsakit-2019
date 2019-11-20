<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Input;

use App\Models\vw_pemeriksaan;
use App\Models\hasil_pemeriksaan;
use App\Models\m_ruang;
use App\Models\rawat_inap;

class PetugasPerawatanController extends Controller
{
    // Data Jabatan
    public function index_rawat()
    {

        // get data
        $DataRawat = DB::table('hasil_pemeriksaan')
            ->join('vw_pemeriksaan', 'hasil_pemeriksaan.id_registrasi', '=', 'vw_pemeriksaan.id_registrasi')
            ->select('hasil_pemeriksaan.*', 'vw_pemeriksaan.*')
            ->where('hasil_pemeriksaan.jenis_perawatan', 1)
            ->orderBy('hasil_pemeriksaan.created_at', 'asc')
            ->get();
 
        // mengirim data jabatan ke view index
        // return view('admin.DataPegawai.index',['jabatan' => $DataPegawai]);
        return view('petugas.petugasRawatInap.perawatanRawatInap.view', compact('DataRawat'));
 
    }

    public function edit_rawat($id_hasil_pemeriksaan){
        $dataHasilPemeriksaanRuangan = hasil_pemeriksaan::where('id_hasil_pemeriksaan', $id_hasil_pemeriksaan)->get();
        $dataRuang = m_ruang::where('status', 0)->get();
        // passing data jabatan yang didapat ke view edit.blade.php
        return view('petugas.petugasRawatInap.perawatanRawatInap.cariRuangan', compact('dataHasilPemeriksaanRuangan', 'dataRuang'));
    }

    public function create_rawat()
    {

        // $prefix = 'HP';
        // $get_last_kode = hasil_pemeriksaan::orderBy('id_hasil_pemeriksaan','desc')->first();
        // $last_kode = ($get_last_kode) ? (int) substr($get_last_kode->id_hasil_pemeriksaan, strlen($prefix), 2)+1 : 1;
        // $digit = 2;
        // $id_hasil_pemeriksaan = $prefix.str_repeat("0", $digit-strlen($last_kode)).$last_kode;

        // $DataPemeriksaan = new hasil_pemeriksaan;
        // $DataPemeriksaan->id_hasil_pemeriksaan = $id_hasil_pemeriksaan;
        // $DataPemeriksaan->id_registrasi = request('id_registrasi');
        // $DataPemeriksaan->tanggal_waktu = date("Y-m-d H:i:s");
        // $DataPemeriksaan->biaya = request('biaya');
        // $DataPemeriksaan->jenis_perawatan = request('jenis_perawatan');
        // $DataPemeriksaan->diagnosis = request('diagnosis');
        // $DataPemeriksaan->anamnesis = request('anamnesis');
        // $DataPemeriksaan->pemeriksaan_fisik = request('pemeriksaan_fisik');
        // $DataPemeriksaan->tindakan = request('tindakan');
        // $DataPemeriksaan->created_at = now();
        // $DataPemeriksaan->save();

        $prefix = 'RI';
        $get_last_kode = rawat_inap::orderBy('id','desc')->first();
        $last_kode = ($get_last_kode) ? (int) substr($get_last_kode->id, strlen($prefix), 2)+1 : 1;
        $digit = 2;
        $id_rawat_inap = $prefix.str_repeat("0", $digit-strlen($last_kode)).$last_kode;

        $RawatInap = new rawat_inap;
        $RawatInap->id_rawat_inap = $id_rawat_inap;
        $RawatInap->id_registrasi = request('id_registrasi');
        $RawatInap->id_hasil_pemeriksaan = request('id_hasil_pemeriksaan');
        $RawatInap->tanggal_masuk = request('tanggal_masuk');
        $RawatInap->tanggal_keluar = request('tanggal_keluar');
        $RawatInap->hari = request('hari');
        $RawatInap->biaya_rawat_inap = request('biaya_rawat_inap');
        $RawatInap->total_biaya_rawat_inap = request('total_biaya_rawat_inap');
        $RawatInap->ruang = request('id_ruang');
        $RawatInap->created_at = now();
        $RawatInap->save();

        // $prefix = 'RJ';
        // $get_last_kode = rawat_jalan::orderBy('id','desc')->first();
        // $last_kode = ($get_last_kode) ? (int) substr($get_last_kode->id, strlen($prefix), 2)+1 : 1;
        // $digit = 2;
        // $id_rawat_jalan = $prefix.str_repeat("0", $digit-strlen($last_kode)).$last_kode;

        // if(request('jenis') == '1'){

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

        // registrasi_pasien::where('id_registrasi', request('id_registrasi'))->update([
        //     'status' => 1
        // ]);

        m_ruang::where('id_ruang', request('id_ruang'))->update([
            'status' => 1
        ]);

        return redirect('/perawatanRawatInap')->with('message', 'Data perawatan berhasil diinput!');

    }

    public function delete_rawat($id_hasil_pemeriksaan)
    {
        // menghapus data jabatan berdasarkan id yang dipilih
        rawat_inap::where('id_hasil_pemeriksaan', $id_hasil_pemeriksaan)->delete();
        // rawat_inap::where('id_registrasi', $id_registrasi)->delete();
        // rawat_jalan::where('id_registrasi', $id_registrasi)->delete();

        // m_ruang::where('id_ruang', request('id_ruang'))->update([
        //     'status' => 1
        // ]);
            
        // alihkan halaman ke halaman jabatan
        return redirect('/perawatanRawatInap')->with('message_delete', 'Data pemeriksaan berhasil direset!');
    }
}
