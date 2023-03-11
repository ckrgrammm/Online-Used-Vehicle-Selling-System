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

@if(\Session::has('success'))
    <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
    </div><br>
@endif

<table id="example" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th>
                <a href="{{route('comments.create')}}" class="btn btn-primary" title="Add">Add<i class="mdi mdi-plus-circle-outline"></i></a>
            </th>
        </tr>
        <tr>
            <th>Name</th>
            <th>Rating</th>
            <th>Review</th>
            <th>Image</th>
            <th>Date Time</th>
            <th>Comment</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($comments as $comment)
        <tr>
            <td>
                <div class="d-flex align-items-center">
                  <div class="avatar mr-3" style="background-image: url({{asset('user/img/profile/'.$comment->user_image)}})"></div>

                  <div class="">
                    <p class="font-weight-bold mb-0">{{$comment->user_name}}</p>
                    <p class="text-muted mb-0">{{$comment->user_email}}</p>
                  </div>
                </div>
            </td>
            <td>{{$comment->rating}}</td>
            <td>{{$comment->review}}</td>
            <td>{{$comment->image}}</td>
            <td>{{$comment->dateTime}}</td>
            <td>{{$comment->comment}}</td>
            <td> 
                <a href="{{route('comments.edit', $comment->id)}}" class="btn btn-success btn-edit" title="Edit"><i class="mdi mdi-square-edit-outline"></i></a>
                <a href="/deleteUser/{{$comment->id}}" class="btn btn-danger delete_button btn-delete" title="Delete"><i class="mdi mdi-delete-outline"></i></a>
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