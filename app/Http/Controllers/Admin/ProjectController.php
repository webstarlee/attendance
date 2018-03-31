<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use DatePeriod;
use DateInterval;
use App\Task;
use App\Admin;
use App\User;
use App\Project;
use App\TimingSheet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function view_project()
    {
        return view('admin.project');
    }

    public function getProjectTableData()
    {
        $projects = Project::all();
        $final_projects = array();
        foreach ($projects as $project) {
            $leader_admin = Admin::where('unique_id', $project->pro_leader)->first();
            $leader_employee = User::where('unique_id', $project->pro_leader)->first();
            $leader = "";
            if ($leader_admin) {
                $leader = $leader_admin;
            } elseif ($leader_employee) {
                $leader = $leader_employee;
            }

            $members = array();
            if ($project->pro_members != null || $project->pro_members != "") {
                $serial_members = unserialize($project->pro_members);
                foreach ($serial_members as $unique_id) {
                    $member = User::where('unique_id', $unique_id)->first();
                    $members[] = array('member_username' => $member->first_name." ".$member->last_name, 'member_avatar' => $member->avatar, 'member_unique' => $member->unique_id);
                }
            }

            $final_projects[] = array(
                'id' => $project->id,
                'pro_name' => $project->pro_name,
                'pro_id' => $project->pro_unid,
                'pro_start_date' => $this->decode_date_format($project->pro_start_date),
                'pro_end_date' => $this->decode_date_format($project->pro_end_date),
                'leader_name' => $leader->first_name." ".$leader->last_name,
                'leader_photo' => $leader->avatar,
                'leader_unique' => $leader->unique_id,
                'members' => $members,
                'pro_priority' => $project->pro_priority,
                'pro_status' => $project->pro_status,
            );
        }
        return $final_projects;
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

    public function project_store(Request $request)
    {
        $project = new Project;
        $project->pro_name = $request->project_title;
        $project->pro_client = $request->project_client;
        $project->pro_start_date = $this->encode_date_format($request->project_start_date);
        $project->pro_end_date = $this->encode_date_format($request->project_end_date);
        $project->pro_rate = $request->project_rate;
        $project->pro_rate_type = $request->project_rate_type;
        $project->pro_priority = $request->project_priority;
        $project->pro_status = 0;
        $project->pro_leader = $request->project_leader;
        $project->pro_members = serialize($request->project_members);
        $project->pro_note = $request->project_note;
        $project->save();

        $project->pro_unid = 'Pro-'.$project->id;
        $project->save();

        return "success";
    }

    public function project_update(Request $request)
    {
        $project = Project::find($request->project_id_for_edit);
        if ($project) {
            $project->pro_name = $request->_project_title;
            $project->pro_client = $request->_project_client;
            $project->pro_start_date = $this->encode_date_format($request->_project_start_date);
            $project->pro_end_date = $this->encode_date_format($request->_project_end_date);
            $project->pro_rate = $request->_project_rate;
            $project->pro_rate_type = $request->_project_rate_type;
            $project->pro_priority = $request->_project_priority;
            $project->pro_leader = $request->_project_leader;
            $project->pro_members = serialize($request->_project_members);
            $project->pro_note = $request->_project_note;
            $project->save();

            return "success";
        }

        return "fail";
    }

    public function getSignleProject($id)
    {
        $project = Project::find($id);
        if ($project) {
            $final_data = array(
                'id' => $project->id,
                'pro_name' => $project->pro_name,
                'pro_client' => $project->pro_client,
                'pro_start_date' => $this->decode_date_format($project->pro_start_date),
                'pro_end_date' => $this->decode_date_format($project->pro_end_date),
                'pro_leader' => $project->pro_leader,
                'pro_members' => unserialize($project->pro_members),
                'pro_priority' => $project->pro_priority,
                'pro_rate' => $project->pro_rate,
                'pro_rate_type' => $project->pro_rate_type,
                'pro_status' => $project->pro_status,
                'pro_note' => $project->pro_note,
            );

            return $final_data;
        }
        return "fail";
    }

    public function updateProjectStatus($project_id, $status)
    {
        $project = Project::find($project_id);
        if ($project) {
            $project->pro_status = $status;
            $project->save();
            return "success";
        }
        return "fail";
    }

    public function view_task()
    {
        $projects = Project::all();
        return view('admin.projectTask', ['projects' => $projects]);
    }

    public function getTaskTableData()
    {
        $tasks = Task::join('projects', 'projects.id', '=', 'tasks.pro_id')->select('tasks.*', 'projects.pro_name')->get();
        $final_tasks = array();
        foreach ($tasks as $task) {
            $members = array();
            if ($task->task_assign != null || $task->task_assign != "") {
                $serial_members = unserialize($task->task_assign);
                foreach ($serial_members as $unique_id) {
                    $member = User::where('unique_id', $unique_id)->first();
                    $members[] = array('member_username' => $member->first_name." ".$member->last_name, 'member_avatar' => $member->avatar, 'member_unique' => $member->unique_id);
                }
            }

            $final_tasks[] = array(
                'id' => $task->id,
                'pro_name' => $task->pro_name,
                'task_name' => $task->task_title,
                'task_status' => $task->task_status,
                'members' => $members,
            );
        }
        return $final_tasks;
    }

    public function task_store(Request $request)
    {
        $task = new Task;
        $task->pro_id = $request->task_project;
        $task->task_title = $request->task_title;
        $task->task_status = 0;
        $task->task_assign = serialize($request->task_members);
        $task->task_note = $request->task_note;
        $task->save();

        return "success";
    }

    public function getSignleTask($id)
    {
        $task = Task::find($id);
        if ($task) {
            $final_data = array(
                'id' => $task->id,
                'pro_id' => $task->pro_id,
                'task_name' => $task->task_title,
                'members' => unserialize($task->task_assign),
                'task_note' => $task->task_note,
            );

            return $final_data;
        }
        return "fail";
    }

    public function task_update(Request $request)
    {
        $task = Task::find($request->task_id_for_edit);
        if ($task) {
            $task->pro_id = $request->_task_project;
            $task->task_title = $request->_task_title;
            $task->task_assign = serialize($request->_task_members);
            $task->task_note = $request->_task_note;
            $task->save();
            return "success";
        }
        return "fail";
    }

    public function updateTaskStatus($task_id, $status)
    {
        $task = Task::find($task_id);
        if ($task) {
            $task->task_status = $status;
            $task->save();
            return "success";
        }
        return "fail";
    }

    public function view_timingsheet()
    {
        $projects = Project::all();
        return view('admin.timingSheet', ['projects' => $projects]);
    }

    public function timingsheet_store(Request $request)
    {
        $sheet = new TimingSheet;
        $sheet->pro_id = $request->sheet_project;
        $sheet->employee_id = $request->sheet_member;
        $sheet->sheet_date = $this->encode_date_format($request->sheet_date);
        $sheet->work_time = $request->sheet_time;
        $sheet->sheet_note = $request->sheet_note;
        $sheet->save();

        return "success";
    }

    public function timingsheet_update(Request $request)
    {
        $sheet = TimingSheet::find($request->sheet_id_for_edit);
        if ($sheet) {
            $sheet->pro_id = $request->_sheet_project;
            $sheet->employee_id = $request->_sheet_member;
            $sheet->sheet_date = $this->encode_date_format($request->_sheet_date);
            $sheet->work_time = $request->_sheet_time;
            $sheet->sheet_note = $request->_sheet_note;
            $sheet->save();

            return "success";
        }
        return "fail";
    }

    public function getSheetTableData()
    {
        $sheets = TimingSheet::join('projects', 'projects.id', '=', 'timing_sheets.pro_id')->select('timing_sheets.*', 'projects.pro_name')->get();
        $final_sheets = array();
        foreach ($sheets as $sheet) {
            $member = User::where('unique_id', $sheet->employee_id)->first();
            $photo_url = "";
            if (file_exists('uploads/avatars/'.$member->unique_id.'/'.$member->avatar)) {
                $photo_url = asset('/uploads/avatars/'.$member->unique_id.'/'.$member->avatar);
            } else {
                $photo_url = asset('/uploads/avatars/default.png');
            }

            $final_sheets[] = array(
                'id' => $sheet->id,
                'pro_name' => $sheet->pro_name,
                'sheet_date' => $this->decode_date_format($sheet->sheet_date),
                'sheet_time' => $sheet->work_time,
                'sheet_note' => $sheet->sheet_note,
                'employee_name' => $member->first_name.' '.$member->last_name,
                'employee_photo' => $photo_url,
                'employee_unique_id' => $member->unique_id,
            );
        }
        return $final_sheets;
    }

    public function getSignleSheet($id)
    {
        $sheet = TimingSheet::find($id);
        if ($sheet) {
            $final_sheet = array(
                'id' => $sheet->id,
                'pro_id' => $sheet->pro_id,
                'sheet_date' => $this->decode_date_format($sheet->sheet_date),
                'sheet_time' => $sheet->work_time,
                'sheet_note' => $sheet->sheet_note,
                'employee_id' => $sheet->employee_id,
            );

            return $final_sheet;
        }
        return "fail";
    }
}
