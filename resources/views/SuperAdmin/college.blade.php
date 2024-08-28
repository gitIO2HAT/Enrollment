@extends('layouts.app')

@section('content')
    @include('layouts._message')


    <div class="row g-4  my-4 d-flex justify-content-center">
        @foreach ($colleges as $college)
            <div class="col-2  rounded-1  me-2" style="width: 350px;">
                <div class="card bg-gradient-test p-3 rounded text-white">
                    <form action="{{ url('SuperAdmin/College/EditCollege/' . $college->id) }}" method="post">
                        @csrf
                        <div class="row ">
                            <div class="col-6 text-start">
                                <input type="text" id="editable-input-college-{{ $college->id }}" name="college"
                                    value="{{ $college->college }}" class="form-control text-center" style="display:none;"
                                    onblur="toggleEdit('college', '{{ $college->id }}')">
                                <span id="editable-span-college-{{ $college->id }}" class="text-start"
                                    onclick="toggleEdit('college', '{{ $college->id }}')"> {{ $college->college }}</span>
                            </div>
                            <div class="col-6 text-end">
                                <span><a type="button" class="mx-2"
                                        onclick="toggleEdit('college', '{{ $college->id }}')">
                                        <i class="fas fa-pen fa-xs" style="color: #dcdde0;"></i>
                                    </a>
                                    <a href="{{ url('SuperAdmin/College/DeletedCollege/' . $college->id) }}"> <i
                                            class="fas fa-times fa-xs" style="color: #dcdde0;"></i></a>
                                </span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span id="editable-span-description-{{ $college->id }}" style="font-size: 14px"
                                onclick="toggleEdit('description', '{{ $college->id }}')">{{ $college->description }}</span>
                            <input type="text" id="editable-input-description-{{ $college->id }}" name="description"
                                value="{{ $college->description }}" class="form-control text-center" style="display:none;"
                                onblur="toggleEdit('description', '{{ $college->id }}')">
                        </div>
                        <button type="submit" style="display:none;"></button>
                    </form>
                </div>

                @foreach ($courses as $course)
                    @if ($college->id === $course->college_id)
                        <form action="{{ url('SuperAdmin/College/EditCourse/' . $course->id) }}" method="post">

                            @csrf
                            <div class="row card-modify  rounded-1 text-dark hover-container">
                                <div class="col-11 text-start">
                                    <span id="editable-span-course-{{ $course->id }}" style="font-size: 14px"
                                        onclick="toggleEdit('course', '{{ $course->id }}')">{{ $course->course }}</span>
                                    <input type="text" id="editable-input-course-{{ $course->id }}" name="course"
                                        value="{{ $course->course }}" class="form-control text-center"
                                        style="display:none;" onblur="toggleEdit('course', '{{ $course->id }}')">
                                </div>
                                <div class="col-1 text-end">
                                    <a href="{{ url('SuperAdmin/College/DeletedCourse/' . $course->id) }}" class="delete-icon"> <i
                                            class="fas fa-times fa-xs" style="color: #973229;"></i></a>
                                </div>
                            </div>
                            <button type="submit" style="display:none;"></button>
                        </form>
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
        <div class="modal fade" id="addCollegeModal" tabindex="-1" aria-labelledby="addCollegeModalLabel"
            aria-hidden="true">
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
                                <input type="text" placeholder="College Name" class="form-control underline-input"
                                    name="college">
                                @if ($errors->has('college'))
                                    <span class="text-danger">{{ $errors->first('college') }}</span>
                                @endif
                                <input type="text" placeholder="Description" class="form-control underline-input"
                                    name="description">
                                @if ($errors->has('description'))
                                    <span class="text-danger">{{ $errors->first('description') }}</span>
                                @endif
                                <button type="submit" class="btn btn-success mt-3">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel"
            aria-hidden="true">
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


                            <div class="row g-4">
                                <div class="text-center">
                                    <label for="college">College</label>
                                    <select id="college" name="college_id" class="form-control underline-input">
                                        <option value="">Select College</option>
                                        @foreach ($colleges as $college)
                                            <option value="{{ $college->id }}">{{ $college->college }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" placeholder="Course Name" class="form-control underline-input"
                                        name="course" value="">
                                    @if ($errors->has('course'))
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

        <div class="modal fade" id="addMajorModal" tabindex="-1" aria-labelledby="addMajorModalLabel"
            aria-hidden="true">
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
                            <div class="row g-4">

                                <div class="text-center">
                                    <label for="course">Course</label>
                                    <select id="course" name="course_id" class="form-control underline-input">
                                        <option value="">Select Course</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->course }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" placeholder="Major Name" class="form-control underline-input"
                                        name="major" value="">
                                    @if ($errors->has('major'))
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
        <div class="modal fade" id="editcollegeModal" tabindex="-1" aria-labelledby="editcollegeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editcollegeModalLabel">Edit College</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Content will be loaded here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
