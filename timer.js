jQuery(document).ready(function($) {

var greenchime = true;
var yellowchime = true;
var redchime = true;
var colorWin;
var colorWinOpened = false;
var colorNow = 'default';
var gotvotetimer;
var checkinterval = 1500 + Math.floor(Math.random()*1000);

//timer send
function colorChange(colorNow) {
    var view = $('#view').children("option:selected").val();
    console.log('color change:'+colorNow);
    console.log('view:'+view);
    if(view != 'timer')
        return;
    var url = jQuery('#seturl').val();
    console.log('send color '+colorNow+' to ' + url);
    //jQuery.post( url, { color: colorNow } );
}

function setBackgroundColor(color) {
    var colorCode = $('body').css('background-color');
    var colorLabel;
    if(color == 'green') {
        colorCode = '#A7DA7E';
        colorLabel = 'Green';
    } else if (color == 'yellow') {
        colorCode = '#FCDC3B';
        colorLabel = 'Yellow';
    } else if (color == 'red') {
        colorCode = '#FF4040';
        colorLabel = 'Red';
    }
    else if(color == 'start') {
        colorLabel = 'Timing...';        
    }
    else {
        colorCode = '#EFEEEF';
        colorLabel = 'Ready';
    }

    $('body').css('background-color', colorCode);
    if(colorWinOpened) {
        colorWin.document.body.style.backgroundColor = colorCode;
        colorWin.document.getElementById('popuplabel').innerHTML = colorLabel;
    }
} 

//audience check
function checkColorChange() {
    //todo - fix this
    return;
    var url = jQuery('#seturl').val()+'?rand='+Math.random();
    //console.log('get url '+url);
    $.get( url, function( data ) {
    if(colorNow == data)
        return;
    colorNow = data;
    setBackgroundColor(colorNow);
    //console.log(data);
    });
}

 function refreshView() {
     var view = $('#view').children("option:selected").val();
     var interval = 1500 + Math.floor(Math.random()*1000);
     console.log('view: '+view);
     if(view == 'normal')
     {
    $('iframe').css("height", window.innerHeight - 50);
    $('iframe').css("width", window.innerWidth - 50);
    $('#jitsi').css("left", '30px');
    $('.timer-controls').hide();
    /*
    gotvotetimer = setInterval(function(){
    checkColorChange();	
    }, checkinterval);
    */
     }
     else {
    $('#explanation').hide();
    $('iframe').css("height", window.innerHeight - 50);
    $('iframe').css("width", window.innerWidth - 100);
    $('.timer-controls').show();
    $('#jitsi').css("left", '100px');
        if(gotvotetimer)
           stopRefreshReceived();
     }

} 

function stopRefreshReceived() {
  clearInterval(gotvotetimer);
}

refreshView(); // initial load
$('#view').change(refreshView);

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
			//buttoncount++;
			//if((buttoncount % 9) == 0)
				$('#buttons').append('<br />');
        });

        $(window).resize(function () {
            _this.resizeTime();
        });

        this.resizeTime();
		
        $('.btnReset').click(function () {
            _this.resetButton();
        });

        $('.btnStart').click(function () {
            _this.startButton();
        });

        //$('#btnNudge').click(function() { _this.startTime = _this.startTime -5; console.log('start: '+ _this.startTime); });
    }
    TSTimer.prototype.resetButton = function () {
        if(this.started)
            this.stop();
        if(colorNow != 'default')
        {
            colorNow = 'default';
            colorChange(colorNow);
            setBackgroundColor(colorNow);
        }
        $('#correction').val('0');
	    if($('#showdigits').is(':checked'))
			$('#trafficlight').text('0:00');
        this.startTime = null;
		greenchime = true;
		yellowchime = true;
		redchime = true;
    };

    TSTimer.prototype.startButton = function () {
        if (this.started) {
            if(colorWinOpened) {
                colorWin.document.getElementById('popuplabel').innerHTML = 'Paused';
            }
            this.stop();
        } else {
            if(colorWinOpened) {
                colorWin.document.getElementById('popuplabel').innerHTML = 'Timing ...';
            }
            this.start();
            colorChange('start');
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
            if(colorNow != 'red')
                {
                    colorNow = 'red';
                    colorChange(colorNow);
                    setBackgroundColor(colorNow);
                }
			if(redchime && $('#playchime').is(':checked'))
				{
				this.audioElement.play();
				redchime = false;
				}
        } else if (elapsedSeconds >= this.yellow) {
            if(colorNow != 'yellow')
                {
                    colorNow = 'yellow';
                    colorChange(colorNow);
                    setBackgroundColor(colorNow);
                }
                if(yellowchime && $('#playchime').is(':checked'))
				{
				this.audioElement.play();
				yellowchime = false;
				}
        } else if (elapsedSeconds >= this.green) {
            if(colorNow != 'green')
                {
                    colorNow = 'green';
                    colorChange(colorNow);
                    setBackgroundColor(colorNow);                    
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
        var elapsedSeconds = this.timeDiffInSeconds(this.startTime, timeNow)+parseInt($("#correction").val());
		if(($('input[name=demolight]:checked').val() == 'green') && (elapsedSeconds < this.green))
			elapsedSeconds = elapsedSeconds + this.green;
		if(($('input[name=demolight]:checked').val() == 'yellow') && (elapsedSeconds < this.yellow))
			elapsedSeconds = elapsedSeconds + this.yellow;
		if(($('input[name=demolight]:checked').val() == 'red') && (elapsedSeconds < this.red))
            elapsedSeconds = elapsedSeconds + this.red;
            
        this.setElementText(elapsedSeconds);
    };
    
    TSTimer.prototype.timeDiffInSeconds = function (earlyTime, lateTime) {
        var diff = lateTime.getTime() - earlyTime.getTime();
        return Math.floor(diff / 1000);
    };

    TSTimer.prototype.formatTime = function (elapsedSeconds) {
        var minutes = Math.floor(elapsedSeconds / 60);
        var seconds = elapsedSeconds % 60;
		if(elapsedSeconds > this.overtime) {
            this.disqualified = true;
            //console.log('elapsed '+elapsedSeconds+' over '+ this.overtime);
        }
        else if (elapsedSeconds < this.undertime) {
            this.disqualified = true;
            //console.log('elapsed '+elapsedSeconds+' under '+ this.undertime);
        }
		else
			this.disqualified = false;
        return minutes + ":" + ((seconds < 10) ? "0" + seconds.toString() : seconds.toString());
    };

    TSTimer.prototype.start = function () {
        var _this = this;
        $('.btnStart').html('Pause');
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
        $('.btnStart').html('Start');
        this.started = false;
        this.stopTime = new Date();
        $('.hidecount').show();
        //$('.nudge').hide();
		if($('#showdigits').is(':checked'))
			$('#trafficlight').text(this.formattedTime);
		$('#smallcounter').text(this.formattedTime);
		this.logStopTime();
        clearTimeout(this.timerToken);
    };

	TSTimer.prototype.logStopTime = function () {
		var speechid = $('#speechid').val();
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
    speeches.push(new SpeechType("Standard", "5:00", "6:00", "7:00", "st-standard"));
    speeches.push(new SpeechType("Table&nbsp;Topics", "1:00", "1:30", "2:00", "st-table-topics"));
    speeches.push(new SpeechType("Evaluation", "2:00", "2:30", "3:00", "st-evaluation"));
    speeches.push(new SpeechType("Icebreaker", "4:00", "5:00", "6:00", "st-icebreaker"));
    var timer = new TSTimer(speeches);
    timer.setDefault();	

$('#popup').click(function(){
    if(colorWinOpened)
        colorWin.focus();
    else {
        colorWin = window.open("about:blank", "Color Light", "width=200,height=100,top=50,left=0");
        colorWinOpened = true;
        colorWin.document.write("<body><h1 id=\"popuplabel\" style=\"font-size: 20vw; text-align: center; margin-top: 10vw\">Ready</h1></body>");
        colorWin.document.body.style.backgroundColor = '#DDDDDD';
        colorWin.document.title = 'Timing Light';
        //window.resizeBy(window.innerWidth,50);
    }
return false;
}); 

$('#timerpopup').click(function(){
    if(typeof timerWin !== 'undefined')
        timerWin.focus();
    else {
        timerWin = window.open("about:blank", "Timer", "width=200,height=200,top=300,left=0");
        timerWin.document.write("<body><p><button class=\"btn-primary btnStart\" type=\"button\" value=\"Start\">Start</button></p><p><button class=\"btn-default btnReset\" type=\"button\" value=\"Reset\">Reset</button></p></body>");
        timerWin.document.body.style.backgroundColor = '#DDDDDD';
        timerWin.document.title = 'Timer';
        //window.resizeBy(window.innerWidth,50);
    }
return false;
}); 

$('form#voting').submit(function(){
    if (! $('#readytovote').is(':checked')){
       $("#readyprompt").html('<span style="color: red;">You must check the final checkbox first</span>');
		$('#readyline').css({'border': 'thin solid red'});
       return false;
    }
}); 

$(document).on( 'change', '#dropdowntime', function() {
    var timevars = $('#dropdowntime').val();
    var parts = timevars.split('|');
    $('#speakername').val(parts[0]);
    $('#green-light').val(parts[1]);
    $('#yellow-light').val(parts[2]);
    $('#red-light').val(parts[3]);
    $('#speechid').val(parts[4]);
});

$('#rednow').click(
    function () {
        $('body').css('background-color', '#FF4040');
        colorNow = 'red';
        colorChange(colorNow);
        setBackgroundColor(colorNow);
    }
);
$('#yellownow').click(
    function () {
        $('body').css('background-color', '#FCDC3B');
        colorNow = 'yellow';
        colorChange(colorNow);
        setBackgroundColor(colorNow);
    }
);

$('#greennow').click(
    function () {
        $('body').css('background-color', '#A7DA7E');
        colorNow = 'green';
        colorChange(colorNow);
        setBackgroundColor(colorNow);
    }
);

$('#hideit').click (
    function() {
        $('#jitsi').hide();
    }
);

});

});//end jquery closure