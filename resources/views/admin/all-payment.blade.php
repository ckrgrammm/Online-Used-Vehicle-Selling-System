@extends('admin/master')
@section('content')
@if(\Session::has('success'))
    <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
    </div><br>
@endif
<div class="container-fluid">
    <h2>Payment Page</h2><br>
    <div class="table-responsive">
        <table id="example" class="table table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>
                    <a href="{{route('payments.create')}}" class="btn btn-primary" title="Add">Add<i class="mdi mdi-plus-circle-outline"></i></a>
                    </th>
                </tr>
                <tr>
                    <th>Order ID</th>
                    <th>Total Charge</th>
                    <th>Payment Date & Time</th>
                    <th>Payment Method</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($payments as $payment)
            <tr>
                <td>{{$payment->order_id}}</td>
                <td>{{$payment->total_charge}}</td>
                <td>{{$payment->payment_date}}</td>
                <td>{{$payment->payment_method}}</td>
                <td>{{$payment->billing_address}}</td>
                <td> 
                    <a href="{{route('payments.edit', $payment->id)}}" class="btn btn-success btn-edit" title="Edit"><i class="mdi mdi-square-edit-outline"></i></a>
                    <a href="/deletePayment/{{$payment->id}}" class="btn btn-danger delete_button btn-delete" title="Delete"><i class="mdi mdi-delete-outline"></i></a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
        $(".delete_button").click(function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            swal({
                title: "Confirmation",
                text: "Are you sure to delete this record?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    window.location.href = url;
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>

<style>
    .table-responsive{
        overflow-x: auto;
        width: 100%;
    }
</style>

@endsection