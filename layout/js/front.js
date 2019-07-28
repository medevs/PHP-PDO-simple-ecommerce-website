$(function() {

	'use strict';

	// Switch Between Login & signup

	$('.login-page h1 span').click(function () {

		$(this).addClass('selected').siblings().removeClass('selected');

		$('.login-page form').hide();

		$('.' + $(this).data('class')).fadeIn(100);
	});

	// Trigger The Selectboxit

	$("select").selectBoxIt({

		autoWidth: false
	});
 
	
	// Hide Placeholder On Form Focus

	$('[placeholder]').focus(function() {

		$(this).attr('data-text',$(this).attr('placeholder'));
   
		$(this).attr('placeholder', '');

	}).blur(function () {

			$(this).attr('placeholder', $(this).attr('data-text'));

	});


		// Add Asterisk On Required Field 

		$('input').each(function() {

			if ($(this).attr('required') === 'required') {

				$(this).after('<span class="asterisk">*</span>');

			}
		});

		// Confirmation Message On Button

		$('.confirm').click(function() {

			return confirm('Are You Sure?');
		});

		$('.live').keyup(function () {

			$($(this).data('class')).text($(this).val());
		
		});



		$('.subMenu > a ').click(function(e)
	{
		e.preventDefault();
		var subMenu = $(this).siblings('ul');
		var li = $(this).parents('li');
		var subMenus = $('#sidebar li.subMenu ul');
		var subMenus_parents = $('#sidebar li.subMenu');
		if(li.hasClass('open'))
		{
			if(($(window).width() > 768) || ($(window).width() < 479)) {
				subMenu.slideUp();
			} else {
				subMenu.fadeOut(250);
			}
			li.removeClass('open');
		} else 
		{
			if(($(window).width() > 768) || ($(window).width() < 479)) {
				subMenus.slideUp();			
				subMenu.slideDown();
			} else {
				subMenus.fadeOut(250);			
				subMenu.fadeIn(250);
			}
			subMenus_parents.removeClass('open');		
			li.addClass('open');	
		}
	});
	
	var ul = $('#sidebar > ul');
	$('#sidebar > a').click(function(e)
	{
		e.preventDefault();
		var sidebar = $('#sidebar');
		if(sidebar.hasClass('open'))
		{
			sidebar.removeClass('open');
			ul.slideUp(250);
		} else 
		{
			sidebar.addClass('open');
			ul.slideDown(250);
		}
	});


 
});