function validate(e) {
    var ev = e || window.event;
    var key = ev.keyCode || ev.which;
    key = String.fromCharCode(key);
    var regex = /[0-9]/;
    if (!regex.test(key)) {
        ev.returnValue = false;
        if (ev.preventDefault)
            ev.preventDefault();
    }
}