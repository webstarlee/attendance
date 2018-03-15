@extends('layouts.adminApp')

@section('title')
Manage Contract type
@endsection

@section('pageTitle')
Contract type Management
@endsection

@section('plugin_style')
<link href="/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						<i class="la la-gear"></i> &nbsp;Contract type Management
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
						<a href="#m-admin-new_contract-type-modal" data-toggle="modal" class="btn btn-outline-accent m-btn m-btn--custom m-btn--icon m-btn--air">
							<span>
								<i class="la la-plus"></i>
								<span>
									New Contract Type
								</span>
							</span>
						</a>
						<div class="m-separator m-separator--dashed d-xl-none"></div>
					</div>
				</div>
			</div>
			<!--end: Search Form -->
            <!--begin: Datatable -->
			<div class="m_contract_datatable"></div>
			<!--end: Datatable -->
		</div>
	</div>

    <div class="modal fade m-custom-modal" id="m-admin-new_contract-type-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						Add New Contract Type
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
						<span aria-hidden="true">
							&times;
						</span>
					</button>
				</div>
                <form id="m-admin-new_contract-type-form" action="{{route('admin.manage.contract.store')}}" role="form" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
    				<div class="modal-body">
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="contract_title">
                                        Title (required):
                                    </label>
                                    <div class="input-group m-input-group m-input-group--air">
                                        <span class="input-group-addon">
                                            <i class="la la-comment-o"></i>
                                        </span>
                                        <input type="text" class="form-control m-input" id="contract_title" name="contract_title" placeholder="Enter contract title (required)" aria-describedby="basic-addon1" required>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
									<label for="contract_description">
										Description (optional)
									</label>
									<textarea class="form-control m-input" name="contract_description" id="contract_description" placeholder="Enter contract description (optional)" rows="5"></textarea>
								</div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputEmail1">
                                        Color:
                                    </label>
                                    <div class="input-group m-input-group m-input-group--air colorpicker-input">
                                        <input type="text" class="form-control m-input" id="contract_color" name="contract_color" placeholder="Enter Attendance date" required value="#000">
                                        <span class="input-group-addon">
                                            <i></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
    				</div>
    				<div class="modal-footer">
    					<button type="button" class="btn btn-outline-primary m-btn m-btn--custom m-btn--air" data-dismiss="modal">
    						Close
    					</button>
    					<button type="submit" class="btn btn-outline-accent m-btn m-btn--custom m-btn--air form-submit-btn">
    						Submit
    					</button>
    				</div>
                </form>
			</div>
		</div>
	</div>

    <div class="modal fade m-custom-modal" id="m-admin-edit_contract-type-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel1">
						Edit Contract Type
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
						<span aria-hidden="true">
							&times;
						</span>
					</button>
				</div>
                <form id="m-admin-edit_contract-type-form" action="{{route('admin.manage.contract.update')}}" role="form" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" id="contract_id_for_edit" name="contract_id_for_edit" value="">
    				<div class="modal-body">
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="contract_title">
                                        Title (required):
                                    </label>
                                    <div class="input-group m-input-group m-input-group--air">
                                        <span class="input-group-addon">
                                            <i class="la la-comment-o"></i>
                                        </span>
                                        <input type="text" class="form-control m-input" id="_contract_title" name="_contract_title" placeholder="Enter contract title (required)" aria-describedby="basic-addon1" required>
                                    </div>
                                </div>
                                <div class="m-form__content"></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
									<label for="_contract_description">
										Description (optional)
									</label>
									<textarea class="form-control m-input" name="_contract_description" id="_contract_description" placeholder="Enter contract description (optional)" rows="5"></textarea>
								</div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="m-form__content"></div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputEmail1">
                                        Color:
                                    </label>
                                    <div class="input-group m-input-group m-input-group--air colorpicker-input">
                                        <input type="text" class="form-control m-input" id="_contract_color" name="_contract_color" placeholder="Enter Attendance date" required>
                                        <span class="input-group-addon">
                                            <i></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
    				</div>
    				<div class="modal-footer">
    					<button type="button" class="btn btn-outline-primary m-btn m-btn--custom m-btn--air" data-dismiss="modal">
    						Close
    					</button>
    					<button type="submit" class="btn btn-outline-accent m-btn m-btn--custom m-btn--air form-submit-btn">
    						Update
    					</button>
    				</div>
                </form>
			</div>
		</div>
	</div>
@endsection
@section('plugin_script')
<script src="/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js" type="text/javascript"></script>
@endsection
@section('customScript')
    <script type="text/javascript">
    $(document).ready(function(){
        setJsplugin();
    });

    function setJsplugin() {
        $('.colorpicker-input').each(function(){
            $(this).colorpicker({
                format: 'rgba'
            });
        })
    }
    </script>
    <script src="/js/datatable/loadContractData.js" type="text/javascript"></script>
    <script src="/js/customManage.js" type="text/javascript"></script>
@endsection
