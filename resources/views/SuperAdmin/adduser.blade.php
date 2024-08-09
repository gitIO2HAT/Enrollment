@extends('layouts.app')

@section('content')
<div class="container my-4">
    <!-- Button Group -->
   
    @include('layouts.btn')
    @include('layouts._message')
    <!-- Table and Filters -->
    <div class="card p-3 rounded shadow-sm">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <form action="{{ url('/SuperAdmin/Adduser') }}" class="w-50">
                @csrf
                <div class="input-group">
                    <span class="input-group-text bg-white border-end">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="search" id="search" class="form-control border-start-0 rounded-1" name="search" placeholder="Search Here" value="{{ request('search') }}" style="width: 50%;">
                    <button style="display: none;" class="btn btn-success m-1" type="submit">Search</button>
                    <button style="display: none;" type="hidden" class="btn btn-success m-1" onclick="clearSearch()">Clear</button>
                </div>
            </form>
            <div class="">
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
                @foreach ($users as $user)
                <tr>
                    <form action="{{ url('/SuperAdmin/Adduser/UpdateUser/'.$user->id) }}" method="POST">
                        @csrf
                        <td class="">
                            {{ $user->admin_id }}
                        </td>
                        <td class="">
                            <span id="editable-span-name-{{ $user->id }}" onclick="toggleEdit('name', '{{ $user->id }}')">
                                {{ $user->name }}
                            </span>
                            <input type="text" id="editable-input-name-{{ $user->id }}" name="name" value="{{ $user->name }}" class="form-control text-center" style="display:none;" onblur="toggleEdit('name', '{{ $user->id }}')">
                        </td>
                        <td class="">
                            <span id="editable-span-username-{{ $user->id }}" onclick="toggleEdit('username', '{{ $user->id }}')">
                                {{ $user->username }}
                            </span>
                            <input type="text" id="editable-input-username-{{ $user->id }}" name="username" value="{{ $user->username }}" class="form-control text-center" style="display:none;" onblur="toggleEdit('username', '{{ $user->id }}')">
                        </td>
                        <td class="">
                            <span id="editable-span-description-{{ $user->id }}" onclick="toggleEdit('description', '{{ $user->id }}')">
                                {{ $user->description }}
                            </span>
                            <input type="text" id="editable-input-description-{{ $user->id }}" name="description" value="{{ $user->description }}" class="form-control text-center" style="display:none;" onblur="toggleEdit('description', '{{ $user->id }}')">
                        </td>
                        <td class="">
                            <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;">
                                <i class="fas fa-save" style="color: #63E6BE;"></i>
                            </button>
                            <a href="{{ url('/SuperAdmin/Adduser/Deleted/'.$user->id) }}">
                                <i class="fas fa-trash-alt" style="color: #f56666;"></i>
                            </a>
                        </td>
                    </form>
                </tr>
                @endforeach
            </tbody>

        </table>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <p class="text-muted">
                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
            </p>
            <nav>
                {{ $users->links() }} <!-- This will generate the pagination links -->
            </nav>
        </div>
    </div>
</div>

<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="addUserModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- Form content here -->
                <form class="text-center" method="POST" action="{{ url('/SuperAdmin/Addadmin') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control underline-input" id="name" name="name" required>
                        @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 ">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control underline-input" id="username" name="username" required>
                        @if($errors->has('username'))
                        <span class="text-danger">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 hidden">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control underline-input" id="password" name="password" value="adminregistrar" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white rounded-pill text-dark" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary rounded-pill text-dark">Add User</button>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection