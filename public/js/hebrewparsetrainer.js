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

	var audio_positive = new Audio('public/audio/positive.wav');
	var audio_negative = new Audio('public/audio/negative.wav');

	var correct_answers;
	var input_count = 0;
	var checked = false;

	function stepFancyInput(step) {
		$('#trainer-input-fancy').html('');
		var buts = {};
		switch (step) {
			case 0:
				buts = { 'Q ':   'Qal'
				       , 'Hip ': 'Hiphil'
				       , 'Ho ':  'Hophal'
				       , 'Ni ':  'Niphal'
				       , 'Pi ':  'Piel'
				       , 'Pu ':  'Pual'
				       , 'Hit ': 'Hitpael'
				}; break;
			case 1:
				buts = { 'pf ':	'Pf.'
				       , 'ipf ':   'Ipf.'
				       , 'coh ':   'Coh.'
				       , 'imp ':   'Imp.'
				       , 'ius ':   'Ius.'
				       , 'infcs':  'Inf. cs.'
				       , 'infabs': 'Inf. abs.'
				       , 'pta ':   'Part. act.'
				       , 'ptp ':   'Part. pass.'
				}; break;
			case 2:
				buts = { '1': '1', '2': '2', '3': '3', '': 'N/A' }; break;
			case 3:
				buts = { 'm': 'Masculine', 'f': 'Feminine', '': 'N/A' }; break;
			case 4:
				buts = { 's': 'Singular', 'p': 'Plural', '': 'N/A' }; break;
		}

		for (k in buts) {
			var but = $('<button></button>');
			but.addClass('btn btn-default').attr('role', 'button');
			but.text(buts[k]).val(k);
			but.click(function(){
				var ip = $('#trainer-input-'+input_count);
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

			$('#trainer-input-fancy').append(but).append('&nbsp;');
		}
	}

	function addInput() {
		input_count++;
		var html = "<div class='row trainer-input'>\
						<div class='col-md-8'>\
							<div class='form-group'>\
								<label for='trainer-input-"+input_count+"'>Parse:</label>\
								<input type='text' class='form-control' id='trainer-input-"+input_count+"' placeholder='Q pf 3ms' spellcheck='false'/>\
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
		$('#trainer-404').hide();
		$('#trainer-verb').css({color: 'gray'});
		$('#trainer-answer').text('');
		removeInputs();

		var stems = $('input[name="stem"]:checked').map(function(){return this.value;});
		var tenses = $('input[name="tense"]:checked').map(function(){return this.value;});
		var roots = $('select[name="root"]').val();

		$.ajax('verb/random/', {
			data: {
				stem: $.makeArray(stems).join(),
				tense: $.makeArray(tenses).join(),
				root: $.makeArray(roots).join()
			},
			dataType: 'json',
			error: function(jqxhr, status, error) {
				$('#trainer-404').fadeIn();
			},
			success: function(data, status, jqxhr) {
				$('#trainer-verb').text(data.verb.verb).css({color: 'black'});

				correct_answers = [];
				for (var i in data.answers) {
					var answer = {
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

		var re = /^\s*(\w+)\s+(\w+)(?:\s+(?:([123])\s*)?([mf])\s*([sp])\s*)?$/;
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
			if (tense.indexOf('participle') == 0 && person != null)
				return false;
			if (tense.indexOf('participle') != 0 && person == null)
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

	function parsingToString(parsing, extended) {
		var genders = {
			'm': 'masculine',
			'f': 'feminine'
		};
		var numbers = {
			's': 'singular',
			'p': 'plural'
		};
		if (extended === true) {
			return parsing.stem + ' ' + parsing.tense +
					(parsing.person ? (' ' + parsing.person) : '') +
					(parsing.gender ? (' ' + genders[parsing.gender]) : '') +
					(parsing.number ? (' ' + numbers[parsing.number]) : '');
		} else {
			return parsing.stem + ' ' + parsing.tense +
					(parsing.person ? (' ' + parsing.person) : '') +
					(parsing.gender ? (' ' + parsing.gender) : '') +
					(parsing.number ? (' ' + parsing.number) : '');
		}
	}

	function processInput() {
		var input = $('#trainer-input-' + input_count);
		var answer = parseAnswer(input.val());
		if (answer === false) {
			input.parent().addClass('has-error');
			$('#trainer-parsed-' + input_count).val('Parsing error');
		} else {
			input.parent().removeClass('has-error');
			$('#trainer-parsed-' + input_count).val(parsingToString(answer, true));
		}
		return answer;
	}

	function checkInput(reload) {
		var answer = processInput();
		if (!answer && $('#trainer-input-'+input_count).val() != '') {
			$('#trainer-input-'+input_count).shake(2, 12, 300);
			return false;
		}

		for (var i in correct_answers) {
			var correct_answer = correct_answers[i];
			if (JSON.stringify(answer) == JSON.stringify(correct_answer)) {
				$('#trainer-input-'+input_count)
					.css({backgroundColor: '#dff0d8'})
					.parent().addClass('has-success');
				if ($('#settings-audio').prop('checked')) audio_positive.play();

				correct_answers.splice(i,1);
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
		}

		$('#trainer-input-'+input_count)
			.css({backgroundColor: '#f2dede'})
			.parent().addClass('has-error');
		if ($('#settings-audio').prop('checked')) audio_negative.play();
		$('#trainer-answer').text(' - ' + correct_answers.map(parsingToString).join(', '));

		return true;
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

		if (typeof reload_on_load != 'undefined' && reload_on_load)
			reloadVerb();
	}

	$('#hebrewparsetrainer-settings .reload-verb').change(function(){
		reloadVerb();
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
