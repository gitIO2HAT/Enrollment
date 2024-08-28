@extends('layouts.app')

@section('content')
    @include('layouts._message')

    <!-- Button Group -->


    <!-- Table and Filters -->
    <div class="card p-3 rounded shadow-sm my-4">
        <div >
            <form action="{{ url('/SuperAdmin/Enrollment') }}" method="GET" class="d-flex justify-content-between align-items-center mb-3">
                @csrf

                <div class="d-flex w-100">
                    <button class="btn btn-success m-1" type="submit">Search</button>
                    <button  type="hidden" class="btn btn-light m-1" onclick="clearSearch()">Clear</button>
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="search" id="search" class="form-control border-start-0" name="search" placeholder="Search Here" value="{{ request('search') }}" style="width: 100%">


                    <!-- College Selection -->
                    <select id="collegeSelect" class="form-select mx-1" name="collegeId">
                        <option value="" selected disabled>--College--</option>
                        <!-- College options go here -->
                    </select>

                    <!-- Course Selection -->
                    <select id="courseSelect" class="form-select mx-1" name="courseId">
                        <option value="" selected disabled>--Course--</option>
                        <!-- Course options go here -->
                    </select>

                    <!-- Major Selection -->
                    <select id="majorSelect" class="form-select mx-1" name="majorId">
                        <option value="" selected disabled>--Major--</option>
                        <!-- Major options go here -->
                    </select>

                    <!-- Year Level Selection -->
                    <select id="yearLevelSelect" class="form-select mx-1" name="yearLevelId">
                        <option selected disabled>--Year Level--</option>
                        @foreach ($years as $year)
                        <option value="{{ $year->id }}">{{ $year->status }}</option>
                        @endforeach
                    </select>

                    <!-- Semester Selection -->
                    <select id="semesterSelect" class="form-select mx-1" name="semesterId">
                        <option selected disabled>--Semester--</option>
                        @foreach ($semester as $sem)
                        <option value="{{ $sem->id }}">{{ $sem->status }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <a type="button" class="btn btn-info text-white rounded-2 mx-1" data-bs-toggle="modal" data-bs-target="#importModal">
                        Import
                    </a>
                </div>
                <div>
                    <a type="button" class="btn btn-warning text-white rounded-2 mx-1" data-bs-toggle="modal" data-bs-target="#studentModal">
                        Student
                    </a>
                </div>
            </form>
        </div>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>College</th>
                    <th>Course</th>
                    <th>Major</th>
                    <th>Year Level</th>
                    <th>Semester</th>
                    <th>Academic Year</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($studentdata as $index => $student)
                    <tr>
                        <td>{{ ($studentdata->currentPage() - 1) * $studentdata->perPage() + $index + 1 }}</td>
                        <td>{{ $student->student_Id }}</td>
                        <td>{{ $student->lastname }}, {{ $student->firstname }} {{ $student->middlename }}</td>
                        <td>{{ $student->college ? $student->college->college : 'N/A' }}</td>
                        <td>{{ $student->course ? $student->course->course : 'N/A' }}</td>
                        <td>{{ $student->major ? $student->major->major : 'N/A' }}</td>
                        <td>{{ $student->yearlevel->status }}</td>
                        <td>{{ $student->semesters->status }}</td>



                        <td>{{ $student->academic_year_start }} - {{ $student->academic_year_end }}</td>


                        <td>
                            <a type="button" href="{{ url('/SuperAdmin/Student/' . $student->id) }}" >
                                <i class="far fa-edit" style="color: #090909;"></i>
                            </a>

                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <p class="text-muted">
                Showing {{ $studentdata->firstItem() }} to {{ $studentdata->lastItem() }} of {{ $studentdata->total() }}
                entries
            </p>
            <nav>
                {{ $studentdata->links() }} <!-- This will generate the pagination links -->
            </nav>
        </div>
    </div>

    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="importModalLabel">Import Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!-- Form content here -->
                    <form class="text-center" method="POST" action="{{ url('') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control underline-input" id="name" name="name"
                                required>
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="mb-3 ">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" class="form-control underline-input" id="username" name="username"
                                required>
                            @if ($errors->has('username'))
                                <span class="text-danger">{{ $errors->first('username') }}</span>
                            @endif
                        </div>
                        <div class="mb-3 hidden">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" class="form-control underline-input" id="password" name="password"
                                value="adminregistrar" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white rounded-pill text-dark"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill text-dark">Add User</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="studentModalLabel">Add Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!-- Form content here -->
                    <form class="text-center" method="POST" action="{{ url('/SuperAdmin/Enrollment/AddStudent') }}">
                        @csrf

                        <!-- First Name -->
                        <div class="mb-3">
                            <label for="firstname" class="form-label">First Name<span
                                    class="text-primary">*</span>:</label>
                            <input type="text" class="form-control underline-input" id="firstname" name="firstname"
                                value="{{ old('firstname') }}" required>
                            @if ($errors->has('firstname'))
                                <span class="text-danger">{{ $errors->first('firstname') }}</span>
                            @endif
                        </div>

                        <!-- Last Name -->
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Last Name<span
                                    class="text-primary">*</span>:</label>
                            <input type="text" class="form-control underline-input" id="lastname" name="lastname"
                                value="{{ old('lastname') }}" required>
                            @if ($errors->has('lastname'))
                                <span class="text-danger">{{ $errors->first('lastname') }}</span>
                            @endif
                        </div>

                        <!-- Middle Name -->
                        <div class="mb-3">
                            <label for="middlename" class="form-label">Middle Name:</label>
                            <input type="text" class="form-control underline-input" id="middlename" name="middlename"
                                value="{{ old('middlename') }}">
                            @if ($errors->has('middlename'))
                                <span class="text-danger">{{ $errors->first('middlename') }}</span>
                            @endif
                        </div>

                        <!-- College -->
                        <div class="mb-3">
                            <label for="collegeSelect" class="form-label">College<span
                                    class="text-primary">*</span>:</label>
                            <select id="collegeSelect" class="form-control underline-input" name="collegeId">
                                <option value="">Select College</option>
                                <!-- College options go here -->
                            </select>
                            @if ($errors->has('collegeId'))
                                <span class="text-danger">{{ $errors->first('collegeId') }}</span>
                            @endif
                        </div>

                        <!-- Course -->
                        <div class="mb-3">
                            <label for="courseSelect" class="form-label">Course<span
                                    class="text-primary">*</span>:</label>
                            <select id="courseSelect" disabled class="form-control underline-input" name="courseId">
                                <option value="">Select Course</option>
                                <!-- Course options go here -->
                            </select>
                            @if ($errors->has('courseId'))
                                <span class="text-danger">{{ $errors->first('courseId') }}</span>
                            @endif
                        </div>

                        <!-- Major -->
                        <div class="mb-3">
                            <label for="majorSelect" class="form-label">Major<span class="text-primary">*</span>:</label>
                            <select id="majorSelect" disabled class="form-control underline-input" name="majorId">
                                <option value="">Select Major</option>
                                <!-- Major options go here -->
                            </select>
                            @if ($errors->has('majorId'))
                                <span class="text-danger">{{ $errors->first('majorId') }}</span>
                            @endif
                        </div>

                        <!-- Year Level -->
                        <div class="mb-3">
                            <label for="year_levelSelect" class="form-label">Year Level<span
                                    class="text-primary">*</span>:</label>
                            <select id="year_levelSelect" class="form-control underline-input" name="year_level">
                                <option value="" selected disabled>--Select Year Level--</option>
                                @foreach ($yearlevels as $year)
                                    <option value="{{ $year->id }}">{{ $year->status }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('year_level'))
                                <span class="text-danger">{{ $errors->first('year_level') }}</span>
                            @endif
                        </div>

                        <!-- Semester -->
                        <div class="mb-3">
                            <label for="semesterSelect" class="form-label">Semester<span
                                    class="text-primary">*</span>:</label>
                            <select id="semesterSelect" class="form-control underline-input" name="semester">
                                <option value="" selected disabled>--Select Semester--</option>
                                @foreach ($semester as $sem)
                                    <option value="{{ $sem->id }}">{{ $sem->status }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('semester'))
                                <span class="text-danger">{{ $errors->first('semester') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="academic_year" class="form-label">Academic Year:</label>
                            <div class="row">
                                <div class="col-5">
                                    <input type="number" class="form-control underline-input" id="academic_year_start" name="academic_year_start" min="1900" max="2099" step="1" oninput="setEndYear()">
                                </div>
                                <div class="col-2">-</div>
                                <div class="col-5">
                                    <input type="number" class="form-control underline-input" id="academic_year_end" name="academic_year_end" min="1900" max="2099" step="1">
                                </div>
                            </div>
                            @if($errors->has('academic_year_start'))
                            <span class="text-danger">{{ $errors->first('academic_year_start') }}</span>
                            @endif
                            @if($errors->has('academic_year_end'))
                            <span class="text-danger">{{ $errors->first('academic_year_end') }}</span>
                            @endif
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-white rounded-pill text-dark"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary rounded-pill text-dark">Add Student</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    @endsection
