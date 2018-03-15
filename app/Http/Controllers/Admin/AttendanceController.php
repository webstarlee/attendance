<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use App\User;
use App\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.manageAttendance');
    }

    public function getAllEmployee()
    {
        $employees = User::all();
        return $employees;
    }

    public function viewSingleAttendance($unique_id)
    {
        $employee = User::where('unique_id', $unique_id)->first();
        if ($employee) {
            return view('admin.singleAttendance', ['employee' => $employee]);
        }
        return back();
    }

    public function getSinlgeAttendance($id)
    {
        $attendance_count = Attendance::where('employee_id', $id)->count();
        $myArray = array();
        if ($attendance_count > 0) {
            $attendances = Attendance::where('employee_id', $id)->join('contract_types', 'contract_types.id', '=', 'attendances.contract_id')->select('attendances.*', 'contract_types.title', 'contract_types.color')->get();
            foreach ($attendances as $attendance) {
                $myArray[] = array('id' => $attendance->id, 'start' => $attendance->attendance_date, 'color' => $attendance->color, 'title' => $attendance->title, "className" => "m-fc-event--light m-fc-event--solid-primary");
            }
        }
        return $myArray;
    }

    public function checkSinlgeAttendance($id, $date)
    {
        $attendances = Attendance::where('employee_id', $id)->where('attendance_date', $date)->first();
        if ($attendances) {
            return $attendances;
        }
        return "nodata";
    }

    public function getAttendance($id)
    {
        $attendance = Attendance::find($id);
        if ($attendance) {
            return $attendance;
        }
        return "fail";
    }

    public function store(Request $request)
    {
        $selectedDate = DateTime::createFromFormat('m/d/Y', $request->attend_date);
        $finalDate = $selectedDate->format('Y-m-d');

        $check_attendance = Attendance::where('attendance_date', $finalDate)->count();
        if ($check_attendance == 0) {
            $attendance = new Attendance;
            $attendance->employee_id = $request->employee_id;
            $attendance->attendance_date = $finalDate;
            $attendance->contract_id = $request->contract_type;
            $attendance->save();

            return "success";
        }

        return "fail";
    }

    public function update(Request $request)
    {
        $attendance = Attendance::find($request->attendance_id);
        if ($attendance) {
            $attendance->contract_id = $request->_contract_type;
            $attendance->save();

            return "success";
        }

        return "fail";
    }

    public function destroy($id)
    {
        $attendance = Attendance::find($id);
        if ($attendance) {
            $attendance->delete();

            return "success";
        }

        return "fail";
    }
}
