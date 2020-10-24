@extends('site.layout')
@section('content')
    <section class="main-container col1-layout">
        <div class="main container">
        @include('site.message')
        <div class="account-login">
            <div class="page-title">
            <h2>Reset Password</h2>
        </div>
        {!! Form::open(['route' => 'site.customer.handle_reset', 'method' => 'post', 'class' => 'form']) !!}
        <fieldset>
            <div class="registered-users">
            <div class="content">
                <p>{{ __('Vui lòng nhập vào email, chúng tôi sẽ gửi địa chỉ thay đổi mật khẩu vào trong email này  của bạn') }}</p>
                <ul class="form-list">
                    <li>
                        <label for="email">Email Address <span class="required">*</span></label>
                        {!! Form::email('email', old('email'), ['required', 'class' => 'input-text required-entry']) !!}
                    </li>
                </ul>
                <div class="buttons-set">
                    <button id="send2" name="send" type="submit" class="button login">
                        <span>{{ __('Send') }}</span>
                    </button>
                </div>
            </div>
            </div>
        </fieldset>
        {!! Form::close() !!}
        </div>
            <br>
            <br>
            <br>
            <br>
            <br>
        </div>
    </section>
@endsection