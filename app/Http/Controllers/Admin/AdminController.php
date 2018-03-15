<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use App\Holiday;
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
}
