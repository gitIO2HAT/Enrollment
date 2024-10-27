@extends('layouts.app')

@section('content')
<div class="container my-4">
    <!-- Button Group -->


    @include('layouts._message')
    <!-- Table and Filters -->
    <div class="card p-3 rounded shadow-sm">
        <h4 class="text-dark text-center">Archived User</h4>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <form action="{{ url('Reports/Adduser/DeleteUser') }}" class="w-50">
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
                <a type="button" class="btn btn-primary text-white rounded-pill mx-2" href="{{url('Reports/Adduser')}}">
                    Back
                </a>
            </div>
        </div>
        <div class="table-responsive">
        <table class="table table-striped table-hover">
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

                    @csrf
                    <td class="">
                        {{ $user->admin_id }}
                    </td>
                    <td class="">

                        {{ $user->name }}


                    </td>
                    <td class="">

                        {{ $user->username }}


                    <td class="">

                        {{ $user->email }}


                    </td>
                    <td class="">

                        {{ $user->role }}


                    </td>
                    <td class="">
                        <a href="{{ url('/Reports/Adduser/Restore/'.$user->id) }}">
                            <i class="fas fa-trash-alt" style="color: #f56666;"></i>
                        </a>
                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>
</div>

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
@endsection