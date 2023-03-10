@extends('admin/master')
@section('content')
<style>
  .pic {
	 width: 16rem;
	 height: 16rem;
	 position: relative;
	 overflow: hidden;
	 border-radius: 50%;
  }

  .lx-btn {
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

  .pic img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
  }
</style>
<div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Basic form elements</h4>
        <p class="card-description"> Basic form elements </p>
        <form class="forms-sample">
          <div class="form-group">
            <label for="exampleInputName1">Name</label>
            <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" value="{{$user->name}}">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail3">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email" value="{{$user->email}}">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword4">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword4" placeholder="Password">
          </div>
          <div class="form-group">
            <label for="exampleSelectGender">Gender</label>
            <select class="form-control" id="exampleSelectGender">
              <option value="male" @if ($user->gender == 'male') selected @endif>Male</option>
              <option value="female" @if ($user->gender == 'female') selected @endif>Female</option>
            </select>
          </div>
          <div class="form-group">
            <label for="exampleInputAddress">Address</label>
            <input type="text" class="form-control" id="exampleInputAddress" placeholder="Address" value="{{$user->address}}">
          </div>
          <div class="form-group">
            <label for="exampleInputPhoneNum">Phone No</label>
            <input type="text" class="form-control" id="exampleInputPhoneNum" placeholder="Phone No" value="{{$user->phoneNum}}">
          </div>
          {{-- <div class="form-group">
            <label>File upload</label>
            <input type="file" name="img[]" class="file-upload-default">
            <div class="input-group col-xs-12">
              <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
              <span class="input-group-append">
                <button class="file-upload-browse btn btn-gradient-primary" type="button">Upload</button>
              </span>
            </div>
          </div> --}}
          <div class="form-group">
            <label for="">Profile picture</label>
            <div class="pic bs-md">
              <img src="{{asset('user/img/profile/'.$user->image)}}" id="profile-image" alt="" width="4024" height="6048" loading="lazy">
              <a id="change-avatar" class="lx-btn"><i class="fas fa-camera-retro"></i>&nbsp;&nbsp;Change your profile picture.</a>
            </div>
          </div>
          <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
          <button class="btn btn-light">Cancel</button>
        </form>
      </div>
    </div>
  </div>
@endsection