@extends('site.layout')
@section('content')
    <div class="main-container col1-layout">
        <div class="container">
            <div class="row">
                <section class="col-sm-12 col-xs-12">
                    <div class="cart-page-area">
                        <h2>{{ __('Lịch sử đặt hàng của bạn') }}</h2>
                        @if (count($history) > 0)
                            <h4>{{ __('Danh sách đơn đặt hàng của bạn') }}</h4>
                            <div class="table-responsive">
                                <table class="shop-cart-table data-cart">
                                    <thead>
                                    <tr>
                                        <th class="product-thumbnail ">{{ __('Mã đơn hàng') }}</th>
                                        <th class="product-product">{{ __('Phương thức thanh toán') }}</th>
                                        <th class="product-price" style="width: 100px">{{ __('Đơn giá') }}</th>
                                        <th class="product-subtotal" style="width: 140px">{{ __('Ngày tạo') }}</th>
                                        <th class="product-quantity">{{ __('Trạng thái') }}</th>
                                        <th class="product-remove">{{ __('Chi tiết') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($history as $row)
                                        <tr class="cart_item">
                                            <td class="item-title">
                                                {{ $row->id }}
                                            </td>
                                            <td class="item-title">
                                                {{ $row->payment }}
                                            </td>
                                            <td class="item-price"> 
                                                {{ number_format($row->amount, null, null, ",") }} đ
                                            </td>
                                            <td class="item-qty">{{ $row->created_at }}</td>
                                            <td class="item-qty">
                                                {{ $row->status }}
                                            </td>
                                            <td class="remove-item">
                                                <a  class="view-detail" value="{{ $row->id }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <section class="content-wrapper">
                                <div class="container">
                                    <div class="std">
                                        <div class="page-not-found">
                                            <h4>{{ __('Bạn chưa có đơn đặt đơn hàng nào') }}</h4>
                                            <br>
                                            <div>
                                                <a href="{{ route('site.home.index') }}" type="button" class="btn-home">
                                                    <span>{{ __('Tiếp tục mua hàng') }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </div>
    <br>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('source/site/version4/js/add-view-detail.js') }}">
    </script>
@endsection