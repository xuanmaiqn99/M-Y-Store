@extends('admin.layout')
@section('content')
    <div class="titleArea">
        <div class="wrapper">
            <div class="pageTitle">
                <h5>{{ __('Đơn đặt hàng') }}</h5>
                <span>{{ __('Quản lý đơn đặt hàng') }}</span>
            </div>
            <div class="horControlB menu_action">
                <ul>
                    <li>
                        <a href="{{ route('order.index') }}">
                            <img src="{{ asset('source/backend/admin/images/icons/control/16/list.png') }}" />
                            <span>{{ __('Danh sách') }}</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('order.export_to_excel') }}">
                            <img src="{{ asset('source/backend/admin/images/excel.png') }}" />
                            <span class="export">{{ __('Xuất file excel') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="line"></div>
    <!-- Message -->
    <!-- Main content wrapper -->
    <div class="wrapper" id="main_product">
        <div class="widget">
            <div class="title">
                <span class="titleIcon"><input type="checkbox" id="titleCheck" name="titleCheck" /></span>
                <h6>
                    {{ __('Danh sách đơn đặt hàng') }}
                </h6>
                <div class="num f12">{{ trans('common.title.sl') }} <b id="total">{{ count($order) }}</b></div>
            </div>
            @if (isset($order) && count($order) > 0)
                    <div class="clear mt15"></div>
                    <table cellpadding="10px" cellspacing="10px" style="margin-left: 10px;" width="100%">
                        <tbody>
                        <tr>
                            <td class="label" style="width:80px;"><label for="filter_type">{{ __('phương thức') }}</label></td>
                            <td class="item">
                                <select colum="4" class="menu" name="payment">
                                    <option value=""></option>
                                    <option value='Tiền mặt' >{{ __('Tiền mặt') }}</option>
                                    <option value='Chuyển khoản' >{{ __('Chuyển khoản') }}</option>
                                </select>
                            </td>
                            <td class="label"><label for="filter_status">{{ __('Trạng thái') }}</label></td>
                            <td class="item">
                                <select colum="6" class="menu" name="status">
                                    <option></option>
                                    <option value='Đang chờ'>{{ __('Đang chờ') }}</option>
                                    <option value='Thành công'>{{ __('Thành công') }}</option>
                                    <option value='Hủy bỏ'>{{ __('Hủy bỏ') }}</option>
                                </select>
                            </td>
                            <td class="label" style="width:60px;">
                                <label for="filter_created">{{ __('Từ ngày') }}</label>
                            </td>
                            <td class="item">
                                <input name="created" value="" id="filter_created" type="date" class="datepicker1" />
                            </td> 
                            <td class="label">
                                <label for="filter_created_to">{{ __('Đến ngày') }}</label>
                            </td>
                            <td class="item">
                                <input name="created_to" value="" id="filter_created_to" type="date" class="datepicker1" />
                            </td>
                            <td class="label"></td>
                            <td class="item"></td>
                        </tr>
                    </tbody>
                </table>
               
                <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable" id="checkAll">
                    <thead>
                    <tr>
                        <td><img src="{{ asset('source/backend/admin/images/icons/tableArrows.png') }}" /></td>
                        <td>{{ __('Mã số') }}</td>
                        <td>{{ __('Tên khách hàng') }}</td>
                        <td>{{ __('Số điện thoại') }}</td>
                        <td>{{ __('Phương thức thanh toán') }}</td>
                        <td>{{ __('Đơn giá') }}</td>
                        <td>{{ __('Trạng thái') }}</td>
                        <td>{{ __('Ngày tạo') }}</td>
                        <td>{{ __('Hành động') }}</td>
                    </tr>
                    </thead>
                    <tbody class="list_item">
                    @foreach ($order as $row)
                        <tr class='row_{{ $row->id }}'>
                            @if ($row->status == "Đang chờ") 
                                <td>{!! Form::checkbox('id[]', $row->id, false, ['class' => 'check-del']) !!}</td>
                            @else
                                <td></td>
                            @endif
                            <td class="textC">{{ $row->id }}</td>
                            <td class="textC">{{ $row->user->name }}</td>
                            <td class="textC">{{ $row->user->phone }}</td>
                            <td class="textC">{{ $row->payment }}</td>
                            <td class="textR red">{{ number_format($row->amount) }} đ</td>
                            @if ($row->status == "Thành công") 
                                <td class="status textC">
                                    <span class="completed">
                                        {{ __('Thành công') }}
                                    </span>
                                </td>
                            @elseif ($row->status == "Đang chờ")
                                <td class="status textC">
                                    <span class="pending">
                                        {{ __('Đang chờ') }}
                                    </span>
                                </td>
                            @else
                                <td class="status textC">
                                    <span class="reject">
                                        {{ __('Hủy bỏ') }}
                                    </span>
                                </td>
                            @endif
                            <td class="textC">{{ $row->created_at }}</td>
                            <td class="textC">
                                <a href="{{ route('order.detail', ['id' => $row->id]) }}" title="xem chi tiết đơn hàng" class="tipS">
                                    <img src="{{ asset('source/backend/admin/images/icons/color/view.png') }}" />
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="list_action itemActions">
                    <a href="{{ route('order.delete')}}" id="delMul" class="button blueB order-del">
                        <span>{{ __('Xóa') }}</span>
                    </a>
                </div>
            @else
                <h5 class="eror">{{ __('Không có đơn đặt hàng nào') }}</h5>
            @endif
        </div>
    </div>
    <div class="clear mt30"></div>
@endsection
