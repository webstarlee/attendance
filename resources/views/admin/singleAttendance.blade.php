@extends('layouts.adminApp')
@section('title')
{{$employee->username}} Attendance
@endsection
@section('pageTitle')
{{$employee->username}} Attendance
@endsection
@section('plugin_style')
<link href="/assets/plugins/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
@endsection
@section('customStyle')
<link href="/css/customProfile.css" rel="stylesheet" type="text/css" />
<link href="/css/customAttend.css" rel="stylesheet" type="text/css" />
@endsection
@section('body_class')
m-aside-left--enabled m-aside-left--offcanvas
@endsection
@section('left_sidebar_toggle')
    <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
        <span></span>
    </a>
@endsection
@section('left_sidebar')
    <button class="m-aside-left-close m-aside-left-close--skin-light" id="m_aside_left_close_btn">
		<i class="la la-close"></i>
	</button>
	<div id="m_aside_left" class="m-grid__item m-aside-left ">
		<!-- BEGIN: Aside Menu -->
		<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-light m-aside-menu--submenu-skin-light " data-menu-vertical="true" data-menu-scrollable="false" data-menu-dropdown-timeout="500">
			<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
                <li class="m-menu__section"><h4 class="m-menu__section-text"></h4></li>
				<li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
					<a  href="{{url('admin/manage/attendance/'.$employee->unique_id.'/view')}}" class="m-menu__link ">
						<i class="m-menu__link-bullet m-menu__link-bullet--dot">
							<span></span>
						</i>
						<span class="m-menu__link-text">
							Dashboard
						</span>
					</a>
				</li>
                <li class="m-menu__item " aria-haspopup="true"  data-redirect="true">
					<a  href="{{url('admin/manage/attendance/'.$employee->unique_id.'/view/request')}}" class="m-menu__link ">
						<i class="m-menu__link-bullet m-menu__link-bullet--dot">
							<span></span>
						</i>
						<span class="m-menu__link-text">
							Requests
						</span>
					</a>
				</li>
			</ul>
		</div>
		<!-- END: Aside Menu -->
	</div>
	<!-- END: Left Aside -->
