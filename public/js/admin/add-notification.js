$(document).ready(function(){
    // Pusher.logToConsole = true;
    var pusher = new Pusher('3ddea16379f0b9608473', {
        cluster: 'ap1',
        encrypted: true
    });
    var result = $('.result');
    var channel = pusher.subscribe('notifi-order');
    var channel1 = pusher.subscribe('order-success');
    channel.bind('App\\Events\\NotifiOrderSuccess', function(data) {
        var newStr = '<li>' +
                        '<a id="new_' + data.info.id + '" href="' + 
                        data.info.link + '" title="" class="sAdd not_view new">'+
                        data.info.title +
                        '<br>' + data.date +
                        '</a>' +
                    '</li>';
        result.prepend(newStr);
        if (!$('.userDropdown').has('li.all').length) {
            $('.userDropdown').append('<li class="all">Xem tất cả</li>');
        }
        var count = $('.result li').length;
        if (count > 3) {
            $('.result li:last-child').remove();
        } 
        $('.numberTop').html(parseInt($('.numberTop').html()) + 1);
    });
    channel1.bind('App\\Events\\OrderEvent', function(data) {
        if (data.flag == "true") {
            $('.result li a').removeClass('new');
            $('.numberTop').html(0);
        } else {
            $('.result li a#new_' + data.id).removeClass('new');
            var count = parseInt($('.numberTop').html()) 
            $('.numberTop').html(count > 0 ? (count - 1) : count);
        }
    });
    $(document).on('click', '.all', function() {
        window.location = $('base').attr('href') + 'admin/notification.html'; 
    });
});
