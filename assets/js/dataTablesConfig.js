var table= '';
var searchInitialTable= '';
$(document).ready(function () {
	$('#dataTable').on('init.dt',function() {
        $("#dataTable").removeClass('table-loader').show();
	});
	
	table = $('#dataTable').DataTable({
		"stateSave": true,
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],  
		"responsive": true,
    	"language": {
           "url": absoluteUrl+"lang/dataTableEnglish.json"
       	},
		'columnDefs': [{
		 'targets': 0,
		 'searchable': false,
		 'orderable': false,
		 'className': 'dt-body-center',
		 'render': function (data, type, full, meta){
		     return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
		 }
		}]
	});

	
	// table
	//     .order( [ 3, 'asc' ] )
	//     .draw();


	// table.on('search.dt', function() {
	// 	 table.rows( { filter : 'applied'} ).order([ 3, 'asc' ]).draw();
	// }); 

	$('.reset-datatable-state a').click( function() {
		table.state.clear();
		//window.location.reload();
	});
	// Handle click on checkbox 
	$('#custom-table input[type="checkbox"]').change( function() {
		alert('checked')
	});

	$('#listViewForm').on('submit', function(e) {
		$(".delete-hidden-ids").remove();
		e.preventDefault();
		var form = $(this);
		var actionType = form.data('action');
    	var sourceType = form.data('source');
    	var sourceIdName = form.data('source_id_name');
    	url = baseApiURL+sourceType+'/'+actionType;
		var count = 0;
		// Iterate over all checkboxes in the table
		table.$('input[type="checkbox"]').each(function() {
			// If checkbox is checked
			if(this.checked) {
			   // Create a hidden element 
			   $(form).append(
			      $('<input>')
			         .attr('type', 'hidden')
			         .attr('class', 'delete-hidden-ids')
			         .attr('name', sourceIdName+'[]')
			         .val(this.value)
			   );
			   count++;
			} 
	  	});
		if(count == 0) {
			e.preventDefault();
		} else {
			swal({
			  title: 'Bist du sicher?',
			  text: "Du kannst diesen Vorgang nicht rückgängig machen!",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Ja, lösche es!',
			  cancelButtonText: 'Nein, abbrechen!',
			}).then((result) => {
			  	if (result.value) {
			  		var request = $.ajax({
			            type: 'POST',
			            url: url,
			            headers: {
					       "Authorization" : "Bearer "+token
					    },
			            data: new FormData(this),
			            contentType: false,
			            cache: false,
			            processData:false,
			            beforeSend:function() {
							$.blockUI({ message: '<h4><i class="fa fa-refresh fa-spin"></i> Einen Augenblick...</h4>' }); 

						},
						complete:function(jqXHR, status){
							$.unblockUI();
						}
			        });
			        request.done(function(response) {
			        	function jsUcfirst(string) 
						{
			    			return string.charAt(0).toUpperCase() + string.slice(1);
						}
						var responseData = null;
						try {
							responseData = JSON.parse(response); 
						} catch (e) {
							responseData = response;
						}
						var status = responseData.status;
						switch (status) { 
							case 1: 
								console.log(responseData.message);
								break;
							case 2:
								console.log(responseData.message);
								if(sourceType == 'user') {
									sourceType = 'Benutzer';
								}
								var message = jsUcfirst(sourceType)+ ' erfolgreich gelöscht';
								table.$('input[type="checkbox"]').each(function() {
									if($(this).prop("checked") == true) {
										table.row( $(this).parents('tr') ).remove().draw();
									}
						  		});
								// swal({
								// 	type: 'success',
								// 	title: 'Glückwunsch',
								// 	text: message,
								// });
								break;
							case 3:
								var errorMessage = '';
								for(let key in responseData.content) { 
									errorMessage += `<p>${responseData.content[key]}</p>`;
								}
								swal({
									type: 'error',
									title: 'Hoppla...',
									html: errorMessage,
								}); 
								console.log(errorMessage);
								console.log(responseData.message);
								break;
							case 4: 
								var errorMessage = responseData.message;
								swal({
									type: 'error',
									title: 'Hoppla...',
									html: errorMessage,
								});
								console.log(responseData.message);
								break;
							case 5: 
								var errorMessage = responseData.message;
								swal({
									type: 'error',
									title: 'Hoppla...',
									html: errorMessage,
								});
								console.log(responseData.message);
								break;
							case 6: 
								var errorMessage = responseData.message;
								swal({
									type: 'error',
									title: 'Hoppla...',
									html: errorMessage,
								});
								console.log(responseData.message);
								break;
							default:
								console.log('Unexpected errors');
						}
					});

					request.fail(function(jqXHR, textStatus) {
						var errorData = null;
						try {
						  errorData = JSON.parse(jqXHR); 
						} catch (e) {
						  errorData = jqXHR;
						}
						swal({
							type: 'error',
							title: 'Hoppla...',
							html: errorData,
						});
						console.log("Error : "+errorData);
					});
			   	}  else {
				   	table.$('input[type="checkbox"]').each(function() {
						$(this).prop("checked", false);
			  		});
			   }
			})
		}
		
	});
	
	//for search function during comparison
	var searchInitialTable = $('#search_initial_table').DataTable( {
		searchHighlight: true,
		retrieve: true,
		responsive: true,
		select: true,
		ordering: false 
	});

	var searchInitialAllTable = $('#search_initial_table_all').DataTable( {
		searchHighlight: true,
		retrieve: true,
		responsive: true,
		select: true,
		ordering: false 
	});

	//symptom search details function
	function searchFunctionData(parentRowId, comparison_table_name, comparison_language, search_only_initials, callback){
		var returnArr = {};
		var message = "";
		var error = false;
		//ajax call for datatable result
		$.ajax({
			type: 'POST',
			url: 'get-symptom-search-result-modified.php',
			data: {
				parentRowId: parentRowId,
				comparison_table_name: comparison_table_name,
				comparison_language: comparison_language,
				search_only_initials: search_only_initials
			},
			dataType: "json",
			success: function( response ) {
				if(typeof(response.result_data) != "undefined" && response.result_data !== null) {
					var resultData = null;
					try {
						resultData = JSON.parse(response.result_data); 
					} catch (e) {
						resultData = response.result_data;
					}
					var newRows = [];
					$(resultData).each(function( index ) {
						$(this).each(function( key, value ) {
							var searched_quelle_code = (typeof(value.source_code) != "undefined" && value.source_code !== null && value.source_code != "") ? value.source_code : "";
							var searched_symptom_id = (typeof(value.symptom_id) != "undefined" && value.symptom_id !== null && value.symptom_id != "") ? value.symptom_id : "";
							var searched_display_string = (typeof(value.symptom_string) != "undefined" && value.symptom_string !== null && value.symptom_string != "") ? value.symptom_string : "";
							var dataArr=[searched_quelle_code, searched_display_string, searched_symptom_id, parentRowId];
							newRows.push(dataArr);
						});
					});
					returnArr.searchDetails = newRows;
					returnArr.message = response;
					returnArr.error = error;
					callback(returnArr);
				}
			}
		}).fail(function (response) {
			error = true;
			message = response;
			returnArr.message = message;
			returnArr.error = error;
			callback(returnArr);
		});
		//will return newRows array.
		return returnArr;
	}

	//symptom search only initial from switch
	$('body').on('click','.btn-initial', function(e){
		//search field empty on load
		$('#search_initial_table').DataTable().search('').draw();
		if($("#initial_results_from_search").hasClass("hidden")){
			$("#initial_results_from_search").removeClass("hidden");
			$("#comparing_results_from_search").addClass("hidden");

			searchInitialAllTable.clear().draw();
			var search_only_initials = 1;
			var parentRowId = "";
			console.log(comparison_table_name);
			console.log(comparison_language);
			searchFunctionData(parentRowId, comparison_table_name, comparison_language, search_only_initials, function (result) {
				if(!result.error){
					$.each(result.searchDetails, function(index, row) {
						var newRow = '<tr class="searchedInfoDataTable" data-searched-symptom-id="' + row[2] + '" data-searched-initial-id="' + row[3] + '">' +
										'<td><a href="#"></a>' + row[0] + '</td>' +
										'<td>' + row[1] + '</td>' +
									'</tr>';
						searchInitialAllTable.row.add($(newRow)).draw(); 
					});
					// Focus the search input field
					$('#search_initial_table_all_filter input').focus();
				}else{
					$("#searchResultTbody").html('<div class="symptom-row text-center"><div class="full-length-row">Operation failed.</div></div>');
					console.log( result.message );
				}
			});
		}
	});

	//symptom search only comparing from switch
	$('body').on('click','.btn-comparative', function(e){
		//search field empty on load
		$('#search_initial_table').DataTable().search('').draw();
		$.when().done(function () {
			if($("#comparing_results_from_search").hasClass("hidden")){
				$("#comparing_results_from_search").removeClass("hidden");
				$("#initial_results_from_search").addClass("hidden");
			}
		}).then(function () {
			$('#search_initial_table_filter input').focus();
		});
	});

	// Symptom search icon functions
	$('body').on('click','.symptom-search-btn', function(e){
		$("#populated_info_data").remove();
		$("#symptomInfoModal").modal('hide');
		$("#searchResultTbody").html('<div class="symptom-row text-center"><div class="full-length-row">No records found.</div></div>');
		$("#footnote_modal_loader .loading-msg").removeClass('hidden');
		$("#footnote_modal_loader .error-msg").html('');
		if($("#footnote_modal_loader").hasClass('hidden'))
			$("#footnote_modal_loader").removeClass('hidden');
		$("#symptomSearchModal").modal('show');
		var parentRowId = $(this).parents('div.symptom-row').attr('id');
		$("#initial_search_id").val(parentRowId);
		console.log(parentRowId);
		console.log(comparison_table_name);
		console.log(comparison_language);
		var initialSymptom = $("#"+parentRowId ).find('.symptom').html();
		var initialSymptomInText = $("#"+parentRowId ).find('.symptom').text();
		//search field empty on load
		$('#search_initial_table').DataTable().search('').draw();
		if(initialSymptom != ""){
			if(!$("#search_modal_loader .loading-msg").hasClass('hidden'))
				$("#search_modal_loader .loading-msg").addClass('hidden');
			$("#search_modal_loader .error-msg").html('');

			$("#searchInitialSymptom").html(initialSymptom);
			//$("#searching_symptom").val(initialSymptomInText);
			$("#searching_symptom").val('');

			//new edits
			//clearing out the existing results
			searchInitialTable.clear().draw();
			var search_only_initials = 0;
			searchFunctionData(parentRowId, comparison_table_name, comparison_language, search_only_initials, function (result) {
				if(!result.error){
					$.each(result.searchDetails, function(index, row) {
						var newRow = '<tr class="searchedInfoDataTable" data-searched-symptom-id="' + row[2] + '" data-searched-initial-id="' + row[3] + '">' +
										'<td><a href="#"></a>' + row[0] + '</td>' +
										'<td>' + row[1] + '</td>' +
									'</tr>';
						searchInitialTable.row.add($(newRow)).draw(); 
					});
					setTimeout(function() {
						$('.dataTables_filter input').focus();
					}, 1000); 
					
				}else{
					$("#searchResultTbody").html('<div class="symptom-row text-center"><div class="full-length-row">Operation failed.</div></div>');
					console.log( result.message );
				}
			})
			
		}else{
			$("#search_modal_loader .loading-msg").addClass('hidden');
			$("#search_modal_loader .error-msg").html('Could not find the symptom.');
		}
	});

	// //fetch symptom info from the searched data table during comparison
	$('#search_initial_table tbody').on('dblclick', 'tr', function() {
		var searchedSymptomId = $(this).data('searched-symptom-id'); 
		var searchedInitialId = $(this).data('searched-initial-id'); 
		searchedInitialId = searchedInitialId.replace("row","");
		var initialId = searchedInitialId;
		var comparingSymptomId = searchedSymptomId;
		//not hiding the symptom search modal as it is new requirement
		//$('#symptomSearchModal').modal('hide');
		setTimeout(function() {
			$("#info_modal_loader .loading-msg").removeClass('hidden');
			$("#info_modal_loader .error-msg").html('');
			if($("#info_modal_loader").hasClass('hidden'))
				$("#info_modal_loader").removeClass('hidden');

			$("#populated_info_data").remove();
			$("#symptomInfoModal").modal('show');
			
			$.ajax({
				type: 'POST',
				url: 'get-symptom-info-comparison-table.php',
				data: {
					initial_symptom_id: initialId,
					comparing_symptom_id: comparingSymptomId,
					comparison_table_name: comparison_table_name,
					comparison_language: comparison_language
				},
				dataType: "json",
				success: function( response ) {
					if(response.status == "success"){
						var resultData = null;
						try {
							resultData = JSON.parse(response.result_data); 
						} catch (e) {
							resultData = response.result_data;
						}
						if(!$("#info_modal_loader").hasClass('hidden'))
							$("#info_modal_loader").addClass('hidden');

						var Beschreibung_de = (resultData.Beschreibung_de != "" && resultData.Beschreibung_de != null) ? resultData.Beschreibung_de : "-";
						var Beschreibung_en = (resultData.Beschreibung_en != "" && resultData.Beschreibung_en != null) ? resultData.Beschreibung_en : "-";
						var BeschreibungOriginal_book_format_de = (resultData.BeschreibungOriginal_book_format_de != "" && resultData.BeschreibungOriginal_book_format_de != null) ? resultData.BeschreibungOriginal_book_format_de : "-";
						var BeschreibungOriginal_book_format_en = (resultData.BeschreibungOriginal_book_format_en != "" && resultData.BeschreibungOriginal_book_format_en != null) ? resultData.BeschreibungOriginal_book_format_en : "-";
						var BeschreibungOriginal_de = (resultData.BeschreibungOriginal_de != "" && resultData.BeschreibungOriginal_de != null) ? resultData.BeschreibungOriginal_de : "-";
						var BeschreibungOriginal_en = (resultData.BeschreibungOriginal_en != "" && resultData.BeschreibungOriginal_en != null) ? resultData.BeschreibungOriginal_en : "-";
						var BeschreibungOriginal_with_grading_de = (resultData.BeschreibungOriginal_with_grading_de != "" && resultData.BeschreibungOriginal_with_grading_de != null) ? resultData.BeschreibungOriginal_with_grading_de : "-";
						var BeschreibungOriginal_with_grading_en = (resultData.BeschreibungOriginal_with_grading_en != "" && resultData.BeschreibungOriginal_with_grading_en != null) ? resultData.BeschreibungOriginal_with_grading_en : "-";
						var searchable_text_with_grading_de = (resultData.searchable_text_with_grading_de != "" && resultData.searchable_text_with_grading_de != null) ? resultData.searchable_text_with_grading_de : "-";
						var searchable_text_with_grading_en = (resultData.searchable_text_with_grading_en != "" && resultData.searchable_text_with_grading_en != null) ? resultData.searchable_text_with_grading_en : "-";
						var BeschreibungFull_with_grading_de = (resultData.BeschreibungFull_with_grading_de != "" && resultData.BeschreibungFull_with_grading_de != null) ? resultData.BeschreibungFull_with_grading_de : "-";
						var BeschreibungFull_with_grading_en = (resultData.BeschreibungFull_with_grading_en != "" && resultData.BeschreibungFull_with_grading_en != null) ? resultData.BeschreibungFull_with_grading_en : "-";

						var Fussnote = (resultData.Fussnote != "" && resultData.Fussnote != null) ? resultData.Fussnote : "-";
						var Verweiss = (resultData.Verweiss != "" && resultData.Verweiss != null) ? resultData.Verweiss : "-";
						var Kommentar = (resultData.Kommentar != "" && resultData.Kommentar != null) ? resultData.Kommentar : "-";
						var Remedy = (resultData.Remedy != "" && resultData.Remedy != null) ? resultData.Remedy : "-";
						var symptom_type = (resultData.symptom_type != "" && resultData.symptom_type != null) ? resultData.symptom_type : "-";
						var EntnommenAus = (resultData.EntnommenAus != "" && resultData.EntnommenAus != null) ? resultData.EntnommenAus : "-";
						var Pruefer = (resultData.Pruefer != "" && resultData.Pruefer != null) ? resultData.Pruefer : "-";
						var symptom_of_different_remedy = (resultData.symptom_of_different_remedy != "" && resultData.symptom_of_different_remedy != null) ? resultData.symptom_of_different_remedy : "-";
						var BereichID = (resultData.BereichID != "" && resultData.BereichID != null) ? resultData.BereichID : "-";
						var Unklarheiten = (resultData.Unklarheiten != "" && resultData.Unklarheiten != null) ? resultData.Unklarheiten : "-";
						// Source Data
						var titel = (resultData.titel != "" && resultData.titel != null) ? resultData.titel : "-";
						var code = (resultData.code != "" && resultData.code != null) ? resultData.code : "-";
						var autor_or_herausgeber = (resultData.autor_or_herausgeber != "" && resultData.autor_or_herausgeber != null) ? resultData.autor_or_herausgeber : "-";
						var jahr = (resultData.jahr != "" && resultData.jahr != null) ? resultData.jahr : "-";
						var band = (resultData.band != "" && resultData.band != null) ? resultData.band : "-";
						var auflage = (resultData.auflage != "" && resultData.auflage != null) ? resultData.auflage : "-";
						var source_type = (resultData.source_type != "" && resultData.source_type != null) ? resultData.source_type : "-";
						
						var synonym_word = (resultData.synonym_word != "" && resultData.synonym_word != null) ? resultData.synonym_word : "-";
						var synonym = (resultData.synonym != "" && resultData.synonym != null) ? resultData.synonym : "-";
						var synonym = (resultData.synonym != "" && resultData.synonym != null) ? resultData.synonym : "-";
						var cross_reference = (resultData.cross_reference != "" && resultData.cross_reference != null) ? resultData.cross_reference : "-";
						var synonym_partial_2 = (resultData.synonym_partial_2 != "" && resultData.synonym_partial_2 != null) ? resultData.synonym_partial_2 : "-";
						var generic_term = (resultData.generic_term != "" && resultData.generic_term != null) ? resultData.generic_term : "-";
						var sub_term = (resultData.sub_term != "" && resultData.sub_term != null) ? resultData.sub_term : "-";
						var synonym_nn = (resultData.synonym_nn != "" && resultData.synonym_nn != null) ? resultData.synonym_nn : "-";

						var is_final_version_available = (resultData.is_final_version_available != "" && resultData.is_final_version_available != null) ? resultData.is_final_version_available : 0;
						var fv_con_initial_symptom_de = (resultData.fv_con_initial_symptom_de != "" && resultData.fv_con_initial_symptom_de != null) ? resultData.fv_con_initial_symptom_de : "-";
						var fv_con_initial_symptom_en = (resultData.fv_con_initial_symptom_en != "" && resultData.fv_con_initial_symptom_en != null) ? resultData.fv_con_initial_symptom_en : "-";
						var fv_con_comparative_symptom_de = (resultData.fv_con_comparative_symptom_de != "" && resultData.fv_con_comparative_symptom_de != null) ? resultData.fv_con_comparative_symptom_de : "-";
						var fv_con_comparative_symptom_en = (resultData.fv_con_comparative_symptom_en != "" && resultData.fv_con_comparative_symptom_en != null) ? resultData.fv_con_comparative_symptom_en : "-";
						var fv_symptom_de = (resultData.fv_symptom_de != "" && resultData.fv_symptom_de != null) ? resultData.fv_symptom_de : "-";
						var fv_symptom_en = (resultData.fv_symptom_en != "" && resultData.fv_symptom_en != null) ? resultData.fv_symptom_en : "-";
						
						var fv_con_initial_source_code = (resultData.fv_con_initial_source_code != "" && resultData.fv_con_initial_source_code != null) ? resultData.fv_con_initial_source_code : "-";
						var fv_con_comparative_source_code = (resultData.fv_con_comparative_source_code != "" && resultData.fv_con_comparative_source_code != null) ? resultData.fv_con_comparative_source_code : "-";

						var symptom_number = (resultData.symptom_number != "" && resultData.symptom_number != null) ? resultData.symptom_number : "-";
						var symptom_page = (resultData.symptom_page != "" && resultData.symptom_page != null) ? resultData.symptom_page : "-";
						var original_source_kommentar = (resultData.original_source_kommentar != "" && resultData.original_source_kommentar != null) ? resultData.original_source_kommentar : "-";
						var original_source_potency_of_remedy = (resultData.original_source_potency_of_remedy != "" && resultData.original_source_potency_of_remedy != null) ? resultData.original_source_potency_of_remedy : "-";
						var html = '';
						html += '<div id="populated_info_data">';
						html += '	<div class="row">';
						html += '		<div class="col-sm-12"><h4>Symptominformation</h4></div>';
						html += '	</div>';
						html += '	<div class="row">';
						html += '		<!-- <div class="col-sm-4"><p><b>Imported symptom</b></p></div>';
						html += '		<div class="col-sm-8"><p> '+Beschreibung_de+'</p></div> -->';
						html += '		<div class="col-sm-12"><p><b>Originalsymptom</b></p></div>';
						html += '		<div class="col-sm-4"><p>Deutsch (de)</p></div>';
						html += '		<div class="col-sm-8"><p>'+BeschreibungOriginal_book_format_de+'</p></div>';
						html += '		<div class="col-sm-4"><p>Englisch (en)</p></div>';
						html += '		<div class="col-sm-8"><p>'+BeschreibungOriginal_book_format_en+'</p></div>';
						html += '		<div class="col-sm-12"><p><b>Konvertiertes Symptom</b></p></div>';
						html += '		<div class="col-sm-4"><p>Deutsch (de)</p></div>';
						html += '		<div class="col-sm-8"><p>'+BeschreibungFull_with_grading_de+'</p></div>';
						html += '		<div class="col-sm-4"><p>Englisch (en)</p></div>';
						html += '		<div class="col-sm-8"><p>'+BeschreibungFull_with_grading_en+'</p></div>';
						if(is_final_version_available != 0){
							html += '		<div class="col-sm-4"><p><b>Final version Symptom</b></p></div>';
							html += '		<div class="col-sm-8"><div class="row"><div class="col-sm-6"><p><u>Deutsch (de)</u></p></div><div class="col-sm-6"><p><u>Englisch (en)</u></p></div></div></div>';
							html += '		<div class="col-sm-4">Initial<span class="pull-right">'+fv_con_initial_source_code+'</span></div>';
							html += '		<div class="col-sm-8"><div class="row"><div class="col-sm-6">'+fv_con_initial_symptom_de+'</p></div><div class="col-sm-6"><p>'+fv_con_initial_symptom_en+'</p></div></div></div>';
							html += '		<div class="col-sm-4">Comparative<span class="pull-right">'+fv_con_comparative_source_code+'</span></div>';
							html += '		<div class="col-sm-8"><div class="row"><div class="col-sm-6">'+fv_con_comparative_symptom_de+'</p></div><div class="col-sm-6"><p>'+fv_con_comparative_symptom_en+'</p></div></div></div>';
							html += '		<div class="col-sm-4">Final version</div>';
							html += '		<div class="col-sm-8"><div class="row"><div class="col-sm-6">'+fv_symptom_de+'</p></div><div class="col-sm-6"><p>'+fv_symptom_en+'</p></div></div></div>';
						}
						html += '		<div class="col-sm-4"><p><b>Symptom Type</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+symptom_type+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Arznei</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+Remedy+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Fußnote</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+Fussnote+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Prüfer</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+Pruefer+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Literatur</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+EntnommenAus+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Kapitel</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+BereichID+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Kommentar</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+Kommentar+'</p></div>';
						html += '	</div>';
						html += '	<div class="row">';
						html += '		<div class="col-sm-12"><h4>Synonyms</h4></div>';
						html += '	</div>';
						html += '	<div class="row">';
						html += '		<div class="col-sm-4"><p><b>Synonym Word</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+synonym_word+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Strict Synonym</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+synonym+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Synonym Partial 1</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+cross_reference+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Synonym Partial 2</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+synonym_partial_2+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Synonym General</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+generic_term+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Synonym Minor</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+sub_term+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Synonym NN</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+synonym_nn+'</p></div>';
						html += '	</div>';
						// html += '	<hr>';
						html += '	<div class="row">';
						html += '		<div class="col-sm-12"><h4>Information der Quelle</h4></div>';
						html += '	</div>';
						html += '	<div class="row">';
						html += '		<div class="col-sm-4"><p><b>Titel</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+titel+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Kürzel/Code</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+code+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Autor</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+autor_or_herausgeber+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Jahr</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+jahr+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Band</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+band+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Auflage</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+auflage+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Art der Quelle</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+source_type+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Symptomnummer</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+symptom_number+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Seite</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+symptom_page+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Quelle Kommentar</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+original_source_kommentar+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Potency of remedy</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+original_source_potency_of_remedy+'</p></div>';
						html += '	</div>';
						html += '</div>';
						if ($("#info_container").children("div#populated_info_data").length){
							$("#info_container").children("div#populated_info_data").remove();
						}
						$("#info_container").append(html);

					}else{
						$("#info_modal_loader .loading-msg").addClass('hidden');
						$("#info_modal_loader .error-msg").html('Something went wrong!');
						console.log(response);
					}
				}
			}).fail(function (response) {
				$("#info_modal_loader .loading-msg").addClass('hidden');
				$("#info_modal_loader .error-msg").html('Something went wrong!');
				if ( window.console && window.console.log ) {
					console.log( response );
				}
			});
		}, 1000);
		
	});

	// //fetch symptom info from the searched data table during comparison
	$('#search_initial_table_all tbody').on('click', 'tr', function() {
		var searchedSymptomId = $(this).data('searched-symptom-id'); 
		var searchedInitialId = $(this).data('searched-initial-id'); 
		searchedInitialId = searchedInitialId.replace("row","");
        console.log('Custom Symptom:', searchedSymptomId);
        console.log('Custom Intial:', searchedInitialId);
        console.log('Custom Table:', comparison_table_name);
        console.log('Custom Lang:', comparison_language);
		//return false;
		//var initialId = searchedInitialId;
		var initialId = searchedSymptomId;
		var comparingSymptomId = searchedSymptomId;
		$('#symptomSearchModal').modal('hide');
		setTimeout(function() {
			$("#info_modal_loader .loading-msg").removeClass('hidden');
			$("#info_modal_loader .error-msg").html('');
			if($("#info_modal_loader").hasClass('hidden'))
				$("#info_modal_loader").removeClass('hidden');

			$("#populated_info_data").remove();
			$("#symptomInfoModal").modal('show');
			
			$.ajax({
				type: 'POST',
				url: 'get-symptom-info-comparison-table.php',
				data: {
					initial_symptom_id: initialId,
					comparing_symptom_id: comparingSymptomId,
					comparison_table_name: comparison_table_name,
					comparison_language: comparison_language
				},
				dataType: "json",
				success: function( response ) {
					console.log("fetch info success");
					console.log(response);
					if(response.status == "success"){
						var resultData = null;
						try {
							resultData = JSON.parse(response.result_data); 
						} catch (e) {
							resultData = response.result_data;
						}
						if(!$("#info_modal_loader").hasClass('hidden'))
							$("#info_modal_loader").addClass('hidden');

						var Beschreibung_de = (resultData.Beschreibung_de != "" && resultData.Beschreibung_de != null) ? resultData.Beschreibung_de : "-";
						var Beschreibung_en = (resultData.Beschreibung_en != "" && resultData.Beschreibung_en != null) ? resultData.Beschreibung_en : "-";
						var BeschreibungOriginal_book_format_de = (resultData.BeschreibungOriginal_book_format_de != "" && resultData.BeschreibungOriginal_book_format_de != null) ? resultData.BeschreibungOriginal_book_format_de : "-";
						var BeschreibungOriginal_book_format_en = (resultData.BeschreibungOriginal_book_format_en != "" && resultData.BeschreibungOriginal_book_format_en != null) ? resultData.BeschreibungOriginal_book_format_en : "-";
						var BeschreibungOriginal_de = (resultData.BeschreibungOriginal_de != "" && resultData.BeschreibungOriginal_de != null) ? resultData.BeschreibungOriginal_de : "-";
						var BeschreibungOriginal_en = (resultData.BeschreibungOriginal_en != "" && resultData.BeschreibungOriginal_en != null) ? resultData.BeschreibungOriginal_en : "-";
						var BeschreibungOriginal_with_grading_de = (resultData.BeschreibungOriginal_with_grading_de != "" && resultData.BeschreibungOriginal_with_grading_de != null) ? resultData.BeschreibungOriginal_with_grading_de : "-";
						var BeschreibungOriginal_with_grading_en = (resultData.BeschreibungOriginal_with_grading_en != "" && resultData.BeschreibungOriginal_with_grading_en != null) ? resultData.BeschreibungOriginal_with_grading_en : "-";
						var searchable_text_with_grading_de = (resultData.searchable_text_with_grading_de != "" && resultData.searchable_text_with_grading_de != null) ? resultData.searchable_text_with_grading_de : "-";
						var searchable_text_with_grading_en = (resultData.searchable_text_with_grading_en != "" && resultData.searchable_text_with_grading_en != null) ? resultData.searchable_text_with_grading_en : "-";
						var BeschreibungFull_with_grading_de = (resultData.BeschreibungFull_with_grading_de != "" && resultData.BeschreibungFull_with_grading_de != null) ? resultData.BeschreibungFull_with_grading_de : "-";
						var BeschreibungFull_with_grading_en = (resultData.BeschreibungFull_with_grading_en != "" && resultData.BeschreibungFull_with_grading_en != null) ? resultData.BeschreibungFull_with_grading_en : "-";

						var Fussnote = (resultData.Fussnote != "" && resultData.Fussnote != null) ? resultData.Fussnote : "-";
						var Verweiss = (resultData.Verweiss != "" && resultData.Verweiss != null) ? resultData.Verweiss : "-";
						var Kommentar = (resultData.Kommentar != "" && resultData.Kommentar != null) ? resultData.Kommentar : "-";
						var Remedy = (resultData.Remedy != "" && resultData.Remedy != null) ? resultData.Remedy : "-";
						var symptom_type = (resultData.symptom_type != "" && resultData.symptom_type != null) ? resultData.symptom_type : "-";
						var EntnommenAus = (resultData.EntnommenAus != "" && resultData.EntnommenAus != null) ? resultData.EntnommenAus : "-";
						var Pruefer = (resultData.Pruefer != "" && resultData.Pruefer != null) ? resultData.Pruefer : "-";
						var symptom_of_different_remedy = (resultData.symptom_of_different_remedy != "" && resultData.symptom_of_different_remedy != null) ? resultData.symptom_of_different_remedy : "-";
						var BereichID = (resultData.BereichID != "" && resultData.BereichID != null) ? resultData.BereichID : "-";
						var Unklarheiten = (resultData.Unklarheiten != "" && resultData.Unklarheiten != null) ? resultData.Unklarheiten : "-";
						// Source Data
						var titel = (resultData.titel != "" && resultData.titel != null) ? resultData.titel : "-";
						var code = (resultData.code != "" && resultData.code != null) ? resultData.code : "-";
						var autor_or_herausgeber = (resultData.autor_or_herausgeber != "" && resultData.autor_or_herausgeber != null) ? resultData.autor_or_herausgeber : "-";
						var jahr = (resultData.jahr != "" && resultData.jahr != null) ? resultData.jahr : "-";
						var band = (resultData.band != "" && resultData.band != null) ? resultData.band : "-";
						var auflage = (resultData.auflage != "" && resultData.auflage != null) ? resultData.auflage : "-";
						var source_type = (resultData.source_type != "" && resultData.source_type != null) ? resultData.source_type : "-";
						
						var synonym_word = (resultData.synonym_word != "" && resultData.synonym_word != null) ? resultData.synonym_word : "-";
						var synonym = (resultData.synonym != "" && resultData.synonym != null) ? resultData.synonym : "-";
						var synonym = (resultData.synonym != "" && resultData.synonym != null) ? resultData.synonym : "-";
						var cross_reference = (resultData.cross_reference != "" && resultData.cross_reference != null) ? resultData.cross_reference : "-";
						var synonym_partial_2 = (resultData.synonym_partial_2 != "" && resultData.synonym_partial_2 != null) ? resultData.synonym_partial_2 : "-";
						var generic_term = (resultData.generic_term != "" && resultData.generic_term != null) ? resultData.generic_term : "-";
						var sub_term = (resultData.sub_term != "" && resultData.sub_term != null) ? resultData.sub_term : "-";
						var synonym_nn = (resultData.synonym_nn != "" && resultData.synonym_nn != null) ? resultData.synonym_nn : "-";

						var is_final_version_available = (resultData.is_final_version_available != "" && resultData.is_final_version_available != null) ? resultData.is_final_version_available : 0;
						var fv_con_initial_symptom_de = (resultData.fv_con_initial_symptom_de != "" && resultData.fv_con_initial_symptom_de != null) ? resultData.fv_con_initial_symptom_de : "-";
						var fv_con_initial_symptom_en = (resultData.fv_con_initial_symptom_en != "" && resultData.fv_con_initial_symptom_en != null) ? resultData.fv_con_initial_symptom_en : "-";
						var fv_con_comparative_symptom_de = (resultData.fv_con_comparative_symptom_de != "" && resultData.fv_con_comparative_symptom_de != null) ? resultData.fv_con_comparative_symptom_de : "-";
						var fv_con_comparative_symptom_en = (resultData.fv_con_comparative_symptom_en != "" && resultData.fv_con_comparative_symptom_en != null) ? resultData.fv_con_comparative_symptom_en : "-";
						var fv_symptom_de = (resultData.fv_symptom_de != "" && resultData.fv_symptom_de != null) ? resultData.fv_symptom_de : "-";
						var fv_symptom_en = (resultData.fv_symptom_en != "" && resultData.fv_symptom_en != null) ? resultData.fv_symptom_en : "-";
						
						var fv_con_initial_source_code = (resultData.fv_con_initial_source_code != "" && resultData.fv_con_initial_source_code != null) ? resultData.fv_con_initial_source_code : "-";
						var fv_con_comparative_source_code = (resultData.fv_con_comparative_source_code != "" && resultData.fv_con_comparative_source_code != null) ? resultData.fv_con_comparative_source_code : "-";

						var symptom_number = (resultData.symptom_number != "" && resultData.symptom_number != null) ? resultData.symptom_number : "-";
						var symptom_page = (resultData.symptom_page != "" && resultData.symptom_page != null) ? resultData.symptom_page : "-";
						var original_source_kommentar = (resultData.original_source_kommentar != "" && resultData.original_source_kommentar != null) ? resultData.original_source_kommentar : "-";
						var original_source_potency_of_remedy = (resultData.original_source_potency_of_remedy != "" && resultData.original_source_potency_of_remedy != null) ? resultData.original_source_potency_of_remedy : "-";
						var html = '';
						html += '<div id="populated_info_data">';
						html += '	<div class="row">';
						html += '		<div class="col-sm-12"><h4>Symptominformation</h4></div>';
						html += '	</div>';
						html += '	<div class="row">';
						html += '		<!-- <div class="col-sm-4"><p><b>Imported symptom</b></p></div>';
						html += '		<div class="col-sm-8"><p> '+Beschreibung_de+'</p></div> -->';
						html += '		<div class="col-sm-12"><p><b>Originalsymptom</b></p></div>';
						html += '		<div class="col-sm-4"><p>Deutsch (de)</p></div>';
						html += '		<div class="col-sm-8"><p>'+BeschreibungOriginal_book_format_de+'</p></div>';
						html += '		<div class="col-sm-4"><p>Englisch (en)</p></div>';
						html += '		<div class="col-sm-8"><p>'+BeschreibungOriginal_book_format_en+'</p></div>';
						html += '		<div class="col-sm-12"><p><b>Konvertiertes Symptom</b></p></div>';
						html += '		<div class="col-sm-4"><p>Deutsch (de)</p></div>';
						html += '		<div class="col-sm-8"><p>'+BeschreibungFull_with_grading_de+'</p></div>';
						html += '		<div class="col-sm-4"><p>Englisch (en)</p></div>';
						html += '		<div class="col-sm-8"><p>'+BeschreibungFull_with_grading_en+'</p></div>';
						if(is_final_version_available != 0){
							html += '		<div class="col-sm-4"><p><b>Final version Symptom</b></p></div>';
							html += '		<div class="col-sm-8"><div class="row"><div class="col-sm-6"><p><u>Deutsch (de)</u></p></div><div class="col-sm-6"><p><u>Englisch (en)</u></p></div></div></div>';
							html += '		<div class="col-sm-4">Initial<span class="pull-right">'+fv_con_initial_source_code+'</span></div>';
							html += '		<div class="col-sm-8"><div class="row"><div class="col-sm-6">'+fv_con_initial_symptom_de+'</p></div><div class="col-sm-6"><p>'+fv_con_initial_symptom_en+'</p></div></div></div>';
							html += '		<div class="col-sm-4">Comparative<span class="pull-right">'+fv_con_comparative_source_code+'</span></div>';
							html += '		<div class="col-sm-8"><div class="row"><div class="col-sm-6">'+fv_con_comparative_symptom_de+'</p></div><div class="col-sm-6"><p>'+fv_con_comparative_symptom_en+'</p></div></div></div>';
							html += '		<div class="col-sm-4">Final version</div>';
							html += '		<div class="col-sm-8"><div class="row"><div class="col-sm-6">'+fv_symptom_de+'</p></div><div class="col-sm-6"><p>'+fv_symptom_en+'</p></div></div></div>';
						}
						html += '		<div class="col-sm-4"><p><b>Symptom Type</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+symptom_type+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Arznei</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+Remedy+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Fußnote</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+Fussnote+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Prüfer</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+Pruefer+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Literatur</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+EntnommenAus+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Kapitel</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+BereichID+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Kommentar</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+Kommentar+'</p></div>';
						html += '	</div>';
						html += '	<div class="row">';
						html += '		<div class="col-sm-12"><h4>Synonyms</h4></div>';
						html += '	</div>';
						html += '	<div class="row">';
						html += '		<div class="col-sm-4"><p><b>Synonym Word</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+synonym_word+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Strict Synonym</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+synonym+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Synonym Partial 1</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+cross_reference+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Synonym Partial 2</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+synonym_partial_2+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Synonym General</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+generic_term+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Synonym Minor</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+sub_term+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Synonym NN</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+synonym_nn+'</p></div>';
						html += '	</div>';
						// html += '	<hr>';
						html += '	<div class="row">';
						html += '		<div class="col-sm-12"><h4>Information der Quelle</h4></div>';
						html += '	</div>';
						html += '	<div class="row">';
						html += '		<div class="col-sm-4"><p><b>Titel</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+titel+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Kürzel/Code</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+code+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Autor</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+autor_or_herausgeber+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Jahr</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+jahr+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Band</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+band+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Auflage</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+auflage+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Art der Quelle</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+source_type+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Symptomnummer</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+symptom_number+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Seite</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+symptom_page+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Quelle Kommentar</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+original_source_kommentar+'</p></div>';
						html += '		<div class="col-sm-4"><p><b>Potency of remedy</b></p></div>';
						html += '		<div class="col-sm-8"><p>'+original_source_potency_of_remedy+'</p></div>';
						html += '	</div>';
						html += '</div>';
						if ($("#info_container").children("div#populated_info_data").length){
							$("#info_container").children("div#populated_info_data").remove();
						}
						$("#info_container").append(html);

					}else{
						$("#info_modal_loader .loading-msg").addClass('hidden');
						$("#info_modal_loader .error-msg").html('Something went wrong!');
						console.log("fetch info error");
						console.log(response);
					}
				}
			}).fail(function (response) {
				$("#info_modal_loader .loading-msg").addClass('hidden');
				$("#info_modal_loader .error-msg").html('Something went wrong!');
				if ( window.console && window.console.log ) {
					console.log("fetch info failed");
					console.log( response );
				}
			});
		}, 1000);
		
	});
});