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
	      	console.log(response);
	      	var modalContents = '';
	      	try {
	          	responseData = JSON.parse(response); 
	      	} catch (e) {
	          	responseData = response;
	      	}
	      	if (typeof responseData == 'object') {
		      	for(let key in responseData) { 
		        	modalContents += `<div class="row">
						<div class="col-xs-4"><label>${key}:</label></div>
						<div class="col-xs-8 autor-value">${(responseData[key] == null || responseData[key] == '') ? '-' : responseData[key]}</div>
					</div>`;
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
});