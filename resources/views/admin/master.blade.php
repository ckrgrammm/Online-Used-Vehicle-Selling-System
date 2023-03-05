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

    <style>
        .table {
        border-spacing: 0 0.85rem !important;
        }

        .table td,
        .table th {
        vertical-align: middle;
        margin-bottom: 10px;
        border: none;
        }

        .table thead tr,
        .table thead th {
        border: none;
        font-size: 12px;
        letter-spacing: 1px;
        text-transform: uppercase;
        background: transparent;
        }

        .table td {
        background: #fff;
        }

        .table td:first-child {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
        }

        .table td:last-child {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        }

        table.dataTable.dtr-inline.collapsed
        > tbody
        > tr[role="row"]
        > td:first-child:before,
        table.dataTable.dtr-inline.collapsed
        > tbody
        > tr[role="row"]
        > th:first-child:before {
        top: 28px;
        left: 14px;
        border: none;
        box-shadow: none;
        }

        table.dataTable.dtr-inline.collapsed > tbody > tr[role="row"] > td:first-child,
        table.dataTable.dtr-inline.collapsed > tbody > tr[role="row"] > th:first-child {
        padding-left: 48px;
        }

        table.dataTable > tbody > tr.child ul.dtr-details {
        width: 100%;
        }

        table.dataTable > tbody > tr.child span.dtr-title {
        min-width: 50%;
        }

        table.dataTable.dtr-inline.collapsed > tbody > tr > td.child,
        table.dataTable.dtr-inline.collapsed > tbody > tr > th.child,
        table.dataTable.dtr-inline.collapsed > tbody > tr > td.dataTables_empty {
        padding: 0.75rem 1rem 0.125rem;
        }

        div.dataTables_wrapper div.dataTables_length label,
        div.dataTables_wrapper div.dataTables_filter label {
        margin-bottom: 0;
        }

        .table a:hover,
        .table a:focus {
        text-decoration: none;
        }

        table.dataTable {
        margin-top: 12px !important;
        }
    </style>
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