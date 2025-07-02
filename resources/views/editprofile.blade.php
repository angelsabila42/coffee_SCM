@extends('layouts.app')
@section('page-title', 'Edit Profile')
@section('content')
<div class="container mt-2">
    <form action="{{route('editprofile')}}" method="post">
    @csrf
     <!--UploadImage-->
    <div class="text-center mb-4">
        <div class="mb-3">
            <img src="{{$user->profile_picture}}" class="rounded-circle" alt="Profile Image" width="150" height="150">
        </div>
        <input type="file" name="profile_picture" class="form-control">
    </div>
    <!--AccountDetails-->
        <h6>AccountDetails</h6>
        <div class="row mb-3">
            <div class="col">
                <label for="fullName"class="form-label">Full Name</label> 
                <input type="text" class="form-control" id="fullName" value="{{$user->name}}">
            </div>
            {{-- <div class="col-md-6">
                <label for="phoneNumber" class="form-label">Phone Number</label> 
                <input type="text" class="form-control" id="phoneNumber" placeholder="0944443090">
            </div> --}}
        </div>
        <div class="mb-4">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email"  value="{{$user->email}}">
        </div> 
        <button class="btn btn-primary">Update Profile</button>
    </form>
    <form action="{{route('editprofile')}}" method="post">
    @csrf
    <!--ChangePassword-->
        <h6>Change Password</h6>
        <div class="rowmb-3">
            <div class="col-md-6">
                <label for="newPassword" class="form-label">Current Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="currentPassword" name="current_password" >
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword2('currentPassword')" >
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <label for="newPassword" class="form-label">New Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="newPassword" name="new_password">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('newPassword')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <label for="confirmPassword"class="form-label">Confirm Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="confirmPassword" name="new_password_confirmation">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword1('confirmPassword')">
                        <i class="fas  fa-eye"></i>
                    </button>
                </div>
            </div>
        </div><br>
        <button type="submit" class="btn btn-warning">Change Password</button>
    </form>
</div>
 <script>
function togglePassword(newPassword){
    var input = document.getElementById('newPassword');
    if(input.type==="password"){
        input.type="text";
        }else{
            input.type="password";
            }
        }
 function togglePassword1(confirmPassword){
    var input1 = document.getElementById('confirmPassword');
     if(input1.type==="password"){
         input1.type="text";
         }else{
             input1.type="password";
             }
         }
         function togglePassword2(currentPassword){
    var input1 = document.getElementById('currentPassword');
     if(input1.type==="password"){
         input1.type="text";
         }else{
             input1.type="password";
             }
         }
</script>
@endsection