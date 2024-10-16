<?php

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // Fetch the current authenticated user
    $user = Auth::user();

    // Retrieve the courses the user is associated with
    // Assuming the user can have multiple courses
    // $courses = $user->courses;
    $course = Course::where('id', $user->course_id)->first();
    return view('dashboard', compact('course'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // MANGE FACILITATOR, STUDENTS, SUBJECT ROUTES
    Route::get('/manage/facilitator', [ManageController::class, 'manageFacilitator'])->name('manageFacilitator');
    Route::post('/manage/facilitator', [ManageController::class, 'store'])->name('facilitator.store');
    Route::delete('/manage/facilitator/{facilitator}', [ManageController::class, 'destroyFacilitator'])->name('facilitator.destroy');



    Route::get('/manage/student', [ManageController::class, 'manageStudent'])->name('manageStudent');
    Route::post('/manage/student', [ManageController::class, 'storeStudent'])->name('student.store');
    Route::delete('/manage/student/{student}', [ManageController::class, 'destroyStudent'])->name('student.destroy');


    Route::get('/manage/course', [ManageController::class, 'manageCourse'])->name('manageCourse');
    Route::post('/manage/course', [ManageController::class, 'storeCourse'])->name('course.store');
    Route::delete('/manage/course/{course}', [ManageController::class, 'destroyCourse'])->name('course.destroy');

});



Route::middleware(['auth'])->group(function () {
    // Route to display attendance page with list of students
    Route::get('/attendance', [AttendanceController::class, 'showStudents'])->name('attendance.show');

    // Route to handle attendance marking
    Route::post('/attendance/{courseId}/mark', [AttendanceController::class, 'markAttendance'])->name('attendance.mark');

    // Route to generate the monthly attendance report
    // Route::get('/attendance/monthly-report/{courseId}', [AttendanceController::class, 'monthlyReport'])->name('attendance.monthlyReport');
    Route::get('/attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');
});



require __DIR__.'/auth.php';



