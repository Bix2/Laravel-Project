$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#breath_session__buttton').on('click', function (event) {
        var amount = 1;
        event.preventDefault();
        $('.breath__animation').addClass('session');
        $('.total-line .progress-line').removeClass('animated');
        $('.total-line .progress-line').css('width', '0');
        setTimeout(function () {
        $('.total-line .progress-line').addClass('animated');
        $('.total-line .progress-line').css('width', '100%');
        }, 1);
        setTimeout(function () {
            $('.breath__animation').removeClass('session');
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
			$('#breath_session__buttton').html('Again?');
			$('#breathingdone').addClass('done');
	}, 60000);
    });
});