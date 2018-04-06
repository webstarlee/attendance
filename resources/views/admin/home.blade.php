@extends('layouts.adminApp')

@section('title')
Dashboard
@endsection

@section('pageTitle')
Dashboard
@endsection

@section('plugin_style')
<link href="/assets/plugins/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="m-portlet ">
		<div class="m-portlet__body  m-portlet__body--no-padding">
			<div class="row m-row--no-padding m-row--col-separator-xl">
				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
					<!--begin::Total Profit-->
					<div class="m-widget24">
						<div class="m-widget24__item">
							<h4 class="m-widget24__title">
								Employee Number
							</h4>
							<br>
							<span class="m-widget24__desc">
								total employee
							</span>
							<span class="m-widget24__stats m--font-brand">
								<?php
                                    $employee_count = \App\User::count();
                                ?>
                                {{$employee_count}}
							</span>
							<div class="m--space-40"></div>
						</div>
					</div>
					<!--end::Total Profit-->
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
					<!--begin::New Feedbacks-->
					<div class="m-widget24">
						<div class="m-widget24__item">
							<h4 class="m-widget24__title">
								Project Number
							</h4>
							<br>
							<span class="m-widget24__desc">
								total project
							</span>
							<span class="m-widget24__stats m--font-info">
                                <?php
                                    $project_count = \App\Project::count();
                                ?>
                                {{$project_count}}
							</span>
							<div class="m--space-40"></div>
						</div>
					</div>
					<!--end::New Feedbacks-->
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
					<!--begin::New Orders-->
					<div class="m-widget24">
						<div class="m-widget24__item">
							<h4 class="m-widget24__title">
								Task Number
							</h4>
							<br>
							<span class="m-widget24__desc">
								total task
							</span>
							<span class="m-widget24__stats m--font-danger">
                                <?php
                                    $task_count = \App\Task::count();
                                ?>
                                {{$task_count}}
							</span>
							<div class="m--space-40"></div>
						</div>
					</div>
					<!--end::New Orders-->
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
					<!--begin::New Users-->
					<div class="m-widget24">
						<div class="m-widget24__item">
							<h4 class="m-widget24__title">
								New Ticket
							</h4>
							<br>
							<span class="m-widget24__desc">
								view tickets
							</span>
							<span class="m-widget24__stats m--font-success">
                                <?php
                                    $ticket_count = \App\Ticket::count();
                                ?>
                                {{$ticket_count}}
							</span>
							<div class="m--space-40"></div>
						</div>
					</div>
					<!--end::New Users-->
				</div>
			</div>
		</div>
	</div>
    <div class="m-portlet">
		<div class="m-portlet__body m-portlet__body--no-padding">
			<div class="row m-row--no-padding m-row--col-separator-xl">
				<div class="col-md-12 col-lg-12 col-xl-4">
					<!--begin:: Widgets/Stats2-1 -->
					<div class="m-widget1">
						<div class="m-widget1__item">
							<div class="row m-row--no-padding align-items-center">
								<div class="col">
									<h3 class="m-widget1__title">
										Member Profit
									</h3>
									<span class="m-widget1__desc">
										Awerage Weekly Profit
									</span>
								</div>
								<div class="col m--align-right">
									<span class="m-widget1__number m--font-brand">
										+$17,800
									</span>
								</div>
							</div>
						</div>
						<div class="m-widget1__item">
							<div class="row m-row--no-padding align-items-center">
								<div class="col">
									<h3 class="m-widget1__title">
										Orders
									</h3>
									<span class="m-widget1__desc">
										Weekly Customer Orders
									</span>
								</div>
								<div class="col m--align-right">
									<span class="m-widget1__number m--font-danger">
										+1,800
									</span>
								</div>
							</div>
						</div>
						<div class="m-widget1__item">
							<div class="row m-row--no-padding align-items-center">
								<div class="col">
									<h3 class="m-widget1__title">
										Issue Reports
									</h3>
									<span class="m-widget1__desc">
										System bugs and issues
									</span>
								</div>
								<div class="col m--align-right">
									<span class="m-widget1__number m--font-success">
										-27,49%
									</span>
								</div>
							</div>
						</div>
					</div>
					<!--end:: Widgets/Stats2-1 -->
				</div>
				<div class="col-md-12 col-lg-12 col-xl-4">
					<!--begin:: Widgets/Stats2-2 -->
					<div class="m-widget1">
						<div class="m-widget1__item">
							<div class="row m-row--no-padding align-items-center">
								<div class="col">
									<h3 class="m-widget1__title">
										IPO Margin
									</h3>
									<span class="m-widget1__desc">
										Awerage IPO Margin
									</span>
								</div>
								<div class="col m--align-right">
									<span class="m-widget1__number m--font-accent">
										+24%
									</span>
								</div>
							</div>
						</div>
						<div class="m-widget1__item">
							<div class="row m-row--no-padding align-items-center">
								<div class="col">
									<h3 class="m-widget1__title">
										Payments
									</h3>
									<span class="m-widget1__desc">
										Yearly Expenses
									</span>
								</div>
								<div class="col m--align-right">
									<span class="m-widget1__number m--font-info">
										+$560,800
									</span>
								</div>
							</div>
						</div>
						<div class="m-widget1__item">
							<div class="row m-row--no-padding align-items-center">
								<div class="col">
									<h3 class="m-widget1__title">
										Logistics
									</h3>
									<span class="m-widget1__desc">
										Overall Regional Logistics
									</span>
								</div>
								<div class="col m--align-right">
									<span class="m-widget1__number m--font-warning">
										-10%
									</span>
								</div>
							</div>
						</div>
					</div>
					<!--begin:: Widgets/Stats2-2 -->
				</div>
				<div class="col-md-12 col-lg-12 col-xl-4">
					<!--begin:: Widgets/Stats2-3 -->
					<div class="m-widget1">
						<div class="m-widget1__item">
							<div class="row m-row--no-padding align-items-center">
								<div class="col">
									<h3 class="m-widget1__title">
										Orders
									</h3>
									<span class="m-widget1__desc">
										Awerage Weekly Orders
									</span>
								</div>
								<div class="col m--align-right">
									<span class="m-widget1__number m--font-success">
										+15%
									</span>
								</div>
							</div>
						</div>
						<div class="m-widget1__item">
							<div class="row m-row--no-padding align-items-center">
								<div class="col">
									<h3 class="m-widget1__title">
										Transactions
									</h3>
									<span class="m-widget1__desc">
										Daily Transaction Increase
									</span>
								</div>
								<div class="col m--align-right">
									<span class="m-widget1__number m--font-danger">
										+80%
									</span>
								</div>
							</div>
						</div>
						<div class="m-widget1__item">
							<div class="row m-row--no-padding align-items-center">
								<div class="col">
									<h3 class="m-widget1__title">
										Revenue
									</h3>
									<span class="m-widget1__desc">
										Overall Revenue Increase
									</span>
								</div>
								<div class="col m--align-right">
									<span class="m-widget1__number m--font-primary">
										+60%
									</span>
								</div>
							</div>
						</div>
					</div>
					<!--begin:: Widgets/Stats2-3 -->
				</div>
			</div>
		</div>
	</div>
    <div class="m-portlet" id="m_portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                        <i class="flaticon-map-location"></i>
                    </span>
                    <h3 class="m-portlet__head-text">
                        Event Calendar
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div id="m_dash_event_calendar"></div>
        </div>
    </div>
@endsection
@section('plugin_script')
<script src="/assets/plugins/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
@endsection
@section('customScript')
<script src="/js/calendar/dashboardCalendar.js" type="text/javascript"></script>
@endsection
