        @extends('layouts.master')

        @section('content')
        @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
        @endif
        @if(session()->has('message_delete'))
        <div class="alert alert-danger">
            {{ session()->get('message_delete') }}
        </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Data Pasien</h3>
                    </div>
                    <div> 
                        <a type="button" class="btn btn-success btn-sm" style="float: left;margin:20px;" href="/RegistrasiPasien">
                            <i class="fa fa-plus"></i> Tambah Data Pasien
                        </a>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <table id="data-pasien" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Rekam Medis</th>
                                            <th>Nama</th>
                                            <th>Umur</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Alamat</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($DataPasien as $index => $dps)
                                        <tr>
                                            <td>{{$index +1}}</td>
                                            <td>{{$dps->no_rekam_medis}}</td>
                                            <td>{{$dps->nama_pasien}}</td>
                                            <td>{{$dps->umur}} Tahun</td>
                                            <td>{{Carbon\Carbon::parse($dps->tanggal_lahir)->formatLocalized('%d %B %Y')}}</td>
                                            <td>{{$dps->alamat}}</td>
                                            @if($dps->jenis_kelamin == 1)
                                            <td>
                                                <span style="text-transform: capitalize;" class="badge badge-primary">Pria
                                                </span>
                                            </td>
                                            @elseif($dps->jenis_kelamin == 2)
                                            <td>
                                                <span style="text-transform: capitalize;" class="badge badge-pink">Wanita
                                                </span>
                                            </td>
                                            @endif
                                            <td>
                                                <a href="/dataPegawai/cetak/{{ $dps->id_pasien }}" class="btn btn-warning btn-sm">Cetak Kartu Pasien</a>

                                                <a href="/dataPasien/delete/{{ $dps->id_pasien }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus data ini?')">Delete</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> 
    </div>
</div>
<!-- /.modal -->
<!-- End Row -->
@endsection