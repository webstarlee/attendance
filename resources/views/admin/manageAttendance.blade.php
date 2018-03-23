@extends('layouts.adminApp')

@section('title')
Attendance Manage
@endsection

@section('pageTitle')
Attendance Management
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						<i class="la la-gear"></i> &nbsp;Attendance Management
					</h3>
				</div>
			</div>
		</div>
		<div class="m-portlet__body">
			<!--begin: Search Form -->
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
			<!--end: Search Form -->
            <!--begin: Datatable -->
			<div id="m_attendance_datatable"></div>
			<!--end: Datatable -->
		</div>
	</div>


@endsection
@section('customScript')
    <script src="/js/attendance.js" type="text/javascript"></script>
    <script src="/js/customManage.js" type="text/javascript"></script>
@endsection
