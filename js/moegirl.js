var page_regex = /\/\/zh.moegirl.org\/(([\w%.\-_:]+))/i;

$('#pjax_container').on('replace_link', function () {
	$(this).find('a').each(function () {
		var a = $(this), link = a.prop('href');
		if (page_regex.test(link)) {
			var new_link = './' + page_regex.exec(link)[1];
			if (is_win) new_link = new_link.replace(':', '__');
			a.prop('href', new_link).attr('pjax', 'on');
		}
	});
}).trigger('replace_link');

$(document).pjax('a[pjax]', '#pjax_container').on('pjax:success', function () {
	console.log('Content Loaded');
	$('#pjax_container').trigger('replace_link');
});