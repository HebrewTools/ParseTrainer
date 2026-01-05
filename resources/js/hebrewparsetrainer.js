/**
 * HebrewParseTrainer - practice Hebrew verbs
 * Copyright (C) 2015-2021  Camil Staps <info@camilstaps.nl>
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
$.ajaxSetup({
	headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

$(document).ready(function(){
	// http://stackoverflow.com/a/4399433/1544337
	jQuery.fn.shake = function(intShakes, intDistance, intDuration) {
		this.each(function() {
			$(this).css("position","relative");
			for (var x=1; x<=intShakes; x++) {
				$(this).animate({left:(intDistance*-1)}, (intDuration/intShakes)/4)
						.animate({left:intDistance}, (intDuration/intShakes)/2)
						.animate({left:0}, (intDuration/intShakes)/4);
			}
		});
		return this;
	};

	var audio_positive = new Audio('audio/positive.wav');
	var audio_negative = new Audio('audio/negative.wav');

	var correct_answers;
	var input_count = 0;
	var checked = false;

	function stepFancyInput(step) {
		$('#trainer-input-fancy').html('');
		var btns = {};
		switch (step) {
			case 0:
				btns = { 'Q ':   'Qal'
				       , 'Hip ': 'Hiphil'
				       , 'Ho ':  'Hophal'
				       , 'Ni ':  'Niphal'
				       , 'Pi ':  'Piel'
				       , 'Pu ':  'Pual'
				       , 'Hit ': 'Hitpael'
				}; break;
			case 1:
				btns = { 'pf ':	'Pf.'
				       , 'ipf ':   'Ipf.'
				       , 'coh ':   'Coh.'
				       , 'imp ':   'Imp.'
				       , 'jus ':   'Jus.'
				       , 'infcs':  'Inf. cs.'
				       , 'infabs': 'Inf. abs.'
				       , 'ptc ':   'Ptc.'
				       , 'ptcp ':   'Ptc. pass. (qal)'
				}; break;
			case 2:
				btns = { '1': '1', '2': '2', '3': '3', '': 'N/A' }; break;
			case 3:
				btns = { 'm': 'Masculine', 'f': 'Feminine', 'c': 'Common', '': 'N/A' }; break;
			case 4:
				btns = { 's': 'Singular', 'p': 'Plural', '': 'N/A' }; break;
		}

		let btn_group = $('<div></div>');
		btn_group.addClass('btn-group').attr('role', 'group');

		for (k in btns) {
			let btn = $('<button></button>');
			btn.addClass('btn btn-default').attr('role', 'button');
			btn.text(btns[k]).val(k);
			btn.click(function(){
				let ip = $('#trainer-input-'+input_count);
				ip.val(ip.val() + $(this).val()).focus();
				if (step < 4) {
					stepFancyInput(step + 1);
				} else {
					var done = checkInput(true);
					if ($('#trainer-input-'+input_count).parent().hasClass('has-error')) {
						var next = $('<button></button>');
						next.addClass('btn btn-warning').attr('role', 'button');
						next.click(reloadVerb);
						if (done) {
							next.text('Next');
						} else {
							next.text('Skip');
						}
						$('#trainer-input-fancy').html(next);
					}
				}
			});

			$(btn_group).append(btn);
			if (k < btns.length-1)
				$(btn_group).append('&nbsp;');
		}

		let reset_btn = $('<button></button>');
		reset_btn.addClass('btn btn-default').attr('role', 'button');
		reset_btn.text('Reset');
		reset_btn.click(function(){
			let ip = $('#trainer-input-'+input_count);
			ip.val('').focus();
			stepFancyInput(0);
		});

		$('#trainer-input-fancy').append(btn_group).append('&nbsp;').append(reset_btn);
	}

	function addInput() {
		input_count++;
		var html = "<div class='row trainer-input'>\
						<div class='col-md-8'>\
							<div class='form-group'>\
								<label for='trainer-input-"+input_count+"'>Parse:</label>\
								<input type='text' class='form-control' id='trainer-input-"+input_count+"' placeholder='Q pf 3ms' spellcheck='false' autocorrect='off'/>\
							</div>\
						</div>\
						<div class='col-md-4'>\
							<div class='form-group'>\
								<label for='trainer-parsed-"+input_count+"'>Interpreted as:</label>\
								<input type='text' class='form-control' id='trainer-parsed-"+input_count+"' readonly='readonly'/>\
							</div>\
						</div>\
					</div>";
		$('#trainer-input-container').append(html);

		$('#trainer-input-'+input_count).keyup(function(e){
			if (e.keyCode == 13) {
				if (!checked) {
					checked = checkInput(false);
				} else {
					reloadVerb();
					$(this)
						.val('')
						.css({backgroundColor:'transparent'})
						.parent().removeClass('has-error has-success');
					checked = false;
				}
			} else {
				$(this)
					.css({backgroundColor:'transparent'})
					.parent().removeClass('has-error has-success');
				checked = false;
				processInput();
			}
		}).focus();

		stepFancyInput(0);
	}

	function removeInputs() {
		$('.trainer-input').remove();
		input_count = 0;
	}

	function reloadVerb() {
		$('#trainer-error').hide();
		$('#trainer-verb').css({color: 'gray'});
		$('#trainer-answer').text('');
		removeInputs();

		var stems = $('input[name="stem"]:checked').map(function(){return this.value;});
		var tenses = $('input[name="tense"]:checked').map(function(){return this.value;});
		var roots = $('select[name="root"]').val();

		$.ajax('verb/random/', {
			method: 'POST',
			data: {
				stem: $.makeArray(stems).join(),
				tense: $.makeArray(tenses).join(),
				root: $.makeArray(roots).join()
			},
			dataType: 'json',
			error: function(jqxhr, status, error) {
				if ('message' in jqxhr.responseJSON) {
					$('#trainer-error').html(jqxhr.responseJSON.message);
				} else {
					$('#trainer-error').text('There was an unexpected error while searching for a verb.');
				}
				$('#trainer-error').fadeIn();
			},
			success: function(data, status, jqxhr) {
				$('#trainer-verb').text(data.verb.verb).css({color: 'black'});

				correct_answers = [];
				for (var i in data.answers) {
					var answer = {
						root: data.answers[i].root,
						stem: data.answers[i].stem,
						tense: data.answers[i].tense,
						person: data.answers[i].person,
						gender: data.answers[i].gender,
						number: data.answers[i].number
					};
					correct_answers.push(answer);
				}

				addInput();
			}
		});
	}

	var stems = [];
	var tenses = [];
	var tenses_abbr = [];

	function findStem(stem) {
		var stems_ = stems.filter(function(s){return s.toLowerCase().indexOf(stem.toLowerCase()) == 0;});
		if (stems_.length == 1)
			return stems_[0];
	}

	function findTense(tense) {
		if (tenses.indexOf(tense) != -1)
			return tense;
		if (tenses_abbr.indexOf(tense) != -1)
			return tenses[tenses_abbr.indexOf(tense)];
	}

	function parseAnswer(parsing) {
		var persons = ['1', '2', '3', null];
		var genders = ['m', 'f', 'c', null];
		var numbers = ['s', 'p', null];

		var re = /^\s*(\w+)\s+(\w+\b)(?:\s+(?:([123])\s*)?([mfc])\s*([sp])\s*)?$/;
		var match = parsing.match(re);
		if (match == null)
			return false;

		var stem = findStem(match[1]);
		var tense = findTense(match[2]);
		var person = match[3] ? match[3] : null;
		var gender = match[4] ? match[4] : null;
		var number = match[5] ? match[5] : null;

		if (typeof stem === 'undefined' || typeof tense === 'undefined' || $.inArray(person, persons) == -1 ||
				$.inArray(gender, genders) == -1 || $.inArray(number, numbers) == -1)
			return false;

		if (tense.indexOf('infinitive') == 0 && (person != null || gender != null || number != null))
			return false;
		if (tense.indexOf('infinitive') != 0) {
			if (gender == null || number == null)
				return false;
			if (tense.indexOf('participle') != -1 && person != null)
				return false;
			if (tense.indexOf('participle') == -1 && person == null)
				return false;
		}

		return {
			stem: stem,
			tense: tense,
			person: person,
			gender: gender,
			number: number
		};
	}

	function parsingToString(parsing, extended, html) {
		var genders = {
			'm': 'masculine',
			'f': 'feminine',
			'c': 'common'
		};
		var numbers = {
			's': 'singular',
			'p': 'plural'
		};

		var prs = parsing.stem + ' ' + parsing.tense +
					(parsing.person ? (' ' + parsing.person) : '');

		if (extended === true) {
			prs += (parsing.gender ? (' ' + genders[parsing.gender]) : '') +
					(parsing.number ? (' ' + numbers[parsing.number]) : '');
		} else {
			prs += (parsing.gender ? (' ' + parsing.gender) : '') +
					(parsing.number ? (' ' + parsing.number) : '');
		}

		if ('root' in parsing) {
			if (html)
				prs += ' <span class="hebrew">' + parsing.root + '</span>';
			else
				prs += ' ' + parsing.root;
		}

		return prs;
	}

	function processInput() {
		var input = $('#trainer-input-' + input_count);
		var answer = parseAnswer(input.val());
		if (answer === false) {
			input.parent().addClass('has-error');
			$('#trainer-parsed-' + input_count).val(
				input.val().length < 8 ? 'Input full parsing...' : 'Parsing error');
		} else {
			input.parent().removeClass('has-error');
			$('#trainer-parsed-' + input_count).val(parsingToString(answer, true, false));
		}
		return answer;
	}

	function checkInput(reload) {
		var answer = processInput();
		if (!answer && $('#trainer-input-'+input_count).val() != '') {
			$('#trainer-input-'+input_count).shake(2, 12, 300);
			return false;
		}

		var answers = [answer];
		if (answer['gender'] == 'c') {
			answers.push(structuredClone(answer));
			answers[0]['gender'] = 'm';
			answers[1]['gender'] = 'f';
		}

		for (var i in answers) {
			let answer = answers[i];
			let answer_json = JSON.stringify(answer);
			let answer_found = false;

			for (var j in correct_answers) {
				var correct_answer = structuredClone(correct_answers[j]);
				delete correct_answer['root'];

				if (answer_json == JSON.stringify(correct_answer)) {
					answer_found = true;
					break;
				}
			}

			if (!answer_found) {
				$('#trainer-input-'+input_count)
					.css({backgroundColor: '#f2dede'})
					.parent().addClass('has-error');
				if ($('input[name="general"][value="audio"]').prop('checked')) audio_negative.play();
				$('#trainer-answer').html(' - ' + correct_answers.map(a => parsingToString(a, false, true)).join(', '));

				return true;
			}
		}

		/* Only remove from correct_answers if the above did not yield an error,
		 * since correct_answers is used to give feedback to the user. */
		for (var i in answers) {
			let answer = answers[i];
			let answer_json = JSON.stringify(answer);

			for (var j in correct_answers) {
				var correct_answer = structuredClone(correct_answers[j]);
				delete correct_answer['root'];

				if (answer_json == JSON.stringify(correct_answer)) {
					correct_answers.splice(j,1);
					break;
				}
			}
		}

		$('#trainer-input-'+input_count)
			.css({backgroundColor: '#dff0d8'})
			.parent().addClass('has-success');
		if ($('input[name="general"][value="audio"]').prop('checked')) audio_positive.play();

		if (correct_answers.length > 0) {
			addInput();
			return false;
		} else {
			if (reload === true) {
				window.setTimeout(reloadVerb, 600);
			}
			return true;
		}
	}

	function init() {
		$.ajax('stem/', {
			dataType: 'json',
			success: function(data, status, jqxhr) {
				stems = data.map(function(d){return d.name;});
			}
		});

		$.ajax('tense/', {
			dataType: 'json',
			success: function(data, status, jqxhr) {
				tenses = data.map(function(d){return d.name;});
				tenses_abbr = data.map(function(d){return d.abbreviation;});
			}
		});

		restoreSettingsFromStorage();

		if (typeof reload_on_load != 'undefined' && reload_on_load)
			reloadVerb();
	}

	function saveSettingsToStorage() {
		const stems = $.makeArray($('input[name="stem"]:checked').map(function(){return this.value;})).join();
		const tenses = $.makeArray($('input[name="tense"]:checked').map(function(){return this.value;})).join();
		const generalOptions = $.makeArray($('input[name="general"]:checked').map(function(){return this.value;})).join();

		const rootsArray = $.makeArray($('select[name="root"]').val());
		const allPossibleRoots = $.makeArray($('select[name="root"] option').map(function(){return this.value;}));
		const roots = allPossibleRoots.length !== rootsArray.length ? rootsArray.join() : '';

		localStorage.setItem('settings-stems', stems);
		localStorage.setItem('settings-tenses', tenses);
		localStorage.setItem('settings-roots', roots);
		localStorage.setItem('settings-general', generalOptions);
	}

	function restoreSettingsFromStorage() {
		const stems = (localStorage.getItem('settings-stems', stems) || '').split(',').filter(Boolean);
		const tenses = (localStorage.getItem('settings-tenses', tenses) || '').split(',').filter(Boolean);
		const roots = (localStorage.getItem('settings-roots', roots) || '').split(',').filter(Boolean);
		const generalOptions = (localStorage.getItem('settings-general', generalOptions) || '').split(',').filter(Boolean);

		if (stems.length) {
			$('input[name="stem"]').prop('checked', false);
			for (let i = 0; i < stems.length; ++i) {
				$('input[name="stem"][value="' + stems[i] + '"]').prop('checked', true);
			}
		}

		if (tenses.length) {
			$('input[name="tense"]').prop('checked', false);
			for (let i = 0; i < tenses.length; ++i) {
				$('input[name="tense"][value="' + tenses[i] + '"]').prop('checked', true);
			}
		}

		if (roots.length) {
			$('select[name="root"]').prop('selected', false);
			for (let i = 0; i < roots.length; ++i) {
				$('select[name="root"][value="' + roots[i] + '"]').prop('selected', true);
			}
		}

		if (generalOptions.length) {
			$('input[name="general"]').prop('checked', false);
			for (let i = 0; i < generalOptions.length; ++i) {
				$('input[name="general"][value="' + generalOptions[i] + '"]').prop('checked', true);
			}
		}
	}

	$('#hebrewparsetrainer-settings .reload-verb').change(function(){
		reloadVerb();
	});

	$('#hebrewparsetrainer-settings').change(function(){
		saveSettingsToStorage();
	});

	var help_shown = false;
	$('#show-hide-help').click(function(){
		help_shown = !help_shown;
		$('#trainer-input-help').slideToggle();
		$(this).text((help_shown ? 'Hide' : 'Show') + ' help');
		$('#trainer-input-'+input_count).focus();
	});

	init();
});
