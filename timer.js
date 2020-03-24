var greenchime = true;
var yellowchime = true;
var redchime = true;
var colorWin;
var colorWinOpened = false;

var SpeechType = (function () {
    function SpeechType(name, greenTime, yellowTime, redTime, id) {
        this.name = name;
        this.greenTime = greenTime;
        this.yellowTime = yellowTime;
        this.redTime = redTime;
        this.id = id;
    }
    return SpeechType;
})();

var TSTimer = (function () {
    function TSTimer(speeches) {
        var _this = this;
        this.started = false;
        this.speeches = speeches;
		var formattedTime = '';
		var buttoncount = 0;
		var current_name = null;
		this.audioElement = document.createElement('audio');
		this.audioElement.setAttribute('src', $('#chimeurl').val());

        $.each(this.speeches, function (indexInArray, valueOfElement) {
            var newButton = $('<span>').attr('id', valueOfElement.id).addClass('speech-type').html(valueOfElement.name);
            newButton.click(function (event) {
                _this.activateSpeech($(event.target).attr('id'));
            });
            newButton.appendTo('#buttons');
			buttoncount++;
			if((buttoncount % 7) == 0)
				$('#buttons').append('<br />&nbsp;<br />');
        });

        $(window).resize(function () {
            _this.resizeTime();
        });

        this.resizeTime();
		
        $('#btnReset').click(function () {
            _this.resetButton();
        });

        $('#btnStart').click(function () {
            _this.startButton();
        });
    }
    TSTimer.prototype.resetButton = function () {
        if(this.started)
			this.stop();
	    if($('#showdigits').is(':checked'))
			$('#trafficlight').text('0:00');
        $('body').css('background-color', '#EFEEEF');
        if(colorWinOpened) {
            colorWin.document.body.style.backgroundColor = '#EFEEEF';
            colorWin.document.getElementById('popuplabel').innerHTML = 'Ready';
        }
		$('#colorlabel').html('');
        this.startTime = null;
		greenchime = true;
		yellowchime = true;
		redchime = true;
    };

    TSTimer.prototype.startButton = function () {
        if (this.started) {
            if(colorWinOpened) {
                colorWin.document.getElementById('popuplabel').innerHTML = 'Stopped';
            }
            this.stop();
        } else {
            if(colorWinOpened) {
                colorWin.document.getElementById('popuplabel').innerHTML = 'Timing ...';
            }
            this.start();

        }
    };

    TSTimer.prototype.resizeTime = function () {
        var width = $(window).width();
        var x = Math.floor((width < 900) ? (width / 900) * 28 : 28);
        $('#trafficlight').css('font-size', x + 'em');
    };

    TSTimer.prototype.setElementText = function (elapsedSeconds) {
		this.formattedTime = this.formatTime(elapsedSeconds);
		if($('#showdigits').is(':checked'))
			$('#trafficlight').text(this.formattedTime);
		else
			$('#trafficlight').html('<img src="' + $('#stopwatchurl').val() + '" />');
		$('#smallcounter').text(this.formattedTime);

		if (elapsedSeconds >= this.red) {
            $('body').css('background-color', '#FF4040');
            if(colorWinOpened) {
                colorWin.document.body.style.backgroundColor = '#FF4040';
                colorWin.document.getElementById('popuplabel').innerHTML = 'Red';    
            }
            $('#colorlabel').html('Red');
			if(redchime && $('#playchime').is(':checked'))
				{
				this.audioElement.play();
				redchime = false;
				}
        } else if (elapsedSeconds >= this.yellow) {
            $('body').css('background-color', '#FCDC3B');
			$('#colorlabel').html('Yellow');
            if(colorWinOpened) {
                colorWin.document.body.style.backgroundColor = '#FCDC3B';
                colorWin.document.getElementById('popuplabel').innerHTML = 'Yellow';
            }
                if(yellowchime && $('#playchime').is(':checked'))
				{
				this.audioElement.play();
				yellowchime = false;
				}
        } else if (elapsedSeconds >= this.green) {
            $('body').css('background-color', '#A7DA7E');
            $('#colorlabel').html('Green');
            if(colorWinOpened) {
            colorWin.document.body.style.backgroundColor = '#A7DA7E';
            colorWin.document.getElementById('popuplabel').innerHTML = 'Green';
            }
            if(greenchime && $('#playchime').is(':checked'))
				{
				this.audioElement.play();
				greenchime = false;
				}
		
        }
		
    };

    TSTimer.prototype.timerEvent = function () {
        if (!this.startTime) {
            this.startTime = new Date();
        }
        var timeNow = new Date();
        var elapsedSeconds = this.timeDiffInSeconds(this.startTime, timeNow);
		if(($('input[name=demolight]:checked').val() == 'green') && (elapsedSeconds < this.green))
			elapsedSeconds = elapsedSeconds + this.green;
		if(($('input[name=demolight]:checked').val() == 'yellow') && (elapsedSeconds < this.yellow))
			elapsedSeconds = elapsedSeconds + this.yellow;
		if(($('input[name=demolight]:checked').val() == 'red') && (elapsedSeconds < this.red))
			elapsedSeconds = elapsedSeconds + this.red;

        this.setElementText(elapsedSeconds);
    };
	
	$('#demo-green').click( function () {
		this.startTime = new Date() - this.green;
		alert('time' + this.startTime);
	});
	$('#demo-yellow').click( function () {
		this.startTime = new Date() - this.yellow;
	});
	$('#demo-red').click( function () {
		this.startTime = new Date() - this.red;
	});
	
    TSTimer.prototype.timeDiffInSeconds = function (earlyTime, lateTime) {
        var diff = lateTime.getTime() - earlyTime.getTime();
        return Math.floor(diff / 1000);
    };

    TSTimer.prototype.formatTime = function (elapsedSeconds) {
        var minutes = Math.floor(elapsedSeconds / 60);
        var seconds = elapsedSeconds % 60;
		if(elapsedSeconds > this.overtime) {
            this.disqualified = true;
            console.log('elapsed '+elapsedSeconds+' over '+ this.overtime);
        }
        else if (elapsedSeconds < this.undertime) {
            this.disqualified = true;
            console.log('elapsed '+elapsedSeconds+' under '+ this.undertime);
        }
		else
			this.disqualified = false;
        return minutes + ":" + ((seconds < 10) ? "0" + seconds.toString() : seconds.toString());
    };

    TSTimer.prototype.start = function () {
        var _this = this;
        $('#btnStart').html('Stop');
		$('.hidecount').hide();
        this.started = true;
        if (this.startTime) {
            var newStartTime = new Date().getTime() - (this.stopTime.getTime() - this.startTime.getTime());
            this.startTime.setTime(newStartTime);
        }
        this.green = this.getSecondsFromTextBox('#green-light');
        this.yellow = this.getSecondsFromTextBox('#yellow-light');
        this.red = this.getSecondsFromTextBox('#red-light');
		this.undertime = this.green - 30;
		this.overtime = this.red + 30;
		this.disqualified = true;
        this.timerToken = setInterval(function () {
            return _this.timerEvent();
        }, 100);
    };

    TSTimer.prototype.stop = function () {
        $('#btnStart').html('Start');
        this.started = false;
        this.stopTime = new Date();
		$('.hidecount').show();
		if($('#showdigits').is(':checked'))
			$('#trafficlight').text(this.formattedTime);
		$('#smallcounter').text(this.formattedTime);
		this.logStopTime();
        clearTimeout(this.timerToken);
    };

	TSTimer.prototype.logStopTime = function () {
		var speechid = $('.active-speech').attr('id');
		var speakerName = $('#speakername').val();
		if(!speakerName)
			speakerName = '?';
		speechid = speechid.replace('agenda-speech','');
		//var checked = '';
		if(this.disqualified)
			$('#disqualified'+speechid).prop('checked', true);
        else
            $('#disqualified'+speechid).prop('checked', false);
		$('#actualtime'+speechid).val(this.formattedTime);
        $('#timelog').append('<p>' + speakerName + ' ' + this.formattedTime + '</p>');
	};

    TSTimer.prototype.getSecondsFromTextBox = function (id) {
        var greenLight = $(id).val();
        return parseInt(greenLight.split(':')[0]) * 60 + parseInt(greenLight.split(':')[1]);
    };

    TSTimer.prototype.setDefault = function () {
        this.activateSpeech('st-standard');
    };

    TSTimer.prototype.activateSpeech = function (speechId) {
		var button_name = '';
		this.resetButton();
        $.each(this.speeches, function (indexInArray, valueOfElement) {
            if (valueOfElement.id === speechId) {
                $('#green-light').val(valueOfElement.greenTime);
                $('#yellow-light').val(valueOfElement.yellowTime);
                $('#red-light').val(valueOfElement.redTime);
				button_name = this.name;
				TSTimer.current_name = button_name = button_name.replace('&nbsp;',' ');
				if((button_name == 'Standard') || (button_name == 'Advanced') || (button_name == 'Icebreaker'))
					$('#speakername').val('');
				else
					$('#speakername').val(button_name);
            }
        });
        $('.active-speech').removeClass('active-speech');
        $('#' + speechId).addClass('active-speech');
    };
    return TSTimer;
})();

