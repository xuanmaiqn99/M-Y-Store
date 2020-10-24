$(window).on('load', function () {
    var base = $('base').attr('href');
    var table = $('#checkAll').DataTable();
    $('.menu').on( 'change', function () {
        var i = $(this).attr('colum');
        var v = $(this).val(); 
        table.columns(i).search(v).draw();
    });
    $('.datepicker1').on('change click keyup', function() {
        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {
                var min = $('#filter_created').val();
                var max = $('#filter_created_to').val();
                if(min != "")
                    min = new Date(min);
                if(max != "")
                    max = new Date(max);
                var startDate = new Date(data[7].split(" ")[0]);
                if (min == "" && max == "") { return true; }
                if (min == "" && startDate <= max) { return true;}
                if (max == "" && startDate >= min) {return true;}
                if (startDate <= max && startDate >= min) { return true; }
                return false;
            }
        );
        table.draw();
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.export').click(function(e){
        e.preventDefault();
        var url = $(this).parent().attr('href');
        $.ajax({
            type: "post",
            url: url,
            dataType: "json",
            success: function (response) {
                if ($.isEmptyObject(response)) {
                    alert('Đơn đặt hàng trống');
                } else {
                    var a = document.createElement("a");
                    a.href = response.file; 
                    a.download = response.name;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();     
                }
            },
            error: function (request, status, error) {
                showToast('', request.responseText, 'error');
                reLoad();
            }
        });
      
    });
    $('.confirm-order').hide();
    $('.order-submit').click(function(e){
        e.preventDefault();
        $('.confirm-order').submit();
    });
    $(document).on('click', '.delete', function (e) {
        e.preventDefault();
        id = $(this).attr('value');
        if( $(this).hasClass('category')) {
            var url = $(this).attr('check');
            var link = $(this).attr('href');
            $.ajax({
                type: "post",
                url: url,
                data: {
                    id: id
                },
                success:function (data) {
                    if(data == 0){
                        $.confirm({
                            theme: 'material',
                            title:'',
                            content: 'Bạn có chắc chắn muốn xóa',
                            buttons: {
                                ok: {
                                    btnClass: 'btn-blue',
                                    action:function () {
                                        $.ajax({
                                            type: "post",
                                            url: link,
                                            data: {
                                                id: id,
                                                data: data
                                            },
                                            success:function (data) {
                                                table.row(".row_" + id).remove().draw();
                                                var str = $('#total').html() -1;
                                                $('#total').html(str);
                                                showToast('', 'Xóa thành công', 'success');
                                            },
                                            error: function (request, status, error) {
                                                showToast('', request.responseText, 'error');
                                                reLoad();
                                            }
                                        });
                                    }
                                },
                                cancle: {
                                }
                            }
                        });
                    }else if(data == 1){
                        $.confirm({
                            theme: 'material',
                            title:'',
                            content: 'Danh mục này chứa danh mục con, bạn vẫn muốn xóa',
                            buttons: {
                                ok: {
                                    btnClass: 'btn-blue',
                                    action:function () {
                                        $.ajax({
                                            type: "post",
                                            url: link,
                                            data: {
                                                id: id,
                                                data: data
                                            },
                                            success:function (data) {
                                                $.each(data, function(index, value ) {
                                                    table.row(".row_" + value).remove().draw();
                                                });
                                                var str = $('#total').html() - data.length;
                                                $('#total').html(str);
                                                showToast('', 'Xóa thành công', 'success');
                                            },
                                            error: function (request, status, error) {
                                                showToast('', request.responseText, 'error');
                                                reLoad();
                                            }
                                        });
                                    }
                                },
                                cancle: {
                                }
                            }
                        });
                    }
                    else if(data == 2){
                        $.confirm({
                            theme: 'material',
                            title:'',
                            content: 'Danh mục này chứa sản phẩm, bạn vẫn muốn xóa',
                            buttons: {
                                ok: {
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        $.ajax({
                                            type: "post",
                                            url: link,
                                            data: {
                                                id: id,
                                                data: data
                                            },
                                            success: function (data) {
                                                table.row(".row_" + id).remove().draw();
                                                var str = $('#total').html() -1;
                                                $('#total').html(str);
                                                showToast('', 'Xóa thành công', 'success');
                                            },
                                            error: function (request, status, error) {
                                                showToast('', request.responseText, 'error');
                                                reLoad();
                                            }
                                        });
                                    }
                                },
                                cancle: {
                                }
                            }
                        });
                    }else {
                        return false;
                    }
                },
                error: function (request, status, error) {
                    showToast('', request.responseText, 'error')
                    reLoad();
                }
            });
        } else {
            var url = $(this).attr('href');
            $.confirm({
                theme: 'material',
                title:'',
                content: 'Bạn có chắc chắn muốn xóa',
                buttons: {
                    ok: {
                        btnClass: 'btn-blue',
                        action:function () {
                            $.ajax({
                                type: "post",
                                url: url,
                                data:{
                                    id: id
                                },
                                success:function (data) {
                                    if(data =='ok'){
                                        table.row(".row_" + id).remove().draw();
                                        var str = $('#total').html() -1;
                                        $('#total').html(str);
                                        showToast('', 'Xóa thành công', 'success');
                                    }
                                },
                                error: function (request, status, error) {
                                    showToast('', request.responseText, 'error');
                                    reLoad();
                                }
                            });
                        }
                    },
                    cancle : {
                    }
                }
            });
        }
    });

    $(document).on('click', '#delMul', function (e) {
        e.preventDefault();
        var allVals = [];
        $(".check-del:checked").each(function() {
            allVals.push($(this).attr('value'));
        });
        if(allVals.length ==0){
            $.dialog({
                theme: 'material',
                title: '',
                content: 'Vui lòng chọn cái bạn muốn xóa',
                animationSpeed: 200,
                backgroundDismiss: true,
            });
        }else{
            var url = $('#delMul').attr('href');
            $.confirm({
                theme: 'material',
                title:'',
                content: 'Bạn có chắc chắn muốn xóa các thứ đã chọn',
                buttons: {
                    ok: {
                        btnClass: 'btn-blue',
                        action:function () {
                            $.ajax({
                                type: "post",
                                url: url,
                                data:{
                                    allVals: allVals
                                },
                                success:function (data) {
                                    if (data =='ok'){
                                        if ($('#delMul').hasClass('order-del')) {
                                            $.each(allVals, function( index, value ) {
                                                $('table tr.row_' + value + ' td:nth-child(1)').html('');
                                                var str = '<span class="reject">Hủy bỏ</span>';
                                                $('table tr.row_' + value + ' td:nth-child(7)').html(str);
                                            });
                                        } else {
                                            $.each(allVals, function( index, value ) {
                                                table.row(".row_" + value).remove().draw();   
                                            });
                                            var str = $('#total').html().split('|');
                                            for(var i=0;i<str.length;i++){
                                                str[i] = str[i]-allVals.length;
                                            }
                                            $('#total').html(str[0]);
                                        }
                                        showToast('', 'Xóa thành công', 'success');
                                        if (str[0] == "0" && $('#delMul').hasClass('reply-del')) {
                                            redirectTo(base + '/admin/comment/index.html');
                                        }
                                    } else {
                                        return false;
                                    }
                                },
                                error: function (request, status, error) {
                                    showToast('', request.responseText, 'error');
                                    reLoad();
                                }
                            });
                        }
                    },
                    cancle : {
                    }
                }
            });
        }
    });
});