function showToast(title, message, type) {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "1500",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    toastr[type](message, title);
}

function reLoad(timeout = 1500) {
    setTimeout(function() { location.reload(); }, timeout);
}

function redirectTo(url, timeout = 1500) {
    setTimeout(function() { window.location = url; }, timeout);
}