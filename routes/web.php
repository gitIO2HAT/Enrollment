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
    Route::get('/Reports/Enrollment', [EnrollmentController::class, 'enrollment']);
    Route::get('/colleges', [EnrollmentController::class, 'getColleges']);
    Route::get('/courses/{college_id}', [EnrollmentController::class, 'getCourses']);
    Route::get('/majors/{course_id}', [EnrollmentController::class, 'getMajors']);
    Route::post('/Reports/Enrollment/AddStudent', [EnrollmentController::class, 'addstudent']);
    Route::get('/Reports/Student/{id}', [EnrollmentController::class, 'student']);
    Route::post('/Reports/Student/Edit/{id}', [EnrollmentController::class, 'editstudent']);
    Route::post('/Reports/Student/Import', [EnrollmentController::class, 'importStudents']);
    Route::post('/Reports/Export', [EnrollmentController::class, 'ExportStudents']);


    Route::get('/Reports/Graduate', [GraduateController::class, 'graduate']);


    Route::get('/Reports/Adduser', [AdduserController::class, 'adduser']);


    Route::post('/Reports/Addadmin', [AdduserController::class, 'addadmin']);
    Route::post('/Reports/Adduser/UpdateUser/{id}', [AdduserController::class, 'updateuser']);
    Route::get('/Reports/Adduser/Deleted/{id}', [AdduserController::class, 'delete']);
    Route::get('/Reports/Adduser/Restore/{id}', [AdduserController::class, 'restore']);
    Route::get('/Reports/Adduser/DeleteUser', [AdduserController::class, 'deleteuser']);

    Route::get('/Reports/Profile', [ProfileController::class, 'profile']);
    Route::post('/Reports/Updateprofile/{id}', [ProfileController::class, 'updateprofile']);

    Route::match(['get', 'post'], '/Reports/College', [CollegeController::class, 'college']);
    Route::post('/Reports/College/AddCollege', [CollegeController::class, 'addcollege']);
    Route::post('/Reports/College/AddCourse', [CollegeController::class, 'addcourse']);
    Route::post('/Reports/College/AddMajor', [CollegeController::class, 'addmajor']);
    Route::post('/Reports/College/EditCollege/{id}', [CollegeController::class, 'editcollege']);
    Route::get('/Reports/College/DeletedCollege/{id}', [CollegeController::class, 'deletecollege']);
    Route::post('/Reports/College/EditCourse/{id}', [CollegeController::class, 'editcourse']);
    Route::get('/Reports/College/DeletedCourse/{id}', [CollegeController::class, 'deletecourse']);
    Route::post('/Reports/College/EditMajor/{id}', [CollegeController::class, 'editmajor']);
    Route::get('/Reports/College/DeletedMajor/{id}', [CollegeController::class, 'deletemajor']);
   



});
