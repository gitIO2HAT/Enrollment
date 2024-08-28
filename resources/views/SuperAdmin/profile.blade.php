@extends('layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="row g-4">
                @include('layouts._message')
                <div class="col-sm-12 col-xl-12">

                    <div class="bg-white text-center p-4">
                        <div class="user-head">
                            <form method="POST" action="{{ url('/SuperAdmin/Updateprofile/' . Auth::user()->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-4 d-flex align-items-center">
                                    <div class="col-sm-4 col-xl-4">
                                        <div class="fields">
                                            <div class="mt-2" id="profileContainer" style="position: relative; display: inline-block;">
                                                <label for="profileImage" onclick="handleImageClick(event)" style="cursor: pointer; position: relative;">
                                                    <img class="rounded-circle" id="profilePicture" src="{{ asset('public/accountprofile/'. Auth::user()->profile_pic) }}" alt="Profile" width="200px">
                                                    <i class="fas fa-camera camera-icon"></i>
                                                </label>
                                                <input type="file" name="profile_pic" id="profileImage" style="display: none;" onchange="displayImage(this)">
                                            </div>
                                            <div class="border-light mt-3">
                                                <h5 class="text-dark">{{ Auth::user()->name }}</h5>
                                                <h6 class="text-light">{{ Auth::user()->admin_id }}</h6>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-4 col-xl-4">
                                        <div class="fields">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Username:</label>
                                                <input type="text" class="form-control underline-input" id="username" name="username" value="{{ Auth::user()->username }}" required>
                                                @if($errors->has('username'))
                                                <span class="text-danger">{{ $errors->first('username') }}</span>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password:</label>
                                                <input type="password" class="form-control underline-input" id="password" name="password">
                                                @if($errors->has('password'))
                                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label for="questions" class="form-label">Questions:</label>
                                                <select id="questions" class="form-control underline-input" name="questions" required>
                                                    <option selected disabled>--Select Question--</option>
                                                    <option value="1" @if(Auth::user()->questions == '1') selected @endif>Mother's Maiden Name?</option>
                                                    <option value="2" @if(Auth::user()->questions == '2') selected @endif>First Pet's Name?</option>
                                                    <option value="3" @if(Auth::user()->questions == '3') selected @endif>City You Were Born In?</option>
                                                    <option value="4" @if(Auth::user()->questions == '4') selected @endif>Name of Your Favorite Teacher?</option>
                                                    <option value="5" @if(Auth::user()->questions == '5') selected @endif>Model of Your First Car?</option>
                                                    <option value="6" @if(Auth::user()->questions == '6') selected @endif>Title of Your Favorite Book?</option>
                                                    <option value="7" @if(Auth::user()->questions == '7') selected @endif>Name of Your First School?</option>
                                                    <option value="8" @if(Auth::user()->questions == '8') selected @endif>Title of Your Favorite Movie?</option>
                                                    <option value="9" @if(Auth::user()->questions == '9') selected @endif>Your Favorite Color?</option>
                                                    <option value="10" @if(Auth::user()->questions == '10') selected @endif>Name of Your Best Friend in Childhood?</option>
                                                </select>
                                                @if($errors->has('questions'))
                                                <span class="text-danger">{{ $errors->first('questions') }}</span>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label for="answer" class="form-label">Answer:</label>
                                                <input type="text" placeholder="Answer" class="form-control underline-input" name="answer" value="{{ Auth::user()->answer }}" required>
                                                @if($errors->has('answer'))
                                                <span class="text-danger">{{ $errors->first('answer') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xl-4">
                                        <div class="fields">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Full Name:</label>
                                                <input type="text" placeholder="Enter Full Name" class="form-control underline-input" name="name" value="{{ Auth::user()->name }}" required>
                                                @if($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label for="sex" class="form-label">Sex:</label>
                                                <select id="sex" class="form-control underline-input" name="sex">
                                                    <option selected disabled>--Select Sex--</option>
                                                    <option value="1" @if(Auth::user()->sex == '1') selected @endif>Male</option>
                                                    <option value="2" @if(Auth::user()->sex == '2') selected @endif>Female</option>
                                                    <option value="3" @if(Auth::user()->sex == '3') selected @endif>Other</option>
                                                </select>
                                                @if($errors->has('sex'))
                                                <span class="text-danger">{{ $errors->first('sex') }}</span>
                                                @endif
                                            </div>

                                            <div class="mb-3">
                                                <label for="role" class="form-label">Role:</label>
                                                <input type="text" placeholder="Enter Role" class="form-control underline-input" name="role" value="{{ Auth::user()->role }}" required>
                                                @if($errors->has('role'))
                                                <span class="text-danger">{{ $errors->first('role') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                                <a href="{{ url('SuperAdmin/Enrollment') }}" class="btn btn-primary">Done</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
