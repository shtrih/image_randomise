$(function () {
	var overlay = $('.overlay'),
		image = $('.img img'),
		imageloader = new Image();

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
				.css('opacity', '1');
			overlay.fadeOut('fast');
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
});
