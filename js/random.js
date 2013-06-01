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
			;
			overlay.fadeOut('fast');

			$('.gplus').attr('href', 'https://plus.google.com/share?url=' + encodeURI(data.url));
			$('#copy').val(data.url);
			$('.fullscreen').attr('href', data.url);
			$('.info')
				.find('.width').text(data.resolution[0]).end()
				.find('.height').text(data.resolution[1]).end()
				.find('.size').text(data.size)
			;
			$('title').text(data.name);
		};
		imageloader.src = data.url;

		resizeToWindow();
	}

	window.addEventListener("popstate", function(e) {
		if (history.state && e.state){
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
			max_height = Number($('.info .height').text()),
			offset,
			result_height;

		offset = $('.share').outerHeight()
			+ $('.info').outerHeight()
			+ $('.footer').outerHeight()
			+ 4
		;
		result_height = window_height - offset;
		if (max_height && result_height > max_height) {
			result_height = max_height;
		}

		image.animate({
			height: result_height,
		}, {
			duration: 300,
			specialEasing: {
				height: 'swing'
			}
		});
	}
});
