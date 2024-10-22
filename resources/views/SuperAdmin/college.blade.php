@extends('layouts.app')

@section('content')
@include('layouts._message')


<div class="row g-4 my-4 d-flex justify-content-center">
    @foreach ($colleges as $college)
    <div class="col-lg-3 col-md-4 col-sm-6 col-12 rounded-1 me-2">
        <div class="card bg-gradient-test p-3 rounded text-white">
            <form action="{{ url('SuperAdmin/College/EditCollege/' . $college->id) }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-6 text-start">
                        <input type="text" id="editable-input-college-{{ $college->id }}" name="college"
                            value="{{ $college->college }}" class="form-control text-center" style="display:none;"
                            onblur="toggleEdit('college', '{{ $college->id }}')" maxlength="10">
                        <span id="editable-span-college-{{ $college->id }}" class="text-start"
                            onclick="toggleEdit('college', '{{ $college->id }}')">{{ $college->college }}</span>
                    </div>
                    <div class="col-6 text-end">
                        <span>
                            <a type="button" title="Edit" class="mx-2" onclick="toggleEdit('college', '{{ $college->id }}')">
                                <i class="fas fa-pen fa-xs" style="color: #dcdde0;"></i>
                            </a>
                            <a title="Delete" href="{{ url('SuperAdmin/College/DeletedCollege/' . $college->id) }}"
                                onclick="return confirm('Are you sure you want to delete this college?');">
                                <i class="fas fa-times fa-xs" style="color: #dcdde0;"></i>
                            </a>
                        </span>
                    </div>
                </div>
                <div class="mt-3">
                    <span id="editable-span-description-{{ $college->id }}" style="font-size: 14px"
                        onclick="toggleEdit('description', '{{ $college->id }}')">{{ $college->description }}</span>
                    <input type="text" id="editable-input-description-{{ $college->id }}" name="description"
                        value="{{ $college->description }}" class="form-control text-center" style="display:none;"
                        onblur="toggleEdit('description', '{{ $college->id }}')" maxlength="100">
                </div>
                <button type="submit" style="display:none;"></button>
            </form>
        </div>

        @foreach ($courses as $course)
        @if ($college->id === $course->college_id)
        <form action="{{ url('SuperAdmin/College/EditCourse/' . $course->id) }}" method="post">
            @csrf
            <div class="row card-modify rounded-1 text-dark hover-container">
                <div class="col-11 text-start">
                    <span id="editable-span-course-{{ $course->id }}" style="font-size: 14px;"
                        onclick="toggleEdit('course', '{{ $course->id }}')">{{ $course->course }}</span>
                    <input type="text" id="editable-input-course-{{ $course->id }}" name="course"
                        value="{{ $course->course }}" class="form-control text-center" style="display:none;"
                        onblur="toggleEdit('course', '{{ $course->id }}')" maxlength="100">
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
                    <form action="{{ url('SuperAdmin/College/AddCollege') }}" method="POST">
                        @csrf
                        <input type="text" placeholder="College Name" class="form-control underline-input" name="college" maxlength="10">

                        @if ($errors->has('college'))
                        <span class="text-danger">{{ $errors->first('college') }}</span>
                        @endif

                        <input type="text" placeholder="Description" class="form-control underline-input" name="description" maxlength="100">
                        @if ($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                        @endif

                        <button type="submit" class="btn btn-white text-center mt-2" style="width:400px;">Add College</button>
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
                    <h5 class="modal-title text-dark" id="addCourseModalLabel">Add Course</h5>
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
                                    name="course" value="" maxlength="100">
                                @if ($errors->has('course'))
                                <span class="text-danger">{{ $errors->first('course') }}</span>
                                @endif


                                <button type="submit" class="btn btn-white text-center mt-2" style="width:400px;">Add Course</button>
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
                    <h5 class="modal-title text-dark" id="addMajorModalLabel">Add Major</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for adding a new major -->
                    <form id="add-major-form" action="/SuperAdmin/College/AddMajor" method="POST">
                        @csrf
                        <div class="row g-4">

                            <div class="text-center">

                                <label for="course">Select Course</label>
                                <select id="course" name="course_id" class="form-control underline-input">
                                    <option value="f" selected>Select Course</option>
                                    @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->course }}</option>
                                    @endforeach
                                </select>
                                <input type="text" placeholder="Major Name" class="form-control underline-input" name="major" value="" maxlength="100">
                                @if ($errors->has('major'))
                                <span class="text-danger">{{ $errors->first('major') }}</span>
                                @endif
                            </div>
                        </div>
                    </form>

                    <div class="text-center bg-gradient-test rounded-1 mt-4">
                        <a style="font-size:20px;" class="text-white" data-bs-toggle="modal" data-bs-target="#addMajorListModal">Major Table List</a>
                    </div>




                    <div class="text-center">
                        <button type="submit" class="btn btn-white text-center mt-2" style="width:400px;" form="add-major-form">Add Major</button>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" data-modal-id="addMajorListModal" id="addMajorListModal" tabindex="-1" aria-labelledby="addMajorListModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-lg modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="addMajorListModalLabel">Major List</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body overflow-auto" style="max-height: 400px;">
                    <form action="{{ url('/SuperAdmin/College') }}" method="GET" class="search-form">
                        @csrf
                        <div class="d-flex mb-3">
                            <!-- Search Input -->
                            <input type="search" id="search" class="form-control" name="search" placeholder="Search Course" value="{{ request('search') }}" style="font-size: 15px;">

                            <!-- Select Dropdown for Courses -->
                            <select id="course_id" name="course_id" class="form-control mx-2">
                                <option value="">Select a Course</option> <!-- Default option -->
                                @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->course }}
                                </option>
                                @endforeach
                            </select>

                            <!-- Search Button -->
                            <button class="btn btn-primary" type="submit" title="Search">
                                <i class="fas fa-search"></i> Search
                            </button>

                            <!-- Clear Search Button -->
                            <button type="button" title="Clear Search" class="btn btn-secondary" onclick="clearSearch()">
                                <i class="fas fa-backspace"></i> Clear
                            </button>
                        </div>
                    </form>
                    <div class="table-responsive" style="text-align: center;">
                        <table class="table"
                            style="font-size: 16px; border: 1px solid black; margin: 0 auto; width: 100%;">
                            <thead>
                                <tr class="fw-bold" style="color: black;">
                                    @foreach($courseslist as $course)
                                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; 
                           white-space: nowrap;">
                                        {{ $course->course }}
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                // Get the maximum number of majors for a course to ensure equal rows
                                $maxMajorsCount = $courseslist->map(function($course) {
                                return $course->major->count();
                                })->max();
                                @endphp

                                @for($i = 0; $i < $maxMajorsCount; $i++)
                                    <tr>
                                    @foreach($courseslist as $course)
                                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">
                                        @if(isset($course->major[$i]))
                                        {{ $course->major[$i]->major }}
                                        @else
                                        <em>No more majors</em>
                                        @endif
                                    </td>
                                    @endforeach
                                    </tr>
                                    @endfor
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if there is a saved modal state in localStorage
            const openModalId = localStorage.getItem('openModal');

            if (openModalId) {
                const modal = new bootstrap.Modal(document.getElementById(openModalId));
                modal.show(); // Open the modal that was previously open
            }

            // Add event listeners to all modals to save state when opened or closed
            document.querySelectorAll('.modal').forEach(modalElement => {
                const modalId = modalElement.getAttribute('id');
                const bsModal = new bootstrap.Modal(modalElement);

                // When modal is opened, save its state
                modalElement.addEventListener('shown.bs.modal', () => {
                    localStorage.setItem('openModal', modalId);
                });

                // When modal is closed, remove its state
                modalElement.addEventListener('hidden.bs.modal', () => {
                    localStorage.removeItem('openModal');
                });
            });
        });
    </script>

    @endsection