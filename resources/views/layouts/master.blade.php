
<!DOCTYPE html>
<html>
    
<!-- Mirrored from moltran.coderthemes.com/menu_2/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 08 Jun 2018 04:18:42 GMT -->
<head>
        <meta charset="utf-8" />
        <title>RSIA Bahagia</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- <link rel="shortcut icon" href="assets/images/favicon_1.ico"> -->
        <link rel="shortcut icon" href="{{ asset('admin/assets/images/RSIA.png') }}">

        <link href="assets/plugins/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css">

        <!-- DataTables -->
        <link href="{{asset('admin/assets/plugins/datatables/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/plugins/datatables/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/plugins/datatables/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/plugins/datatables/responsive.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/plugins/datatables/scroller.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">

        <link href="{{asset('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('admin/assets/css/core.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('admin/assets/css/icons.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('admin/assets/css/components')}}.css" rel="stylesheet" type="text/css">
        <link href="{{asset('admin/assets/css/pages.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('admin/assets/css/menu.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('admin/assets/css/responsive.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('admin/assets/plugins/select2/dist/css/select2.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('admin/assets/plugins/select2/dist/css/select2-bootstrap.css')}}" rel="stylesheet" type="text/css">

        <script src="assets/js/modernizr.min.js"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

    </head>


    <body>
        <div class="wrapper">
            <div class="container">

                @include('layouts.includes._navbar')

                @yield('content')

                @include('layouts.includes._footer')

                <!-- Footer -->
                <!-- <footer class="footer text-right">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-6">
                                2016 © Moltran.
                            </div>
                            <div class="col-xs-6">
                                <ul class="pull-right list-inline m-b-0">
                                    <li>
                                        <a href="#">About</a>
                                    </li>
                                    <li>
                                        <a href="#">Help</a>
                                    </li>
                                    <li>
                                        <a href="#">Contact</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </footer> -->
                <!-- End Footer -->

            </div>
            <!-- end container -->


        </div>



        <!-- jQuery  -->
        <script src="{{asset('admin/assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/detect.js')}}"></script>
        <script src="{{asset('admin/assets/js/fastclick.js')}}"></script>
        <script src="{{asset('admin/assets/js/jquery.blockUI.js')}}"></script>
        <script src="{{asset('admin/assets/js/waves.js')}}"></script>
        <script src="{{asset('admin/assets/js/wow.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/jquery.nicescroll.js')}}"></script>
        <script src="{{asset('admin/assets/js/jquery.scrollTo.min.js')}}"></script>

        <!-- App js -->
        <script src="{{asset('admin/assets/js/jquery.app.js')}}"></script>

        <!-- dashboard  -->
        <script src="{{asset('admin/assets/pages/jquery.dashboard.js')}}"></script>

        <!-- Datatables-->
        <script src="{{asset('admin/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('admin/assets/plugins/datatables/dataTables.bootstrap.js')}}"></script>
        <script src="{{asset('admin/assets/plugins/datatables/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('admin/assets/plugins/datatables/buttons.bootstrap.min.js')}}"></script>
        <script src="{{asset('admin/assets/plugins/datatables/jszip.min.js')}}"></script>
        <script src="{{asset('admin/assets/plugins/datatables/pdfmake.min.js')}}"></script>
        <script src="{{asset('admin/assets/plugins/datatables/vfs_fonts.js')}}"></script>
        <script src="{{asset('admin/assets/plugins/datatables/buttons.html5.min.js')}}"></script>
        <script src="{{asset('admin/assets/plugins/datatables/buttons.print.min.js')}}"></script>
        <script src="{{asset('admin/assets/plugins/datatables/dataTables.fixedHeader.min.js')}}"></script>
        <script src="{{asset('admin/assets/plugins/datatables/dataTables.keyTable.min.js')}}"></script>
        <script src="{{asset('admin/assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
        <script src="{{asset('admin/assets/plugins/datatables/responsive.bootstrap.min.js')}}"></script>
        <script src="{{asset('admin/assets/plugins/datatables/dataTables.scroller.min.js')}}"></script>
        <script src="{{asset('admin/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
        <script src="{{asset('admin/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>

        <!-- Datatable init js -->
        <script src="{{asset('admin/assets/pages/datatables.init.js')}}"></script>
        
        <!-- jQuery  -->
        <script src="{{asset('admin/assets/pages/jquery.dashboard.js')}}"></script>

        <script type="text/javascript">

            $('#data-pegawai').dataTable();
            $('#data-jabatan').dataTable();
            $('#data-obat').dataTable();
            $('#data-pasien').dataTable();
            $('#data-poli').dataTable();
            $('#data-dokter').dataTable();
            $('#data-jadwal-dokter').dataTable();

            $('#status_obat').select2();

            $('#tanggal_lahir').datepicker({
                format: 'yyyy-mm-dd',
            });
            // $('#role').select2();
            // $('#jenis_kelamin').select2();

            jQuery(document).ready(function($) {
                $('.counter').counterUp({
                    delay: 100,
                    time: 1200
                });
            });

            // jQuery(document).ready(function(){
            //   $("#role").change(function() {
            //       if($(this).val() == 2){

            //           $("#row-poli").css('display', 'block');

            //       }else{
            //           $("#row-poli").css('display', 'none');
            //       }
            //   });
            // });

            $("#role").change(function() {
              if ($(this).val() == 2) {
                $("#row-poli").css('display', 'block');

              } else {
                $("#row-poli").css('display', 'none');
              }
            });
            
        </script>

    </body>

<!-- Mirrored from moltran.coderthemes.com/menu_2/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 08 Jun 2018 04:19:20 GMT -->
</html>