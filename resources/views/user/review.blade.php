@extends('user/master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="{{asset('user/image-uploader/image-uploader.css')}}">
<script src="{{asset('user/image-uploader/image-uploader.js')}}"></script>
<div class="container">
    <div class="card" style="margin-top: 10rem">
        <div class="card-header">Total Reviews</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6 text-center">
                    <h1 class="text-warning mt-4 mb-4">
                        <b><span id="average_rating">0.0</span> / 5</b>
                    </h1>
                    <div class="mb-3">
                        <i class="fas fa-star star-light mr-1 main_star"></i>
                        <i class="fas fa-star star-light mr-1 main_star"></i>
                        <i class="fas fa-star star-light mr-1 main_star"></i>
                        <i class="fas fa-star star-light mr-1 main_star"></i>
                        <i class="fas fa-star star-light mr-1 main_star"></i>
                    </div>
                    <h3><span id="total_review">0</span> Review</h3>
                </div>
                <div class="col-sm-4">
                    <p>
                        <div class="progress-label-left"><b>5</b> <i class="fas fa-star text-warning"></i></div>

                        <div class="progress-label-right">(<span id="total_five_star_review">0</span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="five_star_progress"></div>
                        </div>
                    </p>
                    <p>
                        <div class="progress-label-left"><b>4</b> <i class="fas fa-star text-warning"></i></div>
                        
                        <div class="progress-label-right">(<span id="total_four_star_review">0</span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="four_star_progress"></div>
                        </div>               
                    </p>
                    <p>
                        <div class="progress-label-left"><b>3</b> <i class="fas fa-star text-warning"></i></div>
                        
                        <div class="progress-label-right">(<span id="total_three_star_review">0</span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="three_star_progress"></div>
                        </div>               
                    </p>
                    <p>
                        <div class="progress-label-left"><b>2</b> <i class="fas fa-star text-warning"></i></div>
                        
                        <div class="progress-label-right">(<span id="total_two_star_review">0</span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="two_star_progress"></div>
                        </div>               
                    </p>
                    <p>
                        <div class="progress-label-left"><b>1</b> <i class="fas fa-star text-warning"></i></div>
                        
                        <div class="progress-label-right">(<span id="total_one_star_review">0</span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="one_star_progress"></div>
                        </div>               
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5" id="review_content">
        <div class="row mb-3">

            <div class="col-sm-1">
                <img src="{{asset('user/img/profile/4312701486403509e4e725.png')}}" class="rounded-circle pt-2 pb-2">
            </div>
        
            <div class="col-sm-11">
        
                <div class="card">
        
                    <div class="card-header"><b>'+data.review_data[count].user_name+'</b></div>
        
                    <div class="card-body">
        
                        <i class="fas fa-star star-light mr-1"></i>
        
                        <br />
        
                        data.review_data[count].user_review
                        
                        <hr>

                        <div class="row mb-3">

                            <div class="col-sm-1">
                                <div class="rounded-circle bg-danger text-white pt-2 pb-2">
                                    <h3 class="text-center">A</h3>
                                </div>
                            </div>
                        
                            <div class="col-sm-11">
                        
                                <div class="card">
                        
                                    <div class="card-header"><b>'+data.review_data[count].user_name+'</b></div>
                        
                                    <div class="card-body">
                        
                                        <i class="fas fa-star text-warning mr-1"></i>
                        
                                        <br />
                        
                                        data.review_data[count].user_review
                        
                                    </div>
                        
                                    <div class="card-footer text-right">On '+data.review_data[count].datetime+'</div>
                        
                                </div>
                        
                            </div>
                        
                        </div>
                    </div>
        
                    <div class="card-footer text-right">On '+data.review_data[count].datetime+'</div>
        
                </div>
        
            </div>
        
        </div>
    </div>
</div>
</body>
</html>

<div id="review_modal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Submit Review</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{url('reviews')}}" id="add-review-form" method="POST" enctype="multipart/form-data">
          <div class="modal-body">
            @csrf
            <h4 class="text-center mt-2 mb-4">
                <i class="fas fa-star star-light submit_star mr-1" id="submit_star_1" data-rating="1"></i>
                <i class="fas fa-star star-light submit_star mr-1" id="submit_star_2" data-rating="2"></i>
                <i class="fas fa-star star-light submit_star mr-1" id="submit_star_3" data-rating="3"></i>
                <i class="fas fa-star star-light submit_star mr-1" id="submit_star_4" data-rating="4"></i>
                <i class="fas fa-star star-light submit_star mr-1" id="submit_star_5" data-rating="5"></i>
            </h4>
            <div class="form-group">
                <div class="input-images-1" style="padding-top: .5rem;"></div>
            </div>
            <div class="form-group">
                <textarea name="user_review" id="user_review" class="form-control" placeholder="Type Review Here"></textarea>
            </div>
            <div class="form-group text-center mt-4">
                <button type="button" class="btn btn-primary" id="save_review">Submit</button>
            </div>
          </div>
          </form>
    </div>
  </div>
</div>

<style>
.progress-label-left
{
float: left;
margin-right: 0.5em;
line-height: 1em;
}
.progress-label-right
{
float: right;
margin-left: 0.3em;
line-height: 1em;
}
.star-light
{
color:#e9ecef;
}

.image-uploader .upload-text{
  cursor: pointer;
}
</style>

<script>
    $(function () {

        $('.input-images-1').imageUploader();

    });
</script>

<script>

$(document).ready(function(){

var rating_data = 0;

$('#add_review').click(function(){

    $('#review_modal').modal('show');

});

$(document).on('mouseenter', '.submit_star', function(){

    var rating = $(this).data('rating');

    reset_background();

    for(var count = 1; count <= rating; count++)
    {

        $('#submit_star_'+count).addClass('text-warning');

    }

});

function reset_background()
{
    for(var count = 1; count <= 5; count++)
    {

        $('#submit_star_'+count).addClass('star-light');

        $('#submit_star_'+count).removeClass('text-warning');

    }
}

$(document).on('mouseleave', '.submit_star', function(){

    reset_background();

    for(var count = 1; count <= rating_data; count++)
    {

        $('#submit_star_'+count).removeClass('star-light');

        $('#submit_star_'+count).addClass('text-warning');
    }

});

$(document).on('click', '.submit_star', function(){

    rating_data = $(this).data('rating');

});

$('#save_review').click(function(){
    event.preventDefault();

    var images = $('input[name^="images"]').val();

    var user_review = $('#user_review').val();

    if(images == '' || user_review == '' || rating_data == '0')
    {
        alert("Please Fill Both Field");
        return false;
    }
    else
    {
        $.ajax({
            url:"{{url('reviews')}}",
            method:"POST",
            data:{rating_data:rating_data, images:images, user_review:user_review},
            success:function(data)
            {
                $('#review_modal').modal('hide');

                load_rating_data();

                alert(data);
            }
        })
    }

});

load_rating_data();

function load_rating_data()
{
    $.ajax({
        url:"/reviews/store",
        method:"POST",
        data:{action:'load_data'},
        dataType:"JSON",
        success:function(data)
        {
            $('#average_rating').text(data.average_rating);
            $('#total_review').text(data.total_review);

            var count_star = 0;

            $('.main_star').each(function(){
                count_star++;
                if(Math.ceil(data.average_rating) >= count_star)
                {
                    $(this).addClass('text-warning');
                    $(this).addClass('star-light');
                }
            });

            $('#total_five_star_review').text(data.five_star_review);

            $('#total_four_star_review').text(data.four_star_review);

            $('#total_three_star_review').text(data.three_star_review);

            $('#total_two_star_review').text(data.two_star_review);

            $('#total_one_star_review').text(data.one_star_review);

            $('#five_star_progress').css('width', (data.five_star_review/data.total_review) * 100 + '%');

            $('#four_star_progress').css('width', (data.four_star_review/data.total_review) * 100 + '%');

            $('#three_star_progress').css('width', (data.three_star_review/data.total_review) * 100 + '%');

            $('#two_star_progress').css('width', (data.two_star_review/data.total_review) * 100 + '%');

            $('#one_star_progress').css('width', (data.one_star_review/data.total_review) * 100 + '%');

            if(data.review_data.length > 0)
            {
                var html = '';

                for(var count = 0; count < data.review_data.length; count++)
                {
                    html += '<div class="row mb-3">';

                    html += '<div class="col-sm-1"><div class="rounded-circle bg-danger text-white pt-2 pb-2"><h3 class="text-center">'+data.review_data[count].user_name.charAt(0)+'</h3></div></div>';

                    html += '<div class="col-sm-11">';

                    html += '<div class="card">';

                    html += '<div class="card-header"><b>'+data.review_data[count].user_name+'</b></div>';

                    html += '<div class="card-body">';

                    for(var star = 1; star <= 5; star++)
                    {
                        var class_name = '';

                        if(data.review_data[count].rating >= star)
                        {
                            class_name = 'text-warning';
                        }
                        else
                        {
                            class_name = 'star-light';
                        }

                        html += '<i class="fas fa-star '+class_name+' mr-1"></i>';
                    }

                    html += '<br />';

                    html += data.review_data[count].user_review;

                    html += '</div>';

                    html += '<div class="card-footer text-right">On '+data.review_data[count].datetime+'</div>';

                    html += '</div>';

                    html += '</div>';

                    html += '</div>';
                }

                $('#review_content').html(html);
            }
        }
    })
}

});

</script>
    
@endsection