$(document).ready(function () {
    var speeches = [];
    speeches.push(new SpeechType("Table&nbsp;Topics", "1:00", "1:30", "2:00", "st-table-topics"));
    speeches.push(new SpeechType("Evaluation", "2:00", "2:30", "3:00", "st-evaluation"));
    speeches.push(new SpeechType("Icebreaker", "4:00", "5:00", "6:00", "st-icebreaker"));
    speeches.push(new SpeechType("Standard", "5:00", "6:00", "7:00", "st-standard"));
    speeches.push(new SpeechType("Advanced", "8:00", "9:00", "10:00", "st-advanced"));
    speeches.push(new SpeechType("One Minute", "0:30", "0:45", "1:00", "st-minute"));
    speeches.push(new SpeechType("Test", "0:02", "0:04", "0:06", "st-test"));
	$('.agenda_speakers').each(function( index ) {
  		speeches.push(new SpeechType($( this ).val(), $( this ).attr('green'), $( this ).attr('yellow'), $( this ).attr('red'), "agenda-speech" + index));
	});
    var timer = new TSTimer(speeches);
    timer.setDefault();	

$('#popup').click(function(){
    colorWin = window.open("about:blank", "Color Light", "width=200,height=200");
    colorWinOpened = true;
    colorWin.document.write("<body><h1 id=\"popuplabel\" style=\"font-size: 20vw; text-align: center; margin-top: 20vw\">Ready</h1><body>");
colorWin.document.body.style.backgroundColor = '#DDDDDD';
colorWin.document.title = 'Timing Light';
return false;
}); 

$('form#voting').submit(function(){
    if (! $('#readytovote').is(':checked')){
       $("#readyprompt").html('<span style="color: red;">You must check the final checkbox first</span>');
		$('#readyline').css({'border': 'thin solid red'});
       return false;
    }
}); 

});