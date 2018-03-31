@extends('layouts.adminApp')

@section('title')
@lang('language.event.event') @lang('language.management')
@endsection

@section('pageTitle')
@lang('language.event.event') @lang('language.management')
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
                        @lang('language.event.event') @lang('language.management')
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="#m-admin-new_event-modal" data-toggle="modal" class="btn btn-outline-accent m-btn m-btn--custom m-btn--icon m-btn--air">
                            <span>
                                <i class="la la-plus"></i>
                                <span>
                                    @lang('language.new') @lang('language.event.event')
                                </span>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <div id="m_holiday_calendar"></div>
        </div>
    </div>

    <div class="modal fade m-custom-modal" id="m-admin-new_event-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel1">
						@lang('language.event.add_new_event')
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
						<span aria-hidden="true">
							&times;
						</span>
					</button>
				</div>
                <form id="m-admin-new_event-form" action="{{route('admin.manage.event.store')}}" role="form" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
    				<div class="modal-body">
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="event_date">
                                        @lang('language.date')*
                                    </label>
                                    <input type="text" class="form-control m-input input-date-picker" id="event_date" name="event_date" placeholder="@lang('language.date')" required>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-6">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="event_start_time">
                                        @lang('language.start'):
                                    </label>
                                    <div class="input-group m-input-group m-input-group--air">
                                        <span class="input-group-addon">
                                            <i class="la la-clock-o"></i>
                                        </span>
                                        <input type="text" class="form-control m-input input-time-picker" id="event_start_time" name="event_start_time" value="8:00 Am" required>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                            <div class="col-sm-6">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="event_end_time">
                                        @lang('language.end'):
                                    </label>
                                    <div class="input-group m-input-group m-input-group--air">
                                        <span class="input-group-addon">
                                            <i class="la la-clock-o"></i>
                                        </span>
                                        <input type="text" class="form-control m-input input-time-picker" id="event_end_time" name="event_end_time" value="4:00 Pm" required>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="event_title">
                                        @lang('language.title')*
                                    </label>
                                    <input type="text" class="form-control m-input" id="event_title" name="event_title" placeholder="@lang('language.event.event') @lang('language.title')" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
									<label for="event_note">
										@lang('language.description')
									</label>
									<textarea class="form-control m-input" name="event_note" id="event_note" placeholder="@lang('language.description')" rows="5"></textarea>
								</div>
                            </div>
                        </div>
    				</div>
    				<div class="modal-footer">
    					<button type="button" class="btn m-btn--air btn-outline-primary" data-dismiss="modal">
    						@lang('language.close')
    					</button>
    					<button type="submit" class="btn m-btn--air btn-outline-accent form-submit-btn">
    						@lang('language.submit')
    					</button>
    				</div>
                </form>
			</div>
		</div>
    </div>

    <div class="modal fade m-custom-modal" id="m-admin-edit_event-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						@lang('language.edit') @lang('language.event.event')
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
						<span aria-hidden="true">
							&times;
						</span>
					</button>
				</div>
                <form id="m-admin-edit_event-form" action="{{route('admin.manage.event.update')}}" role="form" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="event_id_for_edit" id="event_id_for_edit" value="">
    				<div class="modal-body">
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="_event_date">
                                        @lang('language.date')*
                                    </label>
                                    <input type="text" class="form-control m-input input-date-picker" id="_event_date" name="_event_date" placeholder="@lang('language.date')" required>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-6">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="_event_start_time">
                                        @lang('language.start'):
                                    </label>
                                    <div class="input-group m-input-group m-input-group--air">
                                        <span class="input-group-addon">
                                            <i class="la la-clock-o"></i>
                                        </span>
                                        <input type="text" class="form-control m-input input-time-picker" id="_event_start_time" name="_event_start_time" value="8:00 Am" required>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                            <div class="col-sm-6">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="_event_end_time">
                                        @lang('language.end'):
                                    </label>
                                    <div class="input-group m-input-group m-input-group--air">
                                        <span class="input-group-addon">
                                            <i class="la la-clock-o"></i>
                                        </span>
                                        <input type="text" class="form-control m-input input-time-picker" id="_event_end_time" name="_event_end_time" value="4:00 Pm" required>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="_event_title">
                                        @lang('language.title')*
                                    </label>
                                    <input type="text" class="form-control m-input" id="_event_title" name="_event_title" placeholder="@lang('language.event.event') @lang('language.title')" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
									<label for="_event_note">
										@lang('language.description')
									</label>
									<textarea class="form-control m-input" name="_event_note" id="_event_note" placeholder="@lang('language.description')" rows="5"></textarea>
								</div>
                            </div>
                        </div>
    				</div>
    				<div class="modal-footer">
                        <button type="button" class="btn m-btn--air btn-outline-primary" data-dismiss="modal">
    						@lang('language.close')
    					</button>
                        <button type="button" class="btn m-btn--air btn-outline-danger" id="event_delete_btn">
    						@lang('language.delete')
    					</button>
    					<button type="submit" class="btn m-btn--air btn-outline-accent form-submit-btn">
    						@lang('language.submit')
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
    <script src="/js/calendar/eventCalendar.js" type="text/javascript"></script>
@endsection
