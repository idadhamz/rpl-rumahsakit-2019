        @extends('layouts.master')

        @section('content')

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Monitoring Pasien</h3>
                    </div>
                    <!-- <div> 
                        <a type="button" class="btn btn-success btn-sm" style="float: left;margin:20px;" href="/RegistrasiPasien">
                            <i class="fa fa-plus"></i> Tambah Data Pasien
                        </a>
                    </div> -->
                    <div> 
                        <a href="/dataRawatInap" type="button" class="btn btn-success btn-sm" style="float: left;margin:20px;" data-toggle="modal">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <table class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                
                                    </thead>

                                    <tbody>
                                        @foreach($DataPasien as $index => $dps)
                                        <tr>
                                            <td width="25%;">No Rekam Medis</td>
                                            <td style="font-weight: bold;text-transform: uppercase;">{{$dps->no_rekam_medis}}</td>
                                        </tr>
                                        <tr>
                                            <td width="25%;">Nama</td>
                                            <td style="font-weight: bold;text-transform: capitalize;">{{$dps->nama_pasien}}</td>
                                        </tr>
                                        <tr>
                                            <td width="25%;">Tanggal Lahir</td>
                                            <td style="font-weight: bold;">{{Carbon\Carbon::parse($dps->tanggal_lahir)->formatLocalized('%d %B %Y')}}</td>
                                        </tr>
                                        <tr>
                                            <td width="25%;">Umur</td>
                                            <td style="font-weight: bold;">{{$dps->umur}} Tahun</td>
                                        </tr>
                                        <tr>
                                            <td width="25%;">Alamat</td>
                                            <td style="font-weight: bold;">{{$dps->alamat}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div> 
                        <a type="button" class="btn btn-info btn-sm" style="float: left;margin:20px;" data-toggle="modal" data-target="#tambah-monitoring">
                            <i class="fa fa-plus"></i> Tambah Monitoring
                        </a>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <table id="data-pasien" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <!-- <th style="font-weight: lighter;">No</th> -->
                                            <th style="font-weight: lighter;">Tanggal</th>
                                            <th style="font-weight: lighter;">Keluhan dan Pemeriksaan Fisik</th>
                                            <th style="font-weight: lighter;">Tanda Vital</th>
                                            <!-- <th>Tanggal Lahir</th> -->
                                            <!-- <th>Alamat</th> -->
                                            <th style="font-weight: lighter;">Pengobatan dan Tindakan</th>
                                            <th style="font-weight: lighter;">Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($DataMonitoring as $index => $dps)
                                        <tr>
                                            <!-- <td>1</td> -->
                                            <!-- <td>{{Carbon\Carbon::parse($dps->waktu)->formatLocalized('%d %B %Y')}}</td> -->
                                            <td>{{$dps->waktu}}</td>
                                            <td>{{$dps->keluhan_pasien}}</td>
                                            <td>Tensi (T) : {{$dps->tensi}}<br>Frekuensi Pernapasan (RR) : {{$dps->frekuensi_pernapasan}}<br>Denyut Nadi (N) : {{$dps->nadi}}<br>Suhu Badan (t) : {{$dps->suhu}}<br></td>
                                            <!-- <td>{{Carbon\Carbon::parse($dps->tanggal_lahir)->formatLocalized('%d %B %Y')}}</td> -->
                                            <!-- <td>{{$dps->alamat}}</td> -->
                                            <td>{{$dps->tindakan}}</td>
                                            <td>
                                                <a href="/monitoringPasien/edit/{{$dps->id}}" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Edit</a>
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

        <div id="tambah-monitoring" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tambah-monitoring" aria-hidden="true" style="display: none">
            <div class="modal-dialog modal-lg"> 
                <form action="/dataRawatInap/monitoringPasien/create" method="post" autocomplete="off">
                   {{csrf_field()}}
                <div class="modal-content"> 
                <div class="modal-header">
                    <h4 class="modal-title mt-0">Tambah Monitoring</h4>
                </div> 
                <div class="modal-body"> 
                    <div class="row"> 
                        <div class="col-md-3" style="margin-top: 5px;"> 
                            <label for="keluhan_pasien" class="control-label">Keluhan dan <br>Pemeriksaan Fisik</label>
                        </div> 
                        <div class="col-md-9"> 
                            <div class="form-group">
                                <!-- <input type="text" class="form-control" id="keluhan_pasien" name="keluhan_pasien" autocomplete="off">  -->
                                <textarea class="form-control" rows="3" id="keluhan_pasien" name="keluhan_pasien"></textarea>
                            </div> 
                        </div> 
                    </div>
                    <div class="row"> 
                        <div class="col-md-3" style="margin-top: 5px;"> 
                            <label for="tensi" class="control-label">Tensi</label>
                        </div> 
                        <div class="col-md-9"> 
                            <div class="form-group">
                                <input type="text" class="form-control" id="tensi" name="tensi" autocomplete="off"> 
                            </div> 
                        </div> 
                    </div> 
                    <div class="row"> 
                        <div class="col-md-3" style="margin-top: 5px;"> 
                            <label for="frekuensi_pernapasan" class="control-label">Frekuensi Pernapasan</label>
                        </div> 
                        <div class="col-md-9"> 
                            <div class="form-group">
                                <input type="text" class="form-control" id="frekuensi_pernapasan" name="frekuensi_pernapasan" autocomplete="off"> 
                            </div> 
                        </div> 
                    </div>
                    <div class="row"> 
                        <div class="col-md-3" style="margin-top: 5px;"> 
                            <label for="nadi" class="control-label">Denyut Nadi</label>
                        </div> 
                        <div class="col-md-9"> 
                            <div class="form-group">
                                <input type="text" class="form-control" id="nadi" name="nadi" autocomplete="off"> 
                            </div> 
                        </div> 
                    </div>
                    <div class="row"> 
                        <div class="col-md-3" style="margin-top: 5px;"> 
                            <label for="suhu" class="control-label">Suhu Badan</label>
                        </div> 
                        <div class="col-md-9"> 
                            <div class="form-group">
                                <input type="text" class="form-control" id="suhu" name="suhu" autocomplete="off"> 
                            </div> 
                        </div> 
                    </div>
                    <div class="row"> 
                        <div class="col-md-3" style="margin-top: 5px;"> 
                            <label for="tindakan" class="control-label">Pengobatan dan Tindakan</label>
                        </div> 
                        <div class="col-md-9"> 
                            <div class="form-group">
                                <!-- <input type="text" class="form-control" id="tindakan" name="tindakan" autocomplete="off">  -->
                                <textarea class="form-control" rows="3" id="tindakan" name="tindakan"></textarea>
                            </div> 
                        </div> 
                    </div>
                </div> 
                <div class="modal-footer"> 
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button> 
                    <button type="submit" class="btn btn-info waves-effect waves-light">Simpan Data</button> 
                </div> 
            </form>
        </div> 

    </div>
</div>
<!-- /.modal -->
<!-- End Row -->
@endsection