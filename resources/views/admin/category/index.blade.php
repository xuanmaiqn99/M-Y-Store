@extends('admin.layout')
@section('content')
    @include('admin.category.head')
    <!-- Message -->
    <!-- Main content wrapper -->
    <div class="wrapper" id="main_product">
        <div class="widget">
            <div class="title">
                <span class="titleIcon"><input type="checkbox" id="titleCheck" name="titleCheck" /></span>
                <h6>
                    {{ __('Danh sách danh mục') }}
                </h6>
                <div class="num f12">{{ trans('common.title.sl') }} <b id="total">{{count($category)}}</b></div>
            </div>
            @if(isset($category) && count($category)>0)
                <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable" id="checkAll">
                    <thead>
                    <tr>
                        <td><img src="{{ asset('source/backend/admin/images/icons/tableArrows.png') }}" /></td>
                        <td>{{ __('Mã số') }}</td>
                        <td>{{ __('Tên danh mục') }}</td>
                        <td>{{ __('Danh mục cha') }}</td>
                        <td>{{ __('Hành động') }}</td>
                    </tr>
                    </thead>
                    <tbody class="list_item">
                    @foreach ($category as $row)
                        <tr class='row_{{ $row->id }}'>
                            <td>{!! Form::checkbox('id[]', $row->id, false, ['class' => 'check-del']) !!}</td>
                            <td class="textC">{{ $row->id }}</td>
                            <td class="textC">{{ $row->name }}</td>
                            <td class="textC">{{ $row->parent_id }}</td>
                            <td class="option textC">
                                <a href="{{ route('category.edit', ['id' => $row->id]) }}" title="Chỉnh sửa" class="tipS">
                                    <img src="{{ asset('source/backend/admin/images/icons/color/edit.png') }}" />
                                </a>
                                <a href="{{ route('category.delete') }}" value="{{ $row->id }}" title="Xóa" class="tipS delete category" check="{{ route('category.checkChild') }}">
                                    <img src="{{ asset('source/backend/admin/images/icons/color/delete.png') }}" />
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="list_action itemActions">
                    <a href="{{ route('comment.delMulCom')}}" id="delMul" class="button blueB">
                        <span>{{ __('Xóa') }}</span>
                    </a>
                </div>
            @else
                <h5 class="eror">{{ __('Không có danh mục nào') }}</h5>
            @endif
        </div>
    </div>
    <div class="clear mt30"></div>
@endsection
