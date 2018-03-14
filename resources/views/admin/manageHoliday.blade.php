@extends('layouts.adminApp')
@section('title')
Manage Holiday
@endsection
@section('pageTitle')
Holiday Management
@endsection
@section('plugin_style')
<link href="/assets/plugins/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="m-portlet" id="m_portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                        <i class="flaticon-map-location"></i>
                    </span>
                    <h3 class="m-portlet__head-text">
                        Holiday Calendar
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="javascript:;" id="add-new-holiday-btn" class="btn btn-outline-accent m-btn m-btn--custom m-btn--icon m-btn--air">
                            <span>
                                <i class="la la-plus"></i>
                                <span>
                                    Add Holiday
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
					<a class="nav-link m-tabs__link active" data-toggle="tab" href="#holiday-calendar-tab">
						<i class="fa fa-calendar"></i> Calendar
					</a>
				</li>
				<li class="nav-item m-tabs__item">
					<a class="nav-link m-tabs__link" data-toggle="tab" href="#holiday-table-tab">
						<i class="fa fa-table"></i> List View
					</a>
				</li>
			</ul>
            <div class="tab-content">
                <div class="tab-pane active" id="holiday-calendar-tab" role="tabpanel">
                    <div id="m_holiday_calendar"></div>
                </div>
                <div class="tab-pane" id="holiday-table-tab" role="tabpanel">
                    <div id="m_holiday_table"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade m-custom-modal" id="m-admin-new_holiday-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						Add New Holiday
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
						<span aria-hidden="true">
							&times;
						</span>
					</button>
				</div>
                <form id="m-admin-new_holiday-form" action="{{route('admin.manage.holiday.store')}}" role="form" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
    				<div class="modal-body">
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="contract_title">
                                        *Date:
                                    </label>
                                    <input type="text" class="form-control m-input" id="holi_date" name="holi_date" placeholder="Enter Holiday date" required>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="contract_title">
                                        *Title:
                                    </label>
                                    <input type="text" class="form-control m-input" id="holi_title" name="holi_title" placeholder="Enter Holiday title" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
									<label for="contract_description">
										Description:
									</label>
									<textarea class="form-control m-input" name="holi_description" id="holi_description" placeholder="Enter Holiday description" rows="5"></textarea>
								</div>
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

    <div class="modal fade m-custom-modal" id="m-admin-edit_holiday-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						Edit Holiday
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
						<span aria-hidden="true">
							&times;
						</span>
					</button>
				</div>
                <form id="m-admin-edit_holiday-form" action="{{route('admin.manage.holiday.update')}}" role="form" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="holiday_id" id="holiday_id" value="">
    				<div class="modal-body">
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="contract_title">
                                        *Date:
                                    </label>
                                    <input type="text" class="form-control m-input" id="_holi_date" name="_holi_date" placeholder="Enter Holiday date" required>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="contract_title">
                                        *Title:
                                    </label>
                                    <input type="text" class="form-control m-input" id="_holi_title" name="_holi_title" placeholder="Enter Holiday title" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
									<label for="contract_description">
										Description:
									</label>
									<textarea class="form-control m-input" name="_holi_description" id="_holi_description" placeholder="Enter Holiday description" rows="5"></textarea>
								</div>
                            </div>
                        </div>
    				</div>
    				<div class="modal-footer">
    					<button type="button" class="btn m-btn--air btn-outline-primary" data-dismiss="modal">
    						Close
    					</button>
                        <button type="button" class="btn m-btn--air btn-outline-danger" id="holiday_delete_btn">
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
            $('#holi_date').datepicker({
                todayHighlight: true,
                autoclose: true,
                orientation: "bottom left",
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            });
        }
    </script>
    <script src="/js/holiday.js" type="text/javascript"></script>
    <script src="/js/customManage.js" type="text/javascript"></script>
@endsection
