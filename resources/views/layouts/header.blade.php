
<header class="header-container shadow ">
    <div class="   border-end border-light px-3">
        <img class="rounded-circle d-flex align-items-center " src="{{ asset('img/registrar.png') }}" alt="Profile Picture" style="width: 30px; height: 30px; object-fit: cover;">
        <div class="vr mx-3"></div>
    </div>

    <div class="font">
        <div class=" btn-group">
        @if(Request::segment(2) == 'Enrollment')
            <a class="btn  bg-gradient-test rounded-pill  text-center font-adjust px-4" href="{{ url('/Reports/Enrollment') }}">Enrollment Reports</a>
            @else
            <a class="btn  bg-hover rounded-pill  text-light text-center font-adjust px-4" href="{{ url('/Reports/Enrollment') }}">Enrollment Reports</a>
            @endif
            @if(Request::segment(2) == 'Graduate')
            <a class="btn  bg-gradient-test rounded-pill  text-center font-adjust px-4" href="{{ url('/Reports/Graduate') }}">Graduate Reports</a>
            @else
            <a class="btn  bg-hover rounded-pill  text-light text-center font-adjust px-4" href="{{ url('/Reports/Graduate') }}">Graduate Reports</a>
            @endif
            @if(Request::segment(2) == 'College')
            <a class="btn  bg-gradient-test rounded-pill  text-center font-adjust px-4 " href="{{ url('/Reports/College') }}">Colleges</a>
            @else
            <a class="btn  bg-hover rounded-pill  text-light text-center font-adjust px-4" href="{{ url('/Reports/College') }}">Colleges</a>
            @endif
            @if(Auth::user()->admin_id == '2024-adm-001')
            @if(Request::segment(2) == 'Adduser')
            <a class="btn  bg-gradient-test rounded-pill text-center font-adjust px-4" href="{{ url('/Reports/Adduser') }}">Add User</a>
            @else
            <a class="btn  bg-hover rounded-pill text-light text-center font-adjust px-4" href="{{ url('/Reports/Adduser') }}">Add User</a>
            @endif
            @endif
        </div>
    </div>

    <div class="d-flex align-items-center">
        <div class="vr mx-3"></div>
        <div class="dropdown pe-3">
            <a class="btn d-flex align-items-center" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="rounded-circle mx-1" src="{{ asset('public/accountprofile/' . Auth::user()->profile_pic) }}" alt="Profile Picture" style="width: 30px; height: 30px; object-fit: cover;">
                <span class=" font-adjust" >{{ Auth::user()->name }}</span>
                <i class="bi bi-caret-down-fill ms-2" style="color: #000000;"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="{{ url('/Reports/Profile') }}">Profile</a></li>
                <li><a class="dropdown-item" href="{{ route('logoutButton') }}" onclick="return confirm('Are you sure you want to logout?');">Logout</a></li>
            </ul>
        </div>
    </div>
</header>
