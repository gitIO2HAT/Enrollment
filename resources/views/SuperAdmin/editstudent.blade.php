@extends('layouts.app')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="row g-4">
                @include('layouts._message')
                <div class="col-sm-12 col-xl-12">


                    <div class="bg-white text-center p-4">

                        <h1 class="text-dark">{{$studentdata->student_Id}} - {{$studentdata->lastname}}, {{$studentdata->firstname}} {{$studentdata->middlename}} {{ $studentdata->suffix ? $studentdata->fix->status : '' }}</h1>
                        <div class="user-head">
                            <form method="POST" action="{{ url('/SuperAdmin/Student/Edit/' . $studentdata->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-4 d-flex align-items-center">
                                    <div class="col-sm-4 col-xl-4">
                                        <div class="fields">

                                            <div class="border-light mt-3">
                                                <h5 class="text-dark"></h5>
                                                <h6 class="text-light"></h6>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">First Name:</label>
                                            <input type="text" class="form-control underline-input" id="firstname" name="firstname" value="{{$studentdata->firstname}}">
                                            @if($errors->has('firstname'))
                                            <span class="text-danger">{{ $errors->first('firstname') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label for="lastname" class="form-label">Last Name:</label>
                                            <input type="text" class="form-control underline-input" id="firstname" name="lastname" value="{{$studentdata->lastname}}">
                                            @if($errors->has('lastname'))
                                            <span class="text-danger">{{ $errors->first('lastname') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label for="middlename" class="form-label">Middle Name:</label>
                                            <input type="text" class="form-control underline-input" id="firstname" name="middlename" value="{{$studentdata->middlename}}">
                                            @if($errors->has('middlename'))
                                            <span class="text-danger">{{ $errors->first('middlename') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label for="suffix" class="form-label">Suffix:</label>
                                            <select id="suffix" class="form-control underline-input" name="suffix">
                                                <option selected disabled>--Select Suffix--</option>
                                                @foreach ($suffixs as $fex )
                                                <option value="{{$fex->id}}" @if($studentdata->suffix == $fex->id) selected @endif>{{$fex->status}}</option>
                                                @endforeach
                                                <!-- Course options go here -->
                                            </select>
                                            @if ($errors->has('suffix'))
                                            <span class="text-danger">{{ $errors->first('suffix') }}</span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="col-sm-4 col-xl-4">
                                        <div class="fields">
                                            <div class="mb-3">
                                                <label for="collegeSelectEdit" class="form-label">College<span class="text-primary">*</span>:</label>
                                                <select id="collegeSelectEdit" class="form-control underline-input" name="collegeId">
                                                    <option selected value="">--Select College--</option>
                                                    <!-- College options go here -->
                                                </select>
                                                @if ($errors->has('collegeId'))
                                                <span class="text-danger">{{ $errors->first('collegeId') }}</span>
                                                @endif
                                            </div>
                                            <!-- Course -->
                                            <div class="mb-3">
                                                <label for="courseSelectEdit" class="form-label">Course<span class="text-primary">*</span>:</label>
                                                <select id="courseSelectEdit" disabled class="form-control underline-input" name="courseId">
                                                    <option value=""></option>
                                                    <!-- Course options go here -->
                                                </select>
                                                @if ($errors->has('courseId'))
                                                <span class="text-danger">{{ $errors->first('courseId') }}</span>
                                                @endif
                                            </div>
                                            <!-- Major -->
                                            <div class="mb-3">
                                                <label for="majorSelectEdit" class="form-label">Major<span class="text-primary">*</span>:</label>
                                                <select id="majorSelectEdit" disabled class="form-control underline-input" name="majorId">
                                                    <option value=""></option>
                                                    <!-- Major options go here -->
                                                </select>
                                                @if ($errors->has('majorId'))
                                                <span class="text-danger">{{ $errors->first('majorId') }}</span>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label for="academic_year" class="form-label">Academic Year:</label>
                                                <div class="row">
                                                    <div class="col-5">
                                                        <input type="number" class="form-control underline-input" id="academic_year_start" name="academic_year_start" value="{{$studentdata->academic_year_start}}" min="1900" max="" step="1" oninput="setEndYear()">
                                                    </div>
                                                    <div class="col-2">-</div>
                                                    <div class="col-5">
                                                        <input type="number" class="form-control underline-input" id="academic_year_end" name="academic_year_end" value="{{$studentdata->academic_year_end}}" min="1900" max="" step="1">
                                                    </div>
                                                </div>
                                                @if($errors->has('academic_year_start'))
                                                <span class="text-danger">{{ $errors->first('academic_year_start') }}</span>
                                                @endif
                                                @if($errors->has('academic_year_end'))
                                                <span class="text-danger">{{ $errors->first('academic_year_end') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xl-4">
                                        <div class="fields">
                                            <div class="mb-3">
                                                <label for="sex" class="form-label">Sex<span
                                                        class="text-primary">*</span>:</label>
                                                <select id="sex" class="form-control underline-input" name="sex">
                                                    <option selected disabled="">--Select sex--</option>
                                                    <option value="1" @if($studentdata->sex == 1) selected @endif>Female</option>
                                                    <option value="2" @if($studentdata->sex == 2) selected @endif>Male</option>
                                                    <option value="3" @if($studentdata->sex == 3) selected @endif>Prefer not to say</option>
                                                </select>
                                                @if ($errors->has('sex'))
                                                <span class="text-danger">{{ $errors->first('sex') }}</span>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label for="academic_award" class="form-label">Academic Award:</label>
                                                <select id="academic_award" class="form-control underline-input" name="academic_award">
                                                    <option selected disabled>--Select Awards--</option>
                                                    @foreach ($award as $awards )
                                                    <option value="{{$awards->id}}" @if($studentdata->academic_award == $awards->id) selected @endif>{{$awards->status}}</option>
                                                    @endforeach
                                                    <!-- Course options go here -->
                                                </select>
                                                @if ($errors->has('academic_award'))
                                                <span class="text-danger">{{ $errors->first('academic_award') }}</span>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label for="year_level" class="form-label">Year Level:</label>
                                                <select id="year_level" class="form-control underline-input" name="year_level">
                                                    <option selected disabled>--Select Year Level--</option>
                                                    @foreach ($yearlevel as $year)
                                                    <option value="{{ $year->id }}" @if($studentdata->year_level == $year->id) selected @endif>{{ $year->status }}</option>
                                                    @endforeach
                                                    <!-- Course options go here -->
                                                </select>
                                                @if ($errors->has('year_level'))
                                                <span class="text-danger">{{ $errors->first('year_level') }}</span>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label for="semester" class="form-label">Semester:</label>
                                                <select id="semester" class="form-control underline-input" name="semester">
                                                    <option selected disabled>--Select Semester--</option>
                                                    @foreach ($semester as $sem )
                                                    <option value="{{$sem->id}}" @if($studentdata->semester == $sem->id) selected @endif>{{$sem->status}}</option>
                                                    @endforeach
                                                    <!-- Course options go here -->
                                                </select>
                                                @if ($errors->has('semester'))
                                                <span class="text-danger">{{ $errors->first('semester') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection