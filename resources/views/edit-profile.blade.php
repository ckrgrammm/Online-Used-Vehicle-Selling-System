@extends('master')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/luxonauta/luxa@8a98/dist/compressed/luxa.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.4.1/croppie.min.js"></script>
<style>
  /* html, body {
	 font-family: "Roboto", sans-serif;
	 font-size: 88%;
}
 body {
	 display: grid;
	 grid-template-rows: auto 1fr auto;
	 background-image: url("https://i.postimg.cc/fbSXnBct/video.png");
	 background-attachment: fixed;
	 background-size: contain;
	 background-position: center;
	 background-repeat: no-repeat;
} */
 main {
	 min-height: 100vh;
	 padding: 2rem 0;
}
 main section {
	 width: 100%;
}
 main section .lx-column.column-user-pic {
	 display: flex;
	 align-items: flex-start;
	 justify-content: flex-end;
}
 main section .profile-pic {
	 width: auto;
	 max-width: 20rem;
	 margin: 3rem 2rem;
	 padding: 2rem;
	 display: flex;
	 flex-flow: wrap column;
	 align-items: center;
	 justify-content: center;
	 border-radius: 0.25rem;
	 background-color: white;
}
 main section .profile-pic .pic-label {
	 width: 100%;
	 margin: 0 0 1rem 0;
	 text-align: center;
	 font-size: 1.4rem;
	 font-weight: 700;
}
 main section .profile-pic .pic {
	 width: 16rem;
	 height: 16rem;
	 position: relative;
	 overflow: hidden;
	 border-radius: 50%;
}
 main section .profile-pic .pic .lx-btn {
	 opacity: 0;
	 width: 100%;
	 height: 100%;
	 margin: 0;
	 padding: 0;
	 position: absolute;
	 transform: translate(-50%, -50%);
	 top: 50%;
	 left: 50%;
	 display: none;
	 align-items: center;
	 justify-content: center;
	 text-transform: none;
	 font-size: 1rem;
	 color: white;
	 background-color: rgba(0, 0, 0, 0.8);
}
 main section .profile-pic .pic img {
	 width: 100%;
	 height: 100%;
	 object-fit: cover;
	 object-position: center;
}
 main section .profile-pic .pic:focus .lx-btn, main section .profile-pic .pic:focus-within .lx-btn, main section .profile-pic .pic:hover .lx-btn {
	 opacity: 1;
	 display: flex;
}
 main section .profile-pic .pic-info {
	 width: 100%;
	 margin: 2rem 0 0 0;
	 font-size: 0.9rem;
	 text-align: center;
}
 main section form {
	 width: auto;
	 min-width: 15rem;
	 max-width: 25rem;
	 margin: 3rem 0 0 0;
}
 main section form .fieldset {
	 width: 100%;
	 margin: 2rem 0;
	 position: relative;
	 display: flex;
	 flex-wrap: wrap;
	 align-items: center;
	 justify-content: flex-start;
}
 main section form .fieldset label {
	 width: 100%;
	 margin: 0 0 1rem 0;
	 font-size: 1.2rem;
	 font-weight: 700;
}
 main section form .fieldset .input-wrapper {
	 width: 100%;
	 display: flex;
	 flex-flow: nowrap;
	 align-items: stretch;
	 justify-content: center;
}
 main section form .fieldset .input-wrapper .icon {
	 width: fit-content;
	 margin: 0;
	 padding: 0.375rem 0.75rem;
	 display: flex;
	 align-items: center;
	 border-top-left-radius: 0.25em;
	 border-bottom-left-radius: 0.25em;
	 border-top-right-radius: 0;
	 border-bottom-right-radius: 0;
	 border: 0.0625rem solid #ced4da;
	 font-size: 1rem;
	 font-weight: 400;
	 line-height: 1.5;
	 color: #495057;
	 text-align: center;
	 background-color: #e9ecef;
}
 main section form .fieldset .input-wrapper input, main section form .fieldset .input-wrapper select {
	 flex-grow: 1;
	 min-height: 3rem;
	 padding: 0.375rem 0.75rem;
	 display: block;
	 border-top-left-radius: 0;
	 border-bottom-left-radius: 0;
	 border-top-right-radius: 0.25em;
	 border-bottom-right-radius: 0.25em;
	 border: 0.0625rem solid #ced4da;
	 border-left: 0;
	 font-size: 1rem;
	 font-weight: 400;
	 line-height: 1.5;
	 color: #495057;
}
 main section form .fieldset .input-wrapper:focus .icon, main section form .fieldset .input-wrapper:focus-within .icon, main section form .fieldset .input-wrapper:hover .icon {
	 color: #538e46;
}
 main section form .fieldset:first-child {
	 margin-top: 0;
}
 main section form .fieldset:last-child {
	 margin-bottom: 0;
}
 main section form .actions {
	 width: 100%;
	 display: flex;
	 align-items: center;
	 justify-content: space-between;
}
 main section form .actions .lx-btn {
	 padding: 0.5rem 1rem;
	 display: flex;
	 align-items: center;
	 justify-content: center;
	 font-weight: 700;
	 color: white;
}
 main section form .actions .lx-btn#cancel, main section form .actions .lx-btn.cancel {
	 background-color: #f55;
}
 main section form .actions .lx-btn#clear, main section form .actions .lx-btn.clear {
	 color: black;
	 background-color: white;
}
 main section form .actions .lx-btn#save, main section form .actions .lx-btn.save {
	 background-color: #538e46;
}
 @media screen and (max-width: 64rem) {
	 main section .profile-pic {
		 max-width: 100%;
		 margin: 0;
	}
}
 @media screen and (max-width: 56.25rem) {
	 main section form {
		 max-width: 100%;
		 margin: 0;
	}
}
 
