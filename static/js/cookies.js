$(document).ready(function () {

    const modal_cookies = $('#modal-cookies');

    allowCookies();

    $("#modal-cookies").modal({
        show: false,
        backdrop: 'static'
    });

    let shownCookies = getCookie("shownCookies");
    if (shownCookies !== "1") {
        $('#enable-google-cookies', modal_cookies).prop('checked', false);
        modal_cookies.modal('show');
    }

    modal_cookies.on('click', '#accept-cookies', function () {
        let checked = $('#enable-google-cookies', modal_cookies).is(':checked');
        if (checked) {
            setCookie('allowStats', '1', 365);
        } else {
            setCookie('allowStats', '0', 365);
        }
        let shownCookies = getCookie("shownCookies");
        if (shownCookies === '1') {
            location.reload();
        } else {
            setCookie('shownCookies', '1', 365);
            allowCookies();
        }

    });


    $('#cookiesBtn').on('click', function () {
        let allowStats = getCookie("allowStats");
        let checked = allowStats === '1';
        $('#enable-google-cookies', modal_cookies).prop('checked', checked);
        modal_cookies.modal('show');
    });

});

function allowCookies() {
    let allowStats = getCookie("allowStats");
    if (allowStats === "1") {
        window['ga-disable-UA-64370383-1'] = false;
    } else {
        window['ga-disable-UA-64370383-1'] = true;
    }
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
