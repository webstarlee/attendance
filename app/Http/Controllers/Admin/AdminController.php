<?php

namespace App\Http\Controllers\Admin;

use DateTime;
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
}
