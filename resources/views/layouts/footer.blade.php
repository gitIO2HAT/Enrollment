<footer class="text-center">
@if(Request::segment(2) == 'College')
<div class="sticky-widget mb-5" style="display:none;">
        <div class="menu d-flex flex-column">
            <a type="button" title="Add College Department" class="mx-2 my-2 py-2   text-white text-center rounded-2" data-bs-toggle="modal" style="width:90px;" data-bs-target="#addCollegeModal">
                <span class="text-white fs-6"> <i class="fas fa-university  " style="color: #315e26;"></i></span>
            </a>
            <a type="button" title="Add Course"  class="mx-2 my-2 py-2 text-white text-center rounded-2" data-bs-toggle="modal" style="width:90px;" data-bs-target="#addCourseModal">
                <span class="text-white fs-6"> <i class="fas fa-graduation-cap " style="color: #315e26;"></i></span>
            </a>
            <a type="button" title="Add Major"  class="mx-2 my-2 py-2  text-white text-center rounded-2" data-bs-toggle="modal" style="width:90px;" data-bs-target="#addMajorModal">
                <span class="text-white fs-6"> <i class="fas fa-address-book " style="color: #315e26;" ></i></span>
            </a>

        </div>
        <div class="text-end">
            <button class=" rounded-3 close-button" style="position: fixed; width:40px; height:40px; right: 20px; bottom: 60px;background-color: #315e26;"><i class="far fa-arrow-alt-circle-down" style="color: #ffffff;"></i></button>
        </div>
    </div>
    <button id="show-widget" class=" rounded-3" style="position: fixed;width:40px; height:40px; right: 20px; bottom: 60px; display: inline; background-color: #315e26;"><i class="far fa-arrow-alt-circle-up" style="color: #fff;"></i></button>
    @endif
    <div class="d-flex justify-content-center align-items-center my-2">
        <img src="{{ asset('img/usep.png') }}" alt="Logo 1" class="mx-2">
        <img src="{{ asset('img/registrar.png') }}" alt="Logo 2" class="mx-2">
    </div>

    <p class="mb-1 mt-1">University of Southeastern Philippines • Office of the University Registrar</p>
    <p class="mb-1">Copyright © 2025. All Rights Reserved.</p>
    <a href="https://www.usep.edu.ph/usep-data-privacy-statement/#:~:text=The%20University%20shall%20never%20share,consent%20from%20the%20data%20subjects." class="text-muted" target="_blank">Privacy Policy</a>

    <p class="text-muted small mt-1">Beta Testing 0.11.10.24</p>
</footer>
