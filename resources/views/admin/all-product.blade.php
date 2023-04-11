@extends('admin/master')
@section('content')

@if(\Session::has('success'))
<div class="alert alert-success">
    <p>{{ \Session::get('success') }}</p>
</div><br>
@endif

<h2>Product Page</h2><br>
<table id="example" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th>
                <a href="{{route('products.create')}}" class="btn btn-primary" title="Add">Add<i class="mdi mdi-plus-circle-outline"></i></a>
            </th>
        </tr>
        <tr>
            <th>Make</th>
            <th>Model</th>
            <th>Year</th>
            <th>Mileage</th>
            <th>Color</th>
            <th>Transmission</th>
            <th>Description</th>
            <th>Images</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{ $product->make }}</td>
            <td>{{ $product->model }}</td>
            <td>{{ $product->year }}</td>
            <td>{{ $product->mileage }}</td>
            <td>{{ $product->color }}</td>
            <td>{{ $product->transmission }}</td>
            <td>{{ $product->product_description }}</td>
            <td><img src="{{asset('user/img/product/'.$product->product_image)}}"></td>
            <td>{{ $product->price }}</td>
           
                <td> 
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-success btn-edit" title="Edit"><i class="mdi mdi-square-edit-outline"></i></a>
                <a href="/destroyProduct/{{$product->id}}" class="btn btn-danger delete_button btn-delete" title="Delete"><i class="mdi mdi-delete-outline"></i></a>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "lengthMenu": [5, 10, 20, 50],
            "dom": 'ZBfrltip',
            "buttons": [
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 8 ]
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 8 ]
                    }
                },
            ],
        });
    });
</script>

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

@endsection