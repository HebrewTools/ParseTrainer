/**
 * Created by camil on 1/4/16.
 */
$(document).ready(function(){
    var audio_positive = new Audio('/public/audio/positive.wav');
    var audio_negative = new Audio('/public/audio/negative.wav');

    var correct_answer;

    function reloadVerb() {
        $('#trainer-404').hide();
        $('#trainer-verb').css({color: 'gray'});
        $('#trainer-answer').text('');

        var stems = $('input[name="stem"]:checked').map(function(){return this.value;});
        var tenses = $('input[name="tense"]:checked').map(function(){return this.value;});
        var roots = $('input[name="root"]:checked').map(function(){return this.value;});

        $.ajax('/verb/random', {
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
                $('#trainer-verb').text(data.verb).css({color: 'black'});
                correct_answer = {
                    stem: data.stem,
                    tense: data.tense,
                    person: data.person,
                    gender: data.gender,
                    number: data.number
                };
            }
        });
    }

    var stems = [];
    var tenses = [];
    var tenses_abbr = [];

    function findStem(stem) {
        var stems_ = stems.filter(function(s){return s.indexOf(stem) == 0;});
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
        var genders = ['m', 'f', 'c'];
        var numbers = ['s', 'p'];

        var re = /^\s*(\w+)\s+(\w+)\s+(?:([123])\s*)?([mfc])\s*([sp])\s*$/;
        var match = parsing.match(re);
        if (match == null)
            return false;

        var stem = findStem(match[1]);
        var tense = findTense(match[2]);
        var person = match[3] ? match[3] : null;
        var gender = match[4];
        var number = match[5];

        if (typeof stem === 'undefined' || typeof tense === 'undefined' || $.inArray(person, persons) == -1 ||
            !$.inArray(gender, genders) == -1 || !$.inArray(number, numbers) == -1)
            return false;

        if (tense.indexOf('participle') == 0 && person != null)
            return false;
        if (tense.indexOf('participle') != 0 && person == null)
            return false;

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
            'f': 'feminine',
            'c': 'communis generis'
        };
        var numbers = {
            's': 'singular',
            'p': 'plural'
        };
        if (extended === true) {
            return parsing.stem + ' ' + parsing.tense + ' ' + parsing.person +
                ' ' + genders[parsing.gender] + ' ' + numbers[parsing.number];
        } else {
            return parsing.stem + ' ' + parsing.tense + ' ' + parsing.person + ' ' + parsing.gender + ' ' + parsing.number;
        }
    }

    function processInput() {
        var input = $('#trainer-input');
        var answer = parseAnswer(input.val());
        if (answer === false) {
            input.parent().addClass('has-error');
            $('#trainer-parsed').val('Parsing error');
        } else {
            input.parent().removeClass('has-error');
            $('#trainer-parsed').val(parsingToString(answer, true));
        }
        return answer;
    }

    function checkInput() {
        var answer = processInput();
        if (JSON.stringify(answer) == JSON.stringify(correct_answer)) {
            $('#trainer-input')
                .css({backgroundColor: '#dff0d8'})
                .parent().addClass('has-success');
            if ($('#settings-audio').prop('checked')) audio_positive.play();
        } else {
            $('#trainer-input')
                .css({backgroundColor: '#f2dede'})
                .parent().addClass('has-error');
            if ($('#settings-audio').prop('checked')) audio_negative.play();
            $('#trainer-answer').text(' - ' + parsingToString(correct_answer));
        }
    }

    function init() {
        $.ajax('/stem', {
            dataType: 'json',
            success: function(data, status, jqxhr) {
                stems = data.map(function(d){return d.name;});
            }
        });

        $.ajax('/tense', {
            dataType: 'json',
            success: function(data, status, jqxhr) {
                tenses = data.map(function(d){return d.name;});
                tenses_abbr = data.map(function(d){return d.abbreviation;});
            }
        });

        reloadVerb();

        $('#trainer-input').focus();
    }

    $('#hebrewparsetrainer-settings input.reload-verb').change(function(){
        reloadVerb();
    });

    var checked = false;
    $('#trainer-input').keyup(function(e){
        if (e.keyCode == 13) {
            if (!checked) {
                checkInput();
                checked = true;
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
    });

    init();
});