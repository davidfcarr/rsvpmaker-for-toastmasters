(function($) {
	
	$('#default_css').hide();
	
	$("#default_css_show").click(function(){
		$('#default_css').show();
		$("#default_css_show").hide();
	});
	
	$('.speech_update').hide();
		
	$(document).on( 'click', '.nav-tab-wrapper a', function() {
		$('section').hide();
		$('section').eq($(this).index()).show();
		return false;
	});

	$(document).on( 'click', '.edit_speech', function() {
	var slug = $(this).attr('slug');
	$('#'+slug).show();
		return false;
	});

	$(document).on( 'click', '.remove_meta_speech', function() {
	var user_id = $(this).attr('user_id');
	var project = $(this).attr('project');
	$.ajax({
		url: ajaxurl,
		method: 'POST',
		data: {
			'action':'remove_meta_speech',
			'project': project,
			'user_id': user_id
		},
		success:function(data) {
			// This outputs the result of the ajax request
			console.log(data);
			alert('Remove ' + project + ' for user id: ' + user_id);
			location.reload(true);
		},
		error: function(errorThrown){
		    console.log(errorThrown);
		}
	});	  
		return false;
	});

	$(document).on( 'change', '#tm_select_member select', function() {
	var user_id = $('#tm_select_member select').val();
	var member_url = location.href;
	var urlparts = member_url.split('&toastmaster');
	var member_url = urlparts[0] + '&toastmaster=' + user_id;
	location.href = member_url;
	});

	$(document).on( 'change', '#pick_event', function() {
	var post_id = $('#pick_event').val();
	var event_url = location.href;
	var urlparts = event_url.split('&post_id');
	var member_url = urlparts[0] + '&post_id=' + post_id;
	location.href = member_url;
	});
	
	var add_speech_blank = $('form#add_speech_form').html();

	$('form#add_speech_form').submit(function(e) {
		e.preventDefault();
	// This does the ajax request
	
	$.ajax({
		url: ajaxurl,
		method: 'POST',
		data: {
			'action':'add_speech',
			'_manual_meta': $('#_manual_').val(),
			'_project_meta': $('#_project_').val(),
			'_title_meta': $('#title_text').val(),
			'_intro_meta': $('#_intro_').val(),
			'project_year': $('#project_year_add').val(),
			'project_month': $('#project_month_add').val(),
			'project_day': $('#project_day_add').val(),
			'user_id': $('#member').val()
		},
		success:function(data) {
			// This outputs the result of the ajax request
			$('#add_speech_status').html(data);
			$('#add_speech_status').fadeIn(200);
			console.log(data);
			$('form#add_speech_form').html(add_speech_blank);
		},
		error: function(errorThrown){
		    console.log(errorThrown);
		}
	});	  
		return false;
	});

	$('form#add_role_form').submit(function(e) {
		e.preventDefault();
	// This does the ajax request
	
	$.ajax({
		url: ajaxurl,
		method: 'POST',
		data: {
			'action':'add_speech',
			'_role_meta': $('#_role_meta').val(),
			'project_year': $('#role_year_add').val(),
			'project_month': $('#role_month_add').val(),
			'project_day': $('#role_day_add').val(),
			'user_id': $('#member').val()
		},
		success:function(data) {
			// This outputs the result of the ajax request
			$('#add_role_status').html(data);
			$('#add_role_status').fadeIn(200);
			console.log(data);
		},
		error: function(errorThrown){
		    console.log(errorThrown);
		}
	});	  
		return false;
	});

	$('form#edit_member_stats').submit(function(e) {
		e.preventDefault();
	// This does the ajax request
	
	$.ajax({
		url: ajaxurl,
		method: 'POST',
		data: $(this).serialize(),
		success:function(data) {
			// This outputs the result of the ajax request
			console.log(data);
			alert('Saved (reload to see changes on reports)');
		},
		error: function(errorThrown){
		    console.log(errorThrown);
		}
	});	  
		return false;
	});

	$('.increment_stat').click(function() {
	var user_id = $(this).attr('user_id');
	var role = $(this).attr('role');
	var counter = $(this).attr('counter');
	
	$.ajax({
		url: ajaxurl,
		method: 'POST',
		data: {
			'action':'increment_stat',
			'role': role,
			'user_id': user_id
		},
		success:function(data) {
			// This outputs the result of the ajax request
			console.log(data);
			//alert(data);
			$('#increment_stat_result'+counter).html(data);
		},
		error: function(errorThrown){
		    console.log(errorThrown);
		}
	});	  
		
		return false;
	});

$('#add_speech_form').on( "change", ".manual", function() {
	var manual = this.value;
	var target = this.id.replace('manual','project');
	var list = project_list[manual];
	$('#'+target).html('<option value="">Pick a Project</option>' + list);
});

$("#checkAllDelete").click(function(){
    $('#deleterecords input:checkbox').not(this).prop('checked', this.checked);
});

$( document ).on( 'click', '.wptoast-notice .notice-dismiss', function () {
	// Read the "data-notice" information to track which notice
	// is being dismissed and send it via AJAX
	var type = $( this ).closest( '.wptoast-notice' ).data( 'notice' );
	// Make an AJAX call
	// Since WP 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
	$.ajax( ajaxurl,
	  {
		type: 'POST',
		data: {
		  action: 'wptoast_dismissed_notice_handler',
		  type: type,
		}
	  } );
  } );	

$( ".roleplanupdate" ).click(function( event ) {
  event.preventDefault();
var datepost = $(this).attr('datepost');
var takerole = $('#takerole' + datepost + ' option:checked').val();
var was = $('#was' + datepost).val();
var user_id = $('#user_id').val();
	$.ajax( ajaxurl,
	  {
		type: 'POST',
		data: {
		  action: 'wptoast_role_planner_update',
		  datepost: datepost,
		  takerole: takerole,
		  was: was,
		  user_id: user_id,
		}
	  } )
	.done(function( data ) {
		$('#change'+datepost).html(data);
		$('#was' + datepost).val(takerole);
  });
});	
	
})( jQuery );
