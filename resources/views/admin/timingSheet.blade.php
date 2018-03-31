@extends('layouts.adminApp')

@section('title')
@lang('language.project.timing_sheet')
@endsection

@section('pageTitle')
@lang('language.project.timing_sheet')
@endsection

@section('content')
    <?php
        $admins = \App\Admin::where('role', '!=', '3')->get();
        $users = \App\User::all();
    ?>
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						<i class="la la-gear"></i> &nbsp;@lang('language.project.timing_sheet')
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true">
							<a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
								<i class="la la-ellipsis-h m--font-brand"></i>
							</a>
							<div class="m-dropdown__wrapper">
								<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
								<div class="m-dropdown__inner">
									<div class="m-dropdown__body">
										<div class="m-dropdown__content">
											<ul class="m-nav">
												<li class="m-nav__section m-nav__section--first">
													<span class="m-nav__section-text">
														Quick Actions
													</span>
												</li>
												<li class="m-nav__item">
													<a href="" class="m-nav__link">
														<i class="m-nav__link-icon flaticon-share"></i>
														<span class="m-nav__link-text">
															Create Post
														</span>
													</a>
												</li>
												<li class="m-nav__item">
													<a href="" class="m-nav__link">
														<i class="m-nav__link-icon flaticon-chat-1"></i>
														<span class="m-nav__link-text">
															Send Messages
														</span>
													</a>
												</li>
												<li class="m-nav__item">
													<a href="" class="m-nav__link">
														<i class="m-nav__link-icon flaticon-multimedia-2"></i>
														<span class="m-nav__link-text">
															Upload File
														</span>
													</a>
												</li>
												<li class="m-nav__section">
													<span class="m-nav__section-text">
														Useful Links
													</span>
												</li>
												<li class="m-nav__item">
													<a href="" class="m-nav__link">
														<i class="m-nav__link-icon flaticon-info"></i>
														<span class="m-nav__link-text">
															FAQ
														</span>
													</a>
												</li>
												<li class="m-nav__item">
													<a href="" class="m-nav__link">
														<i class="m-nav__link-icon flaticon-lifebuoy"></i>
														<span class="m-nav__link-text">
															Support
														</span>
													</a>
												</li>
												<li class="m-nav__separator m-nav__separator--fit m--hide"></li>
												<li class="m-nav__item m--hide">
													<a href="#" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">
														Submit
													</a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</li>
				</ul>
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
					<div class="col-xl-4 order-1 order-xl-2 m--align-right">
						<a href="#m-admin-new_sheet-modal" data-toggle="modal" class="btn btn-outline-accent m-btn m-btn--custom m-btn--icon m-btn--air">
							<span>
								<i class="la la-plus"></i>
								<span>
									@lang('language.new') @lang('language.sheet')
								</span>
							</span>
						</a>
						<div class="m-separator m-separator--dashed d-xl-none"></div>
					</div>
				</div>
			</div>
			<!--end: Search Form -->
            <!--begin: Datatable -->
			<div id="m_sheet_datatable"></div>
			<!--end: Datatable -->
		</div>
    </div>

    <div class="modal fade m-custom-modal" id="m-admin-new_sheet-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						@lang('language.project.add_new_task')
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
						<span aria-hidden="true">
							&times;
						</span>
					</button>
				</div>
                <form id="m-admin-new_sheet-form" class="m-form" action="{{route('admin.manage.project.sheet.store')}}" role="form" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
    				<div class="modal-body">
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="sheet_project">
                                        @lang('language.project.project')
                                    </label>
                                    <select class="form-control m-bootstrap-select m_selectpicker" id="sheet_project" name='sheet_project' data-live-search="true" required>
                                        @foreach ($projects as $project)
                                            <option value="{{$project->id}}">{{$project->pro_name}}</option>
                                        @endforeach
									</select>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="sheet_member">
                                        @lang('language.employee')
                                    </label>
                                    <select class="form-control m-bootstrap-select m_selectpicker" id="sheet_member" name='sheet_member' data-live-search="true" required>
                                        @foreach ($users as $user)
                                            <option value="{{$user->unique_id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                        @endforeach
									</select>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="sheet_date">
                                        @lang('language.date')
                                    </label>
                                    <div class="input-group m-input-group m-input-group--air">
                                        <span class="input-group-addon">
                                            <i class="la la-calendar"></i>
                                        </span>
                                        <input type="text" class="form-control m-input m-datepciker" id="sheet_date" name="sheet_date" placeholder="@lang('language.date')" aria-describedby="basic-addon1" required>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="sheet_time">
                                        @lang('language.time')
                                    </label>
                                    <div class="input-group m-input-group m-input-group--air">
                                        <span class="input-group-addon">
                                            <i class="la la-clock-o"></i>
                                        </span>
                                        <input type="text" class="form-control m-input m-input-mask-int" id="sheet_time" name="sheet_time" placeholder="@lang('language.time')" aria-describedby="basic-addon1" required>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
									<label for="sheet_note">
										@lang('language.note'):
									</label>
									<textarea class="form-control m-input" id="sheet_note" name="sheet_note" placeholder="@lang('language.note')" rows="3"></textarea>
								</div>
                            </div>
                        </div>
    				</div>
    				<div class="modal-footer">
    					<button type="button" class="btn btn-outline-primary m-btn m-btn--custom m-btn--air" data-dismiss="modal">
    						@lang('language.close')
    					</button>
    					<button type="submit" class="btn btn-outline-accent m-btn m-btn--custom m-btn--air form-submit-btn">
    						@lang('language.submit')
    					</button>
    				</div>
                </form>
			</div>
		</div>
    </div>

    <div class="modal fade m-custom-modal" id="m-admin-edit_sheet-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel1">
						@lang('language.edit') @lang('language.project.project')
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
						<span aria-hidden="true">
							&times;
						</span>
					</button>
				</div>
                <form id="m-admin-edit_sheet-form" class="m-form" action="{{route('admin.manage.project.sheet.update')}}" role="form" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" id="sheet_id_for_edit" name="sheet_id_for_edit" value="">
    				<div class="modal-body">
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="_sheet_project">
                                        @lang('language.project.project')
                                    </label>
                                    <select class="form-control m-bootstrap-select m_selectpicker" id="_sheet_project" name='_sheet_project' data-live-search="true" required>
                                        @foreach ($projects as $project)
                                            <option value="{{$project->id}}">{{$project->pro_name}}</option>
                                        @endforeach
									</select>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="_sheet_member">
                                        @lang('language.employee')
                                    </label>
                                    <select class="form-control m-bootstrap-select m_selectpicker" id="_sheet_member" name='_sheet_member' data-live-search="true" required>
                                        @foreach ($users as $user)
                                            <option value="{{$user->unique_id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                        @endforeach
									</select>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="_sheet_date">
                                        @lang('language.date')
                                    </label>
                                    <div class="input-group m-input-group m-input-group--air">
                                        <span class="input-group-addon">
                                            <i class="la la-calendar"></i>
                                        </span>
                                        <input type="text" class="form-control m-input m-datepciker" id="_sheet_date" name="_sheet_date" placeholder="@lang('language.date')" aria-describedby="basic-addon1" required>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="_sheet_time">
                                        @lang('language.time')
                                    </label>
                                    <div class="input-group m-input-group m-input-group--air">
                                        <span class="input-group-addon">
                                            <i class="la la-clock-o"></i>
                                        </span>
                                        <input type="text" class="form-control m-input m-input-mask-int" id="_sheet_time" name="_sheet_time" placeholder="@lang('language.time')" aria-describedby="basic-addon1" required>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
									<label for="_sheet_note">
										@lang('language.note'):
									</label>
									<textarea class="form-control m-input" id="_sheet_note" name="_sheet_note" placeholder="@lang('language.note')" rows="3"></textarea>
								</div>
                            </div>
                        </div>
    				</div>
    				<div class="modal-footer">
    					<button type="button" class="btn btn-outline-primary m-btn m-btn--custom m-btn--air" data-dismiss="modal">
    						@lang('language.close')
    					</button>
    					<button type="submit" class="btn btn-outline-accent m-btn m-btn--custom m-btn--air form-submit-btn">
    						@lang('language.submit')
    					</button>
    				</div>
                </form>
			</div>
		</div>
    </div>
@endsection
@section('customScript')
    <script src="/js/datatable/loadSheetData.js" type="text/javascript"></script>
@endsection
