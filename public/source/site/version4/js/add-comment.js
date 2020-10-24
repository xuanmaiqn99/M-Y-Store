$(window).on('load', function() {
	var base = $('base').attr('href');
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#reviews').click(function(e) {
    	e.preventDefault();
    	$.ajax({
            url: base + "customer/check-login.html",
            method: "post",
            dataType: "json",
            data: {
            },
            success: function(data) {
               	if ($.isEmptyObject(data)) {
            		showToast('', 'Vui lòng đăng nhập để thực hiện chức năng này', 'warning');
            	} else {
            		if ($('#input-1').val() == 0){
            			showToast('', 'Vui lòng chọn rate', 'error');
            		}else {
            			$('.sub-review').submit();
            		}
            	}
	        },
	        error: function (request, status, error) {
                showToast('', 'Không thể chọn rate được', 'error');
                reLoad();
            }
	    });
    });
    $('#add-comment').click(function(e) {
        e.preventDefault();
        result = $(this).parent();
        message = $('textarea').val();
        if (message != "") {
	        product_id = $('#add-comment').attr('post');
	        $.ajax({
	            url: base + "comment/store",
	            method: "post",
	            dataType: "json",
	            data:{
	                product_id: product_id,
	                message: message,
	            },
	            success: function(data)
	            {
	            	if (data == "error") {
	            		window.location = "404.html";
		            } else if ($.isEmptyObject(data)) {
	            		showToast('', 'Vui lòng đăng nhập để thực hiện chức năng này', 'error');
		            } else {
		            	$('.title').html('<h4>' + data.total +
		            	' Comment</h4>');
		            	result.prev().children().val('');
		            	var str = '<div class="display-comment"><strong>' +
		                data.name + '</strong> ';
		                if (data.level == 1)
		                	str += '<i title="Quản trị viên" class="fa fa-user"></i>';
		                str += '<br>'+data.message+'<br>';
		    			str += '<span><a class="reply" value="' + data.comment_id + '"';
		    			str += 'href="">Trả lời  </a></span>';
		    			str += '<span>' + data.date + '<span>' + '</div>';
		                $('.title').after(str);
		                $('.title').next().after('<br>'+
		                '<div class="display-comment">'+
		                	'<div id="div-' +data.comment_id + 
			                	'" class="display-comment div-reply">' +
				        		'<div class="form-group">' +
				            		'<input id="input-' + data.comment_id + 
				            		'" type="text" name="comment_body" ' +
				            		'class="form-control" />' +
				        		'</div>' +
				        		'<div class="form-group">'+
				            		'<input type="submit" comment="' + data.comment_id +
				            		'" post="' + data.product_id + '" class="btn ' + 
				            		'btn-warning submit-reply" value="Reply" />' +
				       			'</div>'+
		       				'</div>' +
		        		'</div>');
		            }
	            },
	            error: function (request, status, error) {
                    showToast('', 'Không thể bình luận được', 'error');
                    reLoad();
                }
	        });
    	}
    });

    $(document).on("click", '.reply', function(e) { 
        e.preventDefault();
        id = $(this).attr('value');
        $('#div-' + id).slideToggle();
        $('#input-' + id).focus();
    });

    $(document).on('click', '.submit-reply', function(e) {
        e.preventDefault();
        product_id = $(this).attr('post');
        comment_id = $(this).attr('comment');
        message = $(this).parent().prev().children().val();
        if(message != "") {
	        result = $(this).parent().parent();
	        $.ajax({
	            url: base + "comment/reply/store",
	            method: "post",
	            dataType: "json",
	            data: {
	                product_id: product_id,
	                comment_id: comment_id,
	                message: message,
	            },
	            success: function(data)
	            {
	                if (data == "error") {
	            		window.location = "404.html";
		            } else if ($.isEmptyObject(data)) {
	            		showToast('', 'Vui lòng đăng nhập để thực hiện chức năng này', 'warning');
	            	} else {
	            		$('div.title').html('<h4>' + data.total + ' Comment</h4>');
	            		result.find('input[type="text"]').val('');
		                result.hide();
		                var str = '<div class="display-comment"><strong>' +
		                data.name + '</strong> ';
		                if (data.level == 1)
		                	str += '<i title="Quản trị viên" class="fa fa-user"></i>';
		                str += '<br>' + data.message;
		                str += '<br><span>' + data.date + '<span><br><br>' + '</div>'
		                result.before(str);
	            	}
	            },
	            error: function (request, status, error) {
                    showToast('', 'Không thể trả lời bình luận được', 'error');
                    reLoad();
                }
	        });
        }
    });
});
