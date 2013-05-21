$(function () {
	var overlay = $('.overlay'),
		image = $('.img img'),
		imageloader = new Image();

	image.css('max-width', 'none');
	resizeToWindow();

	$('.reload,.img a').on('click', function () {
		image.css('opacity', '0.4');
		overlay.fadeIn('fast');

		$.getJSON('', {ajax:true}, function (data) {
			applyData(data);
			history.pushState(data, null, document.location.pathname + '?img=' + data.name);
		});

		return false;
	});

	function applyData(data) {
		imageloader.onload = function () {
			image.attr('src', data.url)
				.attr('alt', data.name)
				.attr('title', data.name)
				.css('opacity', '1')
				.data('height', data.resolution[1]);
			overlay.fadeOut('fast');
			resizeToWindow();
		};
		imageloader.src = data.url;
		$('.gplus').attr('href', 'https://plus.google.com/share?url=' + encodeURI(data.url));
		$('#copy').val(data.url);
		$('.fullscreen').attr('href', data.url);
		$('.info span').html(data.resolution[0] + ' &times; ' + data.resolution[1] + ' px &nbsp;&nbsp;@&nbsp;&nbsp; ' + data.size + ' Kb');
	}

	window.addEventListener("popstate", function(e) {
		if (history.state){
			applyData(e.state);
		}
	});

	/* https://groups.google.com/forum/?fromgroups#!topic/jquery-en/SgDVE8Y_XAA */
	var resizeTimer = null;
	$(window).on('resize', function () {
		if (resizeTimer)
			clearTimeout(resizeTimer);

		resizeTimer = setTimeout(resizeToWindow, 500);
	});

	function resizeToWindow() {
		var window_height = $(window).height(),
			offset,
			result_height;

		offset = $('.share').outerHeight()
			+ $('.info').outerHeight()
			+ $('.footer').outerHeight()
			+ 4
		;
		result_height = window_height - offset;
		if (result_height > image.data('height')) {
			result_height = image.data('height');
		}

		image.animate({
			'height': result_height
		});
	}
});
