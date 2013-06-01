$(function () {
	var overlay = $('.overlay'),
		image = $('.img img'),
		imageloader = new Image();

	image.css('max-width', 'none');
	resizeToWindow();
	bindHotkeys();

	$('.reload,.img a').on('click', function () {
		loadNextImage();

		return false;
	});

	window.addEventListener('popstate', function(e) {
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

	function bindHotkeys() {
		$(document).on('keyup', function (e) {
			var keyCode = e.keyCode || e.which,
				keys = {
					left:  37,
					right: 39,
					space: 32
				};

			switch (keyCode) {
				case keys.left:
					history.go(-1);
				break;

				case keys.space:
				case keys.right:
					loadNextImage();
				break;
			}
		});
	}

	function loadNextImage() {
		image.css('opacity', '0.4');
		overlay.fadeIn('fast');

		$.getJSON('', {ajax:true}, function (data) {
			applyData(data);
			history.pushState(data, null, document.location.pathname + '?img=' + data.name);
		});
	}

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
