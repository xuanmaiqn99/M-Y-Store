<div class="topNav">
    <div class="wrapper">
        <div class="userNav">
            <ul>
                <li class="dd"><a title=""><img src="{{ asset('source/backend/admin/images/icons/topnav/messages.png') }}" alt=""><span>{{ __('Thông báo') }}</span><span class="numberTop">{{ $total_not or 0 }}</span></a>
                    <ul class="userDropdown">
                        <div class="result">
                        @foreach($notification as $row)
                            <li>
                                @if($row->read_at == null)
                                    <a id="{{ __('new_') }}{{ $row->id }}" href="{{ route('notif.view', ['id' => $row->id]) }}" title="" class="sAdd not_view new">
                                @else
                                    <a id="{{ __('new_') }}{{ $row->id }}" href="{{ route('notif.view', ['id' => $row->id]) }}" title="" class="sAdd not_view">
                                @endif
                                    {{ json_decode($row->data, true)['message'] }}
                                <br>{{ $row->created_at->diffForHumans() }}
                                </a>
                            </li>
                        @endforeach
                        </div>
                        @if(count($notification) > 0)
                        <li class="all">{{ __('Xem tất cả') }}</li>
                        @endif
                    </ul>
                </li>
                <li>
                    <a href="{{ route('site.home.index') }}" target="_blank">
                        <img id="head-right-img" src="{{ asset('source/backend/admin/images/icons/light/home.png') }}" />
                        <span>{{ trans('common.head.trang_chu') }}</span>
                    </a>
                </li>
                <!-- Logout -->
                <li>
                    <a href="{{ route('admin.logout') }}">
                        <img src="{{ asset('source/backend/admin/images/icons/topnav/logout.png') }}" alt="" />
                        <span>{{ trans('common.head.dang_xuat') }}</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="clear"></div>
    </div>
</div>
<!-- Main content -->
