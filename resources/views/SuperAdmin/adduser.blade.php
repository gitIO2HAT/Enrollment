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

                <button type="button" class="btn btn-warning text-white rounded-pill mx-2" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    Add User
                </button>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>AdminID</th>
                    <th>Admin Name</th>
                    <th>Username</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="5" class="text-center">No data available in table</td>
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

<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form content here -->
                <form>
            <div class="mb-3">
                <label for="adminName" class="form-label">Admin Name:</label>
                <input type="text" class="form-control" id="adminName">
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password">
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password:</label>
                <input type="password" class="form-control" id="confirmPassword">
            </div>
            <div class="mb-3">
                <label for="securityQuestion" class="form-label">Add Answer if Forgot Password:</label>
                <select class="form-select" id="securityQuestion">
                    <option selected>Choose...</option>
                    <option value="1">Mother's Maiden Name</option>
                    <option value="2">First Pet's Name</option>
                    <option value="3">City You Were Born In</option>
                    <option value="4">Name of Your Favorite Teacher</option>
                    <option value="5">Model of Your First Car</option>
                    <option value="6">Title of Your Favorite Book</option>
                    <option value="7">Name of Your First School</option>
                    <option value="8">Title of Your Favorite Movie</option>
                    <option value="9">Your Favorite Color</option>
                    <option value="10">Name of Your Best Friend in Childhood</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="answer" class="form-label">Answer:</label>
                <input type="text" class="form-control" id="answer">
            </div>
        </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white rounded-pill text-dark" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill text-dark">Add User</button>
            </div>
        </div>
    </div>
</div>

@endsection