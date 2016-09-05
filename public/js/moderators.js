/**
 * HebrewParseTrainer - practice Hebrew verbs
 * Copyright (C) 2015  Camil Staps <info@camilstaps.nl>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
$(document).ready(function(){
	$('.vote').click(function(){
		var vote = parseInt($(this).data('vote'));
		var verbId = $(this).data('verb');

		var container = $(this).parent();

		$.ajax({
			url: app_url + 'verb/' + verbId + '/vote/' + vote,
			success: function(data) {
				if (!data.success) {
					fail(data.message);
					return;
				}

				var btns = container.find('.vote');
				if (vote) {
					$(btns[0]).removeClass('btn-danger');
					$(btns[0]).addClass('btn-default');
					$(btns[1]).addClass('btn-success');
					$(btns[1]).removeClass('btn-default');
				} else {
					$(btns[0]).addClass('btn-danger');
					$(btns[0]).removeClass('btn-default');
					$(btns[1]).removeClass('btn-success');
					$(btns[1]).addClass('btn-default');
				}

				container.find('.vote-count').text(data.new_vote_count);

				if (data.accepted) {
					alert('This verb has now been accepted!');
					container.parent().remove();
				}
			}
		});

		return true;
	});
});
