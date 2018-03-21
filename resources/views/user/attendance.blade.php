@extends('layouts.app')
@section('title')
My Attendance
@endsection
@section('pageTitle')
My Attendance
@endsection
@section('plugin_style')
<link href="/assets/plugins/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <?php
        $contract_types = \App\ContractType::all();
    ?>
    <input type="hidden" name="golobal_employee_id" id="golobal_employee_id" value="{{Auth::user()->id}}">
    <div class="m-portlet" id="m_portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                        <i class="flaticon-map-location"></i>
                    </span>
                    <h3 class="m-portlet__head-text">
                        Attendance Calendar
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="javascript:;" id="add-new-attendance-btn" class="btn btn-outline-accent m-btn m-btn--custom m-btn--icon m-btn--air">
                            <span>
                                <i class="la la-plus"></i>
                                <span>
                                    Add Attendance
                                </span>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <ul class="nav nav-tabs nav-fill m-tabs-line m-tabs-line--success m-tabs-line--2x" role="tablist">
				<li class="nav-item m-tabs__item">
					<a class="nav-link m-tabs__link active" data-toggle="tab" href="#attendance-calendar-tab">
						<i class="fa fa-calendar"></i> Calendar
					</a>
				</li>
				<li class="nav-item m-tabs__item">
					<a class="nav-link m-tabs__link" data-toggle="tab" href="#attendance-table-tab">
						<i class="fa fa-table"></i> List View
					</a>
				</li>
			</ul>
            <div class="tab-content">
                <div class="tab-pane active" id="attendance-calendar-tab" role="tabpanel">
                    <div id="m_attendance_calendar"></div>
                </div>
                <div class="tab-pane" id="attendance-table-tab" role="tabpanel">
                    <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
        				<div class="row align-items-center">
        					<div class="col-xl-8 order-2 order-xl-1">
        						<div class="form-group m-form__group row align-items-center">
        							<div class="col-md-4">
        								<div class="m-input-icon m-input-icon--left">
        									<input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch">
        									<span class="m-input-icon__icon m-input-icon__icon--left">
        										<span>
        											<i class="la la-search"></i>
        										</span>
        									</span>
        								</div>
        							</div>
        						</div>
        					</div>
        				</div>
        			</div>
                    <div id="m_attendance_table"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade m-custom-modal" id="m-employee-new_attendance-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <form id="m-employee-new_attendance-form" action="{{route('attendance.store')}}" role="form" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
    				<div class="modal-body">
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputEmail1">
                                        Date:
                                    </label>
                                    <div class="input-group m-input-group m-input-group--air">
                                        <span class="input-group-addon">
                                            <i class="la la-calendar"></i>
                                        </span>
                                        <input type="text" class="form-control m-input" id="attend_date" name="attend_date" placeholder="Enter Holiday date" required>
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
                                        <select class="form-control m-bootstrap-select m_selectpicker" name="contract_type">
                                            @foreach ($contract_types as $contract_type)
                                                <option value="{{$contract_type->id}}">{{$contract_type->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
    				</div>
    				<div class="modal-footer">
    					<button type="button" class="btn m-btn--air btn-outline-primary" data-dismiss="modal">
    						Close
    					</button>
    					<button type="submit" class="btn m-btn--air btn-outline-accent form-submit-btn">
    						Submit
    					</button>
    				</div>
                </form>
			</div>
		</div>
    </div>

    <div class="modal fade m-custom-modal" id="m-employee-edit_attendance-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
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
                <form id="m-employee-edit_attendance-form" action="{{route('attendance.update')}}" role="form" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="attendance_id" id="attendance_id" value="">
    				<div class="modal-body">
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputEmail1">
                                        Date:
                                    </label>
                                    <div class="input-group m-input-group m-input-group--air">
                                        <span class="input-group-addon">
                                            <i class="la la-calendar"></i>
                                        </span>
                                        <input type="text" class="form-control m-input" id="_attend_date" name="_attend_date" placeholder="Enter Attendance date" required>
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
                                        <select class="form-control m-bootstrap-select m_selectpicker" id="_contract_type" name="_contract_type">
                                            @foreach ($contract_types as $contract_type)
                                                <option value="{{$contract_type->id}}">{{$contract_type->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
    				</div>
    				<div class="modal-footer">
    					<button type="button" class="btn m-btn--air btn-outline-primary" data-dismiss="modal">
    						Close
    					</button>
                        <button type="button" class="btn m-btn--air btn-outline-danger" id="attendance_delete_btn">
    						Delete
    					</button>
    					<button type="submit" class="btn m-btn--air btn-outline-accent form-submit-btn">
    						Update
    					</button>
    				</div>
                </form>
			</div>
		</div>
    </div>
@endsection
@section('plugin_script')
<script src="/assets/plugins/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
@endsection
@section('customScript')
    <script type="text/javascript">
        $(document).ready(function(){
            setJsplugin();
        });

        function setJsplugin() {
            $('#attend_date').datepicker({
                todayHighlight: true,
                autoclose: true,
                orientation: "bottom left",
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            });

            $('.m_selectpicker').selectpicker();
        }
    </script>
    <script src="/js/employeeAttend.js" type="text/javascript"></script>
@endsection
