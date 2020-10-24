<div class="cart-page-area">
    @if (count($orderDetails) > 0)
        <h4>{{ __('Danh sách các sản phẩm trong đơn hàng của bạn') }}</h4>
        <div class="table-responsive">
            <table class="shop-cart-table data-cart">
                <thead>
                <tr>
                    <th class="product-thumbnail">{{ __('Mã sản phẩm') }}</th>
                    <th class="product-name">{{ __('Tên sản phẩm') }}</th>
                    <th class="product-price" style="width: 90px">{{ __('Đơn giá') }}</th>
                    <th class="product-subtotal">{{ __('Số lượng') }}</th>
                    <th class="product-subtotal" style="width: 90px">{{ __('Thành tiền') }}</th>
                </tr>
                </thead>
                <tbody>
                @php $i = 0; @endphp
                @foreach($orderDetails as $row)
                    <tr class="cart_item">
                        <td class="item-title">
                            {{ $product[$i]->id }}
                        </td>
                        <td class="item-title">
                            {{ $product[$i]->name }}
                        </td>
                        @php $price = $product[$i]->price - $product[$i]->discount; @endphp
                        <td class="item-price"> 
                            {{ number_format($price, null, null, ",") }} đ
                        </td>
                        <td class="item-qty">{{ $row->quantity }}</td>
                        <td class="item-price"> 
                            {{ number_format($price * $row->quantity, null, null, ",") }} đ
                        </td> 
                    </tr>
                    @php $i++; @endphp
                @endforeach
                </tbody>
            </table>
        </div>
    @else
    @endif
</div>
         