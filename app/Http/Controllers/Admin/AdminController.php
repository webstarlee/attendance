<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use App\User;
use App\Event;
use App\Ticket;
use App\Holiday;
use App\Department;
use App\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class adminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.home');
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

    public function decode_date_time_format($date)
    {
        $selectedDate = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        $finalDate = $selectedDate->format('m/d/Y');
        return $finalDate;
    }

    public function encode_date_format($date)
    {
        $selectedDate = DateTime::createFromFormat('m/d/Y', $date);
        $finalDate = $selectedDate->format('Y-m-d');
        return $finalDate;
    }

    public function viewHoliday()
    {
        return view('admin.manageHoliday');
    }

    public function storeHoliday(Request $request)
    {
        $selectedDate = DateTime::createFromFormat('m/d/Y', $request->holi_date);
        $finalDate = $selectedDate->format('Y-m-d');

        $check_holiday = Holiday::where('date', $finalDate)->count();
        if ($check_holiday == 0) {
            $holiday = new Holiday;
            $holiday->date = $finalDate;
            $holiday->title = $request->holi_title;
            $holiday->description = $request->holi_description;
            $holiday->color = '#e4003e';
            $holiday->save();

            return "success";
        }

        return "fail";
    }

    public function updateHoliday(Request $request)
    {
        $holiday = Holiday::find($request->holiday_id);
        if ($holiday) {

            $holiday->title = $request->_holi_title;
            $holiday->description = $request->_holi_description;
            $holiday->save();
            return "success";
        }

        return "fail";
    }

    public function destroyHoliday($id)
    {
        $holiday = Holiday::find($id);
        if ($holiday) {
            $holiday->delete();
            return "success";
        }

        return "fail";
    }

    public function checkholiday($date)
    {
        $holiday = Holiday::where('date', $date)->first();
        if ($holiday) {
            return $holiday;
        }
        return "nodata";
    }

    public function getAllHoliday()
    {
        $holiday_count = Holiday::count();
        $myArray = array();
        if ($holiday_count > 0) {
            $holidays = Holiday::all();
            foreach ($holidays as $holiday) {
                $myArray[] = array('id' => $holiday->id, 'start' => $holiday->date, 'color' => $holiday->color, 'rendering' => 'background', 'title' => $holiday->title, 'description' => $holiday->description );
            }
        }
        return $myArray;
    }

    // manage department
    public function view_department()
    {
        return view('admin.department');
    }

    public function getDepartmentTableData()
    {
        $all_department = Department::all();
        return $all_department;
    }

    public function department_store(Request $request)
    {
        $department = new Department;
        $department->depart_title = $request->department_title;
        $department->depart_note = $request->department_note;
        $department->save();
        return "success";
    }

    public function getSignleDepartment($id)
    {
        $department = Department::find($id);
        if ($department) {
            return $department;
        }
        return "fail";
    }

    public function department_update(Request $request)
    {
        $department = Department::find($request->depatment_id_for_edit);
        if ($department) {
            $department->depart_title = $request->_department_title;
            $department->depart_note = $request->_department_note;
            $department->save();
            return "success";
        }
        return "fail";
    }
    //end
    // manage department
    public function view_designation()
    {
        return view('admin.designation');
    }

    public function getDesignationTableData()
    {
        $all_designation = Designation::join('departments', 'departments.id', '=', 'designations.depart_id')->select('designations.*', 'departments.depart_title')->get();
        return $all_designation;
    }

    public function designation_store(Request $request)
    {
        $designation = new Designation;
        $designation->depart_id = $request->department_id;
        $designation->design_title = $request->designation_title;
        $designation->design_note = $request->designation_note;
        $designation->save();
        return "success";
    }

    public function getSignleDesignation($id)
    {
        $designation = Designation::where('designations.id', $id)->join('departments', 'departments.id', '=', 'designations.depart_id')->select('designations.*', 'departments.depart_title')->first();
        if ($designation) {
            return $designation;
        }
        return "fail";
    }

    public function designation_update(Request $request)
    {
        $designation = Designation::find($request->designation_id_for_edit);
        if ($designation) {
            $designation->depart_id = $request->_department_id;
            $designation->design_title = $request->_designation_title;
            $designation->design_note = $request->_designation_note;
            $designation->save();
            return "success";
        }
        return "fail";
    }
    //end
    //manage event
    public function viewEvent()
    {
        return view('admin.manageEvent');
    }

    public function getEventTableData()
    {
        $events = Event::all();
        $final_datas = array();
        foreach ($events as $event) {
            $final_datas[] = array(
                'id' => $event->id,
                'start' => $event->event_date." ".$event->event_start,
                'description' => $event->event_note,
                'end' => $event->event_date." ".$event->event_end,
                'title' => $event->event_title,
                'color' => '#7636f3',
                'className' => "m-fc-event--light m-fc-event--solid-primary",
            );
        }

        return $final_datas;
    }

    public function event_store(Request $request)
    {
        $event = new Event;
        $event->event_date = $this->encode_date_format($request->event_date);
        $event->event_start = $this->decode_time_format($request->event_start_time);
        $event->event_end = $this->decode_time_format($request->event_end_time);;
        $event->event_title = $request->event_title;
        $event->event_note = $request->event_note;
        $event->save();

        return "success";
    }

    public function event_update(Request $request)
    {
        $event = Event::find($request->event_id_for_edit);
        if ($event) {
            $event->event_date = $this->encode_date_format($request->_event_date);
            $event->event_start = $this->decode_time_format($request->_event_start_time);
            $event->event_end = $this->decode_time_format($request->_event_end_time);
            $event->event_title = $request->_event_title;
            $event->event_note = $request->_event_note;
            $event->save();

            return "success";
        }
        return "fail";
    }

    public function eventDateChange($id, $date)
    {
        $event = Event::find($id);
        if ($event) {
            $event->event_date = $date;
            $event->save();
            return "success";
        }
        return "fail";
    }

    public function eventDestroy($id)
    {
        $event = Event::find($id);
        if ($event) {
            $event->delete();
            return "success";
        }
        return "fail";
    }
    //end
    //manage ticket
    public function viewTicket()
    {
        return view('admin.ticket');
    }

    public function ticket_store(Request $request)
    {
        $ticket = new Ticket;
        $ticket->ticket_subject = $request->ticket_subject;
        $ticket->ticket_client = $request->ticket_client;
        $ticket->ticket_staff = $request->ticket_staff;
        $ticket->ticket_priority = $request->ticket_priority;
        $ticket->ticket_follower = serialize($request->ticket_follower);
        $ticket->ticket_note = $request->ticket_note;
        $ticket->ticket_status = 1; //0->new 1->open 2->onhold 3->closed 4->inprogress 5->cancelled
        $ticket->save();

        $now_date = new DateTime();
        $now_year = $now_date->format('Y');
        $now_month = $now_date->format('m');
        $now_day = $now_date->format('d');
        $final_ticket_id = $ticket->id.$now_year.$now_month.$now_day;

        $ticket->ticket_unique_id = $final_ticket_id;
        $ticket->save();

        return "success";
    }

    public function ticket_update(Request $request)
    {
        $ticket = Ticket::find($request->ticket_id_for_edit);
        if ($ticket) {
            $ticket->ticket_subject = $request->_ticket_subject;
            $ticket->ticket_client = $request->_ticket_client;
            $ticket->ticket_staff = $request->_ticket_staff;
            $ticket->ticket_priority = $request->_ticket_priority;
            $ticket->ticket_follower = serialize($request->_ticket_follower);
            $ticket->ticket_note = $request->_ticket_note;
            $ticket->save();

            return "success";
        }
        return "fail";
    }

    public function getTicketTableData()
    {
        $tickets = Ticket::all();
        $final_tickets = array();
        foreach ($tickets as $ticket) {
            $assign_staff = User::where('unique_id', $ticket->ticket_staff)->first();
            $assign_staff_avatar = "";
            if (file_exists('uploads/avatars/'.$assign_staff->unique_id.'/'.$assign_staff->avatar)) {
                $assign_staff_avatar = asset('/uploads/avatars/'.$assign_staff->unique_id.'/'.$assign_staff->avatar);
            } else {
                $assign_staff_avatar = asset('/uploads/avatars/default.png');
            }

            $followers = array();
            if ($ticket->ticket_follower != null || $ticket->ticket_follower != "") {
                $serialed_followers = unserialize($ticket->ticket_follower);
                foreach ($serialed_followers as $unique_id) {
                    $member = User::where('unique_id', $unique_id)->first();
                    $member_avatar = "";
                    if (file_exists('uploads/avatars/'.$member->unique_id.'/'.$member->avatar)) {
                        $member_avatar = asset('/uploads/avatars/'.$member->unique_id.'/'.$member->avatar);
                    } else {
                        $member_avatar = asset('/uploads/avatars/default.png');
                    }
                    $followers[] = array('follower_username' => $member->first_name." ".$member->last_name, 'follower_avatar' => $member_avatar, 'follower_unique' => $member->unique_id);
                }
            }

            $final_tickets[] = array(
                'id' => $ticket->id,
                'ticket_unique_id' => $ticket->ticket_unique_id,
                'ticket_subject' => $ticket->ticket_subject,
                'ticket_client' => $ticket->ticket_client,
                'ticket_staff_name' => $assign_staff->first_name." ".$assign_staff->last_name,
                'ticket_staff_avatar' => $assign_staff_avatar,
                'ticket_staff_id' => $assign_staff->unique_id,
                'ticket_priority' => $ticket->ticket_priority,
                'ticket_followers' => $followers,
                'ticket_note' => $ticket->ticket_note,
                'ticket_status' => $ticket->ticket_status,
                'ticket_create_date' => $this->decode_date_time_format($ticket->created_at),
            );
        }
        return $final_tickets;
    }

    public function getSignleTicket($id) {
        $ticket = Ticket::find($id);
        if ($ticket) {
            $final_data = array(
                'id' => $ticket->id,
                'ticket_subject' => $ticket->ticket_subject,
                'ticket_client' => $ticket->ticket_client,
                'ticket_staff' => $ticket->ticket_staff,
                'ticket_priority' => $ticket->ticket_priority,
                'ticket_followers' => unserialize($ticket->ticket_follower),
                'ticket_note' => $ticket->ticket_note,
            );

            return $final_data;
        }
        return "fail";
    }

    public function updateTicketStatus($id, $status)
    {
        $ticket = Ticket::find($id);
        if ($ticket) {
            $ticket->ticket_status = $status;
            $ticket->save();
            return "success";
        }
        return "fail";
    }
    //end
}
