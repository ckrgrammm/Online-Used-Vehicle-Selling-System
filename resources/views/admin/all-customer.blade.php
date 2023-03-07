@extends('admin/master')
@section('content')
<style>

.avatar {
  width: 2.75rem;
  height: 2.75rem;
  line-height: 3rem;
  border-radius: 50%;
  display: inline-block;
  background: transparent;
  position: relative;
  text-align: center;
  color: #868e96;
  font-weight: 700;
  vertical-align: bottom;
  font-size: 1rem;
  margin-right: 1rem;
  background-size: cover;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

</style>

<table id="example" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th>
                <a href="/add-customer" class="btn btn-primary" title="Add">Add<i class="mdi mdi-plus-circle-outline"></i></a>
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
            <td>
                <div class="d-flex align-items-center">
                  <div class="avatar mr-3" style="background-image: url({{asset('user/img/profile/59901786640343b8c1a77.png')}})"></div>

                  <div class="">
                    <p class="font-weight-bold mb-0">Ethan Black</p>
                    <p class="text-muted mb-0">ethan-black@example.com</p>
                  </div>
                </div>
            </td>
            <td>System Architect</td>
            <td>Edinburgh</td>
            <td>61</td>
            <td>2011-04-25</td>
            <td>$320,800</td>
            <td> 
                <a href="/edit-customer" class="btn btn-success" title="Edit"><i class="mdi mdi-square-edit-outline"></i></a>
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
            $('#example').DataTable({
                "lengthMenu": [5, 10, 20, 50],
                "dom": 'ZBfrltip',
                "buttons": [
                    "pdfHtml5",
                    "excelHtml5"
                ],
            });
        });
    </script>
@endsection