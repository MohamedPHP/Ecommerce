// JavaScript Document
$(document).ready(function() {
    "use strict";
    // Calls the selectBoxIt method on your HTML select box and uses the default theme

    $("select").selectBoxIt({
        autoWidth: false
    });

    // hide place hold on foucs
    $("[placeholder]").focus(function() {
        $(this).attr("data-text", $(this).attr("placeholder"));
		$(this).attr("placeholder", "");
    }).blur(function () {
			$(this).attr("placeholder", $(this).attr("data-text"));
		});

    // Add the astrix
    $('input, textarea').each(function () {
    	if($(this).attr('required') === 'required'){
    		$(this).after('<span class="astrix">*</span>');
    	}
    });

    // Convert Pass Feiled To Text Feiled

    $('.show-pass').hover(function () {
        $('.password').attr('type', 'text');
    }, function () {
        $('.password').attr('type', 'password');
    });

    // Confirm Massge

    $('.confirm').click(function () {
        return confirm('Are You Sure?');
    });

	// Cat view Options

	$('.categouries h3').click(function (){

		$(this).next('.full-view').slideToggle(200);

	});
    // categouries calss active
    $('.option span').click(function () {

        $(this).addClass('active').siblings('span').removeClass('active');

        if ($(this).data('view') === 'full') {
            $('.cat .full-view').slideDown(200);
        } else {
            $('.cat .full-view').slideUp(200);
        }

    });

    // the dashboard stelying
    $('.toggle-info').click(function () {

        $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);

        if ($(this).hasClass('selected')) {
            $(this).html('<i class="fa fa-minus fa-lg"></i>');
        }else {
            $(this).html('<i class="fa fa-plus fa-lg"></i>');
        }
    });

});
