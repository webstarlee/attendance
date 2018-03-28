@extends('layouts.adminApp')

@section('title')
@lang('language.setting.appearance_setting')
@endsection

@section('pageTitle')
@lang('language.setting.appearance_setting')
@endsection

@section('customStyle')
{{-- <link href="/css/addAdminWizard.css" rel="stylesheet" type="text/css" /> --}}
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						<i class="la la-gear"></i> &nbsp;@lang('language.setting.setting')
					</h3>
				</div>
			</div>
		</div>
        <?php
            $setting_count = \App\Setting::where('id', 1)->count();
            if ($setting_count > 0) {
                $setting = \App\Setting::where('id', 1)->first();
            }
        ?>
        <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator">
			<div class="m-portlet__body">
				<div class="form-group m-form__group row">
					<label class="col-lg-2 col-form-label hr-setting-contents-padding">
						@lang('language.setting.company_name'):
					</label>
					<div class="col-lg-6 hr-setting-contents-padding">
                        <div class="hr-setting-contents-company-name-div">
                            <p id="hr-system-company-name">@if ($setting_count > 0) {{$setting->app_name}} @else Hr @endif</p>
                        </div>
					</div>
                    <div class="col-lg-4 hr-setting-contents-padding">
                        <button type="button" class="btn btn-outline-accent m-btn m-btn--outline m-btn--air" data-toggle="modal" data-target="#company-name__title-change-modal">
                            @lang('language.change')
                        </button>
                    </div>
				</div>
                <div class="m-form__content"></div>
			</div>
		</form>
        <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator">
			<div class="m-portlet__body">
				<div class="form-group m-form__group row">
					<label class="col-lg-2 col-form-label hr-setting-contents-padding">
						@lang('language.setting.logo_img'):
					</label>
					<div class="col-lg-6 hr-setting-contents-padding">
                        <div class="company-logo-container-div">
                            @if ($setting_count > 0)
                                @if (file_exists('uploads/logos/'.$setting->logo_img))
                                    <img src="{{asset('uploads/logos/'.$setting->logo_img)}}" class="m--marginless company-main-logo-img" alt="author">
                                @else
                                    <img src="/assets/images/logo/logo.png" class="m--marginless company-main-logo-img" alt="">
                                @endif
                            @else
                                <img src="/assets/images/logo/logo.png" class="m--marginless company-main-logo-img" alt="">
                            @endif
                        </div>
					</div>
                    <div class="col-lg-4 hr-setting-contents-padding">
                        <button type="button" class="btn btn-outline-accent m-btn m-btn--outline m-btn--air" data-toggle="modal" data-target="#company-logo__pic-change-modal">
                            @lang('language.change')
                        </button>
                    </div>
				</div>
                <div class="m-form__content"></div>
			</div>
		</form>
        <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator">
			<div class="m-portlet__body">
				<div class="form-group m-form__group row">
					<label class="col-lg-2 col-form-label hr-setting-contents-padding">
						@lang('language.setting.fav_img'):
					</label>
					<div class="col-lg-6 hr-setting-contents-padding">
                        <div class="company-fav-container-div">
                            @if ($setting_count > 0)
                                @if (file_exists('uploads/logos/'.$setting->logo_fav))
                                    <img src="{{asset('uploads/logos/'.$setting->logo_fav)}}" class="m--marginless company-fav-logo-img" alt="author">
                                @else
                                    <img src="/assets/images/logo/logo.png" class="m--marginless company-fav-logo-img" alt="">
                                @endif
                            @else
                                <img src="/assets/images/logo/logo.png" class="m--marginless company-fav-logo-img" alt="">
                            @endif
                        </div>
					</div>
                    <div class="col-lg-4 hr-setting-contents-padding">
                        <button type="button" class="btn btn-outline-accent m-btn m-btn--outline m-btn--air" data-toggle="modal" data-target="#company-fav__pic-change-modal">
                            @lang('language.change')
                        </button>
                    </div>
				</div>
                <div class="m-form__content"></div>
			</div>
		</form>
        <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator">
			<div class="m-portlet__body">
				<div class="form-group m-form__group row">
					<label class="col-lg-2 col-form-label hr-setting-contents-padding">
						@lang('language.setting.default_break_time'):
					</label>
					<div class="col-lg-6 hr-setting-contents-padding">
                        <div class="hr-setting-contents-company-name-div">
                            <p id="hr-system-company-break-time-1">{{$setting->time_format($setting->break1_start)}} ~ {{$setting->time_format($setting->break1_end)}}</p>
                            <p id="hr-system-company-break-time-2">{{$setting->time_format($setting->break2_start)}} ~ {{$setting->time_format($setting->break2_end)}}</p>
                        </div>
					</div>
                    <div class="col-lg-4 hr-setting-contents-padding">
                        <button type="button" class="btn btn-outline-accent m-btn m-btn--outline m-btn--air" data-toggle="modal" data-target="#company-break__time-change-modal">
                            @lang('language.change')
                        </button>
                    </div>
				</div>
                <div class="m-form__content"></div>
			</div>
		</form>
        <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator">
			<div class="m-portlet__body">
				<div class="form-group m-form__group row">
					<label class="col-lg-2 col-form-label hr-setting-contents-padding">
						@lang('language.setting.custom_break_time'):
					</label>
					<div class="col-lg-6 hr-setting-contents-padding">
                        <div class="hr-setting-contents-company-name-div">
                            <p id="hr-system-company-break-time-custom">@if ($setting->custom_breaktime == 0) @lang('language.disabled') @else @lang('language.enabled') @endif</p>
                        </div>
					</div>
                    <div class="col-lg-4 hr-setting-contents-padding">
                        <span class="m-switch m-switch--icon m-switch--accent m-switch--lg m-switch--outline">
							<label>
								<input type="checkbox" id="hr-system-company-break-time-custom-switch" @if ($setting->custom_breaktime == 1) checked="checked" @endif name="custom">
								<span></span>
							</label>
						</span>
                    </div>
				</div>
                <div class="m-form__content"></div>
			</div>
		</form>
        <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator">
			<div class="m-portlet__body">
				<div class="form-group m-form__group row">
					<label class="col-lg-2 col-form-label hr-setting-contents-padding">
						@lang('language.setting.vacation_rule'):
					</label>
					<div class="col-lg-6 hr-setting-contents-padding">
                        <div class="hr-setting-contents-company-name-div">
                            <p><span id="hr-system-company-vacation-weeke">{{$setting->vacation_week}}</span> @lang('language.week')</p>
                            <label class="condition-vacation-rule-label">@lang('language.setting.if_work_60days')</label>
                        </div>
					</div>
                    <div class="col-lg-4 hr-setting-contents-padding">
                        <button type="button" class="btn btn-outline-accent m-btn m-btn--outline m-btn--air" data-toggle="modal" data-target="#company-vacation__rule-change-modal">
                            @lang('language.change')
                        </button>
                    </div>
				</div>
                <div class="m-form__content"></div>
			</div>
		</form>
	</div>

    <div class="modal fade m-custom-modal" id="company-logo__pic-change-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						@lang('language.setting.update_company_logo')
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
						<span aria-hidden="true">
							&times;
						</span>
					</button>
				</div>
                <form id="company-logo__pic-change-form" action="{{route('admin.setting.update.logo')}}" role="form" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
    				<div class="modal-body">
	                    <div id="company-logo__pic-slim">
	                        <input type="file" name="slim[]" required/>
	                    </div>
    				</div>
    				<div class="modal-footer">
    					<button type="button" class="btn btn-outline-primary m-btn m-btn--outline m-btn--air" data-dismiss="modal">
    						@lang('language.close')
    					</button>
    					<button type="submit" class="btn btn-outline-accent m-btn m-btn--outline m-btn--air form-submit-btn">
    						@lang('language.update')
    					</button>
    				</div>
                </form>
			</div>
		</div>
	</div>

    <div class="modal fade m-custom-modal" id="company-fav__pic-change-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						@lang('language.setting.update_fav_icon')
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
						<span aria-hidden="true">
							&times;
						</span>
					</button>
				</div>
                <form id="company-fav__pic-change-form" action="{{route('admin.setting.update.fav')}}" role="form" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
    				<div class="modal-body">
	                    <div id="company-fav__pic-slim">
	                        <input type="file" name="slim[]" required/>
	                    </div>
    				</div>
    				<div class="modal-footer">
    					<button type="button" class="btn btn-outline-primary m-btn m-btn--outline m-btn--air" data-dismiss="modal">
    						@lang('language.close')
    					</button>
    					<button type="submit" class="btn btn-outline-accent m-btn m-btn--outline m-btn--air form-submit-btn">
    						@lang('language.update')
    					</button>
    				</div>
                </form>
			</div>
		</div>
	</div>

    <div class="modal fade m-custom-modal" id="company-name__title-change-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						@lang('language.setting.update_company_name')
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
						<span aria-hidden="true">
							&times;
						</span>
					</button>
				</div>
                <form id="company-name__title-change-form" action="{{route('admin.setting.update.name')}}" role="form" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
    				<div class="modal-body">
	                    <div>
	                        <input type="text" class="form-control m-input" name="company_name" placeholder="Enter company name" @if ($setting_count > 0) value="{{$setting->app_name}}" @else value="HR" @endif required/>
	                    </div>
    				</div>
    				<div class="modal-footer">
    					<button type="button" class="btn btn-outline-primary m-btn m-btn--outline m-btn--air" data-dismiss="modal">
    						@lang('language.close')
    					</button>
    					<button type="submit" class="btn btn-outline-accent m-btn m-btn--outline m-btn--air form-submit-btn">
    						@lang('language.update')
    					</button>
    				</div>
                </form>
			</div>
		</div>
	</div>

    <div class="modal fade m-custom-modal" id="company-break__time-change-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						@lang('language.setting.update_com_break_time')
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
						<span aria-hidden="true">
							&times;
						</span>
					</button>
				</div>
                <form id="company-break__time-change-form" action="{{route('admin.setting.update.breaktime')}}" role="form" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
    				<div class="modal-body">
                        <div class="form-group m-form__group smoke-time-container-form">
                            <label for="exampleInputEmail1">
                                @lang('language.setting.break_time') 1:
                            </label>
                            <div class="smoke-time-container">
                                <div class="input-group m-input-group m-input-group--air">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="m-form__content"></div>
                                            <div class="form-group m-form__group">
                                                <label for="exampleInputEmail1">@lang('language.start'):</label>
                                                <div class="input-group m-input-group m-input-group--air">
                                                    <span class="input-group-addon"><i class="la la-clock-o"></i></span>
                                                    <input type="text" class="form-control m-input break-time-picker" name="break_start_1" value="{{$setting->time_format($setting->break1_start)}}" placeholder="Enter time" required="">
                                                </div>
                                            </div>
                                            <div class="m-form__content"></div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="m-form__content"></div>
                                            <div class="form-group m-form__group">
                                                <label for="exampleInputEmail1">@lang('language.end'):</label>
                                                <div class="input-group m-input-group m-input-group--air">
                                                    <span class="input-group-addon"><i class="la la-clock-o"></i></span>
                                                    <input type="text" class="form-control m-input break-time-picker" name="break_end_1" value="{{$setting->time_format($setting->break1_end)}}" placeholder="Enter time" required="">
                                                </div>
                                            </div>
                                            <div class="m-form__content"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-form__group smoke-time-container-form">
                            <label for="exampleInputEmail1">
                                @lang('language.setting.break_time') 2:
                            </label>
                            <div class="smoke-time-container">
                                <div class="input-group m-input-group m-input-group--air">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="m-form__content"></div>
                                            <div class="form-group m-form__group">
                                                <label for="exampleInputEmail1">@lang('language.start'):</label>
                                                <div class="input-group m-input-group m-input-group--air">
                                                    <span class="input-group-addon"><i class="la la-clock-o"></i></span>
                                                    <input type="text" class="form-control m-input break-time-picker" name="break_start_2" value="{{$setting->time_format($setting->break2_start)}}" placeholder="Enter time" required="">
                                                </div>
                                            </div>
                                            <div class="m-form__content"></div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="m-form__content"></div>
                                            <div class="form-group m-form__group">
                                                <label for="exampleInputEmail1">@lang('language.end'):</label>
                                                <div class="input-group m-input-group m-input-group--air">
                                                    <span class="input-group-addon"><i class="la la-clock-o"></i></span>
                                                    <input type="text" class="form-control m-input break-time-picker" name="break_end_2" value="{{$setting->time_format($setting->break2_end)}}" placeholder="Enter time" required="">
                                                </div>
                                            </div>
                                            <div class="m-form__content"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    				</div>
    				<div class="modal-footer">
    					<button type="button" class="btn btn-outline-primary m-btn m-btn--outline m-btn--air" data-dismiss="modal">
    						@lang('language.close')
    					</button>
    					<button type="submit" class="btn btn-outline-accent m-btn m-btn--outline m-btn--air form-submit-btn">
    						@lang('language.update')
    					</button>
    				</div>
                </form>
			</div>
		</div>
    </div>

    <div class="modal fade m-custom-modal" id="company-vacation__rule-change-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						@lang('language.setting.update_com_vacation_rule')
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
						<span aria-hidden="true">
							&times;
						</span>
					</button>
				</div>
                <form id="company-vacation__rule-change-form" action="{{route('admin.setting.update.vacation')}}" role="form" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
    				<div class="modal-body">
                        <div class="form-group m-form__group">
                            <label for="exampleInputEmail1">
                                @lang('language.vacation') @lang('language.week'):
                            </label>
                            <div class="input-group m-input-group m-input-group--air">
                                <select class="form-control m-bootstrap-select m_selectpicker" name="vacation_weeks">
                                    @for ($i=1; $i < 10; $i++)
                                        <option value="{{$i}}" @if ($setting->vacation_week == $i) selected @endif> {{$i}} @lang('language.week') </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
    				</div>
    				<div class="modal-footer">
    					<button type="button" class="btn btn-outline-primary m-btn m-btn--outline m-btn--air" data-dismiss="modal">
    						@lang('language.close')
    					</button>
    					<button type="submit" class="btn btn-outline-accent m-btn m-btn--outline m-btn--air form-submit-btn">
    						@lang('language.update')
    					</button>
    				</div>
                </form>
			</div>
		</div>
    </div>

@endsection
@section('customScript')
    <script type="text/javascript">
        var company_logo_cropper = new Slim(document.getElementById('company-logo__pic-slim'), {
            minSize: {
                width: 10,
                height: 10,
            },
            download: false,
            label: i18n.language.change +" "+ i18n.language.img,
            statusImageTooSmall: i18n.language.profile.image_too_small_slim,
        });

        var company_fav_cropper = new Slim(document.getElementById('company-fav__pic-slim'), {
            minSize: {
                width: 10,
                height: 10,
            },
            download: false,
            label: i18n.language.change +" "+ i18n.language.img,
            statusImageTooSmall: i18n.language.profile.image_too_small_slim,
        });

        $('.m_selectpicker').selectpicker();
    </script>
    <script src="/js/customSetting.js" type="text/javascript"></script>
@endsection
