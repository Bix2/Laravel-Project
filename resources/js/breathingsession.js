$( document ).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#breath_session__buttton').on('click', function(event){
        var amount = 1;
        event.preventDefault();
        $('.breath__animation').addClass('session');
        setTimeout(function(){
            $('.breath__animation').removeClass('session');
            console.log('starting...');
            $.ajax({
                /* the route pointing to the post function */
                url: '/dashboard/breathing/session',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {amount},
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) { 
                    console.log('done');
                }
            });
          }, 3000);
    });
});