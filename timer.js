$(document).ready(function () {
 
var greenchime = true;
var yellowchime = true;
var redchime = true;
var colorWin;
var colorWinOpened = false;
var colorNow = 'default';
var gotvotetimer;
var checksequence = [];
var checkstart;
var checkelapsed;
var nextcheck = 1;
var timer;
var timerstarted = false;
var speeches = [];
var timeNow = 0;
var correction = 0;

function setChecksequence() {
    checksequence = [];
    //semi random sequence up to 8 minutes in seconds, slowing toward the end
    for(i = 5; i < 480; i+= (5 + Math.ceil(Math.random()*10)) ) {
        //next = Math.ceil(Math.random()*(2 * i)) + 1 + next;
        checksequence.push(i);
    }
    console.log(checksequence);
    checkstart = Math.floor(new Date().getTime() / 1000);
    checkelapsed = 0;
    nextcheck = 1;
}

function setTimerViewIntervals(start,green,yellow,red) {
    checksequence = [];
    //semi random sequence up to 8 minutes in seconds, slowing toward the end
    for(i = 5; i < green; i+= (5 + Math.ceil(Math.random()*10)) ) {
        //next = Math.ceil(Math.random()*(2 * i)) + 1 + next;
        checksequence.push(i);
    }
    if(green > 60)
    {
        checksequence.push(green - 5);
        checksequence.push(green);
        checksequence.push(green + 5);
    }
    if(yellow > 60)
    {
        checksequence.push(yellow - 5);
        checksequence.push(yellow);
        checksequence.push(yellow + 5);
    }
    if(red > 60)
    {
        checksequence.push(red - 5);
        checksequence.push(red);
        checksequence.push(red + 5);
    }
    for(i=10; i < 120; i+=5)
        checksequence.push(red + i);
        console.log(checksequence);
        checkstart = Math.floor(start/1000);
        checkelapsed = 0;
        nextcheck = 5;
}

function sendTimerSignal(signal) {
    var view = $('#view').children("option:selected").val();
    if(view != 'timer')
        return;
    var url = jQuery('#seturl').val();
    console.log('send signal to ' + url);
    console.log(signal);
    jQuery.post( url, signal );
}

//timer send
function colorChange(colorNow) {
    var view = $('#view').children("option:selected").val();
    console.log('color change:'+colorNow);
    console.log('elapsed seconds '+checkelapsed);
    console.log(timer.green);
    console.log(timer.yellow);
    console.log(timer.red);
    setBackgroundColor(colorNow);
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

function checkCheck () {
    var view = $('#view').children("option:selected").val();
    if(view != 'normal')
        return;
    var now;
    var nowTime;
    //var checkelapsed;
    //console.log('checkColorChange() '+nextcheck);
    if(!nextcheck)
        {
            console.log('timeout stop');
            stopRefreshReceived();
            return false;
        }
    if((view == 'normal') && !nowTime )
        nowTime = new Date();
    if(timer.startTime)
    {
        console.log('timer.startTime '+timer.startTime.toString());
    }
    else {
        nowTime = new Date();
        now = Math.floor(nowTime.getTime() / 1000);
        console.log('observertime '+ nowTime.toString());
        checkelapsed = now - checkstart;
    }
    //console.log('checkColorChange() start '+checkstart);
    //console.log('checkColorChange() now '+now);
    //console.log('checkColorChange() next '+ nextcheck +' elapsed '+checkelapsed);
    var countdown = nextcheck - checkelapsed;
    console.log('nextcheck/elapsed '+nextcheck+':'+checkelapsed+' checkstart '+checkstart);
    console.log('countdown '+countdown);
    var thirtyplus = nextcheck + 30;
    if(countdown < 0)
    {
        nextcheck = checksequence.shift();
        if(!nextcheck)
            nextcheck = thirtyplus;
    }
    if(checkelapsed == nextcheck) {
        nextcheck = checksequence.shift();
        return true; 
    }
    else {
        console.log('nextcheck/elapsed '+nextcheck+':'+checkelapsed+' checkstart '+checkstart);
        if( (countdown < -60 ) || (countdown > 500) )
            {
                nextcheck = checksequence.shift();
                //console.log('sequence error next '+nextcheck+' elapsed' + checkelapsed);
                if(timerstarted || timer.started) {
                stopRefreshReceived();
                checkelapsed = 0;
                timer.stop();
                timerstarted = false;
                }
                $('#checkstatus').html('timed out');
            }
            else {
                if(timer.started || timerstarted)
                    $('#checkstatus').html('checking in ' + countdown);
                else
                    $('#checkstatus').html('');
                console.log('checking in ' + countdown);                  
            }
            return false;
    }
}

//audience check
function checkColorChange() {
    if(checkCheck())
    {
    console.log('checking at '+checkelapsed);
    //todo - fix this
    var url = jQuery('#seturl').val();
        console.log('get url '+url);
        $.get( url, function( data ) {
        console.log(data);
        console.log('timer started '+timer.started);
        if(data.status && (data.status=='start') )
            {
                if(timerstarted)
                    {
                        console.log('timer already started');
                        return;
                    }
                else {
                $('#smallcounter').text('Timer started');    
                //stopRefreshReceived();
                console.log('start timer');
                $('#green-light').val(data.green);
                $('#yellow-light').val(data.yellow);
                $('#red-light').val(data.red);
                //timer.setStart(data.start);
                //timer.startTime = new Date();
                var ts = Date.parse(data.start);
                /*
                var newstarttime = new Date();
                newstarttime.setTime(ts);
                nowTime = newstarttime;
                */
                timer = new TSTimer(speeches);
                timer.start();
                console.log('timer from server '+data.start);
                console.log('start now set to '+timer.startTime.toTimeString());
                //console.log('start time' + ts);
                correction = Math.round((timer.startTime.getTime() - ts)/1000);
                console.log('correction '+correction);
                setTimerViewIntervals(ts,timer.green,timer.yellow,timer.red);
                timerstarted = true;
                }
            }
        else if(data.status && (data.status=='stop'))
            {
                timestarted = false;
                stopRefreshReceived();
           }
    });

    }
}

 function refreshView() {
     var view = $('#view').children("option:selected").val();
     stopRefreshReceived();
     console.log('switch view: '+view);
     if(view == 'normal')
     {
    if(timer && timer.started)
        window.location.replace(window.location.href);
    timerstarted = false;
    $('iframe').css("height", window.innerHeight - 50);
    $('iframe').css("width", window.innerWidth - 100);
    $('.timer-controls').hide();
    $('#checkcontrols').show();
    setChecksequence();
    gotvotetimer = setInterval(function(){
    checkColorChange();	
    }, 1000);
     }
     else {
    $('#explanation').hide();
    $('#checkcontrols').hide();
    $('iframe').css("height", window.innerHeight - 50);
    $('iframe').css("width", window.innerWidth - 100);
    $('.timer-controls').show();
    timerstarted = false;
        if(gotvotetimer)
           stopRefreshReceived();
     }
     if(timer)
        timer.stop();
} 

function stopRefreshReceived() {
  clearInterval(gotvotetimer);
  if(timer && timer.started)
    {
        timer.resetButton();
    }
  checkelapsed = checkstart = 0;
  console.log('stop timer');
  $('#smallcounter').text('Timer reset');
  $('#checkstatus').text('');
  var view = $('#view').children("option:selected").val();
  if(view == 'normal') {
    setChecksequence();
    gotvotetimer = setInterval(function(){
    checkColorChange();	
    }, 1000);  
  }
}

refreshView(); // initial load
$('#view').change(refreshView);

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
        //setBackgroundColor(colorNow);
    }
);
$('#yellownow').click(
    function () {
        $('body').css('background-color', '#FCDC3B');
        colorNow = 'yellow';
        colorChange(colorNow);
        //setBackgroundColor(colorNow);
    }
);

$('#greennow').click(
    function () {
        $('body').css('background-color', '#A7DA7E');
        colorNow = 'green';
        colorChange(colorNow);
        //setBackgroundColor(colorNow);
    }
);

$('#checknow').click(
    function () {
setChecksequence();
gotvotetimer = setInterval(function(){
checkColorChange();	
}, 1000);
}
);

$('#hideit').click (
    function() {
        $('#jitsi').hide();
    }
);

var TSTimer = (function () {
    function TSTimer(speeches, ts = null) {
        var _this = this;
        this.started = false;
        this.speeches = speeches;
        if(ts) {
            this.startTime = new Date(ts);
            console.log('initialize start time');    
            console.log(this.startTime);
        }
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
            //setBackgroundColor(colorNow);
        }
        correction = 0;
	    if($('#showdigits').is(':checked'))
			$('#trafficlight').text('0:00');
        this.startTime = null;
		greenchime = true;
		yellowchime = true;
        redchime = true;
        checkelapsed = 0;
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
        checkelapsed = elapsedSeconds;
		this.formattedTime = this.formatTime(elapsedSeconds);
		if($('#showdigits').is(':checked'))
			$('#trafficlight').text(this.formattedTime);
		else
			$('#trafficlight').html('<img src="' + $('#stopwatchurl').val() + '" />');
            var view = $('#view').children("option:selected").val();
            if(view == 'timer') {
                $('#smallcounter').text(this.formattedTime);
            }
            else 
                console.log(this.formattedTime);
		if (elapsedSeconds >= this.red) {
            if(colorNow != 'red')
                {
                    colorNow = 'red';
                    colorChange(colorNow);
                    //setBackgroundColor(colorNow);
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
                    //setBackgroundColor(colorNow);
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
                    //setBackgroundColor(colorNow);                    
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
        if(!timeNow)
            {
            timeNow = this.startTime;
            }
        else {
            timeNow = new Date(); //.setTime( timeNow.getTime() + 1000 );
        }
        console.log('time now');
        console.log(timeNow);
        var elapsedSeconds = this.timeDiffInSeconds(this.startTime, timeNow)  + correction;
        this.setElementText(elapsedSeconds);
    };
    
    TSTimer.prototype.timeDiffInSeconds = function (earlyTime, lateTime) {
        //console.log('145');
        //console.log(earlyTime);
        //console.log('147');
        //console.log(lateTime);
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
        if (this.startTime && this.stopTime) {
            var newStartTime = new Date().getTime() - (this.stopTime.getTime() - this.startTime.getTime());
            this.startTime.setTime(newStartTime);
        }
        else
            this.startTime = new Date();
        this.green = this.getSecondsFromTextBox('#green-light');
        this.yellow = this.getSecondsFromTextBox('#yellow-light');
        this.red = this.getSecondsFromTextBox('#red-light');
        var signal = {status: 'start', start: new Date().toString(), green: $('#green-light').val(), yellow: $('#yellow-light').val(),red: $('#red-light').val() };
        sendTimerSignal(signal);
		this.undertime = this.green - 30;
		this.overtime = this.red + 30;
		this.disqualified = true;
        this.timerToken = setInterval(function () {
            return _this.timerEvent();
        }, 1000);
    };

    TSTimer.prototype.stop = function () {
        $('.btnStart').html('Start');
        this.started = false;
        this.stopTime = new Date();
        clearInterval(this.timerToken);
        $('.hidecount').show();
        //$('.nudge').hide();
		if($('#showdigits').is(':checked'))
			$('#trafficlight').text(this.formattedTime);
        var view = $('#view').children("option:selected").val();
        if(view == 'timer') {
    		this.logStopTime();
            $('#smallcounter').text(this.formattedTime);
            sendTimerSignal({status: 'stop'});            
        }
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

    speeches.push(new SpeechType("Standard", "5:00", "6:00", "7:00", "st-standard"));
    speeches.push(new SpeechType("Table&nbsp;Topics", "1:00", "1:30", "2:00", "st-table-topics"));
    speeches.push(new SpeechType("Evaluation", "2:00", "2:30", "3:00", "st-evaluation"));
    speeches.push(new SpeechType("Icebreaker", "4:00", "5:00", "6:00", "st-icebreaker"));
    timer = new TSTimer(speeches);
    timer.setDefault();	
});//end jquery closure