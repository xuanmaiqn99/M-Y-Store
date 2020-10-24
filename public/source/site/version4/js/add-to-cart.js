$(window).on('load', function() {
    var base = $('base').attr('href');
    $('.data-cart').DataTable();
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('click', '.btn-checkout', function() {
        window.location =  base + "cart/checkout.html";
    });
    $('.submit-order').click(function(e) {
        e.preventDefault();
        url = base + "order/check-order.html";
        $.ajax({
            type: "post",
            url: url,
            data: {
            },
            dataType: "json", 
            success: function (data) {
                if (parseInt(data) >0) {
                    var form = document.getElementById("form-checkout");
                    if (form.checkValidity()) {
                        form.submit();
                    } else {
                        showToast('', 'Vui lòng chọn địa chỉ giao hàng', 'warning');
                    }
                } else {
                    showToast('', 'Đơn hàng trống, vui lòng thêm sản phẩm để thực hiện chức năng này', 'warning');
                }
            },
            error: function (request, status, error) {
                showToast('', 'Không thể đặt hàng được', 'error');
                // reLoad();
            }
        });
               
    });
    $('.wishlist-remove').click(function(e){
        e.preventDefault();
        url = $(this).attr("link");
        id = $(this).attr("value");
        $.ajax({
            type: "post",
            url: url,
            data: {
                id: id
            },
            dataType: "json", 
            success: function (data) {
                showToast('', 'Xóa sản phẩm khỏi wishlist thành công', "success");
                reLoad();
            },
            error: function (request, status, error) {
                showToast('', 'Không thể xóa sản phẩm khỏi wishlist được', "error");
                reLoad();
            }
        });
    });

    $('.wishlist').click(function(e){
        e.preventDefault();
        url = $(this).attr('href');
        value = $(this).attr("value");
        $.ajax({
            type: "post",
            url: url,
            data: {
                value: value
            },
            dataType: "json", 
            success: function (data) {
                if (data == "error") {
                    window.location = "404.html";
                } else {
                    var content;
                    var type = "warning";
                    if (data == 'exist') {
                        content = "Sản phẩm này có trong wishlist rồi";
                    } else if (data == "fail") {
                        content = "Vui lòng đăng nhập để thực hiện chức năng này";
                    } else {
                        content = "Thêm vào wishlist thành công";
                        type = "success";
                        $('.wl_sl').html(data);
                    }
                    showToast('', content, type);
                }
            },
            error: function (request, status, error) {
                showToast('', 'Không thể thêm sản phẩm vào wishlist được', "error");
                reLoad();
            }
        });
    });
    $('.delete-compare').click(function(e){
        e.preventDefault();
        url = $(this).attr("href");
        $.ajax({
            type: "post",
            url: url,
            data: {
            },
            dataType: "json", 
            success: function (data) {
                showToast('', 'Xóa sản phẩm khỏi so sánh thành công', "success");
                reLoad();
            },
            error: function (request, status, error) {
                showToast('', 'Không thể xóa sản phẩm trong so sánh được', "error");
                reLoad();
            }
        });
    });
    $(document).on('click', '.compare', function(e){
        e.preventDefault();
        url = $(this).attr("href");
        value = $(this).attr("value");
        $.ajax({
            type: "post",
            url: url,
            data: {
                value: value
            },
            dataType: "json", 
            success: function (data) {
                if (data == "error"){
                    window.location = "404.html";
                } else {
                    var content;
                    var type = "warning";
                    if (data == 'full') {
                        content = "Vượt quá giới hạn so sánh";
                    } else if (data == 'exist') {
                        content = "Sản phẩm này có trong so sánh rồi"
                    } else {
                        content = "Thêm vào so sánh thành công";
                        type = "success";
                        $('#so-luong').html(data);
                    }
                    showToast('', content, type);
                }
            },
            error: function (request, status, error) {
                showToast('', 'Không thể thêm sản phẩm vào so sánh được', "error");
                reLoad();
            }
        });

    });
    $('.add-cart').on('click', function() {
        url = $(this).attr('link');
        $.ajax({
            type: "post",
            url: url,
            data: {
                value: 1
            },
            dataType: "json", 
            success:function (data) {
                if (data == "error") {
                    window.location = "404.html";
                } else if (data == 'ok') {
                    showToast('', 'Thêm sản phầm vào giỏ hàng thành công', 'success');
                    reLoad();
                } else {
                    showToast('', 'Vui lòng đăng nhập để thực hiện được chức năng này', 'warning');
                }
            },
            error: function (request, status, error) {
                showToast('', 'Không thể thêm sản phẩm vào giỏ hàng được', "error");
                reLoad();
            }
        });

    });
    $('.btn-continue').click(function(){
        window.location = base + 'index.html';
    });
    $('.btn-cart').click(function(e){
    	e.preventDefault();
        var url = $(this).attr('link'); 
        var id = $(this).attr('data');
        var value = 1;
        if ($('.btn-cart').hasClass('multiple')) {
            if ($('#qty').val() == '') {
                showToast('', 'Vui lòng chọn số lượng', 'warning');
                return false;
            } else {
                value = $('#qty').val();
            }
        }
        $.ajax({
            type: "post",
            url: url,
            data: {
                id: id,
                value: value
            },
            dataType: "json", 
            success:function (data) {
                if(data == "error") {
                    window.location = "404.html";
                } else if (data.length > 0) {
                    let str = '<div class="basket"><a class="basket-icon">'+
                    '<i class="fa fa-shopping-basket"></i> Shopping Cart <span class="badge">'+
                    data[1]+'</span></a>'+
                    '<div class="top-cart-content">';
                    str += '<div class="block-subtitle">'+
                    '<div class="top-subtotal">'+
                    data[1]+' Sản phẩm, <span class="price">'+data[2]+' đ</span></div></div>'+
                    '<ul class="mini-products-list" id="cart-sidebar">';
                    data[0].forEach( function(element, index) {
                        str += '<li class="item">'+
                        '<div class="item-inner"><a class="product-image" title="product tilte is here"'+
                        'href="'+element.link+'"><img alt="product tilte is here"'+
                        'src="'+element.avatar+'"></a>'+
                        '<div class="product-details">'+
                        '<p class="product-name"><a href="'+element.link+'">'+
                        element.name+'</a></p><strong>'+element.qty+'</strong> x <span class="price">'+
                        element.price+' đ</span></div>'+
                        '</div></li>';
                    });
                    str += '</ul><div class="actions">'+
                    '<a href="'+base+'cart/view.html"'+
                    'class="view-cart"><span>View Cart</span></a>'+
                    '<button class="btn-checkout" title="Checkout"'+
                    'type="button"><span>Checkout</span></button></div></div>';
                    $('#cart-content').html(str);
                    showToast('', 'Thêm vào giỏ hàng thành công', 'success');
                } else {
                    showToast('', 'Vui lòng đăng nhập để thực hiện được chức năng này', 'warning');
                }
            },
            error: function (request, status, error) {
                showToast('', 'Không thể thêm sản phẩm vào giỏ hàng được', "error");
                reLoad();
            }
        });
        
    });
    $('.delete').on('click', function(event) {
    	event.preventDefault();
    	url = $(this).attr('link');
    	id = $(this).attr('value');
    	rowId = $(this).attr('data');
    	$.confirm({
            theme: 'material',
            title:'',
            content: 'Bạn có chắc chắn muốn xóa các sản phẩm đã chọn',
            autoClose: 'cancel|8000',
            buttons: {
            	Ok: {
                    btnClass: 'btn-blue',
                    action:function () {
                        $.ajax({
                            type: "post",
                            url: url,
                            data: {
                                rowId: rowId
                            },
                            success:function (data) {
                            	showToast('', 'Xóa thành công', 'success');
                                redirectTo(base + 'cart/view.html');
			             	},
                            error: function (request, status, error) {
                                showToast('', 'Không thể xóa được', "error");
                                reLoad();
                            }
                        });
                    }
                },
                cancel: {

                }
            }
        });
    });
});