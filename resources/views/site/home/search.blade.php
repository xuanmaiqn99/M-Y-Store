@extends('site.layout')
<!-- end header -->
<!-- Revslider -->
@section('content')
    <div class="container jtv-home-revslider">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-3 hidden-xs"></div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 jtv-main-home-slider">
                <div id='rev_slider_1_wrapper' class='rev_slider_wrapper fullwidthbanner-container'>
                    <div id='rev_slider_1' class='rev_slider fullwidthabanner'>
                        <ul>
                            @foreach($slide as $row)
                                <li data-transition='fade' data-slotamount='7' data-masterspeed='1000' data-thumb="{{ url(config('app.slideUrl')) }}/{{ $row->image_link }}">
                                    <img src="{{ url(config('app.slideUrl')) }}/{{ $row->image_link }}" alt="slider image1" data-bgposition='left top' data-bgfit='cover' data-bgrepeat='no-repeat'/>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Container -->
    <section class="main-container col2-left-layout">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-push-4 col-md-9 col-md-push-3 main-inner">
                    <div class="col-main">
                        <div class="jtv-featured-products">
                            <div class="slider-items-products">
                                <div class="jtv-new-title">
                                    <h2>{{ __('Sản phẩm tìm thấy') }} {{ count($product) }}</h2>
                                </div>
                                <div id="featured-slider" class="product-flexslider hidden-buttons">
                                    <div class="slider-items slider-width-col4 products-grid">
                                        @foreach($product as $row)
                                            <div class="item">
                                                <div class="item-inner">
                                                    <div class="item-img">
                                                        <div class="item-img-info"><a class="product-image" title="Product tilte is here" href="product-detail.html"> <img alt="Product tilte is here" src="{{ url(config('app.imageUrl')) }}/{{ $row->avatar }}"> </a>
                                                            <div class="new-label new-top-left">new</div>
                                                            <div class="mask-shop-white"></div>
                                                            <a class="wishlist" value="{{ $row->id }}" href="{{ route('site.cart.add_to_wishlist') }}">
                                                                <div class="mask-left-shop">
                                                                    <i class="fa fa-heart"></i>
                                                                </div>
                                                            </a>
                                                            <a class="compare" value="{{ $row->id }}" href="{{ route('site.cart.add_to_compare') }}">
                                                                <div class="mask-right-shop">
                                                                    <i class="fa fa-signal"></i>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="item-info">
                                                        <div class="info-inner">
                                                            <div class="item-title">
                                                                <a title="Product tilte is here" href="{{ route('product.view', ['id' => $row->id]) }}">{{ $row->name }}</a>
                                                            </div>
                                                            <div class="item-content">
                                                                <div class="rating">
                                                                    @for($i = 1;$i < 5;$i++)
                                                                        @if($i > round($product_view->averageRating))
                                                                            <i class="fa fa-star-o"></i>
                                                                        @else
                                                                            <i class="fa fa-star"></i>
                                                                        @endif
                                                                    @endfor
                                                                </div>
                                                                <div class="item-price">
                                                                    <div class="price-box">
                                                                        <span class="regular-price">
                                                                            <span class="price">{{ number_format($row->price - $row->discount, null, null, ".") }} VNĐ
                                                                            </span>
                                                                        </span>
                                                                        @if($row->discount > 0)
                                                                            <p class="old-price">
                                                                                <span class="price-label">Regular Price:</span>
                                                                                <span class="price"> {{ number_format($row->price, null, null, ".") }} VNĐ
                                                                                </span>
                                                                            </p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="actions">
                                                                    <div class="add_cart">
                                                                        <button data="{{ $row->id }}" link="{{ route('site.cart.add') }}" class="button btn-cart" type="button">
                                                                            <span><i class="fa fa-shopping-cart"></i> Add to Cart</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Latest Blog -->
                    <div class="jtv-latest-blog">
                        <div class="jtv-new-title">
                            <h2>{{ __('Tin tức mới nhất') }}</h2>
                        </div>
                        <div class="row">
                            <div class="blog-outer-container">
                                <div class="blog-inner">
                                    @foreach($news as $row)
                                        <div class="col-xs-12 col-sm-6 blog-preview_item">
                                            <div class="entry-thumb jtv-blog-img-hover"><a href="{{ route('site.news.view', ['id' => $row->id]) }}"> <img alt="Blog" src="{{ url(config('app.newsUrl')) }}/{{ $row->avatar }}"> </a></div>
                                            <h4 class="blog-preview_title"><a href="{{ route('site.news.view', ['id' => $row->id]) }}">{{ $row->title }}</a></h4>
                                            <div class="blog-preview_info">
                                                <ul class="post-meta">
                                                    <li><i class="fa fa-user"></i>By <a href="#">admin</a></li>
                                                    <li><i class="fa fa-clock-o"></i><span class="day">{{ date("d", strtotime($row->created_at)) }} </span><span class="month">{{ date("M", strtotime($row->created_at)) }}</span></li>
                                                </ul>
                                                <div class="blog-preview_desc news-content">
                                                    {!! $row->content !!}
                                                </div>
                                                <a class="read_btn" href="{{ route('site.news.view', ['id' => $row->id]) }}">Read More</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Latest Blog -->
                </div>
                <!-- Sidebar -->
                <div class="top-sidebar col-left sidebar col-sm-4 col-xs-12 col-sm-pull-8 col-md-3 col-md-pull-9">
                    <div class="sidebar-banner">
                    {!! Form::open(['route' => 'site.home.search_mul', 'method' => 'get']) !!}
                        <div class="form-group div-input">
                            <label>{{ __('Danh mục') }}</label>
                            {!! Form::select('category_id', $cateS, null, ['placeholder' => 'Tất cả danh mục']) !!}
                            <br><br>
                            <label >{{ __('Mức giá') }}</label>
                            {!! Form::select('price', $priceS, null, ['placeholder' => 'Tất cả mức giá']) !!}
                            <br><br>
                            <label>{{ __('Sắp xếp') }}</label>
                            {!! Form::select('order', $orderS, null) !!}
                            <br><br>
                            {!! Form::submit(__('Tìm kiếm'), ['class' => 'btn btn-primary search-form']) !!}
                        </div>
                    {!! Form::close() !!}
                    </div>
                    <!-- <div class="sidebar-banner">
                        <img src="{{ asset('source/site/version4/images/top-banner.jpg') }}" alt="Flash Sale">
                    </div> -->
                    <div class="sidebar-banner"><img src="{{ asset('source/site/version4/images/new-arrivals-banner.jpg') }}" alt="New Arrivals"></div>
                    <div class="jtv-hot-deal-product">
                        <ul class="products-grid">
                            <li class="right-space two-height item">
                                <div class="item-inner">
                                    <div class="item-img">
                                        <div class="item-img-info"><a href="{{ route('product.view', ['id' => $product_view->id]) }}" title="Product tilte is here" class="product-image"><img src="{{ url(config('app.imageUrl')) }}/{{ $product_view->avatar }}" alt="Product tilte is here"> </a>
                                            <div class="hot-label hot-top-left">Hot View</div>
                                            <div class="mask-shop-white"></div>
                                            <a class="wishlist" value="{{ $product_view->id }}" href="{{ route('site.cart.add_to_wishlist') }}">
                                                <div class="mask-left-shop">
                                                    <i class="fa fa-heart"></i>
                                                </div>
                                            </a>
                                            <a class="compare" value="{{ $product_view->id }}" href="{{ route('site.cart.add_to_compare') }}">
                                                <div class="mask-right-shop">
                                                    <i class="fa fa-signal"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="item-info">
                                        <div class="info-inner">
                                            <div class="item-title"><a title="Product tilte is here" href="{{ route('product.view', ['id' => $product_view->id]) }}">{{ $product_view->name }}</a></div>
                                            <div class="item-content">
                                                <div class="rating"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i></div>
                                                <div class="item-price">
                                                    <div class="price-box">
                                                        <span class="regular-price">
                                                            <span class="price">{{ number_format($product_view->price - $product_view->discount, null, null, ".") }} VNĐ
                                                            </span>
                                                        </span>
                                                        @if($product_view->discount > 0)
                                                            <p class="old-price">
                                                                <span class="price-label">Regular Price:</span>
                                                                <span class="price"> {{ number_format($product_view->price, null, null, ".") }} VNĐ</span>
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="actions">
                                                    <div class="add_cart">
                                                        <button data="{{ $product_view->id }}" link="{{ route('site.cart.add') }}" class="button btn-cart" type="button">
                                                            <span><i class="fa fa-shopping-cart"></i> Add to Cart</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- Top Seller Slider -->
                    <div class="jtv-top-products">
                        <div class="slider-items-products">
                            <div class="jtv-new-title">
                                <h2>{{ __('Sản phẩm bán chạy') }}</h2>
                            </div>
                            <div id="top-products-slider" class="product-flexslider hidden-buttons">
                                <div class="slider-items slider-width-col4 products-grid">
                                    @foreach($product_sell as $row)
                                        <div class="item">
                                            <div class="item-inner">
                                                <div class="item-img">
                                                    <div class="item-img-info"><a class="product-image" title="Product tilte is here" href="{{ route('product.view', ['id' => $row->id]) }}"> <img alt="Product tilte is here" src="{{ url(config('app.imageUrl')) }}/{{ $row->avatar }}"> </a>
                                                        <div class="sale-label sale-top-right">sale</div>
                                                        <div class="mask-shop-white"></div>
                                                        <a class="wishlist" value="{{ $row->id }}" href="{{ route('site.cart.add_to_wishlist') }}">
                                                            <div class="mask-left-shop">
                                                                <i class="fa fa-heart"></i>
                                                            </div>
                                                        </a>
                                                        <a class="compare" value="{{ $row->id }}" href="{{ route('site.cart.add_to_compare') }}">
                                                            <div class="mask-right-shop">
                                                                <i class="fa fa-signal"></i>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="item-info">
                                                    <div class="info-inner">
                                                        <div class="item-title"><a title="Product tilte is here" href="{{ route('product.view', ['id' => $row->id]) }}">{{ $row->name }}</a></div>
                                                        <div class="item-content">
                                                            <div class="rating"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i></div>
                                                            <div class="item-price">
                                                                <div class="price-box"><span class="regular-price"> <span class="price">{{ number_format($row->price - $row->discount, null, null, ".") }} VNĐ</span></span>
                                                                    @if($row->discount > 0)
                                                                        <p class="old-price"><span class="price-label">Regular Price:</span> <span class="price"> {{ number_format($row->price, null, null, ".") }} VNĐ</span></p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="actions">
                                                                <div class="add_cart">
                                                                    <button data="{{ $row->id }}" link="{{ route('site.cart.add') }}" class="button btn-cart" type="button">
                                                                        <span><i class="fa fa-shopping-cart"></i> Add to Cart</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Top Seller Slider -->
                </div>
            </div>
        </div>
    </section>
    <!-- Support Policy Box -->
    <div class="container">
        <div class="support-policy-box">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="support-policy"><i class="fa fa-truck"></i>
                        <div class="content">{{ __('Free Shipping on order over $49') }}</div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="support-policy"><i class="fa fa-phone"></i>
                        <div class="content">{{ __('Need Help +1 123 456 7890') }}</div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="support-policy"><i class="fa fa-refresh"></i>
                        <div class="content">{{ __('30 days return Service') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Collection Banner -->
    <!-- collection area end -->
    <!-- Brand Logo -->
    <div class="container jtv-brand-logo-block">
        <div class="jtv-brand-logo">
            <div class="slider-items-products">
                <div id="jtv-brand-logo-slider" class="product-flexslider hidden-buttons">
                    <div class="slider-items slider-width-col6">
                        <div class="item">
                            <a>
                                <img src="{{ asset('source/site/version4/images/brand1.png') }}" alt="Brand Logo">
                            </a>
                        </div>
                        <div class="item">
                            <a>
                                <img src="{{ asset('source/site/version4/images/brand2.png') }}" alt="Brand Logo">
                            </a>
                        </div>
                        <div class="item">
                            <a>
                                <img src="{{ asset('source/site/version4/images/brand3.png') }}" alt="Brand Logo">
                            </a>
                        </div>
                        <div class="item">
                            <a>
                                <img src="{{ asset('source/site/version4/images/brand4.png') }}" alt="Brand Logo">
                            </a>
                        </div>
                        <div class="item">
                            <a>
                                <img src="{{ asset('source/site/version4/images/brand5.png') }}" alt="Brand Logo">
                            </a>
                        </div>
                        <div class="item">
                            <a>
                                <img src="{{ asset('source/site/version4/images/brand6.png') }}" alt="Brand Logo">
                            </a>
                        </div>
                        <div class="item">
                            <a>
                                <img src="{{ asset('source/site/version4/images/brand7.png') }}" alt="Brand Logo">
                            </a>
                        </div>
                        <div class="item">
                            <a>
                                <img src="{{ asset('source/site/version4/images/brand8.png') }}" alt="Brand Logo">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('source/site/version4/js/slide-show.js') }}"></script>
@endsection