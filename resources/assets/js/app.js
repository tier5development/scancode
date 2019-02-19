
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes jQuery and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

var facebookAuthURI = $('meta[name="fb-auth"]').attr('content');
var facebookAPIVersion = $('meta[name="fb-version"]').attr('content');
var scancodeGeneratorBaseURI = "https://graph.facebook.com/v" + facebookAPIVersion + "/me/messenger_codes?access_token=";
var scancodeStoreURI = $('meta[name="scancode"]').attr('content');

function checkLoginState() {
    window.FB.getLoginStatus(function (response) {
        if (response.status == "connected" && response.authResponse !== null) {
            window.location.href = facebookAuthURI;
        }
    });
}

function logout() {
    FB.getLoginStatus(function (response) {
        if (response.status === 'connected') {
            $('#logout-form').submit();
        }
    });
}

window.checkLoginState = checkLoginState;
window.logout = logout;

FB.Event.subscribe('xfbml.render', function () {
    var spinner = document.querySelector("#spinner");
    if (spinner) spinner.removeAttribute("style");
    var loading = document.querySelector('#loading');
    if (loading) loading.parentNode.removeChild(loading);
});

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('#auth-scancode-generate').submit(function (event) {
        event.preventDefault();
        var url = $(this).prop('action'),
            method = $(this).prop('method'),
            facebookUserId = $('#facebook-user').val().trim(),
            facebookPageId = $('#facebook-page').val().trim(),
            facebookPageName = $('#facebook-page :selected').text().trim(),
            ref = $('#ref').val().trim(),
            size = $('#size').val().trim(),
            isError = false;

        if (facebookPageId.length) {
            isError = false;
            $('#facebook-page-error-text').removeClass('error-on', 'error-off');
        } else {
            isError = true;
            $('#facebook-page-error-text').removeClass('error-off', 'error-on');
        }

        if (size.length) {
            isError = false;
            $('#facebook-page-error-text').removeClass('error-on').addClass('error-off');
        } else {
            isError = true;
            $('#facebook-page-error-text').removeClass('error-off').addClass('error-on');
        }

        if (!isError) {
            $.ajax({
                url: url,
                type: method,
                data: {
                    facebook_user_id: facebookUserId,
                    facebook_page_id: facebookPageId
                },
            }).then(function (response) {
                $.ajax({
                    type: "POST",
                    url: scancodeGeneratorBaseURI + response.access_token,
                    data: {
                        type: "standard",
                        data: {
                            ref: ref
                        },
                        "image-size": size
                    }
                }).then(function (response) {
                    $.ajax({
                        type: "POST",
                        url: scancodeStoreURI,
                        data: {
                            facebook_user_id: facebookUserId,
                            facebook_page_id: facebookPageId,
                            facebook_page_name: facebookPageName,
                            scancode_uri: response.uri,
                        }
                    });
                    if (size > 500) size = 500;
                    var appendHtml = '<div id="auth-scancode-display" class="text-center" style="margin-top: 50px;"><img id="scan-code" class="img-responsive" src="' + response.uri + '" style="height: ' + size + 'px; width: ' + size + 'px"><br/>' +
                        '<a id="download-button" class="btn btn-primary" href="' + response.uri + '" download="scancode_' + facebookPageId + '.jpg" name="scancode_' + facebookPageId + '.jpg" target="_blank">Download</a></div>';
                    $('#auth-scancode-display').replaceWith(appendHtml);
                });
            });
        }
    });

    $('#tier5-scancode-generate').submit(function (event) {
        event.preventDefault();
        var url = $(this).prop('action'),
            method = $(this).prop('method'),
            product = $('#product').val().trim(),
            affiliateId = $('#affiliate-id').val().trim(),
            size = $('#size').val().trim(),
            isError = false;

        if (product.length) {
            isError = false;
            $('#facebook-page-error-text').removeClass('error-on').addClass('error-off');
        } else {
            isError = true;
            $('#facebook-page-error-text').removeClass('error-off').addClass('error-on');
        }

        if (affiliateId.length) {
            isError = false;
            $('#facebook-page-error-text').removeClass('error-on').addClass('error-off');
        } else {
            isError = true;
            $('#facebook-page-error-text').removeClass('error-off').addClass('error-on');
        }

        if (size.length) {
            isError = false;
            $('#facebook-page-error-text').removeClass('error-on').addClass('error-off');
        } else {
            isError = true;
            $('#facebook-page-error-text').removeClass('error-off').addClass('error-on');
        }

        if (!isError) {
            $.ajax({
                url: url,
                type: method,
                data: {},
            }).then(function (response) {
                $.ajax({
                    type: "POST",
                    url: scancodeGeneratorBaseURI + response.access_token,
                    data: {
                        type: "standard",
                        data: {
                            ref: '__block==' + product.toLowerCase() + '__affid==' + affiliateId
                        },
                        "image-size": size
                    }
                }).then(function (response) {
                    if (size > 500) size = 500;
                    var appendHtml = '<div id="tier5-scancode-display" class="text-center" style="margin-top: 50px;"><img id="scan-code" class="img-responsive" src="' + response.uri + '" style="height: ' + size + 'px; width: ' + size + 'px"><br/>' +
                        '<a id="download-button" class="btn btn-primary" href="' + response.uri + '" download="scancode_tier5_' + affiliateId + '.jpg" name="scancode_tier5_' + affiliateId + '.jpg" target="_blank">Download</a></div>';
                    $('#tier5-scancode-display').replaceWith(appendHtml);
                });
            });
        }
    });
});
