<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginDashboardController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AdduserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\GraduateController;
use App\Http\Controllers\ProfileController;
use App\Models\Attendance;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginDashboardController::class, 'login']);
Route::post('login', [LoginDashboardController::class, 'AuthLogin']);
Route::get('/logout', [LoginDashboardController::class, 'logoutButton'])->name('logoutButton');



Route::group(['middleware' => 'superadmin'], function () {
    Route::get('/SuperAdmin/Enrollment', [EnrollmentController::class, 'enrollment']);
    Route::get('/SuperAdmin/Graduate', [GraduateController::class, 'graduate']);
    Route::get('/SuperAdmin/Adduser', [AdduserController::class, 'adduser']);
    Route::post('/SuperAdmin/Addadmin', [AdduserController::class, 'addadmin']);
    Route::get('/SuperAdmin/Profile', [ProfileController::class, 'profile']);
    Route::post('/SuperAdmin/Updateprofile/{id}', [ProfileController::class, 'updateprofile']);
    Route::post('/SuperAdmin/Adduser/UpdateUser/{id}', [AdduserController::class, 'updateuser']);
    Route::get('/SuperAdmin/Adduser/Deleted/{id}', [AdduserController::class, 'delete']);
    Route::get('/SuperAdmin/College', [CollegeController::class, 'college']);
    Route::post('/SuperAdmin/College/AddCollege', [CollegeController::class, 'addcollege']);
    Route::post('/SuperAdmin/College/AddCourse', [CollegeController::class, 'addcourse']);
    Route::post('/SuperAdmin/College/AddMajor', [CollegeController::class, 'addmajor']);
    Route::get('/SuperAdmin/courses/{collegeId}', [CollegeController::class, 'getCourses']);
    Route::get('/SuperAdmin/majors/{courseId}', [CollegeController::class, 'getMajors']);



    Route::get('/SuperAdmin/Employee', [EmployeeController::class, 'employee']);
    Route::get('/SuperAdmin/Employee/ArchiveEmployee', [EmployeeController::class, 'archiveemployee']);
    Route::get('/SuperAdmin/Employee/AddEmployee', [EmployeeController::class, 'addemployee']);
    Route::post('/SuperAdmin/Employee/AddEmployee', [EmployeeController::class, 'insertemployee']);
    Route::get('/SuperAdmin/Employee/EditEmployee/{id}', [EmployeeController::class, 'editemployee']);
    Route::post('/SuperAdmin/Employee/EditEmployee/{id}', [EmployeeController::class, 'updateemployee']);
    Route::get('/SuperAdmin/Employee/PreviewEmployee/{id}', [EmployeeController::class, 'previewemployee']);
    Route::get('/SuperAdmin/Employee/Archive/{id}', [EmployeeController::class, 'archive']);
    Route::get('/SuperAdmin/Employee/Restore/{id}', [EmployeeController::class, 'restore']);




    Route::get('/SuperAdmin/Leave', [LeaveController::class, 'leave']);



    Route::get('/SuperAdmin/Announcement', [AnnouncementController::class, 'announcement']);
    Route::post('/SuperAdmin/Announcement', [AnnouncementController::class, 'save_task']);
    Route::get('/SuperAdmin/Read/{id}', [AnnouncementController::class, 'read']);





    Route::get('/SuperAdmin/Attendance', [AttendanceController::class, 'attendance']);
});
