@extends('layouts.app')

@section('content')
@include('layouts._message')

<!-- Button Group -->


<!-- Table and Filters -->
<div class="card p-3 rounded m-5">
    <div>
        <form action="{{ url('/SuperAdmin/Graduate') }}" method="GET" class="d-flex justify-content-between align-items-center mb-3">
            @csrf

            <div class="d-flex w-100">

            <button type="hidden" title="Clear Search Filter" class="btn m-1" onclick="clearSearch()"><i class="fas fa-backspace" style="color: #e85617;"></i></button>
                <span class="input-group-text bg-white border-end-0">
                <button class="btn " title="Search" type="submit"><i class="fas fa-search" style="color: #e0230a;"></i></button>
                </span>
                <input style="font-size: 15px;" type="search" id="search" class="form-control border-start-0" name="search" placeholder="Search Here" value="{{ request('search') }}" style="width: 100%">


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




                <select id="awardsSelect" class="form-select mx-1" name="awardsId" style="font-size: 15px;">
                    <option selected disabled>--Awards--</option>
                    @foreach ($awards as $award)
                    <option value="{{ $award->id }}">{{ $award->status }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

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
        <form id="export-form" action="{{ url('SuperAdmin/Export') }}" method="POST">
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
                    <a type="button" title="Edit <?php echo $student->lastname; ?>" href="{{ url('/SuperAdmin/Student/' . $student->id) }}">
                        <i class="far fa-edit" style="color: #39a1ec;"></i>
                    </a>

                </td>
            </tr>
            @endforeach
        </form>

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
    <div id="action-links" style="display: none;">
    <a class= " p-2 rounded-1 mx-2 bg-hover" href="#" onclick="document.getElementById('export-form').submit();">Export</a>
    <a class= " p-2 rounded-1 mx-2 bg-hover" href="#" id="select-all" onclick="selectAllCheckboxes(); return false;">Select All</a>
    <a class= " p-2 rounded-1 mx-2 bg-hover" href="#" id="deselect-all" onclick="deselectAllCheckboxes(); return false;">Deselect All</a>
</div>
    </div>
@endsection
