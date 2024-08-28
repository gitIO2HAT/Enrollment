<header class="d-flex align-items-center justify-content-between p-2 bg-light border-bottom">
    <div class="d-flex align-items-center">
        <img src="{{ asset('img/registrar.png') }}" alt="Logo" class="me-3 pe-3 border-end" style="height: 50px;">
        <div class="vr mx-3"></div>
    </div>

    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="btn-group">
            <a class="btn btn-danger rounded-pill px-4 me-2" href="{{url('/SuperAdmin/Enrollment')}}">Enrollment Report</a>
            <a class="btn btn-danger rounded-pill px-4 me-2" href="{{url('/SuperAdmin/Graduate')}}">Graduate Report</a>
            <a class="btn btn-danger rounded-pill me-2" href="{{url('/SuperAdmin/College')}}">College</a>
            <a class="btn btn-danger rounded-pill px-4" href="{{url('/SuperAdmin/Adduser')}}">Add User</a>
        </div>
    </div>

    <div class="d-flex align-items-center">
        <div class="vr mx-3"></div>
        <div class="dropdown border-start pe-3">
            <a class="btn d-flex align-items-center " type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="rounded-circle pe-3" style="height: 50px;" id="profilePicture" src="{{ asset('public/accountprofile/' . Auth::user()->profile_pic) }}">
                <span>{{Auth::user()->name}}</span>
                <i class="bi bi-caret-down-fill ms-2" style="color: #000000;"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="{{url('/SuperAdmin/Profile')}}">Profile</a></li>
                <li><a class="dropdown-item" href="{{route('logoutButton')}}">Logout</a></li>
            </ul>
        </div>
    </div>
</header>
