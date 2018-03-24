<?php

namespace App\Http\Controllers\User;

use Auth;
use DateTime;
use DatePeriod;
use DateInterval;
use App\User;
use App\Admin;
use App\Attendance;
use App\AttedanceRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    public function attendance()
    {
        $employee = User::join('contract_types', 'contract_types.id', '=', 'users.contract_type')->select('users.*', 'contract_types.title as contract_title')->find(Auth::user()->id);
        return view('user.attendance', ['employee' => $employee]);
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

    public function encode_date_format($date)
    {
        $selectedDate = DateTime::createFromFormat('m/d/Y', $date);
        $finalDate = $selectedDate->format('Y-m-d');
        return $finalDate;
    }

    public function getAttendance()
    {
        $employee = Auth::user();
        $attendance_count = Attendance::where('employee_id', $employee->id)->count();
        $myArray = array();
        if ($attendance_count > 0) {
            $attendances = Attendance::where('employee_id', $employee->id)->get();
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
                $myArray[] = array('id' => $attendance->id, 'status' => $attendance->status, 'start' => $attendance->attendance_date, 'color' => $attendance_color, 'rendering' => 'background', 'total_work' => $attendance->total_min, 'approval' => $attendance->approval, "className" => "m-fc-event--light m-fc-event--solid-primary");
            }
        }
        return $myArray;
    }

    public function getAttendanceRequest()
    {
        $employee = Auth::user();
        $attendance_count = AttedanceRequest::where('req_employee_id', $employee->id)->count();
        $myArray = array();
        if ($attendance_count > 0) {
            $attendances = AttedanceRequest::where('req_employee_id', $employee->id)->get();
            foreach ($attendances as $attendance) {
                $attendance_color = "#52eadd";
                if ($attendance->req_status == 0) {
                    $attendance_color = "#e4433b";
                } elseif ($attendance->req_status == 2) {
                    $attendance_color = "#bd55ff";
                } elseif ($attendance->req_status == 3) {
                    $attendance_color = "#6ee260";
                } elseif ($attendance->req_status == 4) {
                    $attendance_color = "#4854ea";
                }
                $myArray[] = array('id' => $attendance->id, 'status' => $attendance->req_status, 'start' => $this->decode_date_format($attendance->req_attendance_date_from), 'end' => $this->decode_date_format($attendance->req_attendance_date_to), 'color' => $attendance_color, 'rendering' => 'background', 'total_work' => $attendance->req_total_min, "className" => "m-fc-event--light m-fc-event--solid-primary");
            }
        }
        return $myArray;
    }

    public function checkSinlgeAttendance($date)
    {
        $attendance = Attendance::where('employee_id', Auth::user()->id)->where('attendance_date', $date)->first();
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

    public function attendanceStore(Request $request)
    {
        $today_date = date("m/d/Y");
        if ($today_date != $request->attend_date) {
            return "date_invalid";
        }

        $selectedDate = DateTime::createFromFormat('m/d/Y', $request->attend_date);
        $finalDate = $selectedDate->format('Y-m-d');

        $check_attendance = Attendance::where('attendance_date', $finalDate)->where('employee_id', Auth::user()->id)->count();
        if ($check_attendance == 0) {
            $attendance = new Attendance;
            $attendance->employee_id = Auth::user()->id;
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

    public function attendanceRequest(Request $request)
    {
        $selectedDate = DateTime::createFromFormat('m/d/Y', $request->_attend_date);
        $finalDate = $selectedDate->format('Y-m-d');

        $attend_request_count = AttedanceRequest::where('req_attendance_date_from', $finalDate)->where('req_employee_id', Auth::user()->id)->count();
        if ($attend_request_count == 0) {
            $attend_request = new AttedanceRequest;
            $attend_request->req_attendance_date_from = $finalDate;
            $attend_request->req_attendance_date_to = $finalDate;
            $attend_request->req_employee_id = Auth::user()->id;
            $attend_request->req_status = $request->_attendance_type;
            $attend_request->save();

            if ($request->_attendance_type == 1) {
                $attend_request->req_arrival_time = $this->decode_time_format($request->attend_arrive_time);
                $attend_request->req_departure_time = $this->decode_time_format($request->attend_departure_time);
                $attend_request->req_break1_start = $this->decode_time_format($request->break_start_1);
                $attend_request->req_break1_end = $this->decode_time_format($request->break_end_1);
                $attend_request->req_break2_start = $this->decode_time_format($request->break_start_2);
                $attend_request->req_break2_end = $this->decode_time_format($request->break_end_2);
                $attend_request->save();

                if ($request->attend_smoking_start) {
                    $smokeing_starts = $request->attend_smoking_start;
                    $smokeing_ends = $request->attend_smoking_end;
                    $array_index = 0;
                    $smoking_times = array();
                    foreach ($smokeing_starts as $smokeing_start) {
                        $smoking_times[] = array('start_time' => $this->decode_time_format($smokeing_start), 'end_time' => $this->decode_time_format($smokeing_ends[$array_index]));
                        $array_index++;
                    }
                    $attend_request->req_smoking = serialize($smoking_times);
                    $attend_request->save();
                }

                $attend_request->req_total_min = $attend_request->generate_total_time();
                $attend_request->save();
            }

            return "success";
        }

        return "fail";
    }

    public function attendanceDestroy($id)
    {
        $attendance = Attendance::find($id);
        if ($attendance) {
            $attendance->delete();

            return "success";
        }

        return "fail";
    }

    public function attendanceRequestDestroy($id)
    {
        $attendanceRequest = AttedanceRequest::find($id);
        if ($attendanceRequest) {
            $attendanceRequest->delete();

            return "success";
        }

        return "fail";
    }

    public function getSingleAttendance($id)
    {
        $attendance = Attendance::find($id);
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

    public function getSingleAttendanceRequest($id)
    {
        $attendance_request = AttedanceRequest::find($id);
        if ($attendance_request) {
            $attendance_array = array();
            if ($attendance_request->req_status == 1) {
                if ($attendance_request->req_smoking != null || $attendance_request->req_smoking != "") {
                    $smokings = unserialize($attendance_request->req_smoking);
                    $smoking_array = array();
                    foreach ($smokings as $smoking) {
                        $smoking_array[] = array('sm_start' => $this->encode_time_format($smoking['start_time']), 'sm_end' =>$this->encode_time_format($smoking['end_time']));
                    }
                    $attendance_array = array(
                        'id' => $attendance_request->id,
                        'date_from' => $this->decode_date_format($attendance_request->req_attendance_date_from),
                        'date_to' => $this->decode_date_format($attendance_request->req_attendance_date_to),
                        'type' => $attendance_request->req_status,
                        'arrival_time' => $this->encode_time_format($attendance_request->req_arrival_time),
                        'departure_time' => $this->encode_time_format($attendance_request->req_departure_time),
                        'break1_start_time' => $this->encode_time_format($attendance_request->req_break1_start),
                        'break1_end_time' => $this->encode_time_format($attendance_request->req_break1_end),
                        'break2_start_time' => $this->encode_time_format($attendance_request->req_break2_start),
                        'break2_end_time' => $this->encode_time_format($attendance_request->req_break2_end),
                        'smokings' => $smoking_array
                    );
                } else {
                    $attendance_array = array(
                        'id' => $attendance_request->id,
                        'date_from' => $this->decode_date_format($attendance_request->req_attendance_date_from),
                        'date_to' => $this->decode_date_format($attendance_request->req_attendance_date_to),
                        'type' => $attendance_request->req_status,
                        'arrival_time' => $this->encode_time_format($attendance_request->req_arrival_time),
                        'departure_time' => $this->encode_time_format($attendance_request->req_departure_time),
                        'break1_start_time' => $this->encode_time_format($attendance_request->req_break1_start),
                        'break1_end_time' => $this->encode_time_format($attendance_request->req_break1_end),
                        'break2_start_time' => $this->encode_time_format($attendance_request->req_break2_start),
                        'break2_end_time' => $this->encode_time_format($attendance_request->req_break2_end),
                    );
                }
            } else {
                $attendance_array = array(
                    'id' => $attendance_request->id,
                    'date_from' => $this->decode_date_format($attendance_request->req_attendance_date_from),
                    'date_to' => $this->decode_date_format($attendance_request->req_attendance_date_to),
                    'type' => $attendance_request->req_status,
                );
            }

            return $attendance_array;
        }
        return "nodata";
    }

    public function createDateRange($startDate, $endDate, $format = "Y-m-d")
    {
        $begin = new DateTime($startDate);
        $end = new DateTime($endDate);
        $end->modify('+1 second');

        $interval = new DateInterval('P1D'); // 1 Day
        $dateRange = new DatePeriod($begin, $interval, $end);

        $range = [];
        foreach ($dateRange as $date) {
            $range[] = $date->format($format);
        }

        return $range;
    }

    public function storeAttendanceRequest(Request $request)
    {
        $daterange = $this->createDateRange($request->attend_date_from, $request->attend_date_to);
        foreach ($daterange as $date) {
            $check_request = AttedanceRequest::where('req_attendance_date_from', $date)->where('req_employee_id', Auth::user()->id)->delete();
        }

        $attend_request = new AttedanceRequest;
        $attend_request->req_attendance_date_from = $this->encode_date_format($request->attend_request_date_from);
        $attend_request->req_attendance_date_to = $this->encode_date_format($request->attend_request_date_to);
        $attend_request->req_employee_id = Auth::user()->id;
        $attend_request->req_status = $request->request_attendance_type;
        $attend_request->save();

        if ($request->request_attendance_type == 1) {
            $attend_request->req_arrival_time = $this->decode_time_format($request->attend_arrive_time);
            $attend_request->req_departure_time = $this->decode_time_format($request->attend_departure_time);
            $attend_request->req_break1_start = $this->decode_time_format($request->break_start_1);
            $attend_request->req_break1_end = $this->decode_time_format($request->break_end_1);
            $attend_request->req_break2_start = $this->decode_time_format($request->break_start_2);
            $attend_request->req_break2_end = $this->decode_time_format($request->break_end_2);
            $attend_request->save();

            if ($request->attend_smoking_start) {
                $smokeing_starts = $request->attend_smoking_start;
                $smokeing_ends = $request->attend_smoking_end;
                $array_index = 0;
                $smoking_times = array();
                foreach ($smokeing_starts as $smokeing_start) {
                    $smoking_times[] = array('start_time' => $this->decode_time_format($smokeing_start), 'end_time' => $this->decode_time_format($smokeing_ends[$array_index]));
                    $array_index++;
                }
                $attend_request->req_smoking = serialize($smoking_times);
                $attend_request->save();
            }

            $attend_request->req_total_min = $attend_request->generate_total_time();
            $attend_request->save();
        }

        return "success";
    }

    public function updateAttendanceRequest(Request $request)
    {
        $attend_request = AttedanceRequest::find($request->attendance_request_id);
        if ($attend_request) {
            $attend_request->req_attendance_date_from = $this->encode_date_format($request->_attend_request_date_from);
            $attend_request->req_attendance_date_to = $this->encode_date_format($request->_attend_request_date_to);
            $attend_request->req_employee_id = Auth::user()->id;
            $attend_request->req_status = $request->_request_attendance_type;
            $attend_request->save();

            if ($request->_request_attendance_type == 1) {
                $attend_request->req_arrival_time = $this->decode_time_format($request->attend_arrive_time);
                $attend_request->req_departure_time = $this->decode_time_format($request->attend_departure_time);
                $attend_request->req_break1_start = $this->decode_time_format($request->break_start_1);
                $attend_request->req_break1_end = $this->decode_time_format($request->break_end_1);
                $attend_request->req_break2_start = $this->decode_time_format($request->break_start_2);
                $attend_request->req_break2_end = $this->decode_time_format($request->break_end_2);
                $attend_request->save();

                if ($request->attend_smoking_start) {
                    $smokeing_starts = $request->attend_smoking_start;
                    $smokeing_ends = $request->attend_smoking_end;
                    $array_index = 0;
                    $smoking_times = array();
                    foreach ($smokeing_starts as $smokeing_start) {
                        $smoking_times[] = array('start_time' => $this->decode_time_format($smokeing_start), 'end_time' => $this->decode_time_format($smokeing_ends[$array_index]));
                        $array_index++;
                    }
                    $attend_request->req_smoking = serialize($smoking_times);
                    $attend_request->save();
                }

                $attend_request->req_total_min = $attend_request->generate_total_time();
                $attend_request->save();
            }

            return "success";
        }

        return "fail";
    }
}
