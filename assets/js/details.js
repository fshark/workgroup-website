import 'fancybox/dist/js/jquery.fancybox'
import '../css/details.scss';

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

$(document).ready(function(){
    $(".fancybox").fancybox({
        openEffect: "none",
        closeEffect: "none"
    });

    $(".zoom").hover(function(){
        $(this).addClass('gallery-transition');
    }, function(){
        $(this).removeClass('gallery-transition');
    });
});
