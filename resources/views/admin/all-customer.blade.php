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
            <th>Gender</th>
            <th>Address</th>
            <th>Phone No</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
            <td>
                <div class="d-flex align-items-center">
                  <div class="avatar mr-3" style="background-image: url({{asset('user/img/profile/'.$user->image)}})"></div>

                  <div class="">
                    <p class="font-weight-bold mb-0">{{$user->name}}</p>
                    <p class="text-muted mb-0">{{$user->email}}</p>
                  </div>
                </div>
            </td>
            <td>{{$user->gender}}</td>
            <td>{{$user->address}}</td>
            <td>{{$user->phoneNum}}</td>
            <td>{{$user->role}}</td>
            <td> 
                <a href="/edit-customer/{{$user->id}}" class="btn btn-success" title="Edit"><i class="mdi mdi-square-edit-outline"></i></a>
                <a href="" class="btn btn-danger" title="Delete"><i class="mdi mdi-delete-outline"></i></a>
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
                    "pdfHtml5",
                    "excelHtml5"
                ],
            });
        });
    </script>
@endsection