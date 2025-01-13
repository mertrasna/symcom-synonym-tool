$(document).ready(function(e){
	$(document).on('change', '#global_grading_sets_id', function(){
		$(this).prop('disabled', true);
		$('.save-global-grading-btn').prop('disabled', true);
		var global_grading_sets_id = $(this).val();
		$.blockUI({ message: '<h4><i class="fa fa-refresh fa-spin"></i> Einen Augenblick...</h4>' });
		if(global_grading_sets_id != ""){
			url = baseApiURL+'global-grading-set/view/?global_grading_sets_id='+global_grading_sets_id;

			var request = $.ajax({
	            type: 'GET',
	            url: url,
	            headers: {
			       "Authorization" : "Bearer "+token
			    },
	            data: {},
	            contentType: false,
	            cache: false,
	            processData:false
	        });

	        request.done(function(response) {
	        	// console.log(response);
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
					case 0:
						$.unblockUI();
						$('#global_grading_sets_id').prop('disabled', false);
						// $('.save-global-grading-btn').prop('disabled', false);
						swal({
							type: 'error',
							title: 'Hoppla...',
							html: 'Could not process the operation.',
						});  
						console.log(responseData.message);
						break;
					case 1:
						$.unblockUI();
						$('#global_grading_sets_id').prop('disabled', false);
						// $('.save-global-grading-btn').prop('disabled', false);
						swal({
							type: 'error',
							title: 'Hoppla...',
							html: 'Could not process the operation.',
						});  
						console.log(responseData.message);
						break;
					case 2:
						// console.log(responseData.content);
						var data = null;
						try {
							data = JSON.parse(responseData.content.data); 
						} catch (e) {
							data = responseData.content.data;
						}

						if(typeof data.globalgradingsetvalues !== 'undefined' && data.globalgradingsetvalues !== null && data.globalgradingsetvalues != "") {
							var html = "";
							$.each(data.globalgradingsetvalues, function( key, value ) {
								var formatName = (value.format_name !== null) ? value.format_name : "";
								var formatExample = (value.format_example !== null) ? value.format_example : "-";
								html += '<div class="row">';
								html += '	<div class="col-md-6 col-md-offset-3">';
								html += '		<div class="row">';
								html += '			<div class="col-sm-5">';
								html += '				<div class="form-group">';
								html += '					<label>'+formatName+'</label>';
								html += '					<p>E.g.: '+formatExample+'</p>';
								html += '				</div>';
								html += '			</div>';
								html += '			<div class="col-sm-7">';
								html += '				<div class="form-group">';
								html += '					<select data-active-grade="'+value.format_grade+'" name="format_grade_'+value.global_grading_set_values_id+'" id="format_grade_'+value.global_grading_set_values_id+'" class="form-control global-grade-options">';
								if(value.format_grade == "0")
									html += '						<option selected value="0">0</option>';
								else
									html += '						<option value="0">0</option>';
								if(value.format_grade == "1")
									html += '						<option selected value="1">1</option>';
								else
									html += '						<option value="1">1</option>';
								if(value.format_grade == "1.5")
									html += '						<option selected value="1.5">1½</option>';
								else
									html += '						<option value="1.5">1½</option>';
								if(value.format_grade == "2")
									html += '						<option selected value="2">2</option>';
								else
									html += '						<option value="2">2</option>';
								if(value.format_grade == "2.5")
									html += '						<option selected value="2.5">2½</option>';
								else
									html += '						<option value="2.5">2½</option>';
								if(value.format_grade == "3")
									html += '						<option selected value="3">3</option>';
								else
									html += '						<option value="3">3</option>';
								if(value.format_grade == "3.5")
									html += '						<option selected value="3.5">3½</option>';
								else
									html += '						<option value="3.5">3½</option>';
								if(value.format_grade == "4")
									html += '						<option selected value="4">4</option>';
								else
									html += '						<option value="4">4</option>';
								if(value.format_grade == "4.5")
									html += '						<option selected value="4.5">4½</option>';
								else
									html += '						<option value="4.5">4½</option>';
								if(value.format_grade == "5")
									html += '						<option selected value="5">5</option>';
								else
									html += '						<option value="5">5</option>';
								html += '					</select>';
								if(value.format_grade == "5.5")
									html += '						<option selected value="5.5">5.5</option>';
								else
									html += '						<option value="5.5">5.5</option>';
								html += '					</select>';
								html += '				</div>';
								html += '			</div>';
								html += '		</div>';
								html += '	</div>';
								html += '</div>';
							});
							
						}
						
						$("#format_grade_container").html(html);
						$('#global_grading_sets_id').prop('disabled', false);
						$('.save-global-grading-btn').prop('disabled', false);
						$.unblockUI();
						break;
					case 3:
						$.unblockUI();
						$('#global_grading_sets_id').prop('disabled', false);
						// $('.save-global-grading-btn').prop('disabled', false);
						var errorMessage = responseData.message;
						swal({
							type: 'error',
							title: 'Hoppla...',
							html: errorMessage,
						});
						console.log(responseData.message);
						break;
					case 4:
						$.unblockUI();
						$('#global_grading_sets_id').prop('disabled', false); 
						// $('.save-global-grading-btn').prop('disabled', false);
						var errorMessage = responseData.message;
						// swal({
						// 	type: 'info',
						// 	title: 'Hoppla...',
						// 	html: errorMessage,
						// });
						console.log(responseData.message);
						break;
					case 5:
						$.unblockUI();
						$('#global_grading_sets_id').prop('disabled', false); 
						// $('.save-global-grading-btn').prop('disabled', false);
						var errorMessage = responseData.message;
						swal({
							type: 'error',
							title: 'Hoppla...',
							html: errorMessage,
						});
						console.log(responseData.message);
						break;
					case 6:
						$.unblockUI();
						$('#global_grading_sets_id').prop('disabled', false); 
						// $('.save-global-grading-btn').prop('disabled', false);
						var errorMessage = responseData.message;
						swal({
							type: 'error',
							title: 'Hoppla...',
							html: errorMessage,
						});
						console.log(responseData.message);
						break;
					default:
						$.unblockUI();
						$('#global_grading_sets_id').prop('disabled', false);
						// $('.save-global-grading-btn').prop('disabled', false);
						var errorMessage = responseData.message;
						swal({
							type: 'error',
							title: 'Hoppla...',
							html: errorMessage,
						});
						console.log(responseData.message);
						console.log('Unexpected errors');
						break;
				}
	        });

	        request.fail(function(jqXHR, textStatus) {
	        	$.unblockUI();
				$('#global_grading_sets_id').prop('disabled', false);
				// $('.save-global-grading-btn').prop('disabled', false);
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
		} else {
			$.unblockUI();
			$('#global_grading_sets_id').prop('disabled', false);
			// $('.save-global-grading-btn').prop('disabled', false);
			
		}
	});
	$(document).on('change', '.global-grade-options', function(){
		var activeGrade = $(this).attr("data-active-grade");
		var global_grading_sets_id = $(this).val();
		if(global_grading_sets_id != ""){
			$(this).prop('disabled', true);
			//$('.save-global-grading-btn').prop('disabled', true);
			console.log(activeGrade+" "+global_grading_sets_id);
			$(".global-grade-options[data-active-grade='" + global_grading_sets_id + "']").prop('disabled', true);

			
			$(".global-grade-options[data-active-grade='" + global_grading_sets_id + "']").val(activeGrade);
			$(".global-grade-options[data-active-grade='" + global_grading_sets_id + "']").attr("data-active-grade", activeGrade); 
			$(this).attr("data-active-grade", global_grading_sets_id);

			setTimeout(() => {
				$(".global-grade-options[data-active-grade='" + activeGrade + "']").prop('disabled', false);
				$(this).prop('disabled', false);
			}, 2000);
			// setTimeout(function(e){ 
			// 	$(".global-grade-options[data-active-grade='" + activeGrade + "']").prop('disabled', false);
			// 	$(this).prop('disabled', false);
			// }, 3000);
		}
	});
});