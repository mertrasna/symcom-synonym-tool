$(document).ready(function(e){
    $(".content-form").on('submit', function(e) {
    	e.preventDefault();
    	var form = $(this);
    	var url = '';
    	var actionType = form.data('action');
    	var sourceType = form.data('source');

		var selectedOptions = $('#autor_id option:selected');
		selectedOptions.detach().appendTo('#autor_id');

    	if(actionType == 'add') 
    	{
    		url = baseApiURL+sourceType+'/'+actionType;
    		if(sourceType == 'user') 
    		{
    			sourceType = 'Benutzer';
    		}
    		if(sourceType == 'pruefer') 
    		{
    			sourceType = 'Prüfer';
    		}
    	} 
    	else if(actionType == 'update') 
    	{
    		var sourceIdValue = form.data('source_id_value');
    		var sourceIdName = form.data('source_id_name');
			console.log(sourceIdName);
    		if(sourceType == 'user') 
    		{
    			url = baseApiURL+sourceType+'/'+actionType+'?'+sourceIdName+'='+sourceIdValue;
    			sourceType = 'Benutzer';
    		}
    		else if(sourceType == 'pruefer') 
    		{
    			url = baseApiURL+sourceType+'/'+actionType+'?'+sourceIdName+'_id='+sourceIdValue;
    			sourceType = 'Prüfer';
    		} 
    		else 
    		{
    			url = baseApiURL+sourceType+'/'+actionType+'?'+sourceIdName+'_id='+sourceIdValue;
    		}
    	} 
    	else 
    	{
    		url = baseApiURL+sourceType+'/'+actionType;
    	}
		console.log(url);
        if(! form.valid()) return false;
		console.log("Form Data");
		// Assuming 'this' is a reference to your form element
		var formDataVal = new FormData(this);
		console.log(formDataVal);
		// Log the form data to the console
		formDataVal.forEach(function(value, key) {
		console.log(key + ': ' + value);
		});
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
            beforeSend:function(){
				$.blockUI({ message: '<h4><i class="fa fa-refresh fa-spin"></i> Einen Augenblick...</h4>' }); 

			},
			complete:function(jqXHR, status){
				$.unblockUI();
			}
        });

        request.done(function(response) {
			console.log(response);
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
			//console.log(status);
			switch (status) { 
				case 1: 
					console.log(responseData.message);
					break;
				case 2:
					console.log(responseData.content);
					var message = '';
					var alertTitle = '';
					if(actionType == 'add') 
					{
						$("#reset").trigger('click');
						$('.dropify-clear').trigger('click');
						$(".select2").val('').trigger('change');
						message = jsUcfirst(sourceType) + ' erfolgreich erstellt';
					} 
					else if(actionType == 'update') 
					{ 
						message = jsUcfirst(sourceType) +' wurde erfolgreich aktualisiert';
					} 
					else if(actionType == 'change-password') 
					{
						$("#reset").trigger('click');
						message = 'Das Passwort wurde erfolgreich geändert';
					} 
					else if(actionType == 'update-email') 
					{
						message = 'Das Email wurde erfolgreich geändert';
					}
					else if(actionType == 'save-quelle-settings')
					{
						message = 'Erfolgreich gespeichert';
					}
					else if(actionType == 'save')
					{
						message = 'Erfolgreich gespeichert';
					} 
					else 
					{
						message = jsUcfirst(sourceType)+' erfolgreich erstellt';
						alertTitle= '';
					}
					swal({
						type: 'success',
						title: alertTitle,
						text: message,
					}).then((result) => {
						console.log(result)
						if (result.value) {
							if(actionType == 'add' || actionType == 'update'){
								var currentUrl = window.location.href;
								var urlParts = currentUrl.split('/');
								urlParts.pop();
								var modifiedUrl = urlParts.join('/');
								console.log('modifiedUrl ' + modifiedUrl)
								window.location.href = modifiedUrl;
							}
						}
					});;
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
      });
});