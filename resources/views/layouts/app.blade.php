<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
 
    <title>Enrollment Report - {{Request::segment(2)}} - {{Request::segment(3)}}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{ asset('img/registrar.png') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
</head>


<body>



        <!-- sidebar-menu Start -->

        <!-- sidebar-menu Start -->



        <div class="content bg-white ">

            <!-- header Start -->
            @include('layouts.header')
            <!-- header end -->


            <!-- Dashboard Start -->
            @yield('content')

            <!-- Dashboard end -->
            @include('layouts.footer')

        </div>





    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('lib/chart/chart.min.js')}}"></script>
    <script src="{{asset('lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('lib/tempusdominus/js/moment.min.js')}}"></script>
    <script src="{{asset('lib/tempusdominus/js/moment-timezone.min.js')}}"></script>
    <script src="{{asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    @stack('javascript')
</body>

<script>
        // Clear Search
        function clearSearch() {
            document.getElementById('search').value = '';
            document.querySelector('form').submit();
        }
    </script>
   <script>
    function handleImageClick(event) {
        // Prevent the default behavior of the click event on the label
        event.preventDefault();

        // Trigger file input click when the image is clicked
        document.getElementById('profileImage').click();
    }

    function displayImage(input) {
        var reader = new FileReader();

        reader.onload = function (e) {
            document.getElementById('profilePicture').src = e.target.result;
        };

        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<script>
document.querySelector('.close-button').addEventListener('click', function() {
    document.querySelector('.sticky-widget').style.display = 'none';
    document.querySelector('#show-widget').style.display = 'block'; // Show the 'Show Widget' button
});

document.querySelector('#show-widget').addEventListener('click', function() {
    document.querySelector('.sticky-widget').style.display = 'block';
    this.style.display = 'none'; // Hide the 'Show Widget' button
});

</script>








<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all checkboxes
        const checkboxes = document.querySelectorAll('input[name="selected_users[]"]');

        checkboxes.forEach(function(checkbox) {
            // Add event listener to each checkbox
            checkbox.addEventListener('change', function() {
                // Get the parent row of the checkbox
                const row = checkbox.closest('tr');

                // Toggle the 'selected-row' class based on checkbox status
                if (checkbox.checked) {
                    row.classList.add('selected-row');
                } else {
                    row.classList.remove('selected-row');
                }
            });

            // Add click event to the entire row to toggle checkbox state
            const row = checkbox.closest('tr');
            row.addEventListener('click', function() {
                checkbox.checked = !checkbox.checked;
                // Trigger change event manually
                checkbox.dispatchEvent(new Event('change'));
            });
        });
    });
</script>

<script>
    function setMinEndTime() {
        var startDateInput = document.getElementById("scheduled_date");
        var endDateInput = document.getElementById("scheduled_end");

        if (startDateInput.value) {
            endDateInput.min = startDateInput.value;
        }
    }
</script>
<script>
    document.getElementById('birth_date').addEventListener('change', function() {
        var birthDate = new Date(this.value);
        var today = new Date();
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        document.getElementById('age').value = age;
    });
</script>

