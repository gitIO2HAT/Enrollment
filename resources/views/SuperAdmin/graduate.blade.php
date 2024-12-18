@extends('layouts.app')

@section('content')
@include('layouts._message')

<!-- Button Group -->


<!-- Table and Filters -->
<div class="card p-3 rounded m-5">
    <div>
        <form action="{{ url('/Reports/Graduate') }}" method="GET" class="search-form">
            @csrf

            <div class="d-flex w-100">
                <!-- Clear Search Button -->
                <button type="button" title="Clear Search Filter" class="btn" onclick="clearSearch()">
                    <i class="fas fa-backspace" style="color: #e85617;"></i>
                </button>

                <!-- Search Input -->
                <span class=" bg-white ">
                    <button class="btn" title="Search" type="submit">
                        <i class="fas fa-search" style="color: #e0230a;"></i>
                    </button>
                </span>

                <input type="search" id="search" class="form-control " name="search" placeholder="Search Here" value="{{ request('search') }}" style="font-size: 15px;">

                <!-- College Selection -->
                <select id="collegeSelect" class="form-select mx-1" name="collegeId" style="font-size: 15px;">
                    <option value="" selected disabled>--College--</option>
                    <!-- College options go here -->
                </select>

                <!-- Course Selection -->
                <select id="courseSelect" class="form-select mx-1" name="courseId" style="font-size: 15px;">
                    <option value="" selected disabled>--Course--</option>
                    <!-- Course options go here -->
                </select>

                <!-- Major Selection -->
                <select id="majorSelect" class="form-select mx-1" name="majorId" style="font-size: 15px;">
                    <option value="" selected disabled>--Major--</option>
                    <!-- Major options go here -->
                </select>

                <!-- Awards Selection -->
                <select id="awardsSelect" class="form-select mx-1" name="awardsId" style="font-size: 15px;">
                    <option selected disabled>--Awards--</option>
                    @foreach ($awards as $award)
                    <option value="{{ $award->id }}">{{ $award->status }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Action buttons for importing file and adding students -->

                <a type="button" title="Import File" class="btn rounded-2 mx-1" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="fas fa-file-import bg-gradient-icon"></i>
                </a>

                <a type="button" title="Add Students" class="btn rounded-2 mx-1" data-bs-toggle="modal" data-bs-target="#studentModal">
                    <i class="fas fa-user-plus bg-gradient-icon"></i>
                </a>

        </form>
    </div>

    <div class="table-responsive">
        <table class="font table table-striped table-hover">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>#</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Sex</th>
                    <th>College</th>
                    <th>Course</th>
                    <th>Major</th>
                    <th>Year Level</th>

                    <th>Academic Award</th>
                    <th>Academic Year</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <form id="export-form" action="{{ url('Reports/Export') }}" method="POST">
                    @csrf
                    @foreach ($studentdata as $index => $student)
                    <tr>
                        <td>
                            <input type="checkbox" name="student_Ids[]" value="{{ $student->id }}" onclick="toggleActionLinks();">
                        </td>
                        <td>{{ ($studentdata->currentPage() - 1) * $studentdata->perPage() + $index + 1 }}</td>
                        <td>{{ $student->student_Id }}</td>
                        <td>{{ $student->lastname }}, {{ $student->firstname }} {{ $student->middlename }} {{ $student->suffix ? $student->fix->status : '' }}</td>
                        <td>@if($student->sex == 1)
                            Female
                            @elseif($student->sex == 2)
                            Male
                            @endif</td>
                        <td>{{ $student->college ? $student->college->college : 'N/A' }}</td>
                        <td>{{ $student->course ? $student->course->course : 'N/A' }}</td>
                        <td>{{ $student->major ? $student->major->major : 'N/A' }}</td>
                        <td>{{ $student->yearlevel->status }}</td>
                        <td>{{ $student->awards ? $student->awards->status : 'N/A'}}</td>
                        <td>{{ $student->academic_year_start }} - {{ $student->academic_year_end }}</td>


                        <td>
                            <a type="button" title="Edit <?php echo $student->lastname; ?>" href="{{ url('/Reports/Student/' . $student->id) }}">
                                <i class="far fa-edit" style="color: #39a1ec;"></i>
                            </a>

                        </td>
                    </tr>
                    @endforeach
                </form>

            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3">
        <p class="text-muted">
            Showing {{ $studentdata->firstItem() }} to {{ $studentdata->lastItem() }} of {{ $studentdata->total() }}
            entries
        </p>
        <nav>
            {{ $studentdata->links() }} <!-- This will generate the pagination links -->
        </nav>
    </div>
    <div id="action-links" style="display: none;">
        <a class=" p-2 rounded-1 mx-2 bg-hover" href="#" onclick="document.getElementById('export-form').submit();">Export</a>
        <a class=" p-2 rounded-1 mx-2 bg-hover" href="#" id="select-all" onclick="selectAllCheckboxes(); return false;">Select All</a>
        <a class=" p-2 rounded-1 mx-2 bg-hover" href="#" id="deselect-all" onclick="deselectAllCheckboxes(); return false;">Deselect All</a>
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
                    <form class="text-center" id="import_file" method="POST" action="{{ url('Reports/Student/Import') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" class="form-control" name="file" required>
                        <!-- Corrected the download link -->
                        <a href="{{ asset('public/accountprofile/Graduate Format for Listing MS Excel Worksheet.xlsx') }}" download><u>Download Graduate Excel Format Here</u></a>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary rounded-pill text-dark" form="import_file">Import</button>
                </div>
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
                    <form class="text-center" method="POST" action="{{ url('/Reports/Enrollment/AddStudent') }}">
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
                        <div class="mb-3">
                            <label for="suffix" class="form-label">Suffix:</label>
                            <select id="suffix" class="form-control underline-input" name="suffix">
                                <option value="" selected disabled>--Select Suffix--</option>
                                @foreach ($suffixs as $fix)
                                <option value="{{ $fix->id }}">{{ $fix->status }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('suffix'))
                            <span class="text-danger">{{ $errors->first('suffix') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="sex" class="form-label">Sex<span
                                    class="text-primary">*</span>:</label>
                            <select id="sex" class="form-control underline-input" name="sex">
                                <option value="" selected disabled>--Select Sex--</option>
                                <option value="1">Female</option>
                                <option value="2">Male</option>
                            </select>
                            @if ($errors->has('sex'))
                            <span class="text-danger">{{ $errors->first('sex') }}</span>
                            @endif
                        </div>
                        <!-- College -->
                        <div class="mb-3">
                            <label for="collegeSelectGraduate" class="form-label">College<span
                                    class="text-primary">*</span>:</label>
                            <select id="collegeSelectGraduate" class="form-control underline-input" name="collegeId">
                                <option value="">Select College</option>
                                <!-- College options go here -->
                            </select>
                            @if ($errors->has('collegeId'))
                            <span class="text-danger">{{ $errors->first('collegeId') }}</span>
                            @endif
                        </div>
                        <!-- Course -->
                        <div class="mb-3">
                            <label for="courseSelectGraduate" class="form-label">Course:</label>
                            <select id="courseSelectGraduate" disabled class="form-control underline-input" name="courseId">
                                <option value="">Select Course</option>
                                <!-- Course options go here -->
                            </select>
                            @if ($errors->has('courseId'))
                            <span class="text-danger">{{ $errors->first('courseId') }}</span>
                            @endif
                        </div>
                        <!-- Major -->
                        <div class="mb-3">
                            <label for="majorSelectGraduate" class="form-label">Major:</label>
                            <select id="majorSelectGraduate" disabled class="form-control underline-input" name="majorId">
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
                                <option value="7" selected >Graduated</option>



                            </select>
                            @if ($errors->has('year_level'))
                            <span class="text-danger">{{ $errors->first('year_level') }}</span>
                            @endif
                        </div>
                        <!-- Semester -->
                        <div class="mb-3 ">
                            <label for="semesterSelect" class="form-label">Semester<span
                                    class="text-primary">*</span>:</label>
                            <select id="semesterSelect" class="form-control underline-input" name="semester">
                                <option value="4" selected >N/A</option>


                            </select>
                            @if ($errors->has('semester'))
                            <span class="text-danger">{{ $errors->first('semester') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="academic_year" class="form-label">Academic Year<span
                                    class="text-primary">*</span>:</label>
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
    </div>
</div>
@endsection
