$(window).on('load', function(){
	var base = $('base').attr('href');
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.view-detail').click(function(e) {
    	var id = $(this).attr('value');
    	e.preventDefault();
    	$.ajax({
            url: base + "customer/order-detail-history.html",
            method: "post",
            dataType: "json",
            data: {
            	id: id
            },
            success: function(data) {
               	if ($.isEmptyObject(data)) {
            		window.location = "404.html";
            	} else {
            		$.alert({
                        theme: 'material',
                        title: 'Thông tin chi tiết đơn đặt hàng của bạn',
                        content: data.html,
                        animationSpeed: 100,
                        backgroundDismiss: true,
                        columnClass: 'l',
                        buttons: {
                        	đóng: {
                        		btnClass: 'btn-blue'
                        	}
                        }
                    });
            	}
	        },
            error: function (request, status, error) {
                alert(error);
            }
	    });
    });
});