<script>
    function toggleEdit(field, id) {
        var span = document.getElementById('editable-span-' + field + '-' + id);
        var input = document.getElementById('editable-input-' + field + '-' + id);

        if (span.style.display !== 'none') {
            // Hide the span and show the input
            span.style.display = 'none';
            input.style.display = 'inline';
            input.focus();
        } else {
            // Hide the input and show the span
            span.style.display = 'inline';
            input.style.display = 'none';
            span.innerText = input.value;
        }
    }
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const collegeSelect = document.getElementById('collegeSelect');
        const courseSelect = document.getElementById('courseSelect');
        const majorSelect = document.getElementById('majorSelect');

        // Pre-selected IDs from the server-side data
        const selectedCollegeId = {{ $studentdata->collegeId ?? 'null' }};
        let selectedCourseId = {{ $studentdata->courseId ?? 'null' }};
        const selectedMajorId = {{ $studentdata->majorId ?? 'null' }};

        // Handle cases where Blade might return a string 'null' instead of actual null
        const validSelectedCollegeId = selectedCollegeId === 'null' ? null : selectedCollegeId;
        selectedCourseId = selectedCourseId === 'null' ? null : selectedCourseId;
        const validSelectedMajorId = selectedMajorId === 'null' ? null : selectedMajorId;

        // Fetch and populate colleges on page load
        fetch('/colleges')
            .then(response => response.json())
            .then(data => {
                data.forEach(college => {
                    let option = new Option(college.college, college.id);
                    collegeSelect.add(option);
                });

                // Pre-select the college if available
                if (validSelectedCollegeId) {
                    collegeSelect.value = validSelectedCollegeId;
                    collegeSelect.dispatchEvent(new Event('change')); // Trigger the change event to load courses
                }
            });

        // Event listener for when college is selected
        collegeSelect.addEventListener('change', function() {
            courseSelect.length = 1; // Remove all options except the default
            majorSelect.length = 1; // Remove all options except the default
            majorSelect.disabled = true;

            const selectedCollegeId = this.value;
            if (selectedCollegeId) {
                courseSelect.disabled = false;

                fetch(`/courses/${selectedCollegeId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(course => {
                            let option = new Option(course.course, course.id);
                            courseSelect.add(option);
                        });

                        // Pre-select the course if available
                        if (selectedCourseId) {
                            courseSelect.value = selectedCourseId;
                            courseSelect.dispatchEvent(new Event('change')); // Trigger the change event to load majors
                            selectedCourseId = null; // Reset to avoid conflict if the user changes the selection
                        }
                    });
            } else {
                courseSelect.disabled = true;
                majorSelect.disabled = true;
            }
        });

        // Event listener for when course is selected
        courseSelect.addEventListener('change', function() {
            majorSelect.length = 1; // Remove all options except the default

            selectedCourseId = this.value; // Assign value to the already declared variable
            if (selectedCourseId) {
                majorSelect.disabled = false;

                fetch(`/majors/${selectedCourseId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(major => {
                            let option = new Option(major.major, major.id);
                            majorSelect.add(option);
                        });

                        // Pre-select the major if available
                        if (validSelectedMajorId) {
                            majorSelect.value = validSelectedMajorId;
                        }
                    });
            } else {
                majorSelect.disabled = true;
            }
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const collegeSelect = document.getElementById('collegeSelectSearch');
        const courseSelect = document.getElementById('courseSelectSearch');
        const majorSelect = document.getElementById('majorSelectSearch');

       
        // Fetch and populate colleges on page load
        fetch('/colleges')
            .then(response => response.json())
            .then(data => {
                data.forEach(college => {
                    let option = new Option(college.college, college.id);
                    collegeSelect.add(option);
                });

                // Pre-select the college if available
                if (validSelectedCollegeId) {
                    collegeSelect.value = validSelectedCollegeId;
                    collegeSelect.dispatchEvent(new Event('change')); // Trigger the change event to load courses
                }
            });

        // Event listener for when college is selected
        collegeSelect.addEventListener('change', function() {
            courseSelect.length = 1; // Remove all options except the default
            majorSelect.length = 1; // Remove all options except the default
            majorSelect.disabled = true;

            const selectedCollegeId = this.value;
            if (selectedCollegeId) {
                courseSelect.disabled = false;

                fetch(`/courses/${selectedCollegeId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(course => {
                            let option = new Option(course.course, course.id);
                            courseSelect.add(option);
                        });

                        // Pre-select the course if available
                        if (selectedCourseId) {
                            courseSelect.value = selectedCourseId;
                            courseSelect.dispatchEvent(new Event('change')); // Trigger the change event to load majors
                            selectedCourseId = null; // Reset to avoid conflict if the user changes the selection
                        }
                    });
            } else {
                courseSelect.disabled = true;
                majorSelect.disabled = true;
            }
        });

        // Event listener for when course is selected
        courseSelect.addEventListener('change', function() {
            majorSelect.length = 1; // Remove all options except the default

            selectedCourseId = this.value; // Assign value to the already declared variable
            if (selectedCourseId) {
                majorSelect.disabled = false;

                fetch(`/majors/${selectedCourseId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(major => {
                            let option = new Option(major.major, major.id);
                            majorSelect.add(option);
                        });

                        // Pre-select the major if available
                        if (validSelectedMajorId) {
                            majorSelect.value = validSelectedMajorId;
                        }
                    });
            } else {
                majorSelect.disabled = true;
            }
        });
    });
</script>



<script>
    function setEndYear() {
        const startYear = document.getElementById('academic_year_start').value;
        const endYearInput = document.getElementById('academic_year_end');

        if (startYear) {
            endYearInput.min = parseInt(startYear) + 1;
        } else {
            endYearInput.min = 1900;
        }
    }
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
    const courseSelect = document.getElementById('course');
    const majorsList = document.getElementById('majors-list');

    courseSelect.addEventListener('change', function () {
        const selectedCourseId = this.value;
        const majors = majorsList.querySelectorAll('.major-row');

        majors.forEach(function (major) {
            const majorCourseId = major.getAttribute('data-course-id');
            if (selectedCourseId === majorCourseId || selectedCourseId === '') {
                major.style.display = '';
            } else {
                major.style.display = 'none';
            }
        });
    });
});

    </script>


</html>
