<li class="dd"><a title=""><img src="{{ asset('source/backend/admin/images/icons/topnav/messages.png') }}" alt=""><span>{{ __('Thông báo') }}</span><span class="numberTop">{{ $total_not or 0 }}</span></a>
                    <ul class="userDropdown">
                        <div class="result">
                        @foreach($notification as $row)
                            <li>
                                @if($row->status == 0)
                                    <a id="{{ __('new_') }}{{ $row->id }}" href="{{ $row->link }}" title="" class="sAdd not_view new">
                                @else
                                    <a id="{{ __('new_') }}{{ $row->id }}" href="{{ $row->link }}" title="" class="sAdd not_view">
                                @endif
                                    {{ $row->title }}
                                <br>{{ date('d/m H:i:s', strtotime($row->date)) }}
                                </a>
                            </li>
                        @endforeach
                        </div>
                        @if(count($notification) > 0)
                        <li class="all">{{ __('Xem tất cả') }}</li>
                        @endif
                    </ul>
                </li>