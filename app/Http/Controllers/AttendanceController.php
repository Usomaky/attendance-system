<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function showStudents()
    {
        // Fetch the current authenticated user
        $user = Auth::user();

        // Retrieve the courses the user is associated with
        // Assuming the user can have multiple courses
        // $courses = $user->courses;
        $course = Course::where('id', $user->course_id)->with('users')->get();
        $cours = Course::where('id', $user->course_id)->first();
        // dd($course);
        // dd($cours);


        // Fetch all students registered in the user's courses
        // Ensure this works for various roles by filtering through the user's courses
        $students = User::where('role', 'student')
            ->whereIn('course_id', $course->pluck('id'))
            ->get();

        return view('pages.attendance.show', compact('cours', 'students'));
    }
    // public function markAttendance(Request $request, $courseId)
    // {
    //     // Validate the request
    //     $request->validate([
    //         'attendance' => 'required|array',
    //         'attendance.*' => 'in:Present,Absent',
    //     ]);

    //     try {
    //         $course = Course::findOrFail($courseId);
    //         $attendanceData = $request->input('attendance'); // attendance data is array of user_id => status

    //         foreach ($attendanceData as $userId => $status) {
    //             Attendance::updateOrCreate(
    //                 ['user_id' => $userId, 'course_id' => $courseId, 'date' => Carbon::now()->format('Y-m-d')],
    //                 ['status' => $status]
    //             );
    //         }

    //         return redirect()->back()->with('success', 'Attendance marked successfully');
    //     } catch (\Exception $e) {
    //         Log::error('Error marking attendance: ' . $e->getMessage());
    //         return redirect()->back()->withErrors('An error occurred while marking attendance.');
    //     }
    // }


    // public function markAttendance(Request $request, $courseId)
    // {
    //     // Validate the request
    //     $request->validate([
    //         'attendance' => 'required|array',
    //         'attendance.*' => 'in:Present,Absent',
    //     ]);

    //     try {
    //         $course = Course::findOrFail($courseId);
    //         $attendanceData = $request->input('attendance'); // attendance data is array of user_id => status

    //         foreach ($attendanceData as $userId => $status) {
    //             Attendance::updateOrCreate(
    //                 ['user_id' => $userId, 'course_id' => $courseId, 'date' => Carbon::now()->format('Y-m-d')],
    //                 ['status' => $status]
    //             );
    //         }

    //         // Redirect with success message
    //         return redirect()->back()->with('success', 'Attendance marked successfully');
    //     } catch (\Exception $e) {
    //         // Log the error and redirect with error message
    //         Log::error('Error marking attendance: ' . $e->getMessage());
    //         return redirect()->back()->withErrors('An error occurred while marking attendance.');
    //     }
    // }




    public function markAttendance(Request $request, $courseId)
{
    // Validate the request
    $request->validate([
        'attendance' => 'required|array',
        'attendance.*' => 'in:Present,Absent',
    ]);

    try {
        Log::info('Marking attendance started for course ID: ' . $courseId); // Debugging

        $course = Course::findOrFail($courseId);
        $attendanceData = $request->input('attendance'); // attendance data is array of user_id => status

        Log::info('Attendance Data:', $attendanceData); // Debugging

        foreach ($attendanceData as $userId => $status) {
            Log::info("Updating attendance for user: $userId, status: $status"); // Debugging

            Attendance::updateOrCreate(
                [
                    'user_id' => $userId,
                    'course_id' => $courseId,
                    'date' => Carbon::now()->format('Y-m-d')
                ],
                ['status' => $status]
            );
        }

        Log::info('Attendance marking completed.'); // Debugging

        // Redirect with success message
        return redirect()->back()->with('success', 'Attendance marked successfully');
    } catch (\Exception $e) {
        // Log the error and redirect with error message
        Log::error('Error marking attendance: ' . $e->getMessage());
        return redirect()->back()->withErrors('An error occurred while marking attendance.');
    }
}


// public function report($courseId)
// {
//     $course = Course::with(['users', 'attendances'])->findOrFail($courseId);
//     $students = $course->users->where('role', 'Student');

//     $reports = [];
//     foreach ($students as $student) {
//         $attendance = $student->attendances
//             ->where('course_id', $courseId)
//             ->where('date', '>=', Carbon::now()->startOfMonth())
//             ->groupBy('status');

//         $reports[$student->id] = [
//             'student' => $student,
//             'present' => $attendance->has('Present') ? $attendance->get('Present')->count() : 0,
//             'absent' => $attendance->has('Absent') ? $attendance->get('Absent')->count() : 0,
//         ];
//     }

//     return view('pages.attendance.report', compact('course', 'reports'));
// }


// public function report($courseId)
// {
//     // Fetch the course along with its related users (students) and attendances
//     $course = Course::with(['users.attendances'])->findOrFail($courseId);


//     // Filter students with the role 'Student'
//     $students = $course->users->filter(function ($user) {
//         return $user->role === 'Student';
//     });

//     $reports = [];

//     foreach ($students as $student) {
//         // Filter attendances for the current month and group by status
//         $attendance = $student->attendances
//             ->where('course_id', $courseId)
//             ->where('date', '>=', Carbon::now()->startOfMonth())
//             ->groupBy('status');

//         $reports[$student->id] = [
//             'student' => $student,
//             'present' => $attendance->has('Present') ? $attendance->get('Present')->count() : 0,
//             'absent' => $attendance->has('Absent') ? $attendance->get('Absent')->count() : 0,
//         ];
//     }

//     // Return the view with the course and reports data
//     return view('pages.attendance.report', compact('course', 'reports'));
// }



public function report(Request $request)
{
    Log::info('Entering report method without explicit courseId');

    try {
        // Fetch the current authenticated user
        $user = Auth::user();

        // Fetch the course associated with the authenticated user
        // Assuming the user has only one associated course
        Log::info('Fetching course associated with the authenticated user');
        $course = Course::with(['users' => function($query) {
                $query->where('role', 'student'); // Ensure to fetch only students
            },
            'users.attendances' => function ($query) {
                $query->where('date', '>=', Carbon::now()->startOfMonth())
                      ->where('date', '<=', Carbon::now()->endOfMonth()); // Filter for the current month
            }
        ])->where('id', $user->course_id)->firstOrFail();

        Log::info('Course fetched successfully');

        // Create a report for each student
        Log::info('Creating report for each student');
        $reports = $course->users->map(function ($student) {
            Log::info('Processing student ' . $student->id);
            $attendances = $student->attendances->groupBy('status');

            return [
                'student' => $student,
                'present' => $attendances->get('Present', collect())->count(),
                'absent' => $attendances->get('Absent', collect())->count(),
            ];
        });

        Log::info('Reports created successfully');

        // Return the view with the course and reports data
        Log::info('Returning view with course and reports data');
        return view('pages.attendance.report', compact('course', 'reports'));
    } catch (\Exception $e) {
        Log::error('Error in report method: ' . $e->getMessage());
        return redirect()->back()->withErrors('An error occurred while generating the report.');
    }



}

}
