@extends('layouts.adminAppAuth')
@section('title')
@lang('language.login')
@endsection
@section('content')
    <div class="m-login__signin">
        <div class="m-login__head">
            <h3 class="m-login__title">
                @lang('language.sign_to_admin')
            </h3>
        </div>
        <form class="m-login__form m-form" action="{{route('admin.login')}}">
            <div class="form-group m-form__group">
                <input class="form-control m-input" type="text" placeholder="@lang('language.email')" name="email" autocomplete="off">
            </div>
            <div class="form-group m-form__group">
                <input class="form-control m-input m-login__form-input--last" type="password" placeholder="@lang('language.password')" name="password">
            </div>
            <div class="row m-login__form-sub">
                <div class="col m--align-left">
                    <label class="m-checkbox m-checkbox--focus">
                        <input type="checkbox" name="remember">
                        @lang('language.remember_me')
                        <span></span>
                    </label>
                </div>
                <div class="col m--align-right">
                    <a href="{{route('admin.password.request')}}" class="m-link">
                        @lang('language.forget_pass') ?
                    </a>
                </div>
            </div>
            <div class="m-login__form-action">
                <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">
                    @lang('language.sign_in')
                </button>
            </div>
        </form>
    </div>
@endsection
