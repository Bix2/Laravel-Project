$(document).ready(function(){
    $('.toggleDrawer').click(function(){
        console.log('click');
        $('.tileDrawer').addClass('open');
    })

    $('.collapseDrawer').click(function(){
        $('.tileDrawer').removeClass('open');
    });
});