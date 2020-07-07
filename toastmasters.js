jQuery(document).ready(function($) {

$.ajaxSetup({
	headers: {
		'X-WP-Nonce': wpt_rest.nonce,
	}
});

$('.tmsortable').sortable({
  containment: "parent",
  cursor: "move",
  update: function (event, ui) {
  var datastr = 'action=wpt_reorder&reorder_nonce=' + $('#reorder_nonce').val()+'&post_id=' + this.closest('.post_id');// $('#post_id').val();
  //$('#post_id').val();
  var order = $(this).sortable('toArray');
  var assigned = 0;
  var basefield = order[0].replace(/_[0-9]+/,'');
  var field = basefield + '[]';
  var post_id = $('#'+basefield+'post_id').val();
  var datastr = 'action=wpt_reorder&reorder_nonce=' + $('#reorder_nonce').val()+'&post_id=' + post_id;
var arrayLength = order.length;
for (var i = 0; i < arrayLength; i++) {
	assigned = $('#'+order[i]+'_assigned').val();
	if('undefined' !== typeof assigned)
	datastr = datastr + '&' + field +'='+ assigned; 
}
	var id = $(this).prop("id");
	$('#'+id+'_sortresult').text('Working ...');

	jQuery.post(ajaxurl, datastr, function(response) {
	$('#'+id+'_sortresult').html(response);
	$('#'+id+'_sortresult').fadeIn(200);
	});
  }
});
$('.tmsortable').disableSelection();

$("div.role-block").mouseenter(function(){
$(this).css("background-color","#EFEFEF");
});
$("div.role-block").mouseleave(function(){
$(this).css("background-color","white");
});

var menu = $('#cssmenu');
var menuList = menu.find('ul:first');
var listItems = menu.find('li').not('#responsive-tab');

// Create responsive trigger
menuList.prepend('<li id="responsive-tab"><a href="#">Menu</a></li>');

// Toggle menu visibility
menu.on('click', '#responsive-tab', function(){
	listItems.slideToggle('fast');
	listItems.addClass('collapsed');
});

    var sum = 0;
    $('.maxtime').each(function() {
        sum += Number($(this).val());
    });
	var time_limit = 0;
    $('.time_limit').each(function() {
        time_limit += Number($(this).val());
    });
	
	if((time_limit != 0) && (sum > time_limit) )
		{
		$('.time_message').html('Time reserved, all speakers: ' + sum + ' minutes <span style="color:red;">(limit:' + time_limit + ')</span>');
		}
	else if((time_limit != 0) && (sum > 0))
		{
		$('.time_message').html('Time reserved, all speakers: '+sum+' minutes (limit:' + time_limit + ').');
		}
	else if(sum > 0)
		{
		$('.time_message').html('Time reserved, all speakers: '+sum+' minutes.');
		}

$('.recommend_instead').on('click', function(){
	var target = this.value;
	var role = target.replace('_rm','');
	$('#'+target).html('<p>Add a personal note (optional):<br /><textarea rows="3" cols="40" name="editor_suggest_note['+role+']"></textarea></p>');
});

// delegation code? $('.role_data').on('change', '.manual', function(){
$('.editor_assign').on('change', function(){
	var user_id = this.value;
	//alert('user_id '+user_id);
	var id = this.id;
	var parts = id.split('editor_assign');
	var role = parts[1];
	if ( $('input[name="recommend_instead'+role+'"]').is(':checked') ) {return false;}
	$('#_manual_'+role).html(manuals_list);
	$('#_project_'+role).html('<option value="">Pick Manual for Project List</option>');
	$('#title_text'+role).val('');
	$('#_intro_'+role).val('');
	var post_id = $(this).attr('post_id');
	var editor_id = $('#editor_id').val();
	$('#status'+role).html('Saving ... '+role);
	console.log('post_id '+post_id);
	console.log('role '+role);
	if(post_id > 0)
	{
		var data = {
			'action': 'editor_assign',
			'role': role,
			'user_id': user_id,
			'editor_id': editor_id,
			'post_id': post_id
		};
		$.post(wpt_rest.url+'rsvptm/v1/editor_assign', data, function(response) {
			console.log(response);
			if(response.status){
				$('#status'+role).html(response.status);
			}
			if(response.list) {
				var test = $('#_manual_'+role).val();
				if(typeof test !== 'undefined') {
					$('#_manual_'+role).html(response.list);
					$('#_project_'+role).html(response.projects);
					$('#_manualtype_'+role).val(response.type);
				}
				else {
					$('#editone_manual_'+role).html(response.list);
					$('#editone_project_'+role).html(response.projects);
					$('#editone_manualtype_'+role).val(response.type);	
					$('#editone_title_text'+role).val('');
					$('#editone_intro_'+role).val('');
				}
			}
		});
		
	}
});

$('.manual').on('change', function(){
	var manual = this.value;
	var target = this.id.replace('manual','project');
	var list = project_list[manual];
	$('#'+target).html('<option value="">Pick a Project</option>' + list);
});

$('.manualtype').on('change', function(){
	var manualtype = this.value;
	var target = this.id.replace('manualtype','manual');
	var projects_target = this.id.replace('manualtype','project');
	console.log('type '+manualtype);
	console.log('target '+target);
	var current = $('#'+target).val();
	console.log('current '+current);
	$.get(wpt_rest.url+'rsvptm/v1/type_to_manual/'+manualtype, function(data) {
		console.log(data);
		if(data.list) {
			$('#'+target).html(data.list);
			$('#'+projects_target).html(data.projects);
		}
	} );
	//var list = project_list[manual];
	//$('#'+target).html('<option value="">Pick a Project</option>' + list);
});

$('.project').on('change', function(){
	var project = this.value;
	var time_id = this.id.replace('project','maxtime');
	var display_time_id = this.id.replace('project','display_time');
	var time_msg_id = this.id.replace('project','tmsg');
	var time = project_times[project];
	var display_time = display_times[project];
	$('#'+time_id).val(time);
	$('#'+display_time_id).val(display_time);

	if(this.id.indexOf('Backup') > -1)
		return;

    var sum = 0;
    $('.maxtime').each(function() {
        sum += Number($(this).val());
    });
	
	if((time_limit != 0) && (sum > time_limit) )
		{
		$('#' + time_msg_id).html('<span style="color:red">This choice would push the total time required for speeches over the limit set for the agenda (' + time_limit + ' minutes). You may need to speak to club and meeting organizers about adjusting the agenda. You can also manually adjust the Time Required field if you do not need the maximum time specified by the manual.</span>');
		$('.time_message').html('Time reserved, all speakers: ' + sum + ' minutes <span style="color: red;">(limit:' + time_limit + ')</span>.');
		}
	else if((time_limit != 0) && (sum > 0))
		{
		$('.time_message').html('Time reserved, all speakers: '+sum+' minutes (limit:' + time_limit + ').');
		$('#' + time_msg_id).html('');
		}
	else if(sum > 0)
		{
		$('.time_message').html('Time reserved, all speakers: '+sum+' minutes.');
		$('#' + time_msg_id).html('');
		}
});

$('.moremeetings').hide();
$('#showmore').click( function() {
$('.moremeetings').slideDown();
$('#showmore').hide();
});

$( ".tm_edit_detail" ).submit(function( event ) {
 
  // Stop form from submitting normally
  event.preventDefault();
 
  // Get some values from elements on the page:
  var $form = $( this );
  var status = $(this).attr('status');

	data = $form.serialize();
	jQuery.post(ajaxurl, data, function(response) {
	$('#form'+status).html(response);
	$('#delete'+status).html('');
	});
 
});

$( ".delete_tm_detail" ).click(function( event ) {
 
  // Stop form from submitting normally
  event.preventDefault();
 
  // Get some values from elements on the page:
  var key = $(this).attr('key');
  var status = $(this).attr('status');
  var user_id = $('#user_id_'+status).val();

	data = {
     action: "delete_tm_detail",
     user_id: user_id,
	 key: key
	};
	
	jQuery.post(ajaxurl, data, function(response) {
	$('#form'+status).html(response);
	$('#delete'+status).html('');
	});

});

$(document).on('submit', 'form.toastrole', function(event) {
	event.preventDefault();
	var action = $(this).attr('action') + 'tm_ajax=role';
	var formid = $(this).attr('id');
	var data = $(this).serialize();
	
  	$('#'+formid).html('<div style="line-height: 3">Saving ...</div>');
   setTimeout( function () {
         $('#'+formid).addClass('bounce');
      }, 1000);	
	
	jQuery.post(action, data, function(response) {
	$('#'+formid).html(response);       
         $('#'+formid).removeClass('bounce');
       $('#'+formid).css("opacity", '1');
       $('#'+formid).css("display", 'block');
       
         $('#'+formid).addClass('grow');
	});
});

$(document).on('submit', 'form.remove_me_form', function(event) {
	event.preventDefault();
	var action = $(this).attr('action') + 'tm_ajax=remove_role';
	var formid = $(this).attr('id');
	$('#'+formid).hide();
	var signup_id = formid.replace('remove','');
	var data = $(this).serialize();
  	$('#'+signup_id).html('<div style="min-height: 3em;">Removing ...</div>');
	setTimeout( function () {
	 $('#'+signup_id).addClass('bounce');
	}, 1000);	
	jQuery.post(action, data, function(response) {
	$('#'+signup_id).html('<div style="min-height: 3em;">'+response+'</div>');       
         $('#'+signup_id).removeClass('bounce');
       $('#'+signup_id).css("opacity", '1');
       $('#'+signup_id).css("display", 'block');
       
         $('#'+signup_id).addClass('grow');
	});
});

$('.absences').on('change', function(){
	var user_id = this.value;
	if(user_id < 1)
		return;
	var id = this.id;
	var security = $('#toastcode').val();
	var post_id = $('#'+id).attr('post_id');
	var statusid = 'status_absences'+post_id;
	$('#'+statusid).html('Saving ...');
	var editor_id = $('#editor_id').val();
	if(security && (post_id > 0))
	{
		var data = {
			'action': 'editor_absences',
			'user_id': user_id,
			'editor_id': editor_id,
			'security': security,
			'post_id': post_id
		};
		jQuery.post(ajaxurl, data, function(response) {
		console.log(response);
		$('#'+statusid).html(response);
		$('#'+statusid).fadeIn(200);
		});
	}
});	

$('.absences_remove').on('click', function(){
	var user_id = this.value;
	if(user_id < 1)
		return;
	var id = this.id;
	var security = $('#toastcode').val();
	var post_id = $('#'+id).attr('post_id');
	var statusid = 'current_absences'+post_id+user_id;
	$('#'+statusid).html('Saving ...');
	var editor_id = $('#editor_id').val();
	if(security && (post_id > 0))
	{
		var data = {
			'action': 'absences_remove',
			'user_id': user_id,
			'editor_id': editor_id,
			'security': security,
			'post_id': post_id
		};
		jQuery.post(ajaxurl, data, function(response) {
		console.log(response);
		$('#'+statusid).html(response);
		$('#'+statusid).fadeIn(200);
		});
	}
});

$('.edit_one_form').hide();

$('.editonelink').on('click', function(e){
	e.preventDefault();
	var field = $(this).attr('editone');
	$('#editone' + field).show();
	$('#editonewrapper' + field).hide();
	$('#' + field + '_form').hide();
	$('#remove' + field + '_form').hide();
});

$('.agenda_note_editable_editone').hide();

$('.agenda_note_editable_editone_on').on('click', function(e){
	e.preventDefault();
	$('.agenda_note_editable_editone').show();
	$('.agenda_note_editable_editone_wrapper').hide();
	$('.editable_content').hide();
});

$(document).on('submit', 'form.edit_one_form', function(event) {
	event.preventDefault();
	var action = $(this).attr('action') + 'tm_ajax=role';
	var formid = $(this).attr('id');
	var data = $(this).serialize();
	var user_id = $('#'+formid+' .editor_assign').val();
	data = data.concat('&user_id='+user_id);
	console.log(user_id);
	console.log(data);
  	$('#'+formid).html('<div style="line-height: 3">Saving ...</div>');
   setTimeout( function () {
         $('#'+formid).addClass('bounce');
      }, 1000);	
	
	jQuery.post(action, data, function(response) {
	$('#'+formid).html(response);       
         $('#'+formid).removeClass('bounce');
       $('#'+formid).css("opacity", '1');
       $('#'+formid).css("display", 'block');
       
         $('#'+formid).addClass('grow');
	});
});

});