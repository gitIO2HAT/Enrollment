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
use App\Http\Controllers\ResetPasswordController;
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

Route::get('/', [LoginDashboardController::class, 'login'])->name('login');
Route::post('login', [LoginDashboardController::class, 'AuthLogin']);
Route::get('/ForgetPassword', [LoginDashboardController::class, 'forgetpassword']);
Route::post('/ForgetPassword/Reset', [LoginDashboardController::class, 'sendResetLinkEmail']);
Route::get('/logout', [LoginDashboardController::class, 'logoutButton'])->name('logoutButton');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset']);



Route::group(['middleware' => 'superadmin'], function () {
    Route::get('/SuperAdmin/Enrollment', [EnrollmentController::class, 'enrollment']);
    Route::get('/colleges', [EnrollmentController::class, 'getColleges']);
    Route::get('/courses/{college_id}', [EnrollmentController::class, 'getCourses']);
    Route::get('/majors/{course_id}', [EnrollmentController::class, 'getMajors']);
    Route::post('/SuperAdmin/Enrollment/AddStudent', [EnrollmentController::class, 'addstudent']);
    Route::get('/SuperAdmin/Student/{id}', [EnrollmentController::class, 'student']);
    Route::post('/SuperAdmin/Student/Edit/{id}', [EnrollmentController::class, 'editstudent']);
    Route::post('/SuperAdmin/Student/Import', [EnrollmentController::class, 'importStudents']);
    Route::post('/SuperAdmin/Export', [EnrollmentController::class, 'ExportStudents']);


    Route::get('/SuperAdmin/Graduate', [GraduateController::class, 'graduate']);

    Route::get('/SuperAdmin/Adduser', [AdduserController::class, 'adduser']);
    Route::post('/SuperAdmin/Addadmin', [AdduserController::class, 'addadmin']);
    Route::post('/SuperAdmin/Adduser/UpdateUser/{id}', [AdduserController::class, 'updateuser']);
    Route::get('/SuperAdmin/Adduser/Deleted/{id}', [AdduserController::class, 'delete']);
    Route::get('/SuperAdmin/Adduser/Restore/{id}', [AdduserController::class, 'restore']);
    Route::get('/SuperAdmin/Adduser/DeleteUser', [AdduserController::class, 'deleteuser']);

    Route::get('/SuperAdmin/Profile', [ProfileController::class, 'profile']);
    Route::post('/SuperAdmin/Updateprofile/{id}', [ProfileController::class, 'updateprofile']);

    Route::get('/SuperAdmin/College', [CollegeController::class, 'college']);
    Route::post('/SuperAdmin/College/AddCollege', [CollegeController::class, 'addcollege']);
    Route::post('/SuperAdmin/College/AddCourse', [CollegeController::class, 'addcourse']);
    Route::post('/SuperAdmin/College/AddMajor', [CollegeController::class, 'addmajor']);
    Route::post('/SuperAdmin/College/EditCollege/{id}', [CollegeController::class, 'editcollege']);
    Route::get('/SuperAdmin/College/DeletedCollege/{id}', [CollegeController::class, 'deletecollege']);
    Route::post('/SuperAdmin/College/EditCourse/{id}', [CollegeController::class, 'editcourse']);
    Route::get('/SuperAdmin/College/DeletedCourse/{id}', [CollegeController::class, 'deletecourse']);
    Route::post('/SuperAdmin/College/EditMajor/{id}', [CollegeController::class, 'editmajor']);
    Route::get('/SuperAdmin/College/DeletedMajor/{id}', [CollegeController::class, 'deletemajor']);

   
});
