<!DOCTYPE html>
<html lang="en" >
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<?php
			$setting_count = \App\Setting::where('id', 1)->count();
			if ($setting_count > 0) {
				$setting = \App\Setting::where('id', 1)->first();
			}
		?>
		<title>@if ($setting_count > 0 ) {{$setting->app_name}} @else HR @endif | @yield('title')</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
		<!--begin::Web font -->
		<script src="/assets/plugins/webfont.js"></script>
		<script>
          WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
		</script>
		<!--end::Web font -->
        <!--begin::Base Styles -->
        <link href="/assets/plugins/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
		<link href="/assets/plugins/baseApp/style.bundle.css" rel="stylesheet" type="text/css" />
		@yield('plugin_style')
        <link href="/css/loader.css" rel="stylesheet" type="text/css" />
		<link href="/assets/plugins/slim/slim.min.css" rel="stylesheet" type="text/css" />
		<link href="/css/customGlobal.css" rel="stylesheet" type="text/css" />
		<!--end::Base Styles -->
		{{-- begine::custom style --}}
		@yield('customStyle')
		{{-- end::custom style --}}
		@if ($setting_count > 0)
			@if (file_exists('uploads/logos/'.$setting->logo_fav))
				<link rel="shortcut icon" href="{{asset('uploads/logos/'.$setting->logo_fav)}}" />
			@else
				<link rel="shortcut icon" href="/assets/images/logo/logo_compact.png" />
			@endif
		@else
			<link rel="shortcut icon" href="/assets/images/logo/logo_compact.png" />
		@endif
	</head>
    <!-- end::Head -->
    <!-- begin::Body -->
	<body class="m-page--wide m-header--fixed m-header--fixed-mobile m-footer--push m-aside--offcanvas-default"  >
        {{-- start loading --}}
        <div class="loader-container circle-pulse-multiple">
            <div class="loaders">
                <div id="loading-center-absolute">
                    <div class="object" id="object_four"></div>
                    <div class="object" id="object_three"></div>
                    <div class="object" id="object_two"></div>
                    <div class="object" id="object_one"></div>
                </div>
            </div>
        </div>
		{{-- end loading --}}
        <!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<!-- begin::Header -->
			<header class="m-grid__item	m-header" data-minimize="minimize" data-minimize-offset="200" data-minimize-mobile-offset="200" >
				<div class="m-header__top">
					<div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
						<div class="m-stack m-stack--ver m-stack--desktop">
							<!-- begin::Brand -->
							<div class="m-stack__item m-brand">
								<div class="m-stack m-stack--ver m-stack--general m-stack--inline">
									<div class="m-stack__item m-stack__item--middle m-brand__logo">
										<a href="{{route('admin.dashboard')}}" class="m-brand__logo-wrapper">
											@if ($setting_count > 0)
				                                @if (file_exists('uploads/logos/'.$setting->logo_img))
				                                    <img src="{{asset('uploads/logos/'.$setting->logo_img)}}" class="company-main-logo-img" alt="author">
				                                @else
				                                    <img alt="" src="/assets/images/logo/logo.png" class="company-main-logo-img" />
				                                @endif
				                            @else
												<img alt="" src="/assets/images/logo/logo.png" class="company-main-logo-img" />
				                            @endif
										</a>
									</div>
									<div class="m-stack__item m-stack__item--middle m-brand__tools">
										<!-- begin::Responsive Header Menu Toggler-->
										<a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
											<span></span>
										</a>
										<!-- end::Responsive Header Menu Toggler-->
										<!-- begin::Topbar Toggler-->
										<a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
											<i class="flaticon-more"></i>
										</a>
										<!--end::Topbar Toggler-->
									</div>
								</div>
							</div>
							<!-- end::Brand -->
							<!-- begin::Topbar -->
							<div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
								<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
									<div class="m-stack__item m-topbar__nav-wrapper">
										<ul class="m-topbar__nav m-nav m-nav--inline">
											<li class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-center 	m-dropdown--mobile-full-width" data-dropdown-toggle="click" data-dropdown-persistent="true">
												<a href="javascript:;" class="m-nav__link m-dropdown__toggle" id="">
													<span class="m-nav__link-badge m-badge m-badge--dot m-badge--dot-small m-badge--danger"></span>
													<span class="m-nav__link-icon">
														<span class="m-nav__link-icon-wrapper">
															<i class="flaticon-music-2"></i>
														</span>
													</span>
												</a>
												<div class="m-dropdown__wrapper">
													<span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
													<div class="m-dropdown__inner">
														<div class="m-dropdown__header m--align-center" style="background: url(/assets/images/notification_bg.jpg); background-size: cover;">
															<span class="m-dropdown__header-title">
																9 New
															</span>
															<span class="m-dropdown__header-subtitle">
																User Notifications
															</span>
														</div>
														<div class="m-dropdown__body">
															<div class="m-dropdown__content">
																<ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
																	<li class="nav-item m-tabs__item">
																		<a class="nav-link m-tabs__link active" data-toggle="tab" href="#topbar_notifications_notifications" role="tab">
																			Alerts
																		</a>
																	</li>
																	<li class="nav-item m-tabs__item">
																		<a class="nav-link m-tabs__link" data-toggle="tab" href="#topbar_notifications_events" role="tab">
																			Events
																		</a>
																	</li>
																	<li class="nav-item m-tabs__item">
																		<a class="nav-link m-tabs__link" data-toggle="tab" href="#topbar_notifications_logs" role="tab">
																			Logs
																		</a>
																	</li>
																</ul>
																<div class="tab-content">
																	<div class="tab-pane active" id="topbar_notifications_notifications" role="tabpanel">
																		<div class="m-scrollable" data-scrollable="true" data-max-height="250" data-mobile-max-height="200">
																			<div class="m-list-timeline m-list-timeline--skin-light">
																				<div class="m-list-timeline__items">
																					<div class="m-list-timeline__item">
																						<span class="m-list-timeline__badge -m-list-timeline__badge--state-success"></span>
																						<span class="m-list-timeline__text">
																							12 new users registered
																						</span>
																						<span class="m-list-timeline__time">
																							Just now
																						</span>
																					</div>
																					<div class="m-list-timeline__item">
																						<span class="m-list-timeline__badge"></span>
																						<span class="m-list-timeline__text">
																							System shutdown
																							<span class="m-badge m-badge--success m-badge--wide">
																								pending
																							</span>
																						</span>
																						<span class="m-list-timeline__time">
																							14 mins
																						</span>
																					</div>
																					<div class="m-list-timeline__item">
																						<span class="m-list-timeline__badge"></span>
																						<span class="m-list-timeline__text">
																							New invoice received
																						</span>
																						<span class="m-list-timeline__time">
																							20 mins
																						</span>
																					</div>
																					<div class="m-list-timeline__item">
																						<span class="m-list-timeline__badge"></span>
																						<span class="m-list-timeline__text">
																							DB overloaded 80%
																							<span class="m-badge m-badge--info m-badge--wide">
																								settled
																							</span>
																						</span>
																						<span class="m-list-timeline__time">
																							1 hr
																						</span>
																					</div>
																					<div class="m-list-timeline__item">
																						<span class="m-list-timeline__badge"></span>
																						<span class="m-list-timeline__text">
																							System error -
																							<a href="#" class="m-link">
																								Check
																							</a>
																						</span>
																						<span class="m-list-timeline__time">
																							2 hrs
																						</span>
																					</div>
																					<div class="m-list-timeline__item m-list-timeline__item--read">
																						<span class="m-list-timeline__badge"></span>
																						<span href="" class="m-list-timeline__text">
																							New order received
																							<span class="m-badge m-badge--danger m-badge--wide">
																								urgent
																							</span>
																						</span>
																						<span class="m-list-timeline__time">
																							7 hrs
																						</span>
																					</div>
																					<div class="m-list-timeline__item m-list-timeline__item--read">
																						<span class="m-list-timeline__badge"></span>
																						<span class="m-list-timeline__text">
																							Production server down
																						</span>
																						<span class="m-list-timeline__time">
																							3 hrs
																						</span>
																					</div>
																					<div class="m-list-timeline__item">
																						<span class="m-list-timeline__badge"></span>
																						<span class="m-list-timeline__text">
																							Production server up
																						</span>
																						<span class="m-list-timeline__time">
																							5 hrs
																						</span>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="tab-pane" id="topbar_notifications_events" role="tabpanel">
																		<div class="m-scrollable" m-scrollabledata-scrollable="true" data-max-height="250" data-mobile-max-height="200">
																			<div class="m-list-timeline m-list-timeline--skin-light">
																				<div class="m-list-timeline__items">
																					<div class="m-list-timeline__item">
																						<span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
																						<a href="" class="m-list-timeline__text">
																							New order received
																						</a>
																						<span class="m-list-timeline__time">
																							Just now
																						</span>
																					</div>
																					<div class="m-list-timeline__item">
																						<span class="m-list-timeline__badge m-list-timeline__badge--state1-danger"></span>
																						<a href="" class="m-list-timeline__text">
																							New invoice received
																						</a>
																						<span class="m-list-timeline__time">
																							20 mins
																						</span>
																					</div>
																					<div class="m-list-timeline__item">
																						<span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
																						<a href="" class="m-list-timeline__text">
																							Production server up
																						</a>
																						<span class="m-list-timeline__time">
																							5 hrs
																						</span>
																					</div>
																					<div class="m-list-timeline__item">
																						<span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
																						<a href="" class="m-list-timeline__text">
																							New order received
																						</a>
																						<span class="m-list-timeline__time">
																							7 hrs
																						</span>
																					</div>
																					<div class="m-list-timeline__item">
																						<span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
																						<a href="" class="m-list-timeline__text">
																							System shutdown
																						</a>
																						<span class="m-list-timeline__time">
																							11 mins
																						</span>
																					</div>
																					<div class="m-list-timeline__item">
																						<span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
																						<a href="" class="m-list-timeline__text">
																							Production server down
																						</a>
																						<span class="m-list-timeline__time">
																							3 hrs
																						</span>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="tab-pane" id="topbar_notifications_logs" role="tabpanel">
																		<div class="m-stack m-stack--ver m-stack--general" style="min-height: 180px;">
																			<div class="m-stack__item m-stack__item--center m-stack__item--middle">
																				<span class="">
																					All caught up!
																					<br>
																					No new logs.
																				</span>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</li>
											<li class="m-nav__item m-topbar__quick-actions m-topbar__quick-actions--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push m-dropdown--mobile-full-width m-dropdown--skin-light"  data-dropdown-toggle="click">
												<a href="#" class="m-nav__link m-dropdown__toggle">
													<span class="m-nav__link-badge m-badge m-badge--dot m-badge--info m--hide"></span>
													<span class="m-nav__link-icon">
														<span class="m-nav__link-icon-wrapper">
															<i class="flaticon-share"></i>
														</span>
													</span>
												</a>
												<div class="m-dropdown__wrapper">
													<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
													<div class="m-dropdown__inner">
														<div class="m-dropdown__header m--align-center" style="background: url(/assets/images/quick_actions_bg.jpg); background-size: cover;">
															<span class="m-dropdown__header-title">
																Quick Actions
															</span>
															<span class="m-dropdown__header-subtitle">
																Shortcuts
															</span>
														</div>
														<div class="m-dropdown__body m-dropdown__body--paddingless">
															<div class="m-dropdown__content">
																<div class="m-scrollable" data-scrollable="false" data-max-height="380" data-mobile-max-height="200">
																	<div class="m-nav-grid m-nav-grid--skin-light">
																		<div class="m-nav-grid__row">
																			<a href="#" class="m-nav-grid__item">
																				<i class="m-nav-grid__icon flaticon-file"></i>
																				<span class="m-nav-grid__text">
																					Generate Report
																				</span>
																			</a>
																			<a href="#" class="m-nav-grid__item">
																				<i class="m-nav-grid__icon flaticon-time"></i>
																				<span class="m-nav-grid__text">
																					Add New Event
																				</span>
																			</a>
																		</div>
																		<div class="m-nav-grid__row">
																			<a href="#" class="m-nav-grid__item">
																				<i class="m-nav-grid__icon flaticon-folder"></i>
																				<span class="m-nav-grid__text">
																					Create New Task
																				</span>
																			</a>
																			<a href="#" class="m-nav-grid__item">
																				<i class="m-nav-grid__icon flaticon-clipboard"></i>
																				<span class="m-nav-grid__text">
																					Completed Tasks
																				</span>
																			</a>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</li>
											<li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" data-dropdown-toggle="click">
												<a href="#" class="m-nav__link m-dropdown__toggle">
													{{-- <span class="m-topbar__welcome">
														Hello,&nbsp;
													</span> --}}
													<span class="m-topbar__username">
														{{Auth::guard('admin')->user()->username}}
														&nbsp;
													</span>
													<span class="m-topbar__userpic">
														@if(Auth::guard('admin')->user()->avatar == "default.jpg")
															<img src="/uploads/avatars/default.png" class="m--img-rounded m--marginless m--img-centered m-{{Auth::guard('admin')->user()->unique_id}}-profile-avatar" alt=""/>
														@else
															@if (file_exists('uploads/avatars/'.Auth::guard('admin')->user()->unique_id.'/'.Auth::guard('admin')->user()->avatar))
																<img src="{{asset('uploads/avatars/'.Auth::guard('admin')->user()->unique_id.'/'.Auth::guard('admin')->user()->avatar)}}" class="m--img-rounded m--marginless m--img-centered m-{{Auth::guard('admin')->user()->unique_id}}-profile-avatar" alt="author">
															@else
																<img src="/uploads/avatars/default.png" class="m--img-rounded m--marginless m--img-centered m-{{Auth::guard('admin')->user()->unique_id}}-profile-avatar" alt="">
															@endif
														@endif
													</span>
												</a>
												<div class="m-dropdown__wrapper m-masked-dropdown">
													<div class="m-dropdown__inner">
														<?php
							                                $coverimg_url = "";
							                                if (Auth::guard('admin')->user()->cover == "default.jpg") {
							                                    $coverimg_url = "/uploads/covers/default.jpg";
							                                } else {
							                                    if (file_exists('uploads/covers/'.Auth::guard('admin')->user()->unique_id.'/'.Auth::guard('admin')->user()->cover)) {
							                                        $coverimg_url = '/uploads/covers/'.Auth::guard('admin')->user()->unique_id.'/'.Auth::guard('admin')->user()->cover;
							                                    } else {
							                                        $coverimg_url = "/uploads/covers/default.jpg";
							                                    }
							                                }
							                            ?>
														<div class="m-dropdown__header m--align-center m-{{Auth::guard('admin')->user()->unique_id}}-profile-cover" style="background: url({{$coverimg_url}}); background-size: cover;background-repeat: no-repeat;background-position: center;">
															<div class="m-card-user m-card-user--skin-dark">
																<div class="m-card-user__pic">
																	@if(Auth::guard('admin')->user()->avatar == "default.jpg")
																		<img src="/uploads/avatars/default.png" class="m--img-rounded m--marginless m-{{Auth::guard('admin')->user()->unique_id}}-profile-avatar" alt=""/>
																	@else
																		@if (file_exists('uploads/avatars/'.Auth::guard('admin')->user()->unique_id.'/'.Auth::guard('admin')->user()->avatar))
																			<img src="{{asset('uploads/avatars/'.Auth::guard('admin')->user()->unique_id.'/'.Auth::guard('admin')->user()->avatar)}}" class="m--img-rounded m--marginless m-{{Auth::guard('admin')->user()->unique_id}}-profile-avatar" alt="author">
																		@else
																			<img src="/uploads/avatars/default.png" class="m--img-rounded m--marginless m-{{Auth::guard('admin')->user()->unique_id}}-profile-avatar" alt="">
																		@endif
																	@endif
																</div>
																<div class="m-card-user__details">
																	<span class="m-card-user__name m--font-weight-500">
																		{{Auth::guard('admin')->user()->first_name}} {{Auth::guard('admin')->user()->last_name}}
																	</span>
																	<a href="" class="m-card-user__email m--font-weight-300 m-link">
																		{{Auth::guard('admin')->user()->email}}
																	</a>
																</div>
															</div>
														</div>
														<div class="m-dropdown__body">
															<div class="m-dropdown__content">
																<ul class="m-nav m-nav--skin-light">
																	<li class="m-nav__section m--hide">
																		<span class="m-nav__section-text">
																			Section
																		</span>
																	</li>
																	<li class="m-nav__item">
																		<a href="{{url('admin/profile/admin/'.Auth::guard('admin')->user()->unique_id)}}" class="m-nav__link">
																			<i class="m-nav__link-icon flaticon-profile-1"></i>
																			<span class="m-nav__link-title">
																				<span class="m-nav__link-wrap">
																					<span class="m-nav__link-text">
																						My Profile
																					</span>
																					<span class="m-nav__link-badge">
																						<span class="m-badge m-badge--success">
																							2
																						</span>
																					</span>
																				</span>
																			</span>
																		</a>
																	</li>
																	<li class="m-nav__item">
																		<a href="profile.html" class="m-nav__link">
																			<i class="m-nav__link-icon flaticon-share"></i>
																			<span class="m-nav__link-text">
																				Activity
																			</span>
																		</a>
																	</li>
																	<li class="m-nav__item">
																		<a href="profile.html" class="m-nav__link">
																			<i class="m-nav__link-icon flaticon-chat-1"></i>
																			<span class="m-nav__link-text">
																				Messages
																			</span>
																		</a>
																	</li>
																	<li class="m-nav__separator m-nav__separator--fit"></li>
																		<a href="{{route('admin.logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
																			Logout
																		</a>
                                                                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                                                            @csrf
                                                                        </form>
																	</li>
																</ul>
															</div>
														</div>
													</div>
												</div>
											</li>
											<li id="m_quick_sidebar_toggle" class="m-nav__item">
												<a href="javascript:;" class="m-nav__link m-dropdown__toggle">
													<span class="m-nav__link-icon m-nav__link-icon--aside-toggle">
														<span class="m-nav__link-icon-wrapper">
															<i class="flaticon-menu-button"></i>
														</span>
													</span>
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<!-- end::Topbar -->
						</div>
					</div>
				</div>
				<div class="m-header__bottom">
					<div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
						<div class="m-stack m-stack--ver m-stack--desktop">
							<!-- begin::Horizontal Menu -->
							<div class="m-stack__item m-stack__item--middle m-stack__item--fluid">
								<button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-light " id="m_aside_header_menu_mobile_close_btn">
									<i class="la la-close"></i>
								</button>
								<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-dark m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-light m-aside-header-menu-mobile--submenu-skin-light "  >
									<ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
										<li class="m-menu__item @if(Route::currentRouteName()=='admin.dashboard') m-menu__item--active @endif"  aria-haspopup="true">
											<a  href="{{route('admin.dashboard')}}" class="m-menu__link ">
												<span class="m-menu__item-here"></span>
												<span class="m-menu__link-text">
													Dashboard
												</span>
											</a>
										</li>
										<li class="@if(Route::currentRouteName()=='admin.manage.admins' || Route::currentRouteName()=='admin.manage.employee' || Route::currentRouteName()=='admin.manage.holiday' || Route::currentRouteName()=='admin.manage.attendance' || Route::currentRouteName()=='admin.manage.attendance.single') m-menu__item--active @endif m-menu__item  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="click" aria-haspopup="true">
											<a  href="javascript:;" class="m-menu__link m-menu__toggle">
												<span class="m-menu__item-here"></span>
												<span class="m-menu__link-text">
													Employee
												</span>
												<i class="m-menu__hor-arrow la la-angle-down"></i>
												<i class="m-menu__ver-arrow la la-angle-right"></i>
											</a>
											<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
												<span class="m-menu__arrow m-menu__arrow--adjust"></span>
												<ul class="m-menu__subnav">
													<li class="m-menu__item" aria-haspopup="true">
														<a  href="{{route('admin.manage.employee')}}" class="m-menu__link ">
															<i class="m-menu__link-icon la la-users"></i>
															<span class="m-menu__link-title">
																<span class="m-menu__link-wrap">
																	<span class="m-menu__link-text">
																		All Employees
																	</span>
																</span>
															</span>
														</a>
													</li>
													<li class="m-menu__item" aria-haspopup="true">
														<a  href="{{route('admin.manage.attendance')}}" class="m-menu__link ">
															<i class="m-menu__link-icon la la-fire"></i>
															<span class="m-menu__link-title">
																<span class="m-menu__link-wrap">
																	<span class="m-menu__link-text">
																		Attendance
																	</span>
																</span>
															</span>
														</a>
													</li>
													<li class="m-menu__item" aria-haspopup="true">
														<a  href="{{route('admin.manage.holiday')}}" class="m-menu__link ">
															<i class="m-menu__link-icon flaticon-tea-cup"></i>
															<span class="m-menu__link-title">
																<span class="m-menu__link-wrap">
																	<span class="m-menu__link-text">
																		Holidays
																	</span>
																</span>
															</span>
														</a>
													</li>
												</ul>
											</div>
										</li>
										<li class="@if(Route::currentRouteName()=='admin.setting.appearance' || Route::currentRouteName()=='admin.manage.contract') m-menu__item--active @endif m-menu__item  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="click" aria-haspopup="true">
											<a  href="javascript:;" class="m-menu__link m-menu__toggle">
												<span class="m-menu__item-here"></span>
												<span class="m-menu__link-text">
													Setting
												</span>
												<i class="m-menu__hor-arrow la la-angle-down"></i>
												<i class="m-menu__ver-arrow la la-angle-right"></i>
											</a>
											<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
												<span class="m-menu__arrow m-menu__arrow--adjust"></span>
												<ul class="m-menu__subnav">
													<li class="m-menu__item "  aria-haspopup="true">
														<a  href="{{route('admin.setting.appearance')}}" class="m-menu__link ">
															<i class="m-menu__link-icon flaticon-confetti"></i>
															<span class="m-menu__link-title">
																<span class="m-menu__link-wrap">
																	<span class="m-menu__link-text">
																		Appearance
																	</span>
																</span>
															</span>
														</a>
													</li>
													<li class="m-menu__item "  aria-haspopup="true">
														<a  href="{{route('admin.manage.contract')}}" class="m-menu__link ">
															<i class="m-menu__link-icon flaticon-tool-1"></i>
															<span class="m-menu__link-title">
																<span class="m-menu__link-wrap">
																	<span class="m-menu__link-text">
																		Contract Type
																	</span>
																</span>
															</span>
														</a>
													</li>
												</ul>
											</div>
										</li>
										<li class="m-menu__item  m-menu__item--submenu"  data-menu-submenu-toggle="click" data-redirect="true" aria-haspopup="true">
											<a  href="#" class="m-menu__link m-menu__toggle">
												<span class="m-menu__item-here"></span>
												<span class="m-menu__link-text">
													Orders
												</span>
												<i class="m-menu__hor-arrow la la-angle-down"></i>
												<i class="m-menu__ver-arrow la la-angle-right"></i>
											</a>
											<div class="m-menu__submenu  m-menu__submenu--fixed-xl m-menu__submenu--center" >
												<span class="m-menu__arrow m-menu__arrow--adjust"></span>
												<div class="m-menu__subnav">
													<ul class="m-menu__content">
														<li class="m-menu__item">
															<h3 class="m-menu__heading m-menu__toggle">
																<span class="m-menu__link-text">
																	Finance Reports
																</span>
																<i class="m-menu__ver-arrow la la-angle-right"></i>
															</h3>
															<ul class="m-menu__inner">
																<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
																	<a  href="inner.html" class="m-menu__link ">
																		<i class="m-menu__link-icon flaticon-map"></i>
																		<span class="m-menu__link-text">
																			Annual Reports
																		</span>
																	</a>
																</li>
																<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
																	<a  href="inner.html" class="m-menu__link ">
																		<i class="m-menu__link-icon flaticon-user"></i>
																		<span class="m-menu__link-text">
																			HR Reports
																		</span>
																	</a>
																</li>
															</ul>
														</li>
														<li class="m-menu__item">
															<h3 class="m-menu__heading m-menu__toggle">
																<span class="m-menu__link-text">
																	Project Reports
																</span>
																<i class="m-menu__ver-arrow la la-angle-right"></i>
															</h3>
															<ul class="m-menu__inner">
																<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
																	<a  href="inner.html" class="m-menu__link ">
																		<i class="m-menu__link-bullet m-menu__link-bullet--line">
																			<span></span>
																		</i>
																		<span class="m-menu__link-text">
																			Coca Cola CRM
																		</span>
																	</a>
																</li>
																<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
																	<a  href="inner.html" class="m-menu__link ">
																		<i class="m-menu__link-bullet m-menu__link-bullet--line">
																			<span></span>
																		</i>
																		<span class="m-menu__link-text">
																			Delta Airlines Booking Site
																		</span>
																	</a>
																</li>
															</ul>
														</li>
														<li class="m-menu__item">
															<h3 class="m-menu__heading m-menu__toggle">
																<span class="m-menu__link-text">
																	HR Reports
																</span>
																<i class="m-menu__ver-arrow la la-angle-right"></i>
															</h3>
															<ul class="m-menu__inner">
																<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
																	<a  href="inner.html" class="m-menu__link ">
																		<i class="m-menu__link-bullet m-menu__link-bullet--dot">
																			<span></span>
																		</i>
																		<span class="m-menu__link-text">
																			Staff Directory
																		</span>
																	</a>
																</li>
																<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
																	<a  href="inner.html" class="m-menu__link ">
																		<i class="m-menu__link-bullet m-menu__link-bullet--dot">
																			<span></span>
																		</i>
																		<span class="m-menu__link-text">
																			Client Directory
																		</span>
																	</a>
																</li>
															</ul>
														</li>
														<li class="m-menu__item">
															<h3 class="m-menu__heading m-menu__toggle">
																<span class="m-menu__link-text">
																	Reporting Apps
																</span>
																<i class="m-menu__ver-arrow la la-angle-right"></i>
															</h3>
															<ul class="m-menu__inner">
																<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
																	<a  href="inner.html" class="m-menu__link ">
																		<span class="m-menu__link-text">
																			Report Adjusments
																		</span>
																	</a>
																</li>
																<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
																	<a  href="inner.html" class="m-menu__link ">
																		<span class="m-menu__link-text">
																			Sources & Mediums
																		</span>
																	</a>
																</li>
															</ul>
														</li>
													</ul>
												</div>
											</div>
										</li>
										<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel m-menu__item--more m-menu__item--icon-only"  data-menu-submenu-toggle="click" data-redirect="true" aria-haspopup="true">
											<a  href="#" class="m-menu__link m-menu__toggle">
												<span class="m-menu__item-here"></span>
												<i class="m-menu__link-icon flaticon-more-v3"></i>
												<span class="m-menu__link-text"></span>
											</a>
											<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left m-menu__submenu--pull">
												<span class="m-menu__arrow m-menu__arrow--adjust"></span>
												<ul class="m-menu__subnav">
													<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
														<a  href="inner.html" class="m-menu__link ">
															<i class="m-menu__link-icon flaticon-business"></i>
															<span class="m-menu__link-text">
																eCommerce
															</span>
														</a>
													</li>
													<li class="m-menu__item  m-menu__item--submenu"  data-menu-submenu-toggle="hover" data-redirect="true" aria-haspopup="true">
														<a  href="crud/datatable_v1.html" class="m-menu__link m-menu__toggle">
															<i class="m-menu__link-icon flaticon-computer"></i>
															<span class="m-menu__link-text">
																Audience
															</span>
															<i class="m-menu__hor-arrow la la-angle-right"></i>
															<i class="m-menu__ver-arrow la la-angle-right"></i>
														</a>
														<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
															<span class="m-menu__arrow "></span>
															<ul class="m-menu__subnav">
																<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
																	<a  href="inner.html" class="m-menu__link ">
																		<i class="m-menu__link-icon flaticon-users"></i>
																		<span class="m-menu__link-text">
																			Active Users
																		</span>
																	</a>
																</li>
																<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
																	<a  href="inner.html" class="m-menu__link ">
																		<i class="m-menu__link-icon flaticon-interface-1"></i>
																		<span class="m-menu__link-text">
																			User Explorer
																		</span>
																	</a>
																</li>
																<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
																	<a  href="inner.html" class="m-menu__link ">
																		<i class="m-menu__link-icon flaticon-lifebuoy"></i>
																		<span class="m-menu__link-text">
																			Users Flows
																		</span>
																	</a>
																</li>
																<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
																	<a  href="inner.html" class="m-menu__link ">
																		<i class="m-menu__link-icon flaticon-graphic-1"></i>
																		<span class="m-menu__link-text">
																			Market Segments
																		</span>
																	</a>
																</li>
																<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
																	<a  href="inner.html" class="m-menu__link ">
																		<i class="m-menu__link-icon flaticon-graphic"></i>
																		<span class="m-menu__link-text">
																			User Reports
																		</span>
																	</a>
																</li>
															</ul>
														</div>
													</li>
													<li class="m-menu__item  m-menu__item--submenu"  data-menu-submenu-toggle="hover" data-redirect="true" aria-haspopup="true">
														<a  href="#" class="m-menu__link m-menu__toggle">
															<i class="m-menu__link-icon flaticon-infinity"></i>
															<span class="m-menu__link-text">
																Cloud Manager
															</span>
															<i class="m-menu__hor-arrow la la-angle-right"></i>
															<i class="m-menu__ver-arrow la la-angle-right"></i>
														</a>
														<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
															<span class="m-menu__arrow "></span>
															<ul class="m-menu__subnav">
																<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
																	<a  href="inner.html" class="m-menu__link ">
																		<i class="m-menu__link-icon flaticon-add"></i>
																		<span class="m-menu__link-title">
																			<span class="m-menu__link-wrap">
																				<span class="m-menu__link-text">
																					File Upload
																				</span>
																				<span class="m-menu__link-badge">
																					<span class="m-badge m-badge--danger">
																						3
																					</span>
																				</span>
																			</span>
																		</span>
																	</a>
																</li>
																<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
																	<a  href="inner.html" class="m-menu__link ">
																		<i class="m-menu__link-icon flaticon-signs-1"></i>
																		<span class="m-menu__link-text">
																			File Attributes
																		</span>
																	</a>
																</li>
																<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
																	<a  href="inner.html" class="m-menu__link ">
																		<i class="m-menu__link-icon flaticon-folder"></i>
																		<span class="m-menu__link-text">
																			Folders
																		</span>
																	</a>
																</li>
																<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
																	<a  href="inner.html" class="m-menu__link ">
																		<i class="m-menu__link-icon flaticon-cogwheel-2"></i>
																		<span class="m-menu__link-text">
																			System Settings
																		</span>
																	</a>
																</li>
															</ul>
														</div>
													</li>
												</ul>
											</div>
										</li>
									</ul>
								</div>
							</div>
							<!-- end::Horizontal Menu -->
							<!--begin::Search-->
							<div class="m-stack__item m-stack__item--middle m-dropdown m-dropdown--arrow m-dropdown--large m-dropdown--mobile-full-width m-dropdown--align-right m-dropdown--skin-light m-header-search m-header-search--expandable m-header-search--skin-" id="m_quicksearch" data-search-type="default">
								<!--begin::Search Form -->
								<form class="m-header-search__form">
									<div class="m-header-search__wrapper">
										<span class="m-header-search__icon-search" id="m_quicksearch_search">
											<i class="la la-search"></i>
										</span>
										<span class="m-header-search__input-wrapper">
											<input autocomplete="off" type="text" name="q" class="m-header-search__input" value="" placeholder="Search..." id="m_quicksearch_input">
										</span>
										<span class="m-header-search__icon-close" id="m_quicksearch_close">
											<i class="la la-remove"></i>
										</span>
										<span class="m-header-search__icon-cancel" id="m_quicksearch_cancel">
											<i class="la la-remove"></i>
										</span>
									</div>
								</form>
								<!--end::Search Form -->
								<!--begin::Search Results -->
								<div class="m-dropdown__wrapper">
									<div class="m-dropdown__arrow m-dropdown__arrow--center"></div>
									<div class="m-dropdown__inner">
										<div class="m-dropdown__body">
											<div class="m-dropdown__scrollable m-scrollable" data-scrollable="true" data-max-height="300" data-mobile-max-height="200">
												<div class="m-dropdown__content m-list-search m-list-search--skin-light"></div>
											</div>
										</div>
									</div>
								</div>
								<!--end::Search Results -->
							</div>
							<!--end::Search-->
						</div>
					</div>
				</div>
			</header>
			<!-- end::Header -->
            <!-- begin::Body -->
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor-desktop m-grid--desktop m-body">
				<div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver	m-container m-container--responsive m-container--xxl m-page__container">
					<div class="m-grid__item m-grid__item--fluid m-wrapper">
						<!-- BEGIN: Subheader -->
						<div class="m-subheader ">
							<div class="d-flex align-items-center">
								<div class="mr-auto">
									<h3 class="m-subheader__title ">
										@yield('pageTitle')
									</h3>
								</div>
							</div>
						</div>
						<!-- END: Subheader -->
						<div class="m-content">
							<!--Begin::Section-->
							@yield('content')
							<!--End::Section-->
						</div>
                    </div>
                </div>
            </div>
            <!-- end::Body -->
            <!-- begin::Footer -->
			<footer class="m-grid__item m-footer ">
				<div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
					<div class="m-footer__wrapper">
						<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
							<div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
								<span class="m-footer__copyright">
									2017 &copy; Metronic theme by
									<a href="#" class="m-link">
										Keenthemes
									</a>
								</span>
							</div>
							<div class="m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--first">
								<ul class="m-footer__nav m-nav m-nav--inline m--pull-right">
									<li class="m-nav__item">
										<a href="#" class="m-nav__link">
											<span class="m-nav__link-text">
												About
											</span>
										</a>
									</li>
									<li class="m-nav__item">
										<a href="#"  class="m-nav__link">
											<span class="m-nav__link-text">
												Privacy
											</span>
										</a>
									</li>
									<li class="m-nav__item m-nav__item--last">
										<a href="#" class="m-nav__link" data-toggle="m-tooltip" title="Support Center" data-placement="left">
											<i class="m-nav__link-icon flaticon-info m--icon-font-size-lg3"></i>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</footer>
			<!-- end::Footer -->
        </div>
        <!-- end:: Page -->
        <!-- begin::Quick Sidebar -->
		<div id="m_quick_sidebar" class="m-quick-sidebar m-quick-sidebar--tabbed m-quick-sidebar--skin-light">
			<div class="m-quick-sidebar__content m--hide">
				<span id="m_quick_sidebar_close" class="m-quick-sidebar__close">
					<i class="la la-close"></i>
				</span>
				<ul id="m_quick_sidebar_tabs" class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
					<li class="nav-item m-tabs__item">
						<a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_quick_sidebar_tabs_settings" role="tab">
							Settings
						</a>
					</li>
					<li class="nav-item m-tabs__item">
						<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_quick_sidebar_tabs_logs" role="tab">
							Logs
						</a>
					</li>
				</ul>
                <div class="tab-content">
					<div class="tab-pane active m-scrollable" id="m_quick_sidebar_tabs_settings" role="tabpanel">
						<div class="m-list-settings">
							<div class="m-list-settings__group">
								<div class="m-list-settings__heading">
									General Settings
								</div>
								<div class="m-list-settings__item">
									<span class="m-list-settings__item-label">
										Email Notifications
									</span>
									<span class="m-list-settings__item-control">
										<span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
											<label>
												<input type="checkbox" checked="checked" name="">
												<span></span>
											</label>
										</span>
									</span>
								</div>
								<div class="m-list-settings__item">
									<span class="m-list-settings__item-label">
										Site Tracking
									</span>
									<span class="m-list-settings__item-control">
										<span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
											<label>
												<input type="checkbox" name="">
												<span></span>
											</label>
										</span>
									</span>
								</div>
								<div class="m-list-settings__item">
									<span class="m-list-settings__item-label">
										SMS Alerts
									</span>
									<span class="m-list-settings__item-control">
										<span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
											<label>
												<input type="checkbox" name="">
												<span></span>
											</label>
										</span>
									</span>
								</div>
								<div class="m-list-settings__item">
									<span class="m-list-settings__item-label">
										Backup Storage
									</span>
									<span class="m-list-settings__item-control">
										<span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
											<label>
												<input type="checkbox" name="">
												<span></span>
											</label>
										</span>
									</span>
								</div>
								<div class="m-list-settings__item">
									<span class="m-list-settings__item-label">
										Audit Logs
									</span>
									<span class="m-list-settings__item-control">
										<span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
											<label>
												<input type="checkbox" checked="checked" name="">
												<span></span>
											</label>
										</span>
									</span>
								</div>
							</div>
							<div class="m-list-settings__group">
								<div class="m-list-settings__heading">
									System Settings
								</div>
								<div class="m-list-settings__item">
									<span class="m-list-settings__item-label">
										System Logs
									</span>
									<span class="m-list-settings__item-control">
										<span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
											<label>
												<input type="checkbox" name="">
												<span></span>
											</label>
										</span>
									</span>
								</div>
								<div class="m-list-settings__item">
									<span class="m-list-settings__item-label">
										Error Reporting
									</span>
									<span class="m-list-settings__item-control">
										<span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
											<label>
												<input type="checkbox" name="">
												<span></span>
											</label>
										</span>
									</span>
								</div>
								<div class="m-list-settings__item">
									<span class="m-list-settings__item-label">
										Applications Logs
									</span>
									<span class="m-list-settings__item-control">
										<span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
											<label>
												<input type="checkbox" name="">
												<span></span>
											</label>
										</span>
									</span>
								</div>
								<div class="m-list-settings__item">
									<span class="m-list-settings__item-label">
										Backup Servers
									</span>
									<span class="m-list-settings__item-control">
										<span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
											<label>
												<input type="checkbox" checked="checked" name="">
												<span></span>
											</label>
										</span>
									</span>
								</div>
								<div class="m-list-settings__item">
									<span class="m-list-settings__item-label">
										Audit Logs
									</span>
									<span class="m-list-settings__item-control">
										<span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
											<label>
												<input type="checkbox" name="">
												<span></span>
											</label>
										</span>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane  m-scrollable" id="m_quick_sidebar_tabs_logs" role="tabpanel">
						<div class="m-list-timeline">
							<div class="m-list-timeline__group">
								<div class="m-list-timeline__heading">
									System Logs
								</div>
								<div class="m-list-timeline__items">
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
										<a href="" class="m-list-timeline__text">
											12 new users registered
											<span class="m-badge m-badge--warning m-badge--wide">
												important
											</span>
										</a>
										<span class="m-list-timeline__time">
											Just now
										</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
										<a href="" class="m-list-timeline__text">
											System shutdown
										</a>
										<span class="m-list-timeline__time">
											11 mins
										</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-danger"></span>
										<a href="" class="m-list-timeline__text">
											New invoice received
										</a>
										<span class="m-list-timeline__time">
											20 mins
										</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-warning"></span>
										<a href="" class="m-list-timeline__text">
											Database overloaded 89%
											<span class="m-badge m-badge--success m-badge--wide">
												resolved
											</span>
										</a>
										<span class="m-list-timeline__time">
											1 hr
										</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
										<a href="" class="m-list-timeline__text">
											System error
										</a>
										<span class="m-list-timeline__time">
											2 hrs
										</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
										<a href="" class="m-list-timeline__text">
											Production server down
											<span class="m-badge m-badge--danger m-badge--wide">
												pending
											</span>
										</a>
										<span class="m-list-timeline__time">
											3 hrs
										</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
										<a href="" class="m-list-timeline__text">
											Production server up
										</a>
										<span class="m-list-timeline__time">
											5 hrs
										</span>
									</div>
								</div>
							</div>
							<div class="m-list-timeline__group">
								<div class="m-list-timeline__heading">
									Applications Logs
								</div>
								<div class="m-list-timeline__items">
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
										<a href="" class="m-list-timeline__text">
											New order received
											<span class="m-badge m-badge--info m-badge--wide">
												urgent
											</span>
										</a>
										<span class="m-list-timeline__time">
											7 hrs
										</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
										<a href="" class="m-list-timeline__text">
											12 new users registered
										</a>
										<span class="m-list-timeline__time">
											Just now
										</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
										<a href="" class="m-list-timeline__text">
											System shutdown
										</a>
										<span class="m-list-timeline__time">
											11 mins
										</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-danger"></span>
										<a href="" class="m-list-timeline__text">
											New invoices received
										</a>
										<span class="m-list-timeline__time">
											20 mins
										</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-warning"></span>
										<a href="" class="m-list-timeline__text">
											Database overloaded 89%
										</a>
										<span class="m-list-timeline__time">
											1 hr
										</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
										<a href="" class="m-list-timeline__text">
											System error
											<span class="m-badge m-badge--info m-badge--wide">
												pending
											</span>
										</a>
										<span class="m-list-timeline__time">
											2 hrs
										</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
										<a href="" class="m-list-timeline__text">
											Production server down
										</a>
										<span class="m-list-timeline__time">
											3 hrs
										</span>
									</div>
								</div>
							</div>
							<div class="m-list-timeline__group">
								<div class="m-list-timeline__heading">
									Server Logs
								</div>
								<div class="m-list-timeline__items">
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
										<a href="" class="m-list-timeline__text">
											Production server up
										</a>
										<span class="m-list-timeline__time">
											5 hrs
										</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
										<a href="" class="m-list-timeline__text">
											New order received
										</a>
										<span class="m-list-timeline__time">
											7 hrs
										</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
										<a href="" class="m-list-timeline__text">
											12 new users registered
										</a>
										<span class="m-list-timeline__time">
											Just now
										</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
										<a href="" class="m-list-timeline__text">
											System shutdown
										</a>
										<span class="m-list-timeline__time">
											11 mins
										</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-danger"></span>
										<a href="" class="m-list-timeline__text">
											New invoice received
										</a>
										<span class="m-list-timeline__time">
											20 mins
										</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-warning"></span>
										<a href="" class="m-list-timeline__text">
											Database overloaded 89%
										</a>
										<span class="m-list-timeline__time">
											1 hr
										</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
										<a href="" class="m-list-timeline__text">
											System error
										</a>
										<span class="m-list-timeline__time">
											2 hrs
										</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
										<a href="" class="m-list-timeline__text">
											Production server down
										</a>
										<span class="m-list-timeline__time">
											3 hrs
										</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
										<a href="" class="m-list-timeline__text">
											Production server up
										</a>
										<span class="m-list-timeline__time">
											5 hrs
										</span>
									</div>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
										<a href="" class="m-list-timeline__text">
											New order received
										</a>
										<span class="m-list-timeline__time">
											1117 hrs
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end::Quick Sidebar -->
        <!-- begin::Scroll Top -->
		<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
			<i class="la la-arrow-up"></i>
		</div>
		<!-- end::Scroll Top -->
        <!--begin::Base Scripts -->
		<script src="/assets/plugins/base/vendors.bundle.js" type="text/javascript"></script>
		<script src="/assets/plugins/baseApp/scripts.bundle.js" type="text/javascript"></script>
		@yield('plugin_script')
		<script src="/assets/plugins/slim/slim.kickstart.min.js" type="text/javascript"></script>
		<script src="/js/customGlobal.js" type="text/javascript"></script>
		<!--end::Base Scripts -->
		@yield('customScript')
        <script>
			window.onload = function () {
				setTimeout(function () {
					$('.loader-container').fadeOut('slow'); // will first fade out the loading animation
					$('.loader').delay(150).fadeOut('slow'); // will fade out the white DIV that covers the website.
					$('body').delay(150).css({'overflow':'visible'});
				}, 500);
			}
		</script>
    </body>
</html>
