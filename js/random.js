$(function () {
	var overlay = $('.overlay');
		imageloader = new Image();

	$('.reload,.img a').on('click', function () {
		overlay.fadeIn('fast');

		$.getJSON('', {ajax:true}, function (data) {
			applyData(data);
			history.pushState(data, null, document.location.pathname + '?img=' + data.name);
		});

		return false;
	});

	function applyData(data, push) {
		imageloader.onload = function () {
			$('.img img')
				.attr('src', data.url)
				.attr('alt', data.name)
				.attr('title', data.name);
			overlay.fadeOut('fast');
		};
		imageloader.src = data.url;
		$('.gplus').attr('href', 'https://plus.google.com/share?url=' + encodeURI(data.url));
		$('#copy').val(data.url);
		$('.info span').html(data.resolution[0] + ' &times; ' + data.resolution[1] + ' px &nbsp;&nbsp;@&nbsp;&nbsp; ' + data.size + ' Kb');
	}

	window.addEventListener("popstate", function(e) {
		if (history.state){
			applyData(e.state);
		}
	});
});
