$(document).ready(function(e){
	$(document).on('change', '#quelle_settings_quelle_id', function(){
		$(this).prop('disabled', true);
		$('.save-quelle-settings-btn').prop('disabled', true);
		var quelleId = $(this).val();
		$.blockUI({ message: '<h4><i class="fa fa-refresh fa-spin"></i> Einen Augenblick...</h4>' });
		if(quelleId != ""){
			url = baseApiURL+'quelle/quelle-settings/?quelle_id='+quelleId;

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
						$('#quelle_settings_quelle_id').prop('disabled', false);
						$('.save-quelle-settings-btn').prop('disabled', false);
						swal({
							type: 'error',
							title: 'Hoppla...',
							html: 'Could not process the operation.',
						});  
						console.log(responseData.message);
						break;
					case 1:
						$.unblockUI();
						$('#quelle_settings_quelle_id').prop('disabled', false);
						$('.save-quelle-settings-btn').prop('disabled', false);
						swal({
							type: 'error',
							title: 'Hoppla...',
							html: 'Could not process the operation.',
						});  
						console.log(responseData.message);
						break;
					case 2:
						// console.log(responseData.content);
						var gradingData = null;
						var symptomTypeData = null;
						try {
							gradingData = JSON.parse(responseData.content.data.grading_settings); 
						} catch (e) {
							gradingData = responseData.content.data.grading_settings;
						}
						try {
							symptomTypeData = JSON.parse(responseData.content.data.symptom_type_settings); 
						} catch (e) {
							symptomTypeData = responseData.content.data.symptom_type_settings;
						}
						console.log('gradingData '+gradingData);
						// Grading section start
						(typeof gradingData.normal !== 'undefined' && gradingData.normal !== null && gradingData.normal != "") ? $("#normal option[value='"+gradingData.normal+"']").prop('selected', true) : $("#normal option[value='']").prop('selected', true);
						(typeof gradingData.normal_within_parentheses !== 'undefined' && gradingData.normal_within_parentheses !== null && gradingData.normal_within_parentheses != "") ? $("#normal_within_parentheses option[value='"+gradingData.normal_within_parentheses+"']").prop('selected', true) : $("#normal_within_parentheses option[value='']").prop('selected', true);
						(typeof gradingData.normal_end_with_t !== 'undefined' && gradingData.normal_end_with_t !== null && gradingData.normal_end_with_t != "") ? $("#normal_end_with_t option[value='"+gradingData.normal_end_with_t+"']").prop('selected', true) : $("#normal_end_with_t option[value='']").prop('selected', true);
						(typeof gradingData.normal_end_with_tt !== 'undefined' && gradingData.normal_end_with_tt !== null && gradingData.normal_end_with_tt != "") ? $("#normal_end_with_tt option[value='"+gradingData.normal_end_with_tt+"']").prop('selected', true) : $("#normal_end_with_tt option[value='']").prop('selected', true);
						(typeof gradingData.normal_begin_with_degree !== 'undefined' && gradingData.normal_begin_with_degree !== null && gradingData.normal_begin_with_degree != "") ? $("#normal_begin_with_degree option[value='"+gradingData.normal_begin_with_degree+"']").prop('selected', true) : $("#normal_begin_with_degree option[value='']").prop('selected', true);
						(typeof gradingData.normal_end_with_degree !== 'undefined' && gradingData.normal_end_with_degree !== null && gradingData.normal_end_with_degree != "") ? $("#normal_end_with_degree option[value='"+gradingData.normal_end_with_degree+"']").prop('selected', true) : $("#normal_end_with_degree option[value='']").prop('selected', true);
						(typeof gradingData.normal_begin_with_asterisk !== 'undefined' && gradingData.normal_begin_with_asterisk !== null && gradingData.normal_begin_with_asterisk != "") ? $("#normal_begin_with_asterisk option[value='"+gradingData.normal_begin_with_asterisk+"']").prop('selected', true) : $("#normal_begin_with_asterisk option[value='']").prop('selected', true);
						(typeof gradingData.normal_begin_with_asterisk_end_with_t !== 'undefined' && gradingData.normal_begin_with_asterisk_end_with_t !== null && gradingData.normal_begin_with_asterisk_end_with_t != "") ? $("#normal_begin_with_asterisk_end_with_t option[value='"+gradingData.normal_begin_with_asterisk_end_with_t+"']").prop('selected', true) : $("#normal_begin_with_asterisk_end_with_t option[value='']").prop('selected', true);
						(typeof gradingData.normal_begin_with_asterisk_end_with_tt !== 'undefined' && gradingData.normal_begin_with_asterisk_end_with_tt !== null && gradingData.normal_begin_with_asterisk_end_with_tt != "") ? $("#normal_begin_with_asterisk_end_with_tt option[value='"+gradingData.normal_begin_with_asterisk_end_with_tt+"']").prop('selected', true) : $("#normal_begin_with_asterisk_end_with_tt option[value='']").prop('selected', true);
						(typeof gradingData.normal_begin_with_asterisk_end_with_degree !== 'undefined' && gradingData.normal_begin_with_asterisk_end_with_degree !== null && gradingData.normal_begin_with_asterisk_end_with_degree != "") ? $("#normal_begin_with_asterisk_end_with_degree option[value='"+gradingData.normal_begin_with_asterisk_end_with_degree+"']").prop('selected', true) : $("#normal_begin_with_asterisk_end_with_degree option[value='']").prop('selected', true);
						(typeof gradingData.sperrschrift !== 'undefined' && gradingData.sperrschrift !== null && gradingData.sperrschrift != "") ? $("#sperrschrift option[value='"+gradingData.sperrschrift+"']").prop('selected', true) : $("#sperrschrift option[value='']").prop('selected', true);
						(typeof gradingData.sperrschrift_begin_with_degree !== 'undefined' && gradingData.sperrschrift_begin_with_degree !== null && gradingData.sperrschrift_begin_with_degree != "") ? $("#sperrschrift_begin_with_degree option[value='"+gradingData.sperrschrift_begin_with_degree+"']").prop('selected', true) : $("#sperrschrift_begin_with_degree option[value='']").prop('selected', true);
						(typeof gradingData.sperrschrift_begin_with_asterisk !== 'undefined' && gradingData.sperrschrift_begin_with_asterisk !== null && gradingData.sperrschrift_begin_with_asterisk != "") ? $("#sperrschrift_begin_with_asterisk option[value='"+gradingData.sperrschrift_begin_with_asterisk+"']").prop('selected', true) : $("#sperrschrift_begin_with_asterisk option[value='']").prop('selected', true);
						(typeof gradingData.sperrschrift_bold !== 'undefined' && gradingData.sperrschrift_bold !== null && gradingData.sperrschrift_bold != "") ? $("#sperrschrift_bold option[value='"+gradingData.sperrschrift_bold+"']").prop('selected', true) : $("#sperrschrift_bold option[value='']").prop('selected', true);
						(typeof gradingData.sperrschrift_bold_begin_with_degree !== 'undefined' && gradingData.sperrschrift_bold_begin_with_degree !== null && gradingData.sperrschrift_bold_begin_with_degree != "") ? $("#sperrschrift_bold_begin_with_degree option[value='"+gradingData.sperrschrift_bold_begin_with_degree+"']").prop('selected', true) : $("#sperrschrift_bold_begin_with_degree option[value='']").prop('selected', true);
						(typeof gradingData.sperrschrift_bold_begin_with_asterisk !== 'undefined' && gradingData.sperrschrift_bold_begin_with_asterisk !== null && gradingData.sperrschrift_bold_begin_with_asterisk != "") ? $("#sperrschrift_bold_begin_with_asterisk option[value='"+gradingData.sperrschrift_bold_begin_with_asterisk+"']").prop('selected', true) : $("#sperrschrift_bold_begin_with_asterisk option[value='']").prop('selected', true);
						(typeof gradingData.kursiv !== 'undefined' && gradingData.kursiv !== null && gradingData.kursiv != "") ? $("#kursiv option[value='"+gradingData.kursiv+"']").prop('selected', true) : $("#kursiv option[value='']").prop('selected', true);
						(typeof gradingData.kursiv_end_with_t !== 'undefined' && gradingData.kursiv_end_with_t !== null && gradingData.kursiv_end_with_t != "") ? $("#kursiv_end_with_t option[value='"+gradingData.kursiv_end_with_t+"']").prop('selected', true) : $("#kursiv_end_with_t option[value='']").prop('selected', true);
						(typeof gradingData.kursiv_end_with_tt !== 'undefined' && gradingData.kursiv_end_with_tt !== null && gradingData.kursiv_end_with_tt != "") ? $("#kursiv_end_with_tt option[value='"+gradingData.kursiv_end_with_tt+"']").prop('selected', true) : $("#kursiv_end_with_tt option[value='']").prop('selected', true);
						(typeof gradingData.kursiv_begin_with_degree !== 'undefined' && gradingData.kursiv_begin_with_degree !== null && gradingData.kursiv_begin_with_degree != "") ? $("#kursiv_begin_with_degree option[value='"+gradingData.kursiv_begin_with_degree+"']").prop('selected', true) : $("#kursiv_begin_with_degree option[value='']").prop('selected', true);
						(typeof gradingData.kursiv_end_with_degree !== 'undefined' && gradingData.kursiv_end_with_degree !== null && gradingData.kursiv_end_with_degree != "") ? $("#kursiv_end_with_degree option[value='"+gradingData.kursiv_end_with_degree+"']").prop('selected', true) : $("#kursiv_end_with_degree option[value='']").prop('selected', true);
						(typeof gradingData.kursiv_begin_with_asterisk !== 'undefined' && gradingData.kursiv_begin_with_asterisk !== null && gradingData.kursiv_begin_with_asterisk != "") ? $("#kursiv_begin_with_asterisk option[value='"+gradingData.kursiv_begin_with_asterisk+"']").prop('selected', true) : $("#kursiv_begin_with_asterisk option[value='']").prop('selected', true);
						(typeof gradingData.kursiv_begin_with_asterisk_end_with_t !== 'undefined' && gradingData.kursiv_begin_with_asterisk_end_with_t !== null && gradingData.kursiv_begin_with_asterisk_end_with_t != "") ? $("#kursiv_begin_with_asterisk_end_with_t option[value='"+gradingData.kursiv_begin_with_asterisk_end_with_t+"']").prop('selected', true) : $("#kursiv_begin_with_asterisk_end_with_t option[value='']").prop('selected', true);
						(typeof gradingData.kursiv_begin_with_asterisk_end_with_tt !== 'undefined' && gradingData.kursiv_begin_with_asterisk_end_with_tt !== null && gradingData.kursiv_begin_with_asterisk_end_with_tt != "") ? $("#kursiv_begin_with_asterisk_end_with_tt option[value='"+gradingData.kursiv_begin_with_asterisk_end_with_tt+"']").prop('selected', true) : $("#kursiv_begin_with_asterisk_end_with_tt option[value='']").prop('selected', true);
						(typeof gradingData.kursiv_begin_with_asterisk_end_with_degree !== 'undefined' && gradingData.kursiv_begin_with_asterisk_end_with_degree !== null && gradingData.kursiv_begin_with_asterisk_end_with_degree != "") ? $("#kursiv_begin_with_asterisk_end_with_degree option[value='"+gradingData.kursiv_begin_with_asterisk_end_with_degree+"']").prop('selected', true) : $("#kursiv_begin_with_asterisk_end_with_degree option[value='']").prop('selected', true);
						(typeof gradingData.kursiv_bold !== 'undefined' && gradingData.kursiv_bold !== null && gradingData.kursiv_bold != "") ? $("#kursiv_bold option[value='"+gradingData.kursiv_bold+"']").prop('selected', true) : $("#kursiv_bold option[value='']").prop('selected', true);
						(typeof gradingData.kursiv_bold_begin_with_asterisk_end_with_t !== 'undefined' && gradingData.kursiv_bold_begin_with_asterisk_end_with_t !== null && gradingData.kursiv_bold_begin_with_asterisk_end_with_t != "") ? $("#kursiv_bold_begin_with_asterisk_end_with_t option[value='"+gradingData.kursiv_bold_begin_with_asterisk_end_with_t+"']").prop('selected', true) : $("#kursiv_bold_begin_with_asterisk_end_with_t option[value='']").prop('selected', true);
						(typeof gradingData.kursiv_bold_begin_with_asterisk_end_with_tt !== 'undefined' && gradingData.kursiv_bold_begin_with_asterisk_end_with_tt !== null && gradingData.kursiv_bold_begin_with_asterisk_end_with_tt != "") ? $("#kursiv_bold_begin_with_asterisk_end_with_tt option[value='"+gradingData.kursiv_bold_begin_with_asterisk_end_with_tt+"']").prop('selected', true) : $("#kursiv_bold_begin_with_asterisk_end_with_tt option[value='']").prop('selected', true);
						(typeof gradingData.kursiv_bold_begin_with_degree !== 'undefined' && gradingData.kursiv_bold_begin_with_degree !== null && gradingData.kursiv_bold_begin_with_degree != "") ? $("#kursiv_bold_begin_with_degree option[value='"+gradingData.kursiv_bold_begin_with_degree+"']").prop('selected', true) : $("#kursiv_bold_begin_with_degree option[value='']").prop('selected', true);
						(typeof gradingData.kursiv_bold_begin_with_asterisk !== 'undefined' && gradingData.kursiv_bold_begin_with_asterisk !== null && gradingData.kursiv_bold_begin_with_asterisk != "") ? $("#kursiv_bold_begin_with_asterisk option[value='"+gradingData.kursiv_bold_begin_with_asterisk+"']").prop('selected', true) : $("#kursiv_bold_begin_with_asterisk option[value='']").prop('selected', true);
						(typeof gradingData.kursiv_bold_begin_with_asterisk_end_with_degree !== 'undefined' && gradingData.kursiv_bold_begin_with_asterisk_end_with_degree !== null && gradingData.kursiv_bold_begin_with_asterisk_end_with_degree != "") ? $("#kursiv_bold_begin_with_asterisk_end_with_degree option[value='"+gradingData.kursiv_bold_begin_with_asterisk_end_with_degree+"']").prop('selected', true) : $("#kursiv_bold_begin_with_asterisk_end_with_degree option[value='']").prop('selected', true);
						(typeof gradingData.fett !== 'undefined' && gradingData.fett !== null && gradingData.fett != "") ? $("#fett option[value='"+gradingData.fett+"']").prop('selected', true) : $("#fett option[value='']").prop('selected', true);
						(typeof gradingData.fett_end_with_t !== 'undefined' && gradingData.fett_end_with_t !== null && gradingData.fett_end_with_t != "") ? $("#fett_end_with_t option[value='"+gradingData.fett_end_with_t+"']").prop('selected', true) : $("#fett_end_with_t option[value='']").prop('selected', true);
						(typeof gradingData.fett_end_with_tt !== 'undefined' && gradingData.fett_end_with_tt !== null && gradingData.fett_end_with_tt != "") ? $("#fett_end_with_tt option[value='"+gradingData.fett_end_with_tt+"']").prop('selected', true) : $("#fett_end_with_tt option[value='']").prop('selected', true);
						(typeof gradingData.fett_begin_with_degree !== 'undefined' && gradingData.fett_begin_with_degree !== null && gradingData.fett_begin_with_degree != "") ? $("#fett_begin_with_degree option[value='"+gradingData.fett_begin_with_degree+"']").prop('selected', true) : $("#fett_begin_with_degree option[value='']").prop('selected', true);
						(typeof gradingData.fett_end_with_degree !== 'undefined' && gradingData.fett_end_with_degree !== null && gradingData.fett_end_with_degree != "") ? $("#fett_end_with_degree option[value='"+gradingData.fett_end_with_degree+"']").prop('selected', true) : $("#fett_end_with_degree option[value='']").prop('selected', true);
						(typeof gradingData.fett_begin_with_asterisk !== 'undefined' && gradingData.fett_begin_with_asterisk !== null && gradingData.fett_begin_with_asterisk != "") ? $("#fett_begin_with_asterisk option[value='"+gradingData.fett_begin_with_asterisk+"']").prop('selected', true) : $("#fett_begin_with_asterisk option[value='']").prop('selected', true);
						(typeof gradingData.fett_begin_with_asterisk_end_with_t !== 'undefined' && gradingData.fett_begin_with_asterisk_end_with_t !== null && gradingData.fett_begin_with_asterisk_end_with_t != "") ? $("#fett_begin_with_asterisk_end_with_t option[value='"+gradingData.fett_begin_with_asterisk_end_with_t+"']").prop('selected', true) : $("#fett_begin_with_asterisk_end_with_t option[value='']").prop('selected', true);
						(typeof gradingData.fett_begin_with_asterisk_end_with_tt !== 'undefined' && gradingData.fett_begin_with_asterisk_end_with_tt !== null && gradingData.fett_begin_with_asterisk_end_with_tt != "") ? $("#fett_begin_with_asterisk_end_with_tt option[value='"+gradingData.fett_begin_with_asterisk_end_with_tt+"']").prop('selected', true) : $("#fett_begin_with_asterisk_end_with_tt option[value='']").prop('selected', true);
						(typeof gradingData.fett_begin_with_asterisk_end_with_degree !== 'undefined' && gradingData.fett_begin_with_asterisk_end_with_degree !== null && gradingData.fett_begin_with_asterisk_end_with_degree != "") ? $("#fett_begin_with_asterisk_end_with_degree option[value='"+gradingData.fett_begin_with_asterisk_end_with_degree+"']").prop('selected', true) : $("#fett_begin_with_asterisk_end_with_degree option[value='']").prop('selected', true);
						(typeof gradingData.fett_converted_spaced !== 'undefined' && gradingData.fett_converted_spaced !== null && gradingData.fett_converted_spaced != "") ? $("#fett_converted_spaced option[value='"+gradingData.fett_converted_spaced+"']").prop('selected', true) : $("#fett_converted_spaced option[value='']").prop('selected', true);
						(typeof gradingData.fett_converted_spaced_degree_at_beginning !== 'undefined' && gradingData.fett_converted_spaced_degree_at_beginning !== null && gradingData.fett_converted_spaced_degree_at_beginning != "") ? $("#fett_converted_spaced_degree_at_beginning option[value='"+gradingData.fett_converted_spaced_degree_at_beginning+"']").prop('selected', true) : $("#fett_converted_spaced_degree_at_beginning option[value='']").prop('selected', true);
						(typeof gradingData.fett_converted_spaced_asterisk_at_beginning !== 'undefined' && gradingData.fett_converted_spaced_asterisk_at_beginning !== null && gradingData.fett_converted_spaced_asterisk_at_beginning != "") ? $("#fett_converted_spaced_asterisk_at_beginning option[value='"+gradingData.fett_converted_spaced_asterisk_at_beginning+"']").prop('selected', true) : $("#fett_converted_spaced_asterisk_at_beginning option[value='']").prop('selected', true);
						
						
						
						(typeof gradingData.gross !== 'undefined' && gradingData.gross !== null && gradingData.gross != "") ? $("#gross option[value='"+gradingData.gross+"']").prop('selected', true) : $("#gross option[value='']").prop('selected', true);
						(typeof gradingData.gross_begin_with_degree !== 'undefined' && gradingData.gross_begin_with_degree !== null && gradingData.gross_begin_with_degree != "") ? $("#gross_begin_with_degree option[value='"+gradingData.gross_begin_with_degree+"']").prop('selected', true) : $("#gross_begin_with_degree option[value='']").prop('selected', true);
						(typeof gradingData.gross_begin_with_asterisk !== 'undefined' && gradingData.gross_begin_with_asterisk !== null && gradingData.gross_begin_with_asterisk != "") ? $("#gross_begin_with_asterisk option[value='"+gradingData.gross_begin_with_asterisk+"']").prop('selected', true) : $("#gross_begin_with_asterisk option[value='']").prop('selected', true);
						(typeof gradingData.gross_bold !== 'undefined' && gradingData.gross_bold !== null && gradingData.gross_bold != "") ? $("#gross_bold option[value='"+gradingData.gross_bold+"']").prop('selected', true) : $("#gross_bold option[value='']").prop('selected', true);
						(typeof gradingData.gross_bold_begin_with_degree !== 'undefined' && gradingData.gross_bold_begin_with_degree !== null && gradingData.gross_bold_begin_with_degree != "") ? $("#gross_bold_begin_with_degree option[value='"+gradingData.gross_bold_begin_with_degree+"']").prop('selected', true) : $("#gross_bold_begin_with_degree option[value='']").prop('selected', true);
						(typeof gradingData.gross_bold_begin_with_asterisk !== 'undefined' && gradingData.gross_bold_begin_with_asterisk !== null && gradingData.gross_bold_begin_with_asterisk != "") ? $("#gross_bold_begin_with_asterisk option[value='"+gradingData.gross_bold_begin_with_asterisk+"']").prop('selected', true) : $("#gross_bold_begin_with_asterisk option[value='']").prop('selected', true);
						(typeof gradingData.pi_sign !== 'undefined' && gradingData.pi_sign !== null && gradingData.pi_sign != "") ? $("#pi_sign option[value='"+gradingData.pi_sign+"']").prop('selected', true) : $("#pi_sign option[value='']").prop('selected', true);
						(typeof gradingData.one_bar !== 'undefined' && gradingData.one_bar !== null && gradingData.one_bar != "") ? $("#one_bar option[value='"+gradingData.one_bar+"']").prop('selected', true) : $("#one_bar option[value='']").prop('selected', true);
						(typeof gradingData.two_bar !== 'undefined' && gradingData.two_bar !== null && gradingData.two_bar != "") ? $("#two_bar option[value='"+gradingData.two_bar+"']").prop('selected', true) : $("#two_bar option[value='']").prop('selected', true);
						(typeof gradingData.three_bar !== 'undefined' && gradingData.three_bar !== null && gradingData.three_bar != "") ? $("#three_bar option[value='"+gradingData.three_bar+"']").prop('selected', true) : $("#three_bar option[value='']").prop('selected', true);
						(typeof gradingData.three_and_half_bar !== 'undefined' && gradingData.three_and_half_bar !== null && gradingData.three_and_half_bar != "") ? $("#three_and_half_bar option[value='"+gradingData.three_and_half_bar+"']").prop('selected', true) : $("#three_and_half_bar option[value='']").prop('selected', true);
						(typeof gradingData.four_bar !== 'undefined' && gradingData.four_bar !== null && gradingData.four_bar != "") ? $("#four_bar option[value='"+gradingData.four_bar+"']").prop('selected', true) : $("#four_bar option[value='']").prop('selected', true);
						(typeof gradingData.four_and_half_bar !== 'undefined' && gradingData.four_and_half_bar !== null && gradingData.four_and_half_bar != "") ? $("#four_and_half_bar option[value='"+gradingData.four_and_half_bar+"']").prop('selected', true) : $("#four_and_half_bar option[value='']").prop('selected', true);
						(typeof gradingData.five_bar !== 'undefined' && gradingData.five_bar !== null && gradingData.five_bar != "") ? $("#five_bar option[value='"+gradingData.five_bar+"']").prop('selected', true) : $("#five_bar option[value='']").prop('selected', true);
						// Grading section end
						
						// Symptom type section start
						(typeof symptomTypeData.symptom_type_for_whole !== 'undefined' && symptomTypeData.symptom_type_for_whole !== null && symptomTypeData.symptom_type_for_whole != "") ? $("#symptom_type_for_whole option[value='"+symptomTypeData.symptom_type_for_whole+"']").prop('selected', true) : $("#symptom_type_for_whole option[value='']").prop('selected', true);
						(typeof symptomTypeData.symptoms_with_reference !== 'undefined' && symptomTypeData.symptoms_with_reference !== null && symptomTypeData.symptoms_with_reference != "") ? $("#symptoms_with_reference option[value='"+symptomTypeData.symptoms_with_reference+"']").prop('selected', true) : $("#symptoms_with_reference option[value='']").prop('selected', true);
						(typeof symptomTypeData.symptoms_without_reference !== 'undefined' && symptomTypeData.symptoms_without_reference !== null && symptomTypeData.symptoms_without_reference != "") ? $("#symptoms_without_reference option[value='"+symptomTypeData.symptoms_without_reference+"']").prop('selected', true) : $("#symptoms_without_reference option[value='']").prop('selected', true);
						(typeof symptomTypeData.symptoms_with_provers !== 'undefined' && symptomTypeData.symptoms_with_provers !== null && symptomTypeData.symptoms_with_provers != "") ? $("#symptoms_with_provers option[value='"+symptomTypeData.symptoms_with_provers+"']").prop('selected', true) : $("#symptoms_with_provers option[value='']").prop('selected', true);
						(typeof symptomTypeData.symptoms_without_provers !== 'undefined' && symptomTypeData.symptoms_without_provers !== null && symptomTypeData.symptoms_without_provers != "") ? $("#symptoms_without_provers option[value='"+symptomTypeData.symptoms_without_provers+"']").prop('selected', true) : $("#symptoms_without_provers option[value='']").prop('selected', true);
						(typeof symptomTypeData.symptom_with_A_f_d_H !== 'undefined' && symptomTypeData.symptom_with_A_f_d_H !== null && symptomTypeData.symptom_with_A_f_d_H != "") ? $("#symptom_with_A_f_d_H option[value='"+symptomTypeData.symptom_with_A_f_d_H+"']").prop('selected', true) : $("#symptom_with_A_f_d_H option[value='']").prop('selected', true);
						(typeof symptomTypeData.symptom_with_degree !== 'undefined' && symptomTypeData.symptom_with_degree !== null && symptomTypeData.symptom_with_degree != "") ? $("#symptom_with_degree option[value='"+symptomTypeData.symptom_with_degree+"']").prop('selected', true) : $("#symptom_with_degree option[value='']").prop('selected', true);
						(typeof symptomTypeData.symptom_with_singlet !== 'undefined' && symptomTypeData.symptom_with_singlet !== null && symptomTypeData.symptom_with_singlet != "") ? $("#symptom_with_singlet option[value='"+symptomTypeData.symptom_with_singlet+"']").prop('selected', true) : $("#symptom_with_singlet option[value='']").prop('selected', true);
						(typeof symptomTypeData.symptom_with_doublet !== 'undefined' && symptomTypeData.symptom_with_doublet !== null && symptomTypeData.symptom_with_doublet != "") ? $("#symptom_with_doublet option[value='"+symptomTypeData.symptom_with_doublet+"']").prop('selected', true) : $("#symptom_with_doublet option[value='']").prop('selected', true);

						//origins
						(typeof symptomTypeData.symptom_type_for_whole_origin !== 'undefined' && symptomTypeData.symptom_type_for_whole_origin !== null && symptomTypeData.symptom_type_for_whole_origin != "") ? $("#symptom_type_for_whole_origin option[value='"+symptomTypeData.symptom_type_for_whole_origin+"']").prop('selected', true) : $("#symptom_type_for_whole_origin option[value='']").prop('selected', true);
						(typeof symptomTypeData.symptoms_with_reference_origin !== 'undefined' && symptomTypeData.symptoms_with_reference_origin !== null && symptomTypeData.symptoms_with_reference_origin != "") ? $("#symptoms_with_reference_origin option[value='"+symptomTypeData.symptoms_with_reference_origin+"']").prop('selected', true) : $("#symptoms_with_reference_origin option[value='']").prop('selected', true);
						(typeof symptomTypeData.symptoms_without_reference_origin !== 'undefined' && symptomTypeData.symptoms_without_reference_origin !== null && symptomTypeData.symptoms_without_reference_origin != "") ? $("#symptoms_without_reference_origin option[value='"+symptomTypeData.symptoms_without_reference_origin+"']").prop('selected', true) : $("#symptoms_without_reference_origin option[value='']").prop('selected', true);
						(typeof symptomTypeData.symptoms_with_provers_origin !== 'undefined' && symptomTypeData.symptoms_with_provers_origin !== null && symptomTypeData.symptoms_with_provers_origin != "") ? $("#symptoms_with_provers_origin option[value='"+symptomTypeData.symptoms_with_provers_origin+"']").prop('selected', true) : $("#symptoms_with_provers_origin option[value='']").prop('selected', true);
						(typeof symptomTypeData.symptoms_without_provers_origin !== 'undefined' && symptomTypeData.symptoms_without_provers_origin !== null && symptomTypeData.symptoms_without_provers_origin != "") ? $("#symptoms_without_provers_origin option[value='"+symptomTypeData.symptoms_without_provers_origin+"']").prop('selected', true) : $("#symptoms_without_provers_origin option[value='']").prop('selected', true);
						(typeof symptomTypeData.symptom_with_A_f_d_H_origin !== 'undefined' && symptomTypeData.symptom_with_A_f_d_H_origin !== null && symptomTypeData.symptom_with_A_f_d_H_origin != "") ? $("#symptom_with_A_f_d_H_origin option[value='"+symptomTypeData.symptom_with_A_f_d_H_origin+"']").prop('selected', true) : $("#symptom_with_A_f_d_H_origin option[value='']").prop('selected', true);
						(typeof symptomTypeData.symptom_with_degree_origin !== 'undefined' && symptomTypeData.symptom_with_degree_origin !== null && symptomTypeData.symptom_with_degree_origin != "") ? $("#symptom_with_degree_origin option[value='"+symptomTypeData.symptom_with_degree_origin+"']").prop('selected', true) : $("#symptom_with_degree_origin option[value='']").prop('selected', true);
						(typeof symptomTypeData.symptom_with_singlet_origin !== 'undefined' && symptomTypeData.symptom_with_singlet_origin !== null && symptomTypeData.symptom_with_singlet_origin != "") ? $("#symptom_with_singlet_origin option[value='"+symptomTypeData.symptom_with_singlet_origin+"']").prop('selected', true) : $("#symptom_with_singlet_origin option[value='']").prop('selected', true);
						(typeof symptomTypeData.symptom_with_doublet_origin !== 'undefined' && symptomTypeData.symptom_with_doublet_origin !== null && symptomTypeData.symptom_with_doublet_origin != "") ? $("#symptom_with_doublet_origin option[value='"+symptomTypeData.symptom_with_doublet_origin+"']").prop('selected', true) : $("#symptom_with_doublet_origin option[value='']").prop('selected', true);
						// Symptom type section end
						
						$('#quelle_settings_quelle_id').prop('disabled', false);
						$('.save-quelle-settings-btn').prop('disabled', false);
						$.unblockUI();
						break;
					case 3:
						$.unblockUI();
						$('#quelle_settings_quelle_id').prop('disabled', false);
						$('.save-quelle-settings-btn').prop('disabled', false);
						var errorMessage = responseData.message;
						swal({
							type: 'error',
							title: 'Hoppla...',
							html: errorMessage,
						});
						console.log(responseData.message);
						break;
					case 4:
						// Grading section start
						$("#normal option[value='']").prop('selected', true);
						$("#normal_within_parentheses option[value='']").prop('selected', true);
						$("#normal_end_with_t option[value='']").prop('selected', true);
						$("#normal_end_with_tt option[value='']").prop('selected', true);
						$("#normal_begin_with_degree option[value='']").prop('selected', true);
						$("#normal_end_with_degree option[value='']").prop('selected', true);
						$("#normal_begin_with_asterisk option[value='']").prop('selected', true);
						$("#normal_begin_with_asterisk_end_with_t option[value='']").prop('selected', true);
						$("#normal_begin_with_asterisk_end_with_tt option[value='']").prop('selected', true);
						$("#normal_begin_with_asterisk_end_with_degree option[value='']").prop('selected', true);
						$("#sperrschrift option[value='']").prop('selected', true);
						$("#sperrschrift_begin_with_degree option[value='']").prop('selected', true);
						$("#sperrschrift_begin_with_asterisk option[value='']").prop('selected', true);
						$("#sperrschrift_bold option[value='']").prop('selected', true);
						$("#sperrschrift_bold_begin_with_degree option[value='']").prop('selected', true);
						$("#sperrschrift_bold_begin_with_asterisk option[value='']").prop('selected', true);
						$("#kursiv option[value='']").prop('selected', true);
						$("#kursiv_end_with_t option[value='']").prop('selected', true);
						$("#kursiv_end_with_tt option[value='']").prop('selected', true);
						$("#kursiv_begin_with_degree option[value='']").prop('selected', true);
						$("#kursiv_end_with_degree option[value='']").prop('selected', true);
						$("#kursiv_begin_with_asterisk option[value='']").prop('selected', true);
						$("#kursiv_begin_with_asterisk_end_with_t option[value='']").prop('selected', true);
						$("#kursiv_begin_with_asterisk_end_with_tt option[value='']").prop('selected', true);
						$("#kursiv_begin_with_asterisk_end_with_degree option[value='']").prop('selected', true);
						$("#kursiv_bold option[value='']").prop('selected', true);
						$("#kursiv_bold_begin_with_asterisk_end_with_t option[value='']").prop('selected', true);
						$("#kursiv_bold_begin_with_asterisk_end_with_tt option[value='']").prop('selected', true);
						$("#kursiv_bold_begin_with_degree option[value='']").prop('selected', true);
						$("#kursiv_bold_begin_with_asterisk option[value='']").prop('selected', true);
						$("#kursiv_bold_begin_with_asterisk_end_with_degree option[value='']").prop('selected', true);
						$("#fett option[value='']").prop('selected', true);
						$("#fett_end_with_t option[value='']").prop('selected', true);
						$("#fett_end_with_tt option[value='']").prop('selected', true);
						$("#fett_begin_with_degree option[value='']").prop('selected', true);
						$("#fett_end_with_degree option[value='']").prop('selected', true);
						$("#fett_begin_with_asterisk option[value='']").prop('selected', true);
						$("#fett_begin_with_asterisk_end_with_t option[value='']").prop('selected', true);
						$("#fett_begin_with_asterisk_end_with_tt option[value='']").prop('selected', true);
						$("#fett_begin_with_asterisk_end_with_degree option[value='']").prop('selected', true);
						$("#gross option[value='']").prop('selected', true);
						$("#gross_begin_with_degree option[value='']").prop('selected', true);
						$("#gross_begin_with_asterisk option[value='']").prop('selected', true);
						$("#gross_bold option[value='']").prop('selected', true);
						$("#gross_bold_begin_with_degree option[value='']").prop('selected', true);
						$("#gross_bold_begin_with_asterisk option[value='']").prop('selected', true);
						$("#pi_sign option[value='']").prop('selected', true);
						$("#one_bar option[value='']").prop('selected', true);
						$("#two_bar option[value='']").prop('selected', true);
						$("#three_bar option[value='']").prop('selected', true);
						$("#three_and_half_bar option[value='']").prop('selected', true);
						$("#four_bar option[value='']").prop('selected', true);
						$("#four_and_half_bar option[value='']").prop('selected', true);
						$("#five_bar option[value='']").prop('selected', true);
						// Grading section end
						
						// Symptom type section start
						$("#symptom_type_for_whole option[value='']").prop('selected', true);
						$("#symptoms_with_reference option[value='']").prop('selected', true);
						$("#symptoms_without_reference option[value='']").prop('selected', true);
						$("#symptoms_with_provers option[value='']").prop('selected', true);
						$("#symptoms_without_provers option[value='']").prop('selected', true);
						$("#symptom_with_A_f_d_H option[value='']").prop('selected', true);
						$("#symptom_with_degree option[value='']").prop('selected', true);
						$("#symptom_with_singlet option[value='']").prop('selected', true);
						$("#symptom_with_doublet option[value='']").prop('selected', true);
						$("#symptom_type_for_whole_origin option[value='']").prop('selected', true);
						$("#symptoms_with_reference_origin option[value='']").prop('selected', true);
						$("#symptoms_without_reference_origin option[value='']").prop('selected', true);
						$("#symptoms_with_provers_origin option[value='']").prop('selected', true);
						$("#symptoms_without_provers_origin option[value='']").prop('selected', true);
						$("#symptom_with_A_f_d_H_origin option[value='']").prop('selected', true);
						$("#symptom_with_degree_origin option[value='']").prop('selected', true);
						$("#symptom_with_singlet_origin option[value='']").prop('selected', true);
						$("#symptom_with_doublet_origin option[value='']").prop('selected', true);
						// Symptom type section end

						$.unblockUI();
						$('#quelle_settings_quelle_id').prop('disabled', false); 
						$('.save-quelle-settings-btn').prop('disabled', false);
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
						$('#quelle_settings_quelle_id').prop('disabled', false); 
						$('.save-quelle-settings-btn').prop('disabled', false);
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
						$('#quelle_settings_quelle_id').prop('disabled', false); 
						$('.save-quelle-settings-btn').prop('disabled', false);
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
						$('#quelle_settings_quelle_id').prop('disabled', false);
						$('.save-quelle-settings-btn').prop('disabled', false);
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
				$('#quelle_settings_quelle_id').prop('disabled', false);
				$('.save-quelle-settings-btn').prop('disabled', false);
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
			// Grading section start
			$("#normal option[value='']").prop('selected', true);
			$("#normal_within_parentheses option[value='']").prop('selected', true);
			$("#normal_end_with_t option[value='']").prop('selected', true);
			$("#normal_end_with_tt option[value='']").prop('selected', true);
			$("#normal_begin_with_degree option[value='']").prop('selected', true);
			$("#normal_end_with_degree option[value='']").prop('selected', true);
			$("#normal_begin_with_asterisk option[value='']").prop('selected', true);
			$("#normal_begin_with_asterisk_end_with_t option[value='']").prop('selected', true);
			$("#normal_begin_with_asterisk_end_with_tt option[value='']").prop('selected', true);
			$("#normal_begin_with_asterisk_end_with_degree option[value='']").prop('selected', true);
			$("#sperrschrift option[value='']").prop('selected', true);
			$("#sperrschrift_begin_with_degree option[value='']").prop('selected', true);
			$("#sperrschrift_begin_with_asterisk option[value='']").prop('selected', true);
			$("#sperrschrift_bold option[value='']").prop('selected', true);
			$("#sperrschrift_bold_begin_with_degree option[value='']").prop('selected', true);
			$("#sperrschrift_bold_begin_with_asterisk option[value='']").prop('selected', true);
			$("#kursiv option[value='']").prop('selected', true);
			$("#kursiv_end_with_t option[value='']").prop('selected', true);
			$("#kursiv_end_with_tt option[value='']").prop('selected', true);
			$("#kursiv_begin_with_degree option[value='']").prop('selected', true);
			$("#kursiv_end_with_degree option[value='']").prop('selected', true);
			$("#kursiv_begin_with_asterisk option[value='']").prop('selected', true);
			$("#kursiv_begin_with_asterisk_end_with_t option[value='']").prop('selected', true);
			$("#kursiv_begin_with_asterisk_end_with_tt option[value='']").prop('selected', true);
			$("#kursiv_begin_with_asterisk_end_with_degree option[value='']").prop('selected', true);
			$("#kursiv_bold option[value='']").prop('selected', true);
			$("#kursiv_bold_begin_with_asterisk_end_with_t option[value='']").prop('selected', true);
			$("#kursiv_bold_begin_with_asterisk_end_with_tt option[value='']").prop('selected', true);
			$("#kursiv_bold_begin_with_degree option[value='']").prop('selected', true);
			$("#kursiv_bold_begin_with_asterisk option[value='']").prop('selected', true);
			$("#kursiv_bold_begin_with_asterisk_end_with_degree option[value='']").prop('selected', true);
			$("#fett option[value='']").prop('selected', true);
			$("#fett_end_with_t option[value='']").prop('selected', true);
			$("#fett_end_with_tt option[value='']").prop('selected', true);
			$("#fett_begin_with_degree option[value='']").prop('selected', true);
			$("#fett_end_with_degree option[value='']").prop('selected', true);
			$("#fett_begin_with_asterisk option[value='']").prop('selected', true);
			$("#fett_begin_with_asterisk_end_with_t option[value='']").prop('selected', true);
			$("#fett_begin_with_asterisk_end_with_tt option[value='']").prop('selected', true);
			$("#fett_begin_with_asterisk_end_with_degree option[value='']").prop('selected', true);
			$("#gross option[value='']").prop('selected', true);
			$("#gross_begin_with_degree option[value='']").prop('selected', true);
			$("#gross_begin_with_asterisk option[value='']").prop('selected', true);
			$("#gross_bold option[value='']").prop('selected', true);
			$("#gross_bold_begin_with_degree option[value='']").prop('selected', true);
			$("#gross_bold_begin_with_asterisk option[value='']").prop('selected', true);
			$("#pi_sign option[value='']").prop('selected', true);
			$("#one_bar option[value='']").prop('selected', true);
			$("#two_bar option[value='']").prop('selected', true);
			$("#three_bar option[value='']").prop('selected', true);
			$("#three_and_half_bar option[value='']").prop('selected', true);
			$("#four_bar option[value='']").prop('selected', true);
			$("#four_and_half_bar option[value='']").prop('selected', true);
			$("#five_bar option[value='']").prop('selected', true);
			// Grading section end
			
			// Symptom type section start
			$("#symptom_type_for_whole option[value='']").prop('selected', true);
			$("#symptoms_with_reference option[value='']").prop('selected', true);
			$("#symptoms_without_reference option[value='']").prop('selected', true);
			$("#symptoms_with_provers option[value='']").prop('selected', true);
			$("#symptoms_without_provers option[value='']").prop('selected', true);
			$("#symptom_with_A_f_d_H option[value='']").prop('selected', true);
			$("#symptom_with_degree option[value='']").prop('selected', true);
			$("#symptom_with_singlet option[value='']").prop('selected', true);
			$("#symptom_with_doublet option[value='']").prop('selected', true);
			$("#symptom_type_for_whole_origin option[value='']").prop('selected', true);
			$("#symptoms_with_reference_origin option[value='']").prop('selected', true);
			$("#symptoms_without_reference_origin option[value='']").prop('selected', true);
			$("#symptoms_with_provers_origin option[value='']").prop('selected', true);
			$("#symptoms_without_provers_origin option[value='']").prop('selected', true);
			$("#symptom_with_A_f_d_H_origin option[value='']").prop('selected', true);
			$("#symptom_with_degree_origin option[value='']").prop('selected', true);
			$("#symptom_with_singlet_origin option[value='']").prop('selected', true);
			$("#symptom_with_doublet_origin option[value='']").prop('selected', true);
			// Symptom type section end
			
			$.unblockUI();
			$('#quelle_settings_quelle_id').prop('disabled', false);
			$('.save-quelle-settings-btn').prop('disabled', false);
			
		}
	});
});