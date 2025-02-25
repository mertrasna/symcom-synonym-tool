$(document).ready(function () {
	$('.dropify').dropify({
	    messages: {
	        'default': 'Ziehen Sie eine Datei hierher und klicken Sie auf',
	        'replace': 'Drag & Drop oder Klick zum Ersetzen',
	        'remove':  'Löschen',
	        'error':   'Hoppla, etwas ist passiert.'
	    },
	    error: {
	        'imageFormat': 'Die Datei ist nicht erlaubt ({{ value }} nur).'
    	}
	});
	// extend juery validation rule
	$.extend($.validator.messages, {
		    required: '<i class = "icon-exclamation-sign"></i>'
	});    
	//  multiple select
	$('.select2').select2();

	$('#autor_id').on('select2:select', function (e) {
		var selectedOption = e.params.data;
		var $element = $(this).find('option[value="' + selectedOption.id + '"]');
		
		// Move the selected option to the end of the list
		$element.detach().appendTo(this);
	  });

	  $('#addQuelleForm').on('submit', function (e) {
		// Selected options are updated based on their order
		var selectedOptions = $('#autor_id option:selected');
		selectedOptions.detach().appendTo('#autor_id');
	  });

	//datepicker init
	/* $('#jahr').datepicker(
		{
	  		changeMonth: false,
	        changeYear: true,
	        showButtonPanel: true,
	        yearRange: '1700:2099',
	        dateFormat: 'yy',
	        onClose: function(dateText, inst) { 
	            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
	            $(this).datepicker('setDate', new Date(year, 0, 1));
	        }
		},
		$.datepicker.regional[ "de" ]
	); */
	
	$('.normal-search a').click(function() {
		$(this).hide();
		$('.navbar-custom-menu').hide();
		$('input#navbar-search-input').show();
		$('.closeBtn').show();
	});
	$('.closeBtn').click( function() {
		$(this).hide();
		$('.navbar-custom-menu').show();
		$('input#navbar-search-input').hide();
		$('.normal-search a').show();
	});

	$(document).keydown(function(e) { 
	    if (e.keyCode == 27) { 
	        $("#rowlinkModal").modal('hide');
	    } 
	});

	//datepicker init
	$('#todesjahr, #geburtsjahr').datepicker(
		{
      		changeMonth: true,
			changeYear: true,
			dateFormat: 'dd/mm/yy'
		},
		$.datepicker.regional[ "de" ]
	);

	$('#todesjahr').change(function() {
		if ($('#geburtsjahr').val() !== '' && ($.datepicker.parseDate("dd/mm/yy",$('#geburtsjahr').val()) > $.datepicker.parseDate("dd/mm/yy",$('#todesjahr').val()))) {
			$('#todesjahr').val('');
			$('#geburtsjahr').val('');
			$('#geburtsjahr').focus();
			swal({
			  type: 'error',
			  title: 'Hoppla...',
			  text: 'geburtsjahr kann nicht größer sein als todesjahr'
			});
		}
	});

	$('#geburtsjahr').change(function() {
		if ($('#todesjahr').val() !== '' && ($.datepicker.parseDate("dd/mm/yy",$('#geburtsjahr').val()) > $.datepicker.parseDate("dd/mm/yy",$('#todesjahr').val()))) {
			$('#todesjahr').val('');
			$('#geburtsjahr').val('');
			$('#geburtsjahr').focus();
			swal({
			  type: 'error',
			  title: 'Hoppla...',
			  text: 'geburtsjahr kann nicht größer sein als todesjahr'
			});
		}
	});

	

    $('#rowlinkModal').modal({
        keyboard: true,
        show:false,
        
    }, 5000).on('show.bs.modal', function(event) {
    	var $this = $(this);
    	var url;
    	var type = $(event.relatedTarget).data('type');
    	var modalTitle = $(event.relatedTarget).data('title');
    	if(type == 'autoren') {
    		var autor_id = $(event.relatedTarget).data('id');
    		url = absoluteUrl+'ajax/getModalContent.php?autor_id='+autor_id;
    	} else {
    		var id = $(event.relatedTarget).data('id');
    		url = absoluteUrl+'ajax/getModalContent.php?'+type+'_id='+id;
    	}

    	$.ajax({
		    url: url,
			beforeSend:function() {
				$this.find('.modal-title').html('Loading...');
				var modalLoader = `<div class="overlay" style="height: 150px;">
				              	<i class="fa fa-refresh fa-spin"></i>
				            </div>`;
				$this.find('#rowlinkModalDetails').html(modalLoader);
			}
	    }).done(function(response) {
	      	//console.log(response);
	      	var modalContents = '';
	      	try {
	          	responseData = JSON.parse(response); 
	      	} catch (e) {
	          	responseData = response;
	      	}
	      	if (typeof responseData == 'object') {
				console.log(responseData.non_secure_flag);
				var non_secure_flag_check = responseData.non_secure_flag;
				var source_reference_ns_check = responseData.source_reference_ns;
				var synonym_id = responseData.synonym_id;
				var ns_title_for_synonym = "";
				var ns_title_for_synonym_ref = "";
				var ns_class_for_synonym = "";
				var ns_class_for_synonym_ref = "";
				if(non_secure_flag_check == "1"){
					//ns_title_for_synonym = "Clear";
					ns_class_for_synonym = "ns_bg_color";
				}
				if(source_reference_ns_check =="1"){
					//ns_title_for_synonym_ref = "Clear";
					ns_class_for_synonym_ref = "ns_bg_color";
				}
		      	for(let key in responseData) { 
					if(key != "non_secure_flag" && key != "source_reference_ns" && key != "synonym_id"){
						if(key == "Wort"){
							modalContents += `<div class="row">
								<div class="col-xs-4"><label>${key}:</label></div>
								<div class="col-xs-4 autor-value ${ns_class_for_synonym}">${(responseData[key] == null || responseData[key] == '') ? '-' : responseData[key]}</div>
								<div class="col-xs-4 synonymDoubt" data-synonym-id="${synonym_id}">${ns_title_for_synonym}</div>
							</div>`;
						}else if(key =="References"){
							modalContents += `<div class="row">
								<div class="col-xs-4"><label>${key}:</label></div>
								<div class="col-xs-4 autor-value ${ns_class_for_synonym_ref}">${(responseData[key] == null || responseData[key] == '') ? '-' : responseData[key]}</div>
								<div class="col-xs-4 sourceReferenceDoubt" data-synonym-id="${synonym_id}">${ns_title_for_synonym_ref}</div>
							</div>`;
						}else{
							modalContents += `<div class="row">
								<div class="col-xs-4"><label>${key}:</label></div>
								<div class="col-xs-8 autor-value">${(responseData[key] == null || responseData[key] == '') ? '-' : responseData[key]}</div>
							</div>`;
						}
					}
		        }
		    } else {
		    	modalContents = responseData; 
		    }
	        $this.find('.modal-title').html(modalTitle);
			$this.find('#rowlinkModalDetails').html(modalContents);
			$this.find('.autor-value').each(function () {
	        	if($(this).html() === '-') {
	        		$(this).css( "color", "#A1C180" );
	        	}
			});
		});
    }).on('hidden.bs.modal', function () {
    	$(this).find('#rowlinkModalDetails').html('');
	});

	//check uncheck doubtful synonyms
	$('body').on("click", "#non_secure_flag_check", function (x){
        if($(this).prop("checked") == true) {
			$("#non_secure_flag_check").val("1");
        }else{
			$("#non_secure_flag_check").val("0");
		}
    });

	//check uncheck doubtful synonyms reference
	$('body').on("click", "#source_reference_ns_check", function (x){
        if($(this).prop("checked") == true) {
			$("#source_reference_ns_check").val("1");
        }else{
			$("#source_reference_ns_check").val("0");
		}
    });
});