@endsection
@section('content')
    <?php
        $setting = \App\Setting::where('id', 1)->first();
    ?>
    <input type="hidden" name="golobal_employee_id" id="golobal_employee_id" value="{{$employee->id}}">
    @if(Route::currentRouteName()=='admin.manage.attendance.single')
        @include('admin.module.attendanceCalendar', ['setting'=>$setting, 'employee'=>$employee])
    @elseif(Route::currentRouteName()=='admin.manage.attendance.single.request')
        @include('admin.module.attendanceRequest', ['setting'=>$setting, 'employee'=>$employee])
    @endif

    <div class="modal fade m-custom-modal" id="m-admin-new_attendance-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						Add New Attendance
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
						<span aria-hidden="true">
							&times;
						</span>
					</button>
				</div>
                <form id="m-admin-new_attendance-form" action="{{route('admin.manage.attendance.store')}}" role="form" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="employee_id" value="{{$employee->id}}">
    				<div class="modal-body" style="padding-bottom: 10px;">
                        <div class="row ">
                            <div class="col-sm-6">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputEmail1">
                                        Contract Type:
                                    </label>
                                    <div class="input-group m-input-group m-input-group--air">
                                        <span class="input-group-addon">
                                            <i class="flaticon-tool-1"></i>
                                        </span>
                                        <input type="text" class="form-control m-input" value="{{$employee->contract_title}}" placeholder="Enter date" readonly>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                            <div class="col-sm-6">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputEmail1">
                                        Attendance status:
                                    </label>
                                    <div class="input-group m-input-group m-input-group--air">
                                        <span class="input-group-addon">
                                            <i class="la la-info"></i>
                                        </span>
                                        <select class="form-control m-bootstrap-select m_selectpicker" id="attendance_type" name="attendance_type">
                                            <option value="1" selected>Work</option>
                                            <option value="0">Absence</option>
                                            <option value="2">Business Trip</option>
                                            <option value="3">Vacation</option>
                                            <option value="4">Short Vacation</option>
                                            <option value="5">Doctor</option>
                                            <option value="6">Paragraph</option>
                                            <option value="7">Parental Leave</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputEmail1">
                                        From:
                                    </label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="input-group m-input-group m-input-group--air">
                                                <span class="input-group-addon">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                                <input type="text" class="form-control m-input m-input-datepicker" id="attend_date_from" name="attend_date_from" placeholder="Enter date" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-group m-input-group m-input-group--air">
                                                <span class="input-group-addon">
                                                    <i class="la la-clock-o"></i>
                                                </span>
                                                <input type="text" class="form-control m-input input-time-picker" name="attend_start_time" value="8:00 AM" placeholder="Enter time" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputEmail1">
                                        To:
                                    </label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="input-group m-input-group m-input-group--air">
                                                <span class="input-group-addon">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                                <input type="text" class="form-control m-input m-input-datepicker" id="attend_date_to" name="attend_date_to" placeholder="Enter date" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-group m-input-group m-input-group--air">
                                                <span class="input-group-addon">
                                                    <i class="la la-clock-o"></i>
                                                </span>
                                                <input type="text" class="form-control m-input input-time-picker" name="attend_end_time" value="{{$employee->getContractEndtime()}}" placeholder="Enter time" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <label class="m-checkbox m-checkbox--air m-checkbox--state-success">
									<input type="checkbox" name="attend_weekend" checked>
									Don't insert in Weekend
									<span></span>
								</label>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <label class="m-checkbox m-checkbox--air m-checkbox--state-success">
									<input type="checkbox" name="attend_holiday" checked>
									Don't insert in Holiday
									<span></span>
								</label>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <label class="m-checkbox m-checkbox--air m-checkbox--state-success">
									<input type="checkbox" name="attend_fix_time" checked>
									Don't insert outside of person employment
									<span></span>
								</label>
                            </div>
                        </div>
                        <div class="attendance_status_input_container"></div>
    				</div>
    				<div class="modal-footer">
    					<button type="submit" class="btn m-btn--air btn-outline-accent form-submit-btn">
    						Submit
    					</button>
    				</div>
                </form>
			</div>
		</div>
    </div>

    <div class="modal fade m-custom-modal" id="m-admin-edit_attendance-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel2">
						Edit Attendance
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
						<span aria-hidden="true">
							&times;
						</span>
					</button>
				</div>
                <form id="m-admin-edit_attendance-form" action="{{route('admin.manage.attendance.update')}}" role="form" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="attendance_id" id="attendance_id" value="">
    				<div class="modal-body" style="padding-bottom: 10px;">
                        <div class="row ">
                            <div class="col-sm-6">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label>
                                        Contract Type:
                                    </label>
                                    <div class="input-group m-input-group m-input-group--air">
                                        <span class="input-group-addon">
                                            <i class="flaticon-tool-1"></i>
                                        </span>
                                        <input type="text" class="form-control m-input" value="{{$employee->contract_title}}" placeholder="Enter date" readonly>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                            <div class="col-sm-6">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputEmail1">
                                        Attendance status:
                                    </label>
                                    <div class="input-group m-input-group m-input-group--air">
                                        <span class="input-group-addon">
                                            <i class="la la-info"></i>
                                        </span>
                                        <select class="form-control m-bootstrap-select m_selectpicker" id="_attendance_type" name="_attendance_type">
                                            <option value="1" selected>Work</option>
                                            <option value="0">Absence</option>
                                            <option value="2">Business Trip</option>
                                            <option value="3">Vacation</option>
                                            <option value="4">Short Vacation</option>
                                            <option value="5">Doctor</option>
                                            <option value="6">Paragraph</option>
                                            <option value="7">Parental Leave</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="_attend_date_from">
                                        From:
                                    </label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="input-group m-input-group m-input-group--air">
                                                <span class="input-group-addon">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                                <input type="text" class="form-control m-input m-input-datepicker" id="_attend_date_from" name="_attend_date_from" placeholder="Enter date" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-group m-input-group m-input-group--air">
                                                <span class="input-group-addon">
                                                    <i class="la la-clock-o"></i>
                                                </span>
                                                <input type="text" class="form-control m-input input-time-picker" id="_attend_start_time" name="_attend_start_time" value="8:00 AM" placeholder="Enter time" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="_attend_date_to">
                                        To:
                                    </label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="input-group m-input-group m-input-group--air">
                                                <span class="input-group-addon">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                                <input type="text" class="form-control m-input m-input-datepicker" id="_attend_date_to" name="_attend_date_to" placeholder="Enter date" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-group m-input-group m-input-group--air">
                                                <span class="input-group-addon">
                                                    <i class="la la-clock-o"></i>
                                                </span>
                                                <input type="text" class="form-control m-input input-time-picker" id="_attend_end_time" name="_attend_end_time" value="{{$employee->getContractEndtime()}}" placeholder="Enter time" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <label class="m-checkbox m-checkbox--air m-checkbox--state-success">
									<input type="checkbox" id="_attend_weekend" name="_attend_weekend" checked>
									Don't insert in Weekend
									<span></span>
								</label>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <label class="m-checkbox m-checkbox--air m-checkbox--state-success">
									<input type="checkbox" id="_attend_holiday" name="_attend_holiday" checked>
									Don't insert in Holiday
									<span></span>
								</label>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <label class="m-checkbox m-checkbox--air m-checkbox--state-success">
									<input type="checkbox" id="_attend_fix_time" name="_attend_fix_time" checked>
									Don't insert outside of person employment
									<span></span>
								</label>
                            </div>
                        </div>
                        <div class="attendance_status_input_container"></div>
    				</div>
    				<div class="modal-footer">
                        <button type="submit" class="btn m-btn--air btn-outline-accent form-submit-btn">
    						Update
    					</button>
    				</div>
                </form>
			</div>
		</div>
    </div>

    <div class="modal fade m-custom-modal" id="m-admin-view_attendance_request-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel2">
						View Attendance Request
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
						<span aria-hidden="true">
							&times;
						</span>
					</button>
				</div>
                <form id="m-admin-view_attendance_request-form" action="" role="form" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="attendance_request_id" id="attendance_request_id" value="">
    				<div class="modal-body" style="padding-bottom: 10px;">
                        <div class="row ">
                            <div class="col-sm-6">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputEmail1">
                                        Date From:
                                    </label>
                                    <div class="input-group m-input-group m-input-group--air">
                                        <span class="input-group-addon">
                                            <i class="la la-calendar"></i>
                                        </span>
                                        <input type="text" class="form-control m-input" id="attend_request_date_from" name="attend_request_date_from" placeholder="Enter date" required>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                            <div class="col-sm-6">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputEmail1">
                                        To Date:
                                    </label>
                                    <div class="input-group m-input-group m-input-group--air">
                                        <span class="input-group-addon">
                                            <i class="la la-calendar"></i>
                                        </span>
                                        <input type="text" class="form-control m-input" id="attend_request_date_to" name="attend_request_date_to" placeholder="Enter date" required>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputEmail1">
                                        Contract Type:
                                    </label>
                                    <div class="input-group m-input-group m-input-group--air">
                                        <span class="input-group-addon">
                                            <i class="flaticon-tool-1"></i>
                                        </span>
                                        <input type="text" class="form-control m-input" value="{{$employee->contract_title}}" placeholder="Enter date" readonly>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputEmail1">
                                        Attendance status:
                                    </label>
                                    <div class="input-group m-input-group m-input-group--air">
                                        <span class="input-group-addon">
                                            <i class="la la-info"></i>
                                        </span>
                                        <select class="form-control m-bootstrap-select m_selectpicker" id="attend_request_type" name="attend_request_type">
                                            <option value="0">Absence</option>
                                            <option value="1">Attendance</option>
                                            <option value="2">Business Trip</option>
                                            <option value="3">Vacation</option>
                                            <option value="4">Sickness</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="attendance_status_input_container"></div>
    				</div>
    				<div class="modal-footer">
                        <button type="button" class="btn m-btn--air btn-outline-danger" id="attendance_request_reject_btn">
    						Reject
    					</button>
    					<button type="submit" class="btn m-btn--air btn-outline-accent form-submit-btn">
    						Approve
    					</button>
    				</div>
                </form>
			</div>
		</div>
    </div>

    <div id="hidden_attendance_input_box_container" style="display: none;">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group m-form__group break-time-container-form" style="display: none;">
                    <label>
                        Break Time:
                    </label>
                    <div class="break-time-container"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group m-form__group smoke-time-container-form" style="display: none;">
                    <label>
                        Smoking Time:
                    </label>
                    <div class="smoke-time-container"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12" style="display:flex;justify-content: flex-end;">
                <button type="button" class="btn m-btn--air btn-outline-success add-smoke-time-btn" style="margin-right:10px;">
                    Add smoke
                </button>
                <button type="button" class="btn m-btn--air btn-outline-success add-break-time-btn">
                    Add Break
                </button>
            </div>
        </div>
    </div>
@endsection
@section('plugin_script')
<script src="/assets/plugins/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
<script src="/assets/plugins/circle-progress.min.js" type="text/javascript"></script>
@endsection
@section('customScript')
    <script type="text/javascript">
        var random_string_id = null;
        var golbalEmployeeId = $('#golobal_employee_id').val();
        $(document).ready(function(){
            setJsplugin();
        });

        function setJsplugin() {
            $('.m-input-datepicker').datepicker({
                todayHighlight: true,
                autoclose: true,
                orientation: "bottom left",
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            });

            $('.m_selectpicker').selectpicker();

            $('.input-time-picker').timepicker();
            $('.input-smoke-timepicker').timepicker({
                minuteStep: 5,
                showMeridian: true,
            })
        }
    </script>
    @if(Route::currentRouteName()=='admin.manage.attendance.single')
        <script src="/js/calendar/singleAttendCalendar.js" type="text/javascript"></script>
    @elseif(Route::currentRouteName()=='admin.manage.attendance.single.request')
        <script src="/js/datatable/singleAttendRequestDatatable.js" type="text/javascript"></script>
    @endif
    <script src="/js/singleAttend.js" type="text/javascript"></script>
    <script src="/js/customManage.js" type="text/javascript"></script>
@endsection
