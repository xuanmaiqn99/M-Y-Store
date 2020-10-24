var num = 100; //number of pixels before modifying styles

$(window).bind('scroll', function () {
    if ($(window).scrollTop() > num) {
        $('#head-body').addClass('fixed');
    } else {
        $('#head-body').removeClass('fixed');
    }
});