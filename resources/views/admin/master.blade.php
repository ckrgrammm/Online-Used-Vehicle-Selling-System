<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Respectism</title>
    <link rel="icon" href="{{asset('user/img/favicon.png')}}">
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/style.css')}}">
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap5.min.css">

    {{-- jquery --}}
    <!-- plugins:js -->
    <script src="{{asset('admin/assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap5.min.js"></script>
</head>
<body>
    <div class="container-scroller">
        {{View::make('admin/header')}}
        <div class="container-fluid page-body-wrapper">
            {{View::make('admin/sidebar')}}
            <div class="main-panel">
                <div class="content-wrapper">
                     @yield('content')
                </div>
                {{View::make('admin/footer')}}
            </div>
        </div>
    </div>
    
    <!-- inject:js -->
    <script src="{{asset('admin/assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('admin/assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('admin/assets/js/misc.js')}}"></script>
    <!-- Custom js for this page -->
    <script src="{{asset('admin/assets/js/file-upload.js')}}"></script>

</body>
</html>