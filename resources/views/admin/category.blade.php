@extends('admin/master')
@section('content')
<h2>Product Page</h2><br>
<table id="example" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th>
                <a href="" class="btn btn-primary" title="Add">Add<i class="mdi mdi-plus-circle-outline"></i></a>
            </th>
        </tr>
        <tr>
            <th>Name</th>
            <th>Position</th>
            <th>Office</th>
            <th>Age</th>
            <th>Start date</th>
            <th>Salary</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>yameth</td>
            <td>System Architect</td>
            <td>Edinburgh</td>
            <td>61</td>
            <td>2011-04-25</td>
            <td>$320,800</td>
            <td> 
                <a href="" class="btn btn-success" title="Edit"><i class="mdi mdi-square-edit-outline"></i></a>
                <a href="" class="btn btn-danger" title="Delete"><i class="mdi mdi-delete-outline"></i></a>
            </td>
        </tr>
        <tr>
            <td>Garrett Winters</td>
            <td>Accountant</td>
            <td>Tokyo</td>
            <td>63</td>
            <td>2011-07-25</td>
            <td>$170,750</td>
            <td> 
                <a href="" class="btn btn-success" title="Edit"><i class="mdi mdi-square-edit-outline"></i></a>
                <a href="" class="btn btn-danger" title="Delete"><i class="mdi mdi-delete-outline"></i></a>
            </td>
        </tr>
    </tbody>
</table>

    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>



@endsection