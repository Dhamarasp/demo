jQuery(document).ready(function ($) {
	
	var $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
	if ($navbarBurgers.length > 0) {
		$navbarBurgers.forEach(function ($el) {
			$el.addEventListener('click', function () {
				var target = $el.dataset.target;
				var $target = document.getElementById(target);
				// $el.classList.toggle('is-active');
				// $target.classList.toggle('is-active');
			});
		});
	}

	$(document).on('click', '.modal-button', function () {
		var target = $(this).data('target');
		$('html').addClass('is-clipped');
		$(target).addClass('is-active');
	});

	$(document).on('click', '.dropdown .button', function () {
		var target = $(this).data('target');
		document.getElementById(target).classList.toggle('is-active');
	});
	
	$(document).on('click', '.modal-background, .modal-close', function () {
		$('html').removeClass('is-clipped');
		$(this).parent().removeClass('is-active');
	});
	
	$(document).on('click', '.modal-card-head .delete, .modal-card-foot .button', function () {
		$('html').removeClass('is-clipped');
		$('.modal').removeClass('is-active');
	});

	$(document).on('click', '#menu-backdrop', function () {
		$('html').removeClass('is-clipped');
		$('#menu-backdrop').removeClass('is-active');
		$('.quickview').removeClass('is-active');
	});

	$(document).on('click', '.quickview .target-link', function () {
		$('html').removeClass('is-clipped');
		$('#menu-backdrop').removeClass('is-active');
		$('.quickview').removeClass('is-active');
	});
});

$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
	}
});