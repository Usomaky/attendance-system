<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManageController extends Controller
{
    //
    public function manageFacilitator() {
        $courses = Course::get();

        $facilitators = User::where('role', 'facilitator')->with('course')->get();

        return view('pages.Manage.facilitator', compact('facilitators', 'courses'));
    }
    public function manageStudent() {
        $courses = Course::get();

        $students = User::where('role', 'student')->latest()->with('course')->get();

        return view('pages.Manage.student', compact('students', 'courses'));
    }
    public function manageCourse() {
        $courses = Course::get();

        return view('pages.Manage.course', compact('courses'));
    }
    public function store(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'course' => ['required', 'string', 'max:255'],
            'password' => ['required', 'min:8', 'max:20'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'facilitator',
            'course_id' => $request->course,
            'password' => Hash::make($request->password),
        ]);


        return redirect(route('manageFacilitator'))->with('message', 'Facilitator Added Successfully');

    }
    public function storeStudent(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'course' => ['required', 'string', 'max:255'],
            'password' => ['required', 'min:8', 'max:20'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'student',
            'course_id' => $request->course,
            'password' => Hash::make($request->password),
        ]);


        return redirect(route('manageStudent'))->with('message', 'Student Added Successfully');

    }
    public function storeCourse(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $course = Course::create([
            'name' => $request->name,
            'status' => 'active'
        ]);


        return redirect(route('manageCourse'))->with('message', 'Course Added Successfully');

    }


    public function destroyFacilitator(User $facilitator)
    {
        $facilitator->delete();
        return to_route('manageFacilitator')->with('message', 'Facilitator was deleted successfully');
    }
    public function destroyStudent(User $student)
    {
        $student->delete();
        return to_route('manageStudent')->with('message', 'Student was deleted successfully');
    }
    public function destroyCourse(Course $course)
    {
        if ($course->user()->count() > 0) {
            return back()->with('message', 'Cannot delete course with associated users.');
        }
        $course->delete();
        return to_route('manageCourse')->with('message', 'Course was deleted successfully');
    }
}
