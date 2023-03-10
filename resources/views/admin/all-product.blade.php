@extends('admin/master')
@section('content')
<h2>Product Page</h2><br>
<table id="example" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th>
                <a href="/add-product" class="btn btn-primary" title="Add">Add<i class="mdi mdi-plus-circle-outline"></i></a>
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
            <td>{{ $product->product_image }}</td>
            <td>{{ $product->price }}</td>
           
                <td> 
                <a href="" class="btn btn-success" title="Edit"><i class="mdi mdi-square-edit-outline"></i></a>
                <a href="" class="btn btn-danger" title="Delete"><i class="mdi mdi-delete-outline"></i></a>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>

    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>



@endsection