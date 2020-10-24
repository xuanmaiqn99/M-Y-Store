@extends('site.layout')
@section('content')
    <section class="main-container col1-layout">
        <div class="main container">
            @include('site.message')
            <div class="account-login">
                <div class="page-title">
                    <h2>{{ __('Thay đổi mật khẩu') }}</h2>
                </div>
                {!! Form::open(['route' => 'password.request', 'method' => 'post', 'class' => 'form']) !!}
                <input type="hidden" name="token" value="{{ $token }}">
                <fieldset>
                    <div class="registered-users">
                        <div class="content">
                            <ul class="form-list">
                                <li>
                                    <label for="email">{{ __('Email') }}<span class="required">*</span></label>
                                    {!! Form::email('email', old('email'), ['required', 'class' => 'input-text required-entry']) !!}
                                </li>
                                <li>
                                    <label for="pass">{{ __('Mật khẩu mới') }} <span class="required">*</span></label>
                                    {!! Form::password('password', ['required', 'class' => 'input-text required-entry']) !!}
                                </li>
                                <li>
                                    <label for="pass">{{ __('Nhập lại mật khẩu')}}<span class="required">*</span></label>
                                    {!! Form::password('password_confirmation', ['required', 'class' => 'input-text required-entry']) !!}
                                </li>
                            </ul>
                            <div class="buttons-set">
                                {{ Form::submit(__('Cập nhật'), ['class' => 'button login']) }}
                            </div>
                        </div>
                    </div>
                </fieldset>
                {!! Form::close() !!}
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        </div>
    </section>
@endsection
