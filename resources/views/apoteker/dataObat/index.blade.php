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
                        <h3 class="panel-title">Data Obat</h3>
                    </div>
                    <div> 
                        <a type="button" class="btn btn-success btn-sm" style="float: left;margin:20px;" data-toggle="modal" data-target="#tambah-obat">
                            <i class="fa fa-plus"></i> Tambah Data Obat
                        </a>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <table id="data-obat" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <!-- <th>No</th> -->
                                            <!-- <th>Kode Obat</th> -->
                                            <th width="200px">Nama</th>
                                            <th>Harga</th>
                                            <th>Tipe</th>
                                            <th width="250px">Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($DataObat as $index => $dob)
                                        <tr>
                                            <!-- <td>{{$index +1}}</td> -->
                                            <!-- <td>{{$dob->id_obat}}</td> -->
                                            <td>{{$dob->nama_obat}}</td>
                                            <td>Rp. {{$dob->harga_obat}}</td>
                                            <td><span style="text-transform: capitalize;" class="badge badge-info">{{$dob->tipe}}</span></td>
                                            @if($dob->status_obat == 1)
                                            <td><span style="text-transform: capitalize;" class="badge badge-secondary">Obat Jamu Tradisional</span></td>
                                            @elseif($dob->status_obat == 2)
                                            <td><span style="text-transform: capitalize;" class="badge badge-primary">Obat Herbal Terstandar</span></td>
                                            @elseif($dob->status_obat == 3)
                                            <td><span style="text-transform: capitalize;" class="badge badge-success">Obat Fitofarmaka</span></td>
                                            @elseif($dob->status_obat == 4)
                                            <td><span style="text-transform: capitalize;" class="badge badge-info">Obat Bebas Umum</span></td>
                                            @elseif($dob->status_obat == 5)
                                            <td><span style="text-transform: capitalize;" class="badge badge-warning">Obat Bebas Terbatas</span></td>
                                            @elseif($dob->status_obat == 6)
                                            <td><span style="text-transform: capitalize;" class="badge badge-danger">Obat Keras</span></td>
                                            @elseif($dob->status_obat == 7)
                                            <td><span style="text-transform: capitalize;" class="badge badge-purple">Obat Narkotika</span></td>
                                            @endif
                                            <td>
                                                <a href="/dataObatApoteker/edit/{{ $dob->id_obat }}" class="btn btn-warning btn-sm">Edit</a>

                                                <a href="/dataObatApoteker/delete/{{ $dob->id_obat }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus data ini?')">Delete</a>
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

        <div id="tambah-obat" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tambah-obat" aria-hidden="true" style="display: none">
            <div class="modal-dialog"> 
                <form action="/dataObatApoteker/create" method="post" autocomplete="off">
                   {{csrf_field()}}
                   <div class="modal-content"> 
                    <div class="modal-header">
                        <h4 class="modal-title mt-0">Tambah Obat</h4>
                    </button>
                </div> 
                <div class="modal-body"> 
                    <div class="row"> 
                        <div class="col-md-3" style="margin-top: 5px;"> 
                            <label for="nama_obat" class="control-label">Nama Obat</label>
                        </div> 
                        <div class="col-md-9"> 
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="nama_obat" name="nama_obat" autocomplete="off"> 
                                    </div> 
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control" id="tipe" name="tipe">
                                        <option value="Tablet">Tablet</option>
                                        <option value="Serbuk">Serbuk</option>
                                        <option value="Pil">Pil</option>
                                        <option value="Kapsul">Kapsul</option>
                                        <option value="Kaplet">Kaplet</option>
                                        <option value="Larutan">Larutan</option>
                                        <option value="Salep">Salep</option>
                                        <option value="Cair Tetes">Cair Tetes</option>
                                    </select>
                                </div>
                            </div>
                        </div> 
                    </div> 
                    <div class="row"> 
                        <div class="col-md-3" style="margin-top: 5px;"> 
                            <label for="harga_obat" class="control-label">Harga</label>
                        </div> 
                        <div class="col-md-9"> 
                            <div class="form-group">
                                <input type="number" class="form-control" id="harga_obat" name="harga_obat" autocomplete="off"> 
                            </div> 
                        </div> 
                    </div> 
                    <div class="row"> 
                        <label class="col-sm-3 control-label" style="margin-top: 10px;"></label>
                        <div class="col-sm-9">
                            <select class="form-control" id="status_obat" name="status_obat">
                                <option value="1">Obat Jamu Tradisional</option>
                                <option value="2">Obat Herbal Terstandar</option>
                                <option value="3">Obat Fitofarmaka</option>
                                <option value="4">Obat Bebas Umum</option>
                                <option value="5">Obat Bebas Terbatas</option>
                                <option value="6">Obat Keras</option>
                                <option value="7">Obat Narkotika</option>
                            </select>
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

