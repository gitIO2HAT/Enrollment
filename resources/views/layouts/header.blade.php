<header class="d-flex align-items-center justify-content-between p-2 bg-light border-bottom">
    <div class="d-flex align-items-center">
        <img src="{{ asset('img/registrar.png') }}" alt="Logo" class="me-3 pe-3 border-end" style="height: 50px;">
        <div class="vr mx-3"></div>
    </div>

    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="btn-group">
            @if(Request::segment(2)== 'Enrollment')
            <a class="btn bg-gradient-test rounded-pill px-4 me-2" href="{{url('/SuperAdmin/Enrollment')}}">Enrollment Report</a>
            @else
            <a class="btn  bg-hover rounded-pill px-4 me-2 " href="{{url('/SuperAdmin/Enrollment')}}">Enrollment Report</a>
            @endif
            @if(Request::segment(2)== 'Graduate')
            <a class="btn bg-gradient-test rounded-pill px-4 me-2" href="{{url('/SuperAdmin/Graduate')}}">Graduate Report</a>
            @else
            <a class="btn bg-hover rounded-pill px-4 me-2 " href="{{url('/SuperAdmin/Graduate')}}">Graduate Report</a>
            @endif
            @if(Request::segment(2)== 'College')
            <a class="btn bg-gradient-test rounded-pill me-2" href="{{url('/SuperAdmin/College')}}">College</a>
            @else
            <a class="btn bg-hover rounded-pill me-2 " href="{{url('/SuperAdmin/College')}}">College</a>
            @endif
            @if(Request::segment(2)== 'Adduser')
            <a class="btn bg-gradient-test rounded-pill px-4" href="{{url('/SuperAdmin/Adduser')}}">Add User</a>
            @else
            <a class="btn bg-hover rounded-pill px-4 " href="{{url('/SuperAdmin/Adduser')}}">Add User</a>
            @endif

        </div>
    </div>

    <div class="d-flex align-items-center">
        <div class="vr mx-3"></div>
        <div class="dropdown border-start pe-3">
            <a class="btn d-flex align-items-center " type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="rounded-circle mx-1"  src="{{ asset('public/accountprofile/' . Auth::user()->profile_pic) }}"
                    alt="Profile Picture" style="width: 50px; height: 50px; object-fit: cover;">

                <span>{{Auth::user()->name}}</span>
                <i class="bi bi-caret-down-fill ms-2" style="color: #000000;"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="{{url('/SuperAdmin/Profile')}}">Profile</a></li>
                <li><a class="dropdown-item" href="{{route('logoutButton')}}" onclick="return confirm('Are you sure you want to logout?');">Logout</a></li>
            </ul>
        </div>
    </div>
</header>