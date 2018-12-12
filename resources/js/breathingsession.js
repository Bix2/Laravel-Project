$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#breath_session__buttton').on('click', startSession);
});

var counterTimer;

function startSession(event) {
    event.preventDefault();
    $('#breath_session__buttton').off('click', startSession);
    $('#breath_session__buttton').addClass('reset');
    $('#breath_session__buttton.reset').on('click', cancelSession);
    $('#breath_session__buttton').html('Cancel breathing session');
    $('.breath__animation, .breath__text').addClass('session');
    $('.total-line .progress-line').removeClass('animated');
    $('.total-line .progress-line').css('width', '0');
    setTimeout(function () {
        $('.total-line .progress-line').addClass('animated');
        $('.total-line .progress-line').css('width', '100%');
    }, 1);
    counterTimer = setTimeout(counter, 60000);
}

function cancelSession(event) {
    event.preventDefault();
    $('#breath_session__buttton.reset').off('click', cancelSession);
    $('#breath_session__buttton').removeClass('reset');
    $('#breath_session__buttton').html('Start a breathing session');
    $('.breath__animation, .breath__text').removeClass('session');
    $('.total-line .progress-line').removeClass('animated');
    $('.total-line .progress-line').css('width', '0');
    clearTimeout(counterTimer);
    $('#breath_session__buttton').on('click', startSession);
}

function counter() {
    var amount = 1;
    $('.breath__animation, .breath__text').removeClass('session');
    console.log('starting...');
    $.ajax({
        /* the route pointing to the post function */
        url: '/dashboard/breathing/session',
        type: 'POST',
        /* send the csrf-token and the input to the controller */
        data: { amount: amount },
        dataType: 'JSON',
        /* remind that 'data' is the response of the AjaxController */
        success: function success(data) {
        }
    });
    $('#breath_session__buttton').addClass('hidden');
    $('#breathingdone').addClass('done');
    $('#breath_session__buttton.reset').off('click', cancelSession);
    $('#breath_session__buttton').off('click', startSession);
}