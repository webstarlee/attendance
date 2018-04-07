<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use DatePeriod;
use DateInterval;
use App\User;
use App\Holiday;
use App\Attendance;
use App\ContractType;
use App\EmployeeVacation;
use App\AttedanceRequest;
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
        $employee_array = array();
        foreach ($employees as $employee) {
            $employee_avatar = "";
            if (file_exists('uploads/avatars/'.$employee->unique_id.'/'.$employee->avatar)) {
                $employee_avatar = asset('/uploads/avatars/'.$employee->unique_id.'/'.$employee->avatar);
            } else {
                $employee_avatar = asset('/uploads/avatars/default.png');
            }
            $employee_array[] = array(
                'id' => $employee->id,
                'username' => $employee->username,
                'unique_id' => $employee->unique_id,
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'birth' => $employee->birth,
                'avatar' => $employee_avatar,
                'client_id' => $employee->client_id,
            );
        }
        return $employee_array;
    }

    public function viewSingleAttendance($unique_id)
    {
        $employee = User::where('unique_id', $unique_id)->join('contract_types', 'contract_types.id', '=', 'users.contract_type')->select('users.*', 'contract_types.title as contract_title')->first();
        if ($employee) {
            $employee->mVacation();
            return view('admin.singleAttendance', ['employee' => $employee]);
        }
        return back();
    }

    public function getSinlgeUserAttendance($id)
    {
        $attendance_count = Attendance::where('employee_id', $id)->where('isrequest', 0)->count();
        $myArray = array();

        $holidays = Holiday::all();

        foreach ($holidays as $holiday) {
            $myArray[] = array(
                'start' => $holiday->date,
                'color' => '#ec3fd1',
                'title' => 'holiday',
                'rendering' => 'background',
                'description' => $holiday->title,
                'className' => 'm-fc-event--light m-fc-event--solid-primary'
            );
        }

        if ($attendance_count > 0) {
            $attendances = Attendance::where('employee_id', $id)->where('isrequest', 0)->orderBy('attend_type', 'asc')->get();
            foreach ($attendances as $attendance) {
                $attendance_color = "#3fe8da";
                $title = "work";
                $isbackground = true;
                if ($attendance->attend_type == 0) {
                    $attendance_color = "#4b4b4b";//absence
                    $title = "absence";
                } elseif ($attendance->attend_type == 2) {
                    $attendance_color = "#922dd1";//business trip
                    $title = "business trip";
                } elseif ($attendance->attend_type == 3 || $attendance->attend_type == 4) {
                    $attendance_color = "#ed4184";//vacation, short vacation
                    if ($attendance->attend_type == 3) {
                        $title = "vacation";
                    } else {
                        $isbackground = false;
                        $title = "short vacation";
                    }
                } elseif ($attendance->attend_type == 5) {
                    $attendance_color = "#4e4ff2";//doctor
                    $title = "doctor";
                    $isbackground = false;
                } elseif ($attendance->attend_type == 6) {
                    $attendance_color = "#f2b732";//paragraph
                    $title = "paragraph";
                    $isbackground = false;
                } elseif ($attendance->attend_type == 7) {
                    $attendance_color = "#17aa5f";//parental leave
                    $title = "parental leave";
                }
                $start_day = $attendance->attend_date;
                $start_time = $attendance->attend_date." ".$attendance->start_time;
                $end_time = $attendance->attend_date." ".$attendance->end_time;
                if ($isbackground) {
                    $myArray[] = array(
                        'event_id' => $attendance->id,
                        'start' => $start_day,
                        'color' => $attendance_color,
                        'title' => $title,
                        'rendering' => 'background',
                        'className' => 'm-fc-event--light m-fc-event--solid-primary'
                    );
                }

                $myArray[] = array(
                    'event_id' => $attendance->id,
                    'start' => $start_time,
                    'end' => $end_time,
                    'color' => $attendance_color,
                    'title' => $title,
                    'className' => 'm-fc-event--light m-fc-event--solid-primary'
                );

                if ($attendance->attend_type == 1) {
                    if ($attendance->smokes != null || $attendance->smokes != "") {
                        $smokings = unserialize($attendance->smokes);
                        foreach ($smokings as $smoking) {
                            $myArray[] = array(
                                'event_id' => $attendance->id,
                                'start' => $start_day.' '.$smoking['start_time'],
                                'end' => $start_day.' '.$smoking['end_time'],
                                'color' => '#9c620c',
                                'title' => "smoke",
                                'className' => 'm-fc-event--light m-fc-event--solid-primary'
                            );
                        }
                    }

                    if ($attendance->breaks != null || $attendance->breaks != "") {
                        $breaks = unserialize($attendance->breaks);
                        foreach ($breaks as $break) {
                            $myArray[] = array(
                                'event_id' => $attendance->id,
                                'start' => $start_day.' '.$break['start_time'],
                                'end' => $start_day.' '.$break['end_time'],
                                'color' => '#df3f1c',
                                'title' => "break",
                                'className' => 'm-fc-event--light m-fc-event--solid-primary'
                            );
                        }
                    }
                }
            }
        }

        return $myArray;
    }

    public function getSinlgeUserAttendanceRequest($id)
    {
        $attendance_request_count = AttedanceRequest::where('req_employee_id', $id)->count();
        $myArray = array();
        if ($attendance_request_count > 0) {
            $attendancesRequests = AttedanceRequest::where('req_employee_id', $id)->get();
            foreach ($attendancesRequests as $attendance_request) {
                $attendance_color = "#52eadd";
                if ($attendance_request->req_status == 0) {
                    $attendance_color = "#e4433b";
                } elseif ($attendance_request->req_status == 2) {
                    $attendance_color = "#bd55ff";
                } elseif ($attendance_request->req_status == 3) {
                    $attendance_color = "#6ee260";
                } elseif ($attendance_request->req_status == 4) {
                    $attendance_color = "#4854ea";
                }
                $myArray[] = array('id' => $attendance_request->id, 'status' => $attendance_request->req_status, 'start' => $this->decode_date_format($attendance_request->req_attendance_date_from), 'end' => $this->decode_date_format($attendance_request->req_attendance_date_to), 'color' => $attendance_color, "className" => "m-fc-event--light m-fc-event--solid-primary");
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

    public function getAttendanceRequest($id)
    {
        $attendanceRequest = AttedanceRequest::find($id);
        if ($attendanceRequest) {
            $attendance_array = array();
            if ($attendanceRequest->req_status == 1) {
                if ($attendanceRequest->req_smoking != null || $attendanceRequest->req_smoking != "") {
                    $smokings = unserialize($attendanceRequest->req_smoking);
                    $smoking_array = array();
                    foreach ($smokings as $smoking) {
                        $smoking_array[] = array('sm_start' => $this->encode_time_format($smoking['start_time']), 'sm_end' =>$this->encode_time_format($smoking['end_time']));
                    }
                    $attendance_array = array(
                        'id' => $attendanceRequest->id,
                        'date_from' => $this->decode_date_format($attendanceRequest->req_attendance_date_from),
                        'date_to' => $this->decode_date_format($attendanceRequest->req_attendance_date_to),
                        'type' => $attendanceRequest->req_status,
                        'arrival_time' => $this->encode_time_format($attendanceRequest->req_arrival_time),
                        'departure_time' => $this->encode_time_format($attendanceRequest->req_departure_time),
                        'break1_start_time' => $this->encode_time_format($attendanceRequest->req_break1_start),
                        'break1_end_time' => $this->encode_time_format($attendanceRequest->req_break1_end),
                        'break2_start_time' => $this->encode_time_format($attendanceRequest->req_break2_start),
                        'break2_end_time' => $this->encode_time_format($attendanceRequest->req_break2_end),
                        'smokings' => $smoking_array
                    );
                } else {
                    $attendance_array = array(
                        'id' => $attendanceRequest->id,
                        'date_from' => $this->decode_date_format($attendanceRequest->req_attendance_date_from),
                        'date_to' => $this->decode_date_format($attendanceRequest->req_attendance_date_to),
                        'type' => $attendanceRequest->req_status,
                        'arrival_time' => $this->encode_time_format($attendanceRequest->req_arrival_time),
                        'departure_time' => $this->encode_time_format($attendanceRequest->req_departure_time),
                        'break1_start_time' => $this->encode_time_format($attendanceRequest->req_break1_start),
                        'break1_end_time' => $this->encode_time_format($attendanceRequest->req_break1_end),
                        'break2_start_time' => $this->encode_time_format($attendanceRequest->req_break2_start),
                        'break2_end_time' => $this->encode_time_format($attendanceRequest->req_break2_end),
                    );
                }
            } else {
                $attendance_array = array(
                    'id' => $attendanceRequest->id,
                    'date_from' => $this->decode_date_format($attendanceRequest->req_attendance_date_from),
                    'date_to' => $this->decode_date_format($attendanceRequest->req_attendance_date_to),
                    'type' => $attendanceRequest->req_status,
                );
            }

            return $attendance_array;
        }
        return "nodata";
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

    public function isWeekend($date) {
        $weekDay = date('w', strtotime($date));
        return ($weekDay == 0 || $weekDay == 6);
    }

    public function isHoliday($date) {
        $holiday_count = Holiday::where('date', $date)->count();
        return ($holiday_count > 0);
    }

    public function calculate_time_minute($time)
    {
        $result_time_array = explode(':', $time);
        $result_time_hour = $result_time_array[0];
        $result_time_min = $result_time_array[1];
        $total_result_min = $result_time_hour*60 + $result_time_min;

        return $total_result_min;
    }

    public function store(Request $request)
    {
        $employee = User::find($request->employee_id);
        $contract_type = ContractType::find($employee->contract_type);

        $time1 = $this->decode_time_format($request->attend_start_time);
        $time2 = $this->decode_time_format($request->attend_end_time);

        $cal_min = $this->calculate_time_minute($time1) - $this->calculate_time_minute($time2);

        $selected_min = abs($cal_min);

        if ($request->attend_fix_time && $selected_min > $contract_type->working_time) {
            return "fail_3";
        }

        $daterange = $this->createDateRange($request->attend_date_from, $request->attend_date_to);

        foreach ($daterange as $date) {

            $current_attend_type = $request->attendance_type;

            $check_attendances = Attendance::where('attend_date', $date)->where('employee_id', $request->employee_id)->get();

            $attend_type_array = array(0,1,2,3,7);
            $type_count = 0;
            foreach ($check_attendances as $check_attendance) {
                if (in_array($check_attendance->attend_type, $attend_type_array)) {
                    $type_count ++;
                }
            }

            $boolean_check = true;

            if (in_array($current_attend_type, $attend_type_array) && $type_count > 0) {
                $boolean_check = false;
            }

            $is_weekend = $this->isWeekend($date);
            if ($request->attend_weekend && $is_weekend) {
                $boolean_check = false;
            }

            $is_holiday = $this->isHoliday($date);
            if ($request->attend_holiday && $is_holiday) {
                $boolean_check = false;
            }

            if ($current_attend_type == 3 || $current_attend_type == 4) {
                $start_time = $this->decode_time_format($request->attend_start_time);
                $end_time = $this->decode_time_format($request->attend_end_time);
                $mvacation_check = $employee->checkVacation($start_time, $end_time);
                if (!$mvacation_check) {
                    $boolean_check = false;
                    return "fail_vac_limit";
                }
            }

            if ($boolean_check) {
                $attendance = new Attendance;
                $attendance->employee_id = $request->employee_id;
                $attendance->attend_date = $date;
                $attendance->attend_type = $request->attendance_type;
                $attendance->start_time = $this->decode_time_format($request->attend_start_time);
                $attendance->end_time = $this->decode_time_format($request->attend_end_time);
                $attendance->save();

                if ($request->attendance_type == 1) {

                    if ($request->attend_break_start) {
                        $break_starts = $request->attend_break_start;
                        $break_ends = $request->attend_break_end;
                        $array_index = 0;
                        $break_times = array();
                        foreach ($break_starts as $break_start) {
                            $break_times[] = array('start_time' => $this->decode_time_format($break_start), 'end_time' => $this->decode_time_format($break_ends[$array_index]));
                            $array_index++;
                        }
                        $attendance->breaks = serialize($break_times);
                        $attendance->save();
                    }

                    if ($request->attend_smoking_start) {
                        $smokeing_starts = $request->attend_smoking_start;
                        $smokeing_ends = $request->attend_smoking_end;
                        $array_index = 0;
                        $smoking_times = array();
                        foreach ($smokeing_starts as $smokeing_start) {
                            $smoking_times[] = array('start_time' => $this->decode_time_format($smokeing_start), 'end_time' => $this->decode_time_format($smokeing_ends[$array_index]));
                            $array_index++;
                        }
                        $attendance->smokes = serialize($smoking_times);
                        $attendance->save();
                    }
                }

                $attendance->attend_work_time = $attendance->generate_total_time();
                $attendance->save();

                if ($attendance->attend_type == 3 || $attendance->attend_type == 4) {
                    $current_year = date("Y");
                    $mvacation = EmployeeVacation::where('vac_year', $current_year)->where('employee_id', $employee->unique_id)->first();
                    $total_vacations = Attendance::where('attend_date','like', $current_year.'%')->where('employee_id', $employee->id)->whereIn('attend_type', [3,4])->get();
                    $total_vac_minutes = 0;
                    foreach ($total_vacations as $total_vacation) {
                        $total_vac_minutes = $total_vac_minutes + $total_vacation->attend_work_time;
                    }
                    $mvacation->vac_spend_min = $total_vac_minutes;
                    $mvacation->save();
                }
            }
        }

        return "success";
    }

    public function update(Request $request)
    {
        $attendance = Attendance::find($request->attendance_id);
        if ($attendance) {
            $boolean_check = true;
            $employee = User::find($attendance->employee_id);
            $current_attend_type = $request->_attendance_type;
            if ($current_attend_type == 3 || $current_attend_type == 4) {
                $start_time = $this->decode_time_format($request->_attend_start_time);
                $end_time = $this->decode_time_format($request->_attend_end_time);
                $mvacation_check = $employee->checkVacation($start_time, $end_time);
                if (!$mvacation_check) {
                    $boolean_check = false;
                    return "fail_vac_limit";
                }
            }
            if ($boolean_check) {
                $attendance->attend_type = $request->_attendance_type;
                $attendance->start_time = $this->decode_time_format($request->_attend_start_time);
                $attendance->end_time = $this->decode_time_format($request->_attend_end_time);
                $attendance->breaks = "";
                $attendance->smokes = "";
                $attendance->save();

                if ($current_attend_type == 1) {

                    if ($request->attend_break_start) {
                        $break_starts = $request->attend_break_start;
                        $break_ends = $request->attend_break_end;
                        $array_index = 0;
                        $break_times = array();
                        foreach ($break_starts as $break_start) {
                            $break_times[] = array('start_time' => $this->decode_time_format($break_start), 'end_time' => $this->decode_time_format($break_ends[$array_index]));
                            $array_index++;
                        }
                        $attendance->breaks = serialize($break_times);
                        $attendance->save();
                    }

                    if ($request->attend_smoking_start) {
                        $smokeing_starts = $request->attend_smoking_start;
                        $smokeing_ends = $request->attend_smoking_end;
                        $array_index = 0;
                        $smoking_times = array();
                        foreach ($smokeing_starts as $smokeing_start) {
                            $smoking_times[] = array('start_time' => $this->decode_time_format($smokeing_start), 'end_time' => $this->decode_time_format($smokeing_ends[$array_index]));
                            $array_index++;
                        }
                        $attendance->smokes = serialize($smoking_times);
                        $attendance->save();
                    }
                }

                $attendance->attend_work_time = $attendance->generate_total_time();
                $attendance->save();

                $current_year = date("Y");
                $mvacation = EmployeeVacation::where('vac_year', $current_year)->where('employee_id', $employee->unique_id)->first();
                $total_vacations = Attendance::where('attend_date','like', $current_year.'%')->where('employee_id', $employee->id)->whereIn('attend_type', [3,4])->get();
                $total_vac_minutes = 0;
                foreach ($total_vacations as $total_vacation) {
                    $total_vac_minutes = $total_vac_minutes + $total_vacation->attend_work_time;
                }
                $mvacation->vac_spend_min = $total_vac_minutes;
                $mvacation->save();
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

    public function destroyRequest($id)
    {
        $attendanceRequest = AttedanceRequest::find($id);
        if ($attendanceRequest) {
            $attendanceRequest->delete();
            return "success";
        }

        return "fail";
    }

    public function migration_attendance_request($id)
    {
        $attendanceRequest = AttedanceRequest::find($id);
        if ($attendanceRequest) {
            $daterange = $this->createDateRange($attendanceRequest->req_attendance_date_from, $attendanceRequest->req_attendance_date_to);
            foreach ($daterange as $date) {

                $check_attendance = Attendance::where('attendance_date', $date)->where('employee_id', $attendanceRequest->req_employee_id)->delete();

                $boolean_check = true;
                $is_weekend = $this->isWeekend($date);
                if ($attendanceRequest->req_status != 1 && $is_weekend) {
                    $boolean_check = false;
                }

                if ($boolean_check) {
                    $migration_attendance = new Attendance;

                    $migration_attendance->employee_id = $attendanceRequest->req_employee_id;
                    $migration_attendance->attendance_date = $date;
                    $migration_attendance->status = $attendanceRequest->req_status;
                    $migration_attendance->approval = 1;
                    $migration_attendance->save();

                    if ($attendanceRequest->req_status == 1) {
                        $migration_attendance->arrival_time = $attendanceRequest->req_arrival_time;
                        $migration_attendance->departure_time = $attendanceRequest->req_departure_time;
                        $migration_attendance->break1_start = $attendanceRequest->req_break1_start;
                        $migration_attendance->break1_end = $attendanceRequest->req_break1_end;
                        $migration_attendance->break2_start = $attendanceRequest->req_break2_start;
                        $migration_attendance->break2_end = $attendanceRequest->req_break2_end;
                        $migration_attendance->save();

                        if ($attendanceRequest->req_smoking != null || $attendanceRequest->req_smoking != "") {
                            $migration_attendance->smoking = $attendanceRequest->req_smoking;
                            $migration_attendance->save();
                        }

                        $migration_attendance->total_min = $migration_attendance->generate_total_time();
                        $migration_attendance->save();
                    }

                }
            }

            return "success";
        }
        return "fail";
    }

    public function approveRequest($id)
    {
        $migration_result = $this->migration_attendance_request($id);
        if ($migration_result == "success") {
            $attendanceRequest = AttedanceRequest::find($id)->delete();
        }

        return $migration_result;
    }

    public function getVacationPercent($id)
    {
        $employee = User::find($id);
        if ($employee) {
            $current_year = date("Y");
            $mvacation = EmployeeVacation::where('vac_year', $current_year)->where('employee_id', $employee->unique_id)->first();
            $percent_vac = 0;
            if ($mvacation->vac_total_min > 0) {
                $total_vac = $mvacation->vac_total_min + $mvacation->vac_extra_min;
                $spent_vac = $mvacation->vac_spend_min;
                $percent_vac = $spent_vac/$total_vac*100;
            }
            $detail_view = view('admin.module.vacDetailInfo', compact('employee'))->render();
            $result_array = array('result' => 'success', 'percent' => intval($percent_vac), 'html' => $detail_view);
            return $result_array;
        }
        return array('result' => 'fail');
    }

    public function getAttendSingle($id)
    {
        $attendance = Attendance::find($id);
        if ($attendance) {
            $m_attend_array = array();
            if ($attendance->attend_type == 1) {
                $smoke_array = array();
                $break_array = array();
                if ($attendance->smokes != null || $attendance->smokes != "") {
                    $smokings = unserialize($attendance->smokes);
                    foreach ($smokings as $smoking) {
                        $smoke_array[] = array('sm_start' => $this->encode_time_format($smoking['start_time']), 'sm_end' =>$this->encode_time_format($smoking['end_time']));
                    }
                }

                if ($attendance->breaks != null || $attendance->breaks != "") {
                    $breaks = unserialize($attendance->breaks);
                    foreach ($breaks as $break) {
                        $break_array[] = array('br_start' => $this->encode_time_format($break['start_time']), 'br_end' =>$this->encode_time_format($break['end_time']));
                    }
                }

                $m_attend_array = array(
                    'id' => $attendance->id,
                    'attend_date' => $this->decode_date_format($attendance->attend_date),
                    'attend_type' => $attendance->attend_type,
                    'start_time' => $attendance->start_time,
                    'end_time' => $attendance->end_time,
                    'breaks' => $break_array,
                    'smokes' => $smoke_array,
                );
            } else {
                $m_attend_array = array(
                    'id' => $attendance->id,
                    'attend_date' => $this->decode_date_format($attendance->attend_date),
                    'attend_type' => $attendance->attend_type,
                    'start_time' => $attendance->start_time,
                    'end_time' => $attendance->end_time,
                );
            }

            return $m_attend_array;
        }

        return "fail";
    }
}
