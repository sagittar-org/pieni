function drawIndex(url, elmId)
{
	$.ajax({
		'url': url,
		'dataType': 'json',
		'success': (vars) => {
			$('#' + elmId + ' > *:gt(0)').remove();
			for (const id in vars.data) {
				let elm = $('#' + elmId + ' *:first').clone(true);
				elm.removeClass('d-none');
				for (const name in vars.data[id]) {
					elm.find('[name="' + name + '"]').text(vars.data[id][name]);
				}
				elm.find('.action-view').attr('href', elm.find('.action-view').data('href') + '/' + id);
				$('#' + elmId).append(elm);
			}
		},
	});
}

function drawView(url, elmId)
{
	$.ajax({
		'url': url,
		'dataType': 'json',
		'success': (vars) => {
			for (const name in vars.data) {
				$('#' + elmId).find('[name="' + name + '"]').text(vars.data[name]);
			}
		},
	});
}
