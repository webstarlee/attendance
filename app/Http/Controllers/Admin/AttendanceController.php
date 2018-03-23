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
        $employee = User::where('unique_id', $unique_id)->join('contract_types', 'contract_types.id', '=', 'users.contract_type')->select('users.*', 'contract_types.title as contract_title')->first();
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
            $attendances = Attendance::where('employee_id', $id)->get();
            foreach ($attendances as $attendance) {
                $attendance_color = "#52eadd";
                if ($attendance->status == 0) {
                    $attendance_color = "#e4433b";
                } elseif ($attendance->status == 2) {
                    $attendance_color = "#bd55ff";
                } elseif ($attendance->status == 3) {
                    $attendance_color = "#6ee260";
                } elseif ($attendance->status == 4) {
                    $attendance_color = "#4854ea";
                }
                $myArray[] = array('id' => $attendance->id, 'status' => $attendance->status, 'start' => $attendance->attendance_date, 'color' => $attendance_color, 'rendering' => 'background', 'total_work' => $attendance->total_min,"className" => "m-fc-event--light m-fc-event--solid-primary");
            }
        }
        return $myArray;
    }

    public function checkSinlgeAttendance($id, $date)
    {
        $attendance = Attendance::where('employee_id', $id)->where('attendance_date', $date)->first();
        if ($attendance) {
            $attendance_array = array();
            if ($attendance->status == 1) {
                if ($attendance->smoking != null || $attendance->smoking != "") {
                    $smokings = unserialize($attendance->smoking);
                    $smoking_array = array();
                    foreach ($smokings as $smoking) {
                        $smoking_array[] = array('sm_start' => $this->encode_time_format($smoking['start_time']), 'sm_end' =>$this->encode_time_format($smoking['end_time']));
                    }
                    $attendance_array = array(
                        'id' => $attendance->id,
                        'date' => $this->decode_date_format($attendance->attendance_date),
                        'type' => $attendance->status,
                        'arrival_time' => $this->encode_time_format($attendance->arrival_time),
                        'departure_time' => $this->encode_time_format($attendance->departure_time),
                        'break1_start_time' => $this->encode_time_format($attendance->break1_start),
                        'break1_end_time' => $this->encode_time_format($attendance->break1_end),
                        'break2_start_time' => $this->encode_time_format($attendance->break2_start),
                        'break2_end_time' => $this->encode_time_format($attendance->break2_end),
                        'smokings' => $smoking_array
                    );
                } else {
                    $attendance_array = array(
                        'id' => $attendance->id,
                        'date' => $this->decode_date_format($attendance->attendance_date),
                        'type' => $attendance->status,
                        'arrival_time' => $this->encode_time_format($attendance->arrival_time),
                        'departure_time' => $this->encode_time_format($attendance->departure_time),
                        'break1_start_time' => $this->encode_time_format($attendance->break1_start),
                        'break1_end_time' => $this->encode_time_format($attendance->break1_end),
                        'break2_start_time' => $this->encode_time_format($attendance->break2_start),
                        'break2_end_time' => $this->encode_time_format($attendance->break2_end),
                    );
                }
            } else {
                $attendance_array = array(
                    'id' => $attendance->id,
                    'date' => $this->decode_date_format($attendance->attendance_date),
                    'type' => $attendance->status
                );
            }

            return $attendance_array;
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

    public function encode_time_format($time)
    {
        return date( "g:i A", strtotime($time));
    }

    public function decode_time_format($time)
    {
        return date( "H:i:s", strtotime($time));
    }

    public function decode_date_format($date)
    {
        $selectedDate = DateTime::createFromFormat('Y-m-d', $date);
        $finalDate = $selectedDate->format('m/d/Y');
        return $finalDate;
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
            $attendance->status = $request->attendance_type;
            $attendance->approval = 1;
            $attendance->save();

            if ($request->attendance_type == 1) {
                $attendance->arrival_time = $this->decode_time_format($request->attend_arrive_time);
                $attendance->departure_time = $this->decode_time_format($request->attend_departure_time);
                $attendance->break1_start = $this->decode_time_format($request->break_start_1);
                $attendance->break1_end = $this->decode_time_format($request->break_end_1);
                $attendance->break2_start = $this->decode_time_format($request->break_start_2);
                $attendance->break2_end = $this->decode_time_format($request->break_end_2);
                $attendance->save();

                if ($request->attend_smoking_start) {
                    $smokeing_starts = $request->attend_smoking_start;
                    $smokeing_ends = $request->attend_smoking_end;
                    $array_index = 0;
                    $smoking_times = array();
                    foreach ($smokeing_starts as $smokeing_start) {
                        $smoking_times[] = array('start_time' => $this->decode_time_format($smokeing_start), 'end_time' => $this->decode_time_format($smokeing_ends[$array_index]));
                        $array_index++;
                    }
                    $attendance->smoking = serialize($smoking_times);
                    $attendance->save();
                }

                $attendance->total_min = $attendance->generate_total_time();
                $attendance->save();
            }

            return "success";
        }

        return "fail";
    }

    public function update(Request $request)
    {
        $attendance = Attendance::find($request->attendance_id);
        if ($attendance) {
            $attendance->status = $request->_attendance_type;
            $attendance->approval = 1;
            $attendance->save();

            if ($request->_attendance_type == 1) {
                $attendance->arrival_time = $this->decode_time_format($request->attend_arrive_time);
                $attendance->departure_time = $this->decode_time_format($request->attend_departure_time);
                $attendance->break1_start = $this->decode_time_format($request->break_start_1);
                $attendance->break1_end = $this->decode_time_format($request->break_end_1);
                $attendance->break2_start = $this->decode_time_format($request->break_start_2);
                $attendance->break2_end = $this->decode_time_format($request->break_end_2);
                $attendance->save();

                if ($request->attend_smoking_start) {
                    $smokeing_starts = $request->attend_smoking_start;
                    $smokeing_ends = $request->attend_smoking_end;
                    $array_index = 0;
                    $smoking_times = array();
                    foreach ($smokeing_starts as $smokeing_start) {
                        $smoking_times[] = array('start_time' => $this->decode_time_format($smokeing_start), 'end_time' => $this->decode_time_format($smokeing_ends[$array_index]));
                        $array_index++;
                    }
                    $attendance->smoking = serialize($smoking_times);
                    $attendance->save();
                }

                $attendance->total_min = $attendance->generate_total_time();
                $attendance->save();
            }

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
