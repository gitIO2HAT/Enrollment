@extends('layouts.app')

@section('content')
@include('layouts._message')



<div class="row g-4  my-4 d-flex justify-content-center">
    @foreach ($colleges as $college)
    <div class="col-2  rounded  me-2">
        <div class=" card bg-primary p-3 rounded text-white ">
            {{$college->college}}
            {{$college->description}}
        </div>
        @foreach ($courses as $course)
        @if($college->id === $course->college_id )
        <div class=" card-modify  rounded text-dark ">
            {{$course->course}}
        </div>
        @endif
        @endforeach
    </div>
    @endforeach
</div>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="row g-4">
                <div class="col-sm-4 col-xl-4">
                </div>
                <div class="rounded col-sm-4 col-xl-4">
                </div>
                <div class="col-sm-4 col-xl-4">
                </div>
            </div>
        </div>
    </div>








    <div class="sticky-widget">
        <div class="menu">
            <a type="button" class="mx-2" data-bs-toggle="modal" data-bs-target="#addCollegeModal">
                <i class="fas fa-plus-circle" style="color: #FFD43B;">College</i>
            </a>
            <a type="button" class="mx-2" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                <i class="fas fa-plus-circle" style="color: #FFD43B;">Course</i>
            </a>
            <a type="button" class="mx-2" data-bs-toggle="modal" data-bs-target="#addMajorModal">
                <i class="fas fa-plus-circle" style="color: #FFD43B;">Major</i>
            </a>
            <button class="close-button">×</button>
        </div>
    </div>

    <button id="show-widget" style="position: fixed; right: 20px; bottom: 60px; display: none;">Show Widget</button>


    <div class="modal fade" id="addCollegeModal" tabindex="-1" aria-labelledby="addCollegeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="addCollegeModalLabel">Add College</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form content here -->
                    <form action="/SuperAdmin/College/AddCollege" method="POST">
                        @csrf
                        <div class="text-center">
                            <input type="text" placeholder="College Name" class="form-control underline-input" name="college">
                            @if($errors->has('college'))
                            <span class="text-danger">{{ $errors->first('college') }}</span>
                            @endif
                            <input type="text" placeholder="Description" class="form-control underline-input" name="description">
                            @if($errors->has('description'))
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                            @endif
                            <button type="submit" class="btn btn-success mt-3">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="addCourseModalLabel">Add Position for Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form content here -->
                    <form action="/SuperAdmin/College/AddCourse" method="POST">
                        @csrf

                        <div>
                            <label for="college">College</label>
                            <select id="college" name="college_id">
                                <option value="">Select College</option>
                                @foreach($colleges as $college)
                                <option value="{{ $college->id }}">{{ $college->college }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row g-4">
                            <div class="text-center">
                                <input type="text" placeholder="Course Name" class="form-control underline-input" name="course" value="">
                                @if($errors->has('course'))
                                <span class="text-danger">{{ $errors->first('course') }}</span>
                                @endif
                                <button type="submit" class="btn btn-success mt-2">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addMajorModal" tabindex="-1" aria-labelledby="addMajorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="addMajorModalLabel">Add Position for Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form content here -->
                    <form action="/SuperAdmin/College/AddMajor" method="POST">
                        @csrf
                        <div>
                            <label for="course">Course</label>
                            <select id="course" name="course_id">
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->course }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="row g-4">
                            <div class="text-center">
                                <input type="text" placeholder="Major Name" class="form-control underline-input" name="major" value="">
                                @if($errors->has('major'))
                                <span class="text-danger">{{ $errors->first('major') }}</span>
                                @endif
                                <button type="submit" class="btn btn-success mt-2">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





    @endsection