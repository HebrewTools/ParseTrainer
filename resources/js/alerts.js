$.fn.addAlert = function (kind, message) {
		var box = '<div class="alert alert-' + kind + ' alert-dismissible" role="alert">' +
				'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
				message + '</div>';

		$(this).find('.alerts').append($(box));
}

$.fn.clearAlerts = function () {
		$(this).find('.alerts').html('');
}
