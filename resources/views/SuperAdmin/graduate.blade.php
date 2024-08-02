@extends('layouts.app')

@section('content')
<div class="container my-4">
        <!-- Button Group -->
        <div class="mb-4">
            <button class="btn btn-danger rounded-pill mx-2">Add Student</button>
            <button class="btn btn-danger rounded-pill mx-2">Add College</button>
            <button class="btn btn-danger rounded-pill mx-2">Export</button>
            <button class="btn btn-danger rounded-pill mx-2">Import</button>
            <button class="btn btn-danger rounded-pill mx-2">Select All</button>
        </div>

        <!-- Table and Filters -->
        <div class="card p-3 rounded shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="input-group w-50">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Search...">
                </div>
                <div class="d-flex">
                    <select class="form-select me-2">
                        <option selected>College:</option>
                        <option value="1">College 1</option>
                        <option value="2">College 2</option>
                    </select>
                    <select class="form-select me-2">
                        <option selected>Course:</option>
                        <option value="1">Course 1</option>
                        <option value="2">Course 2</option>
                    </select>
                    <select class="form-select me-2">
                        <option selected>Year Level:</option>
                        <option value="1">Year 1</option>
                        <option value="2">Year 2</option>
                    </select>
                    <select class="form-select">
                        <option selected>Semester:</option>
                        <option value="1">1st Semester</option>
                        <option value="2">2nd Semester</option>
                    </select>
                </div>
            </div>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
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
                    <tr>
                        <td colspan="8" class="text-center">No data available in table</td>
                    </tr>
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <p class="text-muted">Showing 0 to 0 of 0 entries</p>
                <nav>
                    <ul class="pagination mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection