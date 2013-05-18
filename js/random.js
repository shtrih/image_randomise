$(function () {
	$('.reload,.img a').on('click', function () {
		var overlay = $('.overlay').fadeIn('fast');
			imageloader = new Image();

		$.getJSON('', {ajax:true}, function (data) {
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
		});

		return false;
	});


});
