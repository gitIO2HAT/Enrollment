@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @include('layouts._message')

    <div class="card p-3 rounded shadow-sm m-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <form action="{{ url('/SuperAdmin/Adduser') }}" class="w-50">
                @csrf
                <div class="input-group">
                    <span title="Search" class="input-group-text bg-white border-end">
                        <i class="bi bi-search"></i>
                    </span>
                    <input style="font-size: 12px;"type="search" id="search" class="form-control border-start-0 rounded-1" name="search" placeholder="Search Here" value="{{ request('search') }}" style="width: 50%;">
                    <button style="display: none;" class="btn btn-success m-1 font" type="submit">Search</button>
                    <button style="display: none;" type="hidden" class="btn btn-success m-1" onclick="clearSearch()">Clear</button>
                </div>
            </form>
            <div class="">
                <a type="button" title="Add User" class="btn text-white rounded-pill mx-2" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-user-plus bg-gradient-icon"></i>
                </a>
                <a type="button" title="Archived" class="btn text-white rounded-pill mx-2" href="{{url('SuperAdmin/Adduser/DeleteUser')}}">
                <i class="fas fa-archive" style="color: #ea281a;"></i>
                </a>
            </div>
        </div>
        <div class="table-responsive">
    <table class="table table-striped table-hover font">
        <thead>
            <tr>
                <th>AdminID</th>
                <th>Admin Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <form action="{{ url('/SuperAdmin/Adduser/UpdateUser/'.$user->id) }}" method="POST">
                    @csrf
                    <td>{{ $user->admin_id }}</td>
                    <td>
                        <span id="editable-span-name-{{ $user->id }}" onclick="toggleEdit('name', '{{ $user->id }}')">
                            {{ $user->name }}
                        </span>
                        <input type="text" id="editable-input-name-{{ $user->id }}" name="name" value="{{ $user->name }}" class="form-control text-center" style="display:none;" onblur="toggleEdit('name', '{{ $user->id }}')">
                    </td>
                    <td>
                        <span id="editable-span-username-{{ $user->id }}" onclick="toggleEdit('username', '{{ $user->id }}')">
                            {{ $user->username }}
                        </span>
                        <input type="text" id="editable-input-username-{{ $user->id }}" name="username" value="{{ $user->username }}" class="form-control text-center" style="display:none;" onblur="toggleEdit('username', '{{ $user->id }}')">
                    </td>
                    <td>
                        <span id="editable-span-email-{{ $user->id }}" onclick="toggleEdit('email', '{{ $user->id }}')">
                            {{ $user->email }}
                        </span>
                        <input type="email" id="editable-input-email-{{ $user->id }}" name="email" value="{{ $user->email }}" class="form-control text-center" style="display:none;" onblur="toggleEdit('email', '{{ $user->id }}')">
                    </td>
                    <td>
                        <span id="editable-span-role-{{ $user->id }}" onclick="toggleEdit('role', '{{ $user->id }}')">
                            {{ $user->role }}
                        </span>
                        <input type="text" id="editable-input-role-{{ $user->id }}" name="role" value="{{ $user->role }}" class="form-control text-center" style="display:none;" onblur="toggleEdit('role', '{{ $user->id }}')">
                    </td>
                    <td>
                        <button type="submit" title="Save" style="background: none; border: none; padding: 0; cursor: pointer;">
                            <i class="fas fa-save" style="color: #63E6BE;"></i>
                        </button>
                        <a title="Delete User" href="{{ url('/SuperAdmin/Adduser/Deleted/'.$user->id) }}">
                            <i class="fas fa-trash-alt" style="color: #f56666;"></i>
                        </a>
                    </td>
                </form>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


        <div class="font d-flex justify-content-between align-items-center mt-3">
            <p class="text-muted">
                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
            </p>
            <nav>
                {{ $users->links() }}
            </nav>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="errorModalLabel">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($errors->has('name') || $errors->has('username') || $errors->has('email') || $errors->has('role'))
                    @foreach(['name', 'username', 'email', 'role'] as $field)
                        @if($errors->has($field))
                            <p>{{ $errors->first($field) }}</p>
                        @endif
                    @endforeach
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="addUserModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="text-center" method="POST" action="{{ url('/SuperAdmin/Addadmin') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control underline-input" id="name" name="name" required>
                        @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control underline-input" id="username" name="username" required>
                        @if($errors->has('username'))
                            <span class="text-danger">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role:</label>
                        <select id="role" class="form-control underline-input" name="role">
                            <option selected disabled="">--Select Role--</option>
                            <option value="Admin">Admin</option>
                            <option value="Staff">Staff</option>
                        </select>

                        @if($errors->has('role'))
                            <span class="text-danger">{{ $errors->first('role') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control underline-input" id="email" name="email" required>
                        @if($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
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
