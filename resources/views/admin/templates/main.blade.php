<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  {{-- <link rel="icon" href="images/favicon.ico" type="image/ico" /> --}}
    <title>KMB | {{ $title }}</title>    
    <link rel="shortcut icon" href="/icon/favicon.ico" type="image/x-icon">
    <link href="/assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">    
    <link href="/assets/build/css/custom.min.css" rel="stylesheet">

    <link href="/assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Select2 -->
	  <link href="/assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet">

    <script src="/package/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="/package/dist/sweetalert2.min.css">

    <style>
      /* table tbody tr td {
        color: #3f79d7
      } */

      .preloader {
          position: absolute;
          top: 40%;
          left: 50%;
          z-index: 999;
      }

      label {
          overflow: hidden;
      }

      .form_wizard .stepContainer {
          display: block;
          min-height:400px;
          position: relative;
          margin: 0;
          padding: 0;
          border: 0 solid #CCC;
          overflow-x: hidden;
      }
  </style>

  </head>
<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
              <div class="left_col scroll-view">
    
                <div class="clearfix"></div>

                <div class="profile clearfix">
                  <div class="profile_pic">
                    <img src="/assets/img/kmb-logo.png" class="img-circle profile_img" style="width: 110%">
                  </div>
                  <div class="profile_info" style="float: right; width: 50%">
                    <span style="font-size: 20px; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; 
                    color: #3f79d7">Klinik Mutiara</span>
                    <h2 style="font-size: 20px; 
                    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; 
                    color: #55b7e1">Bunda</h2>
                  </div>
                </div>
                    
                <div class="profile clearfix">
                  <div class="profile_pic">
                    <img src="/assets/img/admin.png" class="img-circle profile_img">
                  </div>
                  <div class="profile_info">
                    <span>Selamat Datang,</span>
                    <h2>{{ $infos->nama }}</h2>
                  </div>
                </div>
                <br />
                @include('admin.templates.sidebar')

              </div>
            </div>
            @include('admin.templates.topbar')
            
            <!-- page content -->
            <div class="right_col" role="main">
              <div class="">
                  <h5 class="float-left pb-2">{{ $title }}</h5>
                  {{-- <span class="float-right"> {{ now()->translatedFormat('l, d-F-Y, h:i:s') }}</span> --}}
                  <div class="clearfix"></div>
                  <div class="preloader ">
                      <div class="loading">
                          <img src="/assets/img/loading2.gif" width="200">
                          <p class="ml-4">........Harap Tunggu</p>
                      </div>
                  </div>
                  @yield('content')
              </div>
            </div>

            @include('admin.templates.notice')

        </div>
    </div>
    
    @include('admin.templates.footer')
    
    @stack('script')
    
<!-- jQuery -->
<script src="/assets/vendors/jquery/dist/jquery.min.js"></script>

<script>
  $(document).ready(function(){
  $(".preloader").fadeOut();
  })
</script>

<!-- Bootstrap -->
<script src="/assets/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- FastClick -->
<script src="/assets/vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="/assets/vendors/nprogress/nprogress.js"></script>
<!-- Custom Theme Scripts -->
<script src="/assets/build/js/custom.min.js"></script>
<!-- Select2 -->
<script src="/assets/vendors/select2/dist/js/select2.full.min.js"></script>

<!-- Datatables -->
<script src="/assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="/assets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="/assets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<!-- jQuery Smart Wizard -->
<script src="/assets/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>

</body>
</html>