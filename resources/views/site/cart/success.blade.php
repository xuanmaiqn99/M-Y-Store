@extends('site.layout')
@section('content')
    <section class="content-wrapper">
        <div class="container">
            <div class="std">
                <div class="page-not-found">
                    <h4>{{ __('Cám ơn bạn đã mua hàng, chúng tôi đã gửi đơn hàng chi tiết vào Email của quý khách') }}</h4>
                    <h4>{{ __('Nếu có bất kì thắc mắc vui lòng liên hệ ngay với chúng tôi để được giải đáp') }}</h4>
                    <br>
                    <div>
                        <a href="{{ route('site.home.index') }}" type="button" class="btn-home">
                            <span>{{ __('Back to home') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection