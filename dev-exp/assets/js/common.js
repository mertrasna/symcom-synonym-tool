// Import page question popup selectboxes start
$('#import_question_popup_pruefer_ids').select2({
    // options 
    searchInputPlaceholder: 'Search Pruefer...'
});
$('#import_question_popup_remedy_ids').select2({
    // options 
    searchInputPlaceholder: 'Search remedy...'
});
// Import page question popup selectboxes start

// Encoding UTF8 ⇢ base64
function b64EncodeUnicode(str) {
    return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g, function(match, p1) {
        return String.fromCharCode(parseInt(p1, 16))
    }))
}
// b64EncodeUnicode('✓ à la mode') // "4pyTIMOgIGxhIG1vZGU="
// b64EncodeUnicode('\n') // "Cg=="

// Decoding base64 ⇢ UTF8
function b64DecodeUnicode(str) {
    return decodeURIComponent(Array.prototype.map.call(atob(str), function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2)
    }).join(''))
}
// b64DecodeUnicode('4pyTIMOgIGxhIG1vZGU=') // "✓ à la mode"
// b64DecodeUnicode('Cg==') // "\n"


// Translation and connection opening check boxes START 
$('body').on( 'click', '.translation-toggle-btn', function(e) {
	e.preventDefault();
	var uniqueId = $(this).attr("data-unique-id");
	
	if(!$(this).hasClass('active')){
		$(this).addClass('active');
		$("#row_"+uniqueId).find('.table-symptom-hidden').removeClass('hidden');
		if(!$("#row_"+uniqueId).find('.table-original-symptom').hasClass('table-original-symptom-bg'))
			$("#row_"+uniqueId).find('.table-original-symptom').addClass('table-original-symptom-bg');
	}else{
		$(this).removeClass('active');
		if(!$("#row_"+uniqueId).find('.table-symptom-hidden').hasClass('hidden'))
			$("#row_"+uniqueId).find('.table-symptom-hidden').addClass('hidden');
		$("#row_"+uniqueId).find('.table-original-symptom').removeClass('table-original-symptom-bg');

		var is_there_any_initial_open = 0;
		$( ".translation-toggle-btn-initial" ).each(function() {
			if($(this).hasClass('active'))
				is_there_any_initial_open = 1;
		})
		if(is_there_any_initial_open == 0)
			$("#show_all_initial_translation").prop("checked", false);

		var is_there_any_comparative_open = 0;
		$( ".translation-toggle-btn-comparative" ).each(function() {
			if($(this).hasClass('active'))
				is_there_any_comparative_open = 1;
		})
		if(is_there_any_comparative_open == 0)
			$("#show_all_comparative_translation").prop("checked", false);

		var is_there_anything_open = 0;
		$( ".translation-toggle-btn" ).each(function() {
			if($(this).hasClass('active'))
				is_there_anything_open = 1;
		})
		if(is_there_anything_open == 0){
			$("#show_all_translation").prop("checked", false);
			$("#show_all_initial_translation").prop("checked", false);
			$("#show_all_comparative_translation").prop("checked", false);
		}
	}
});


$('body').on( 'change', '#show_all_connections', function(e) {
	var action = "";
	var is_data_found = 0;

	if($(this).prop("checked") == true) {
		action = "check";
	}else{
		action = "uncheck";
	}

	$( ".vbtn-has-connection" ).each(function() {
		is_data_found = 1;
		var isConnectionLoaded = $(this).attr("data-is-connection-loaded");
		if(action == "check"){
			if(isConnectionLoaded != 1)
				$(this).click();	
		}else if(action == "uncheck"){
			if(isConnectionLoaded == 1)
				$(this).click();
		}
	})

	if(is_data_found == 0){
		$(this).prop("checked", false);
	}
});

$('body').on( 'change', '#show_all_translation', function(e) {
	var action = "";
	var is_data_found = 0;

	if($(this).prop("checked") == true) {
		action = "check";
		$("#show_all_initial_translation").prop("checked", true);
		$("#show_all_comparative_translation").prop("checked", true);
	}else{
		action = "uncheck";
		$("#show_all_initial_translation").prop("checked", false);
		$("#show_all_comparative_translation").prop("checked", false);
	}

	$( ".translation-toggle-btn" ).each(function() {
		is_data_found = 1;
		if(action == "check"){
			if(!$(this).hasClass('active'))
				$(this).click();	
		}else if(action == "uncheck"){
			if($(this).hasClass('active'))
				$(this).click();
		}
	})

	if(is_data_found == 0){
		$(this).prop("checked", false);
		$("#show_all_initial_translation").prop("checked", false);
		$("#show_all_comparative_translation").prop("checked", false);
	}
});

$('body').on( 'change', '#show_all_initial_translation', function(e) {
	var action = "";
	var is_data_found = 0;

	if($(this).prop("checked") == true) {
		action = "check";
		if($("#show_all_comparative_translation").prop("checked") == true)
			$("#show_all_translation").prop("checked", true);
	}else{
		action = "uncheck";
		$("#show_all_translation").prop("checked", false);
	}

	$( ".translation-toggle-btn-initial" ).each(function() {
		is_data_found = 1;
		if(action == "check"){
			if(!$(this).hasClass('active'))
				$(this).click();	
		}else if(action == "uncheck"){
			if($(this).hasClass('active'))
				$(this).click();
		}
	})

	var is_there_anything_open = 0;
	$( ".translation-toggle-btn" ).each(function() {
		if($(this).hasClass('active'))
			is_there_anything_open = 1;
	})
	if(is_there_anything_open == 0)
		$("#show_all_translation").prop("checked", false);

	if(is_data_found == 0)
		$(this).prop("checked", false);
});

$('body').on( 'change', '#show_all_comparative_translation', function(e) {
	var action = "";
	var is_data_found = 0;

	if($(this).prop("checked") == true) {
		action = "check";
		if($("#show_all_initial_translation").prop("checked") == true)
			$("#show_all_translation").prop("checked", true);
	}else{
		action = "uncheck";
		$("#show_all_translation").prop("checked", false);
	}

	$( ".translation-toggle-btn-comparative" ).each(function() {
		is_data_found = 1;
		if(action == "check"){
			if(!$(this).hasClass('active'))
				$(this).click();	
		}else if(action == "uncheck"){
			if($(this).hasClass('active'))
				$(this).click();
		}
	})

	var is_there_anything_open = 0;
	$( ".translation-toggle-btn" ).each(function() {
		if($(this).hasClass('active'))
			is_there_anything_open = 1;
	})
	if(is_there_anything_open == 0)
		$("#show_all_translation").prop("checked", false);

	// if(is_data_found == 0)
	// 	$(this).prop("checked", false);
});
// Translation and connection opening check boxes END 

//automatic connection button in comparison page
$("#editor_connection_process").on("click", function(e){
	$("#automaticConnectionConfiguration").modal('show')
});

//automatic connection confirmation button in automatic confirmation modal
$("#automaticConnectionConfirmationBtn").on("click", function(e){
	$("#automaticConnectionConfirmation").modal('hide');
	$("#automaticConnectionConfiguration").modal('show');
});