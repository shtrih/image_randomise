$(function () {
	$('.reload,.img a').on('click', function () {
		$.getJSON('', {ajax:true}, function (data) {
			$('.gplus').attr('href', 'https://plus.google.com/share?url=' + encodeURI(data.url));
			$('#copy').val(data.url);
			$('.img img').attr('src', data.url);
			$('.info span').html(data.resolution[0] + ' &times; ' + data.resolution[1] + ' px &nbsp;&nbsp;@&nbsp;&nbsp; ' + data.size + ' Kb');
		});

		return false;
	});
});