</style>
<main class="has-dflex-center">
    <section>
      <div class="lx-container-70">
        <br><br><br>
        @if(\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div><br>
        @endif
        <div class="lx-row align-stretch">
          <div class="lx-column column-user-pic">
            <div class="profile-pic bs-md">
              <h1 class="pic-label">Profile picture</h1>
              <div class="pic bs-md">
                <img src="{{asset('img/profile/'.$data->image)}}" id="profile-image" alt="" width="4024" height="6048" loading="lazy">
                <a id="change-avatar" class="lx-btn"><i class="fas fa-camera-retro"></i>&nbsp;&nbsp;Change your profile picture.</a>
              </div>
              <div class="pic-info">
                <p><i class="fas fa-exclamation-triangle"></i>&nbsp;&nbsp;This photo will appear on the platform, in your contributions or where it is mentioned.</p>
              </div>
            </div>
          </div>
          <div class="lx-column">
            <form class="edit-profile-form" id="edit-profile-form" method="POST" action="/submitEditProfileForm/{{$data->id}}" enctype="multipart/form-data">
                {{-- <input type="hidden" name="old-profile-image" id="old-profile-image" value="{{$data->image}}"> --}}
                @csrf
                <input id='selectedFile' class="disp-none" style="display: none" type='file' accept="image/*">
                <input type="hidden" name="changed-profile-image" class="changed-profile-image" id="changed-profile-image" value="">
              <div class="fieldset">
                <label for="user-name">Name</label>
                <div class="input-wrapper">
                  <span class="icon"><i class="fas fa-user"></i></span>
                  <input type="text" id="user-name" name="user-name" value="{{$data->name}}" autocomplete="username" required>
                </div>
                <div id="user-name-helper" class="helper">
                  <p>Your name can appear on the platform, in your contributions or where it is mentioned.</p>
                </div>
              </div>
              <div class="fieldset">
                <label for="gender">Gender</label>
                <div class="input-wrapper">
                  <span class="icon"><i class="fas fa-transgender-alt"></i></span>
                  <label for="male" style="margin-left: 15px">Male</label>
                  <input type="radio" name="gender" id="gender" value="male" @if($data->gender == 'male') checked @endif>
                  <label for="female">Female</label>
                  <input type="radio" name="gender" id="gender" value="female" @if($data->gender == 'female') checked @endif>
                </div>
                <div id="gender-helper" class="helper"></div>
              </div>
              <div class="fieldset">
                <label for="phone-number">Phone Number</label>
                <div class="input-wrapper">
                  <span class="icon"><i class="fas fa-phone"></i></span>
                  <input type="text" id="phone-number" name="phone-number" value="{{$data->phoneNum}}" required>
                </div>
                <div id="phone-number-helper" class="helper"></div>
              </div>
              <div class="fieldset">
                <label for="email">E-mail</label>
                <div class="input-wrapper">
                  <span class="icon"><i class="fas fa-envelope"></i></span>
                  <input type="email" id="email" name="email" value="{{$data->email}}" autocomplete="username">
                </div>
                <div id="email-helper" class="helper"></div>
              </div>
              <div class="fieldset">
                <label for="address">Address</label>
                <div class="input-wrapper">
                  <span class="icon"><i class="fas fa-map-marker"></i></span>
                  <input type="text" id="address" name="address" value="{{$data->address}}" autocomplete="username">
                </div>
                <div id="address-helper" class="helper"></div>
              </div>
              <div class="fieldset">
                <label for="pass">Password</label>
                <div class="input-wrapper">
                  <span class="icon"><i class="fas fa-key"></i></span>
                  <input type="password" id="pass" name="pass" value="" autocomplete="current-password" placeholder="Enter password to reset password">
                  <span toggle="#pass" class="fa fa-fw fa-eye field-icon toggle-password" style="margin-top: 15px;margin-left: 5px;"></span>
                </div>
                <div id="pass-helper" class="helper"></div>
              </div>
              <div class="actions">
                <a href="/" id="cancel" class="lx-btn"><i class="fas fa-ban"></i>&nbsp;&nbsp;Cancel</a>
                {{-- <a id="clear" class="lx-btn"><i class="fas fa-broom"></i>&nbsp;&nbsp;Clean</a> --}}
                <a id="save" class="lx-btn"><i class="fas fa-save"></i>&nbsp;&nbsp;Save</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>

  <div class="modal fade" id="imageModalContainer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content modal-content1 modal-content1">
        <div class="modal-header">
          <h5 class="modal-title" id="imageModal">Crop Image</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body modal-body1">
          <div id='crop-image-container'>
  
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary save-modal">Save</button>
        </div>
      </div>
    </div>
  </div>
  
  {{-- <script src="https://use.fontawesome.com/releases/v5.14.0/js/all.js" defer crossorigin="anonymous" data-search-pseudo-elements></script> --}}

  <script>
    $("#save").click(function(){
        $("#edit-profile-form").submit();
    })

    // var assetUrl = '{{ asset('') }}';
    // var imageUrl = assetUrl + 'img/profile/' + document.getElementById("old-profile-image").value + '.png';
    // document.querySelector('#profile-image').setAttribute("src", imageUrl);
  </script>

  <script>
    $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
  </script>

  <script>
    $(document).on('click', '#change-avatar', function () {
        document.getElementById('selectedFile').click();
    });

    $('#selectedFile').change(function () {
        // if (this.files[0] == undefined)
        // return;

        // Check if any file is selected.
        if (!(this.files.length > 0)) {
            // document.querySelector('#profile-image').setAttribute("src", "https://i.ibb.co/0Y9JcSV/upload-image.png");
            return false;
        }

        var fileInput = document.getElementById('selectedFile');
        var filePath = fileInput.value;
        // Allowing file type
        var allowedExtensions = /(\.PNG|\.png|\.JPEG|\.jpeg|\.jpg|\.JPG)$/i;

        if (!allowedExtensions.exec(filePath)) {
            // document.querySelector('#profile-image').setAttribute("src", "https://i.ibb.co/0Y9JcSV/upload-image.png");

            swal({
                title: "Sorry!",
                text: "Only image having extension jpg/png/jpeg is allowed",
                icon: "warning",
                button: "OK",
            });
            fileInput.value = '';
            return false;
        }

        // check file size
        const fileSize = this.files[0].size / 1024 / 1024; // in MiB
        if (fileSize > 1) {
            // document.querySelector('#profile-image').setAttribute("src", "https://i.ibb.co/0Y9JcSV/upload-image.png");

            swal({
                title: "Sorry!",
                text: "Image size exceeds 1MB",
                icon: "warning",
                button: "OK",
            });
            $(this).val(''); //for clearing with Jquery
            return false;

        }

        $('#imageModalContainer').modal('show');
        let reader = new FileReader();
        reader.addEventListener("load", function () {
        window.src = reader.result;
        $('#selectedFile').val('');
        }, false);
        if (this.files[0]) {
        reader.readAsDataURL(this.files[0]);
        }
    });

    let croppi;
    $('#imageModalContainer').on('shown.bs.modal', function () {
    let width = document.getElementById('crop-image-container').offsetWidth - 20;
    $('#crop-image-container').height((width - 80) + 'px');
        croppi = $('#crop-image-container').croppie({
        viewport: {
            width: 200,
            height: 200,
            type: 'circle'
        },
        });
    $('.modal-body1').height(document.getElementById('crop-image-container').offsetHeight + 50 + 'px');
    croppi.croppie('bind', {
        url: window.src,
    }).then(function () {
        croppi.croppie('setZoom', 0.6);
    });
    });
    $('#imageModalContainer').on('hidden.bs.modal', function () {
    croppi.croppie('destroy');
    });

    $(document).on('click', '.save-modal', function (ev) {
    croppi.croppie('result', {
        type: 'base64',
        format: 'jpeg',
        size: 'circle'
    }).then(function (resp) {
        document.querySelector('#changed-profile-image').setAttribute("value", resp);
        document.querySelector('#profile-image').setAttribute("src", resp);
        $('.modal').modal('hide');
    });
    });
  </script>
@endsection