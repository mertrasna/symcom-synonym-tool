<!-- Comment modal start -->
<div class="modal fade" id="symptomCommentModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	          	<h4 class="modal-title">Symptom Comment</h4>
	        </div>
	        <div id="comment_container" class="modal-body">
	          	<div id="comment_modal_loader" class="form-group text-center">
	          		<span class="loading-msg">Loading informations please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
	          		<span class="error-msg"></span>
				</div>
	        </div>
	        <div class="modal-footer">
	        	<?php  
	        		if(isset($finalView) && $finalView == 0){

	        	?>
		        	<button type="button" onclick="symptomIcons('updateComment')" class="btn btn-primary">Save</button>
		          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <?php  
		    		} 
		        ?>
	        </div>
	    </div>
    </div>
</div>
<!-- Comment modal end -->

<!-- Footnote modal start -->
<div class="modal fade" id="symptomFootnoteModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	          	<h4 class="modal-title">Symptom Footnote</h4>
	        </div>
	        <div id="footnote_container" class="modal-body">
	          	<div id="footnote_modal_loader" class="form-group text-center">
	          		<span class="loading-msg">Loading informations please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
	          		<span class="error-msg"></span>
				</div>
	        </div>
	        <div class="modal-footer">
	        	<?php  
	        		if(isset($finalView) && $finalView == 0){

	        	?>
		          	<button type="button"  onclick="symptomIcons('updateFootnote')" class="btn btn-primary">Save</button>
		          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <?php  
		    		} 
		        ?>
	        </div>
	    </div>
    </div>
</div>
<!-- Footnote modal end -->

<!-- Info modal start -->
<div class="modal fade" id="symptomInfoModal" role="dialog">
    <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	        <div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	          	<!-- <h4 class="modal-title">Symptominformation</h4> -->
	        </div>
	        <div id="info_container" class="modal-body">
	          	<div id="info_modal_loader" class="form-group text-center">
	          		<span class="loading-msg">Loading informations please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
	          		<span class="error-msg"></span>
				</div>
	        </div>
	        <div class="modal-footer">
	          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        </div>
	    </div>
    </div>
</div>
<!-- Info modal end -->

<!-- Connect Edit modal start -->
<div class="modal fade" id="connectEditModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	    	<form id="connect_edit_form" name="connect_edit_form" action="" method="POST">
		        <div class="modal-header">
		          	<h4 class="modal-title">Connect Edit</h4>
		        </div>
		        <div id="connect_edit_modal_container" class="modal-body">
		        	<div id="connect_edit_preview_container" class="hidden">
                        <h4 class="modal-title">Edited Symptom's Preview</h4>
                        <div class="spacer"></div>
                        <div id="connect_edit_modal_preview_loader" class="form-group text-center connect_edit_modal_preview_loader">
                            <span class="loading-msg">Loading informations please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
                            <span class="error-msg text-danger"></span>
                        </div>
                        <div id="preview_content">
                            <table id="resultTable" class="table table-bordered">
                                <thead class="heading-table-bg">
                                    <tr>
                                        <th style="width: 20%;">Symptom Versions</th>
                                        <th style="width: 2%;">#</th>
                                        <th>Symptom</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th rowspan="2">Imported Symptom</th>
                                        <th>de</th>
                                        <td id="connect_edtied_symptom_imported_version_de">-</td>
                                    </tr>
                                    <tr>
                                        <th>en</th>
                                        <td id="connect_edtied_symptom_imported_version_en">-</td>
                                    </tr>
                                    <tr>
                                        <th rowspan="2">Edited Symptom</th>
                                        <th>de</th>
                                        <td id="connect_edtied_symptom_edited_version_de">-</td>
                                    </tr>
                                    <tr>
                                        <th>en</th>
                                        <td id="connect_edtied_symptom_edited_version_en">-</td>
                                    </tr>
                                    <tr>
                                        <th rowspan="2">Original Version</th>
                                        <th>de</th>
                                        <td id="connect_edtied_symptom_original_version_de">-</td>
                                    </tr>
                                    <tr>
                                        <th>en</th>
                                        <td id="connect_edtied_symptom_original_version_en">-</td>
                                    </tr>
                                    <tr>
                                        <th rowspan="2">Converted Version</th>
                                        <th>de</th>
                                        <td id="connect_edtied_symptom_converted_version_de">-</td>
                                    </tr>
                                    <tr>
                                        <th>en</th>
                                        <td id="connect_edtied_symptom_converted_version_en">-</td>
                                    </tr>
                                    <tr class="connect_edit_ce_pe_swap_version_tr">
                                        <th rowspan="2">CE/PE/SWAP Version</th>
                                        <th>de</th>
                                        <td id="connect_edtied_symptom_ce_pe_swap_version_de">-</td>
                                    </tr>
                                    <tr class="connect_edit_ce_pe_swap_version_tr">
                                        <th>en</th>
                                        <td id="connect_edtied_symptom_ce_pe_swap_version_en">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="connect_edit_main_outer_container">
                    	<ul class="nav nav-tabs" id="myTab">
						    <li class="active"><a data-toggle="tab" href="#connect_edit_symptom_edit">Symptom</a></li> <!-- Fonts -->
						    <li><a data-toggle="tab" href="#connect_edit_symptom_settings">Settings</a></li><!-- Symptom types -->
						</ul>
						<div class="tab-content">
							<!-- symptom edit tab start -->
							<div id="connect_edit_symptom_edit" class="tab-pane fade in active">
								<div id="connect_edit_modal_loader" class="form-group text-center connect_edit_modal_loader">
					          		<span class="loading-msg">Loading informations please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
					          		<span class="error-msg"></span>
								</div>
								<div id="connect_edit_symptom_de_container" class="row">
				          			<div class="col-sm-12">
				          				<!-- <p><b>Symptom (de)</b></p> -->
				          				<div><b>Symptom(de)</b> <small>Imported form of the symptom is given below for edit.</small></div>
			                            <table id="" class="table table-bordered" style="margin-bottom: 1px; margin-top: 5px;">           
			                                <tbody>                 
			                                    <tr>                        
			                                        <th style="width: 18%;">Original Version</th>                     
			                                        <td id="preview_original_version_de"></td>               
			                                    </tr>                   
			                                    <tr>                        
			                                        <th>Converted Version</th>                     
			                                        <td id="preview_converted_version_de"></td>  
			                                    </tr>
			                                    <tr>                        
			                                        <th>CE/PE/SWAP Version</th>                     
			                                        <td id="preview_ce_swap_pe_version_de"></td>  
			                                    </tr>               
			                                </tbody>            
			                            </table>
				          			</div>
				          			<div class="col-sm-12">
				          				<!-- <textarea id="fv_symptom" name="fv_symptom" class="texteditor-small" aria-hidden="true"></textarea> -->
				          				<textarea id="fv_symptom_de" name="fv_symptom_de" class="texteditor-small" aria-hidden="true"></textarea>
				          				<span class="fv-symptom-de-error error-text text-danger"></span>
				          			</div>
				          		</div>
								<div id="connect_edit_symptom_en_container" class="row">
									<div class="spacer"></div>
				          			<div class="col-sm-12">
				          				<!-- <p><b>Symptom (en)</b></p> -->
				          				<div><b>Symptom(en)</b> <small>Imported form of the symptom is given below for edit.</small></div>
			                            <table id="" class="table table-bordered" style="margin-bottom: 1px; margin-top: 5px;">            
			                                <tbody>                 
			                                    <tr>                        
			                                        <th style="width: 18%;">Original Version</th>                     
			                                        <td id="preview_original_version_en"></td>               
			                                    </tr>                   
			                                    <tr>                        
			                                        <th>Converted Version</th>                     
			                                        <td id="preview_converted_version_en"></td>  
			                                    </tr>
			                                    <tr>                        
			                                        <th>CE/PE/SWAP Version</th>                     
			                                        <td id="preview_ce_swap_pe_version_de"></td>  
			                                    </tr>               
			                                </tbody>            
			                            </table>
				          			</div>
				          			<div class="col-sm-12">
				          				<textarea id="fv_symptom_en" name="fv_symptom_en" class="texteditor-small" aria-hidden="true"></textarea>
				          				<span class="fv-symptom-en-error error-text text-danger"></span>
				          			</div>
				          			<div class="col-sm-12"><p class="connect-edit-common-error-text text-danger"></p></div>
				          		</div>
							</div>
							<!-- symptom edit tab end -->
							<!-- symptom settings tab start -->
							<div id="connect_edit_symptom_settings" class="tab-pane fade">
								<div class="row">
									<div class="col-md-12">
										<div id="" class="form-group text-center connect_edit_modal_loader">
							          		<span class="loading-msg">Loading informations please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
							          		<span class="error-msg"></span>
										</div>
									</div>
								</div>
								<div id="symptom_edit_settings_container" class="row" style="margin-top: 15px;">
									<!-- <div class="col-md-12">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="symptom_type">Symptom type</label><span class="error-text"></span>
													<select name="symptom_type" id="symptom_type" class="form-control">
														<option value="">Select</option>
														<option value="proving">Proving symptom</option>
														<option value="intoxication">Intoxication</option>
														<option value="clinical">Clinical symptom</option>
														<option value="proving_intoxication_clinical_not_defined">Proving symptom / Intoxication / Clinical symptom not clearly defined</option>
														<option value="characteristic">Characteristic symptom</option>
														<option value="characteristic_not_defined">Characteristic symptom not clearly identified / defined</option>
												    </select>
												</div>
											</div>
											<div class="col-md-6"></div>
										</div>
										<hr>
									</div> -->
									<div class="col-md-12">
										<h4>Grading settings</h4>
										<div class="spacer"></div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="normal">Normal</label><span class="error-text pull-right">Normal</span>
													<select name="normal" id="normal" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="normal_within_parentheses">Normal in Klammern</label><span class="error-text pull-right">(Normal)</span> <!-- Normal within parentheses -->
													<select name="normal_within_parentheses" id="normal_within_parentheses" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="normal_end_with_t">Normal mit t.</label><span class="error-text pull-right">Normal, t.</span> <!-- Normal end with t -->
													<select name="normal_end_with_t" id="normal_end_with_t" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="normal_end_with_tt">Normal mit tt.</label><span class="error-text pull-right">Normal, tt.</span> <!-- Normal end with tt -->
													<select name="normal_end_with_tt" id="normal_end_with_tt" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="normal_begin_with_degree">Normal mit ° am Anfang</label><span class="error-text pull-right">°Normal</span> <!-- Normal begin with degree -->
													<select name="normal_begin_with_degree" id="normal_begin_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="normal_end_with_degree">Normal mit ° am Ende</label><span class="error-text pull-right">Normal,°</span> <!-- Normal end with degree -->
													<select name="normal_end_with_degree" id="normal_end_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="normal_begin_with_asterisk">Normal mit * am Anfang</label><span class="error-text pull-right">*Normal</span> <!-- Normal begin with asterisk -->
													<select name="normal_begin_with_asterisk" id="normal_begin_with_asterisk" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="normal_begin_with_asterisk_end_with_t">Normal mit * am Anfang und t.</label><span class="error-text pull-right">*Normal, t.</span> <!-- Normal begin with asterisk end with t -->
													<select name="normal_begin_with_asterisk_end_with_t" id="normal_begin_with_asterisk_end_with_t" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="normal_begin_with_asterisk_end_with_tt">Normal mit * am Anfang und tt.</label><span class="error-text pull-right">*Normal, tt.</span> <!-- Normal begin with asterisk end with tt -->
													<select name="normal_begin_with_asterisk_end_with_tt" id="normal_begin_with_asterisk_end_with_tt" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="normal_begin_with_asterisk_end_with_degree">Normal mit * am Anfang und °</label><span class="error-text pull-right">*Normal,°</span> <!-- Normal begin with asterisk end with degree -->
													<select name="normal_begin_with_asterisk_end_with_degree" id="normal_begin_with_asterisk_end_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="sperrschrift">Sperrschrift</label><span class="error-text text-sperrschrift pull-right">Sperrschrift</span>
													<select name="sperrschrift" id="sperrschrift" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="sperrschrift_begin_with_degree">Sperrschrift mit ° am Anfang</label><span class="error-text text-sperrschrift pull-right">°Sperrschrift</span> <!-- Sperrschrift begin with degree -->
													<select name="sperrschrift_begin_with_degree" id="sperrschrift_begin_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="sperrschrift_begin_with_asterisk">Sperrschrift mit * am Anfang</label><span class="error-text text-sperrschrift pull-right">*Sperrschrift</span><!-- Sperrschrift begin with asterisk -->
													<select name="sperrschrift_begin_with_asterisk" id="sperrschrift_begin_with_asterisk" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="sperrschrift_bold">Sperrschrift fett</label><span class="error-text text-sperrschrift pull-right"><b>Sperrschrift</b></span><!-- Sperrschrift bold -->
													<select name="sperrschrift_bold" id="sperrschrift_bold" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="sperrschrift_bold_begin_with_degree">Sperrschrift fett mit ° am Anfang</label><span class="error-text text-sperrschrift pull-right"><b>°Sperrschrift</b></span><!-- Sperrschrift bold begin with degree -->
													<select name="sperrschrift_bold_begin_with_degree" id="sperrschrift_bold_begin_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="sperrschrift_bold_begin_with_asterisk">Sperrschrift fett mit * am Anfang</label><span class="error-text text-sperrschrift pull-right"><b>*Sperrschrift</b></span> <!-- Sperrschrift bold begin with asterisk -->
													<select name="sperrschrift_bold_begin_with_asterisk" id="sperrschrift_bold_begin_with_asterisk" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="kursiv">Kursiv</label><span class="error-text pull-right"><i>Kursiv</i></span>
													<select name="kursiv" id="kursiv" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="kursiv_end_with_t">Kursiv mit t.</label><span class="error-text pull-right"><i>Kursiv, t.</i></span> <!-- Kursiv end with t -->
													<select name="kursiv_end_with_t" id="kursiv_end_with_t" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="kursiv_end_with_tt">Kursiv mit tt.</label><span class="error-text pull-right"><i>Kursiv, tt.</i></span><!-- Kursiv end with tt -->
													<select name="kursiv_end_with_tt" id="kursiv_end_with_tt" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="kursiv_begin_with_degree">Kursiv mit ° am Anfang</label><span class="error-text pull-right"><i>°Kursiv</i></span> <!-- Kursiv begin with degree -->
													<select name="kursiv_begin_with_degree" id="kursiv_begin_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="kursiv_end_with_degree">Kursiv mit ° am Ende</label><span class="error-text pull-right"><i>Kursiv,°</i></span> <!-- Kursiv end with degree -->
													<select name="kursiv_end_with_degree" id="kursiv_end_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="kursiv_begin_with_asterisk">Kursiv mit * am Anfang</label><span class="error-text pull-right"><i>*Kursiv</i></span> <!-- Kursiv begin with asterisk -->
													<select name="kursiv_begin_with_asterisk" id="kursiv_begin_with_asterisk" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="kursiv_begin_with_asterisk_end_with_t">Kursiv mit * am Anfang und t.</label><span class="error-text pull-right"><i>*Kursiv, t.</i></span> <!-- Kursiv begin with asterisk end with t -->
													<select name="kursiv_begin_with_asterisk_end_with_t" id="kursiv_begin_with_asterisk_end_with_t" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="kursiv_begin_with_asterisk_end_with_tt">Kursiv mit * am Anfang und tt.</label><span class="error-text pull-right"><i>*Kursiv, tt.</i></span><!-- Kursiv begin with asterisk end with tt -->
													<select name="kursiv_begin_with_asterisk_end_with_tt" id="kursiv_begin_with_asterisk_end_with_tt" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="kursiv_begin_with_asterisk_end_with_degree">Kursiv mit * am Anfang und ° am Ende</label><span class="error-text pull-right"><i>*Kursiv,°</i></span><!-- Kursiv begin with asterisk end with degree -->
													<select name="kursiv_begin_with_asterisk_end_with_degree" id="kursiv_begin_with_asterisk_end_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label for="kursiv_bold">Kursiv fett</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>Kursiv</b></i></span> <!-- Kursiv bold -->
													<select name="kursiv_bold" id="kursiv_bold" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="kursiv_bold_begin_with_asterisk_end_with_t">Kursiv fett mit * am Anfang und t.</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>*Kursiv, t.</b></i></span> <!-- Kursiv bold begin with asterisk end with t -->
													<select name="kursiv_bold_begin_with_asterisk_end_with_t" id="kursiv_bold_begin_with_asterisk_end_with_t" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="kursiv_bold_begin_with_asterisk_end_with_tt">Kursiv fett mit * am Anfang und tt.</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>*Kursiv, tt.</b></i></span> <!-- Kursiv bold begin with asterisk end with tt -->
													<select name="kursiv_bold_begin_with_asterisk_end_with_tt" id="kursiv_bold_begin_with_asterisk_end_with_tt" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="kursiv_bold_begin_with_degree">Kursiv fett mit ° am Anfang</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>°Kursiv</b></i></span> <!-- Kursiv bold begin with degree -->
													<select name="kursiv_bold_begin_with_degree" id="kursiv_bold_begin_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="kursiv_bold_begin_with_asterisk">Kursiv fett mit * am Anfang</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>*Kursiv</b></i></span> <!-- Kursiv bold begin with asterisk -->
													<select name="kursiv_bold_begin_with_asterisk" id="kursiv_bold_begin_with_asterisk" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="kursiv_bold_begin_with_asterisk_end_with_degree">Kursiv fett mit * am Anfang und ° am Ende</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>*Kursiv,°</b></i></span> <!-- Kursiv bold begin with asterisk end with degree -->
													<select name="kursiv_bold_begin_with_asterisk_end_with_degree" id="kursiv_bold_begin_with_asterisk_end_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="fett">Fett</label> <span class="error-text pull-right"><b>Fett</b></span> 
													<select name="fett" id="fett" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="fett_converted_spaced">Fett (konvertierte Sperrschrift)</label> <span class="error-text pull-right text-sperrschrift"><b>Fett</b></span> 
													<select name="fett_converted_spaced" id="fett_converted_spaced" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="fett_end_with_t">Fett mit t.</label><span class="error-text pull-right"><b>Fett, t.</b></span> <!-- Fett end with t -->
													<select name="fett_end_with_t" id="fett_end_with_t" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="fett_end_with_tt">Fett mit tt.</label><span class="error-text pull-right"><b>Fett, tt.</b></span> <!-- Fett end with tt -->
													<select name="fett_end_with_tt" id="fett_end_with_tt" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="fett_begin_with_degree">Fett mit ° am Anfang</label><span class="error-text pull-right"><b>°Fett</b></span> <!-- Fett begin with degree -->
													<select name="fett_begin_with_degree" id="fett_begin_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="fett_converted_spaced_degree_at_beginning">Fett (konvertierte Sperrschrift) mit ° am Anfang</label><span class="error-text pull-right text-sperrschrift"><b>°Fett</b></span> <!-- Fett begin with degree -->
													<select name="fett_converted_spaced_degree_at_beginning" id="fett_converted_spaced_degree_at_beginning" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="fett_end_with_degree">Fett mit ° am Ende</label><span class="error-text pull-right"><b>Fett,°</b></span> <!-- Fett end with degree -->
													<select name="fett_end_with_degree" id="fett_end_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="fett_begin_with_asterisk">Fett mit * am Anfang</label><span class="error-text pull-right"><b>*Fett</b></span> <!-- Fett begin with asterisk -->
													<select name="fett_begin_with_asterisk" id="fett_begin_with_asterisk" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="fett_converted_spaced_asterisk_at_beginning">Fett (konvertierte Sperrschrift) mit * am Anfang</label><span class="error-text pull-right text-sperrschrift"><b>*Fett</b></span> <!-- Fett begin with asterisk -->
													<select name="fett_converted_spaced_asterisk_at_beginning" id="fett_converted_spaced_asterisk_at_beginning" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="fett_begin_with_asterisk_end_with_t">Fett mit * am Anfang und t.</label><span class="error-text pull-right"><b>*Fett, t.</b></span> <!-- Fett begin with asterisk end with t -->
													<select name="fett_begin_with_asterisk_end_with_t" id="fett_begin_with_asterisk_end_with_t" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="fett_begin_with_asterisk_end_with_tt">Fett mit * am Anfang und tt.</label><span class="error-text pull-right"><b>*Fett, tt.</b></span> <!-- Fett begin with asterisk end with tt -->
													<select name="fett_begin_with_asterisk_end_with_tt" id="fett_begin_with_asterisk_end_with_tt" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="fett_begin_with_asterisk_end_with_degree">Fett mit * am Anfang und °</label><span class="error-text pull-right"><b>*Fett,°</b></span> <!-- Fett begin with asterisk end with degree -->
													<select name="fett_begin_with_asterisk_end_with_degree" id="fett_begin_with_asterisk_end_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="gross">Gross</label><span class="error-text pull-right">GROSS</span>
													<select name="gross" id="gross" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="gross_begin_with_degree">Gross mit ° am Anfang</label><span class="error-text pull-right">°GROSS</span> <!-- Gross begin with degree -->
													<select name="gross_begin_with_degree" id="gross_begin_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="gross_begin_with_asterisk">Gross mit * am Anfang</label><span class="error-text pull-right">*GROSS</span> <!-- Gross begin with asterisk -->
													<select name="gross_begin_with_asterisk" id="gross_begin_with_asterisk" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="gross_bold">Gross fett</label><span class="error-text pull-right"><b>GROSS</b></span> <!-- Gross bold -->
													<select name="gross_bold" id="gross_bold" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="gross_bold_begin_with_degree">Gross fett mit ° am Anfang</label><span class="error-text pull-right"><b>°GROSS</b></span> <!-- Gross bold begin with degree -->
													<select name="gross_bold_begin_with_degree" id="gross_bold_begin_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="gross_bold_begin_with_asterisk">Gross fett mit * am Anfang</label><span class="error-text pull-right"><b>*GROSS</b></span> <!-- Gross bold begin with asterisk -->
													<select name="gross_bold_begin_with_asterisk" id="gross_bold_begin_with_asterisk" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="pi_sign">Pi-Zeichen</label><span class="error-text pull-right">π</span>
													<select name="pi_sign" id="pi_sign" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="one_bar">Ein Balken</label><span class="error-text pull-right">|</span>
													<select name="one_bar" id="one_bar" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="two_bar">Zwei Balken</label><span class="error-text pull-right">||</span>
													<select name="two_bar" id="two_bar" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="three_bar">Drei Balken</label><span class="error-text pull-right">|||</span>
													<select name="three_bar" id="three_bar" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="three_and_half_bar">Dreieinhalb Takte</label><span class="error-text pull-right">|||-</span>
													<select name="three_and_half_bar" id="three_and_half_bar" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="four_bar">Vier Balken</label><span class="error-text pull-right">||||</span>
													<select name="four_bar" id="four_bar" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="four_and_half_bar">Viereinhalb Takte</label><span class="error-text pull-right">||||-</span>
													<select name="four_and_half_bar" id="four_and_half_bar" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="five_bar">Fünf Balken</label><span class="error-text pull-right">|||||</span>
													<select name="five_bar" id="five_bar" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-12"><p class="symptom-edit-common-error-text text-danger"></p></div>
								</div>
							</div>
							<!-- symptom settings tab end -->
						</div>
                    </div>
		        </div>
		        <div class="modal-footer">
		        	<input type="hidden" name="connect_edit_modal_initial_symptom_id" id="connect_edit_modal_initial_symptom_id">
		        	<input type="hidden" name="connect_edit_modal_comparing_id" id="connect_edit_modal_comparing_id">
		        	<input type="hidden" name="connect_edit_modal_initial_source_id" id="connect_edit_modal_initial_source_id">
		        	<input type="hidden" name="connect_edit_modal_comparing_source_id" id="connect_edit_modal_comparing_source_id">
		        	<input type="hidden" name="connect_edit_modal_symptom_id_type_to_work" id="connect_edit_modal_symptom_id_type_to_work">
		        	<button type="button" class="btn btn-primary connect-edit-modal-preview-btn">Preview</button>
		        	<button type="button" id="connect_edit_submit_btn" class="btn btn-primary connect-edit-modal-submit-btn hidden">Submit</button>
		        	<button type="button" class="btn btn-primary connect-edit-modal-back-btn hidden" id="connect_edit_modal_back_btn">Go Back</button>
		          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        </div>
	    	</form>
	    </div>
    </div>
</div>
<!-- Connect Edit modal end -->

<!-- Paste Edit modal start -->
<div class="modal fade" id="pasteEditModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	    	<form id="paste_edit_form" name="paste_edit_form" action="" method="POST">
		        <div class="modal-header">
		          	<button type="button" class="close" data-dismiss="modal">&times;</button>
		          	<h4 class="modal-title">Paste Edit</h4>
		        </div>
		        <div id="paste_edit_modal_container" class="modal-body">
		          	<div id="paste_edit_modal_loader" class="form-group text-center">
		          		<span class="loading-msg">Loading informations please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
		          		<span class="error-msg"></span>
					</div>
					<div id="paste_edit_symptom_de_container" class="row">
	          			<div class="col-sm-12">
	          				<!-- <p><b>Symptom (de)</b></p> -->
	          				<div><b>Symptom(de)</b> <small>Imported form of the symptom is given below for edit.</small></div>
                            <table id="" class="table table-bordered" style="margin-bottom: 1px; margin-top: 5px;">           
                                <tbody>                 
                                    <tr>                        
                                        <th style="width: 18%;">Original Version</th>                     
                                        <td id="preview_pemodal_original_version_de"></td>               
                                    </tr>                   
                                    <tr>                        
                                        <th>Converted Version</th>                     
                                        <td id="preview_pemodal_converted_version_de"></td>  
                                    </tr>
                                    <tr>                        
                                        <th>CE/PE/SWAP Version</th>                     
                                        <td id="preview_pemodal_ce_swap_pe_version_de"></td>  
                                    </tr>               
                                </tbody>            
                            </table>
	          			</div>
	          			<div class="col-sm-12">
	          				<!-- <textarea id="fv_pe_symptom" name="fv_pe_symptom" class="texteditor-small" aria-hidden="true"></textarea> -->
	          				<textarea id="fv_pe_symptom_de" name="fv_pe_symptom_de" class="texteditor-small" aria-hidden="true"></textarea>
	          				<span class="fv-symptom-de-error error-text text-danger"></span>
	          			</div>
	          		</div>
					<div id="paste_edit_symptom_en_container" class="row">
						<div class="spacer"></div>
	          			<div class="col-sm-12">
	          				<!-- <p><b>Symptom (en)</b></p> -->
	          				<div><b>Symptom(en)</b> <small>Imported form of the symptom is given below for edit.</small></div>
                            <table id="" class="table table-bordered" style="margin-bottom: 1px; margin-top: 5px;">            
                                <tbody>                 
                                    <tr>                        
                                        <th style="width: 18%;">Original Version</th>                     
                                        <td id="preview_pemodal_original_version_en"></td>               
                                    </tr>                   
                                    <tr>                        
                                        <th>Converted Version</th>                     
                                        <td id="preview_pemodal_converted_version_en"></td>  
                                    </tr>
                                    <tr>                        
                                        <th>CE/PE/SWAP Version</th>                     
                                        <td id="preview_pemodal_ce_swap_pe_version_de"></td>  
                                    </tr>               
                                </tbody>            
                            </table>
	          			</div>
	          			<div class="col-sm-12">
	          				<textarea id="fv_pe_symptom_en" name="fv_pe_symptom_en" class="texteditor-small" aria-hidden="true"></textarea>
	          				<span class="fv-symptom-en-error error-text text-danger"></span>
	          			</div>
	          		</div>
		        </div>
		        <div class="modal-footer">
		        	<button type="button" id="paste_edit_submit_btn" class="btn btn-primary paste-edit-modal-submit-btn">Submit</button>
		          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        </div>
	    	</form>
	    </div>
    </div>
</div>
<!-- Paste Edit modal end -->


<!-- symptom Edit modal start -->
<div class="modal fade" id="symptomEditModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	    	<form id="symptom_edit_form" name="symptom_edit_form" action="" method="POST">
		        <div class="modal-header">
		          	<button type="button" class="close" data-dismiss="modal">&times;</button>
		          	<h4 class="modal-title">Symptom Edit</h4>
		        </div>
		        <div id="symptom_edit_modal_container" class="modal-body">
		        	<div id="symptom_edit_preview_container" class="hidden">
                        <h4 class="modal-title">Edited Symptom's Preview</h4>
                        <div class="spacer"></div>
                        <div id="edit_symptom_modal_preview_loader" class="form-group text-center">
                            <span class="loading-msg">Loading informations please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
                            <span class="error-msg text-danger"></span>
                        </div>
                        <div id="preview_content">
                            <table id="resultTable" class="table table-bordered">
                                <thead class="heading-table-bg">
                                    <tr>
                                        <th style="width: 20%;">Symptom Versions</th>
                                        <th style="width: 2%;">#</th>
                                        <th>Symptom</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th rowspan="2">Imported Symptom</th>
                                        <th>de</th>
                                        <td id="edtied_symptom_imported_version_de">-</td>
                                    </tr>
                                    <tr>
                                        <th>en</th>
                                        <td id="edtied_symptom_imported_version_en">-</td>
                                    </tr>
                                    <tr>
                                        <th rowspan="2">Edited Symptom</th>
                                        <th>de</th>
                                        <td id="edtied_symptom_edited_version_de">-</td>
                                    </tr>
                                    <tr>
                                        <th>en</th>
                                        <td id="edtied_symptom_edited_version_en">-</td>
                                    </tr>
                                    <tr>
                                        <th rowspan="2">Original Version</th>
                                        <th>de</th>
                                        <td id="edtied_symptom_original_version_de">-</td>
                                    </tr>
                                    <tr>
                                        <th>en</th>
                                        <td id="edtied_symptom_original_version_en">-</td>
                                    </tr>
                                    <tr>
                                        <th rowspan="2">Converted Version</th>
                                        <th>de</th>
                                        <td id="edtied_symptom_converted_version_de">-</td>
                                    </tr>
                                    <tr>
                                        <th>en</th>
                                        <td id="edtied_symptom_converted_version_en">-</td>
                                    </tr>
                                    <tr class="ce_pe_swap_version_tr">
                                        <th rowspan="2">CE/PE/SWAP Version</th>
                                        <th>de</th>
                                        <td id="edtied_symptom_ce_pe_swap_version_de">-</td>
                                    </tr>
                                    <tr class="ce_pe_swap_version_tr">
                                        <th>en</th>
                                        <td id="edtied_symptom_ce_pe_swap_version_en">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
		        	<!-- Tab start -->
		        	<div id="symptom_edit_main_outer_container">
		              	<ul class="nav nav-tabs" id="myTab">
						    <li class="active"><a data-toggle="tab" href="#symptom_edit">Symptom</a></li> <!-- Fonts -->
						    <li><a data-toggle="tab" href="#symptom_settings">Settings</a></li><!-- Symptom types -->
						</ul>
						<div class="tab-content">
							<!-- symptom edit tab start -->
							<div id="symptom_edit" class="tab-pane fade in active">
								<div class="row">
									<div class="col-md-12">
										<div id="" class="form-group text-center symptom_edit_modal_loader">
							          		<span class="loading-msg">Loading informations please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
							          		<span class="error-msg"></span>
										</div>
									</div>
								</div>
								<div id="symptom_edit_container" class="row" style="margin-top: 15px;">
									<div class="col-md-12">
										<div id="symptom_version_container" class="row">
				                            <div class="col-sm-12">
				                                <div><b>Symptom version</b></div>
				                                <label class="radio-inline"><input type="radio" name="symptom_version" id="radio_original" value="original" checked>Edit original and converted version.</label>
				                                <label class="radio-inline"><input type="radio" name="symptom_version" id="radio_converted" value="converted">Edit only converted version.</label>
				                                <div class="spacer"></div>
				                            </div>
				                        </div>
										<div id="symptom_edit_symptom_de_container" class="row">
						          			<div class="col-sm-12">
						          				<div><b>Symptom(de)</b> <small>Imported Form of the symptom is given below for edit.</small></div>
	                                            <table id="" class="table table-bordered" style="margin-bottom: 1px; margin-top: 5px;">           
	                                                <tbody>                 
	                                                    <tr>                        
	                                                        <th style="width: 18%;">Original Version</th>                     
	                                                        <td id="preview_edit_musk_original_version_de"></td>               
	                                                    </tr>                   
	                                                    <tr>                        
	                                                        <th>Converted Version</th>                     
	                                                        <td id="preview_edit_musk_converted_version_de"></td>  
	                                                    </tr>
	                                                    <tr>                        
	                                                        <th>CE/PE/SWAP Version</th>                     
	                                                        <td id="preview_edit_musk_ce_swap_pe_version_de"></td>  
	                                                    </tr>               
	                                                </tbody>            
	                                            </table>
						          			</div>
						          			<div class="col-sm-12">
						          				<textarea id="symptom_edit_de" name="symptom_edit_de" class="texteditor-small" aria-hidden="true"></textarea>
						          				<span class="symptom-edit-de-error error-text text-danger"></span>
						          			</div>
						          		</div>
										<div id="symptom_edit_symptom_en_container" class="row">
											<div class="spacer"></div>
						          			<div class="col-sm-12">
						          				<div><b>Symptom(en)</b> <small>Imported form of the symptom is given below for edit.</small></div>
	                                            <table id="" class="table table-bordered" style="margin-bottom: 1px; margin-top: 5px;">            
	                                                <tbody>                 
	                                                    <tr>                        
	                                                        <th style="width: 18%;">Original Version</th>                     
	                                                        <td id="preview_edit_musk_original_version_en"></td>               
	                                                    </tr>                   
	                                                    <tr>                        
	                                                        <th>Converted Version</th>                     
	                                                        <td id="preview_edit_musk_converted_version_en"></td>  
	                                                    </tr>
	                                                    <tr>                        
	                                                        <th>CE/PE/SWAP Version</th>                     
	                                                        <td id="preview_edit_musk_ce_swap_pe_version_en"></td>  
	                                                    </tr>               
	                                                </tbody>            
	                                            </table>
						          			</div>
						          			<div class="col-sm-12">
						          				<textarea id="symptom_edit_en" name="symptom_edit_en" class="texteditor-small" aria-hidden="true"></textarea>
						          				<span class="symptom-edit-en-error error-text text-danger"></span>
						          			</div>
						          		</div>
						          		<div class="row">
	                                        <div class="col-sm-12">
	                                            <div class="spacer"></div>
	                                            <div><b>Individual Upgrade justification</b></div>
	                                            <textarea name="individual_upgrade_justification" id="individual_upgrade_justification" placeholder="Individual Upgrade justification" class="form-control" rows="5" cols="50"></textarea>
	                                        </div>
	                                    </div>
						          		<div class="row">
											<div class="col-sm-12"><p class="symptom-edit-common-error-text text-danger"></p></div>
										</div>
									</div>
								</div>
							</div>
							<!-- symptom edit tab end -->
							<!-- symptom settings tab start -->
							<div id="symptom_settings" class="tab-pane fade">
								<div class="row">
									<div class="col-md-12">
										<div id="" class="form-group text-center symptom_edit_modal_loader">
							          		<span class="loading-msg">Loading informations please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
							          		<span class="error-msg"></span>
										</div>
									</div>
								</div>
								<div id="symptom_edit_settings_container" class="row" style="margin-top: 15px;">
									<div class="col-md-12">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="symptom_type">Symptom type</label><span class="error-text"></span>
													<select name="symptom_type" id="symptom_type" class="form-control">
														<option value="">Select</option>
														<option value="proving">Proving symptom</option>
														<option value="intoxication">Intoxication</option>
														<option value="clinical">Clinical symptom</option>
														<option value="proving_intoxication_clinical_not_defined">Proving symptom / Intoxication / Clinical symptom not clearly defined</option>
														<option value="characteristic">Characteristic symptom</option>
														<option value="characteristic_not_defined">Characteristic symptom not clearly identified / defined</option>
												    </select>
												</div>
											</div>
											<div class="col-md-6"></div>
										</div>
										<hr>
									</div>
									<div class="col-md-12">
										<h4>Grading settings</h4>
										<div class="spacer"></div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="normal">Normal</label><span class="error-text pull-right">Normal</span>
													<select name="normal" id="normal" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="normal_within_parentheses">Normal in Klammern</label><span class="error-text pull-right">(Normal)</span> <!-- Normal within parentheses -->
													<select name="normal_within_parentheses" id="normal_within_parentheses" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="normal_end_with_t">Normal mit t.</label><span class="error-text pull-right">Normal, t.</span> <!-- Normal end with t -->
													<select name="normal_end_with_t" id="normal_end_with_t" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="normal_end_with_tt">Normal mit tt.</label><span class="error-text pull-right">Normal, tt.</span> <!-- Normal end with tt -->
													<select name="normal_end_with_tt" id="normal_end_with_tt" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="normal_begin_with_degree">Normal mit ° am Anfang</label><span class="error-text pull-right">°Normal</span> <!-- Normal begin with degree -->
													<select name="normal_begin_with_degree" id="normal_begin_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="normal_end_with_degree">Normal mit ° am Ende</label><span class="error-text pull-right">Normal,°</span> <!-- Normal end with degree -->
													<select name="normal_end_with_degree" id="normal_end_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="normal_begin_with_asterisk">Normal mit * am Anfang</label><span class="error-text pull-right">*Normal</span> <!-- Normal begin with asterisk -->
													<select name="normal_begin_with_asterisk" id="normal_begin_with_asterisk" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="normal_begin_with_asterisk_end_with_t">Normal mit * am Anfang und t.</label><span class="error-text pull-right">*Normal, t.</span> <!-- Normal begin with asterisk end with t -->
													<select name="normal_begin_with_asterisk_end_with_t" id="normal_begin_with_asterisk_end_with_t" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="normal_begin_with_asterisk_end_with_tt">Normal mit * am Anfang und tt.</label><span class="error-text pull-right">*Normal, tt.</span> <!-- Normal begin with asterisk end with tt -->
													<select name="normal_begin_with_asterisk_end_with_tt" id="normal_begin_with_asterisk_end_with_tt" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="normal_begin_with_asterisk_end_with_degree">Normal mit * am Anfang und °</label><span class="error-text pull-right">*Normal,°</span> <!-- Normal begin with asterisk end with degree -->
													<select name="normal_begin_with_asterisk_end_with_degree" id="normal_begin_with_asterisk_end_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="sperrschrift">Sperrschrift</label><span class="error-text text-sperrschrift pull-right">Sperrschrift</span>
													<select name="sperrschrift" id="sperrschrift" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="sperrschrift_begin_with_degree">Sperrschrift mit ° am Anfang</label><span class="error-text text-sperrschrift pull-right">°Sperrschrift</span> <!-- Sperrschrift begin with degree -->
													<select name="sperrschrift_begin_with_degree" id="sperrschrift_begin_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="sperrschrift_begin_with_asterisk">Sperrschrift mit * am Anfang</label><span class="error-text text-sperrschrift pull-right">*Sperrschrift</span><!-- Sperrschrift begin with asterisk -->
													<select name="sperrschrift_begin_with_asterisk" id="sperrschrift_begin_with_asterisk" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="sperrschrift_bold">Sperrschrift fett</label><span class="error-text text-sperrschrift pull-right"><b>Sperrschrift</b></span><!-- Sperrschrift bold -->
													<select name="sperrschrift_bold" id="sperrschrift_bold" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="sperrschrift_bold_begin_with_degree">Sperrschrift fett mit ° am Anfang</label><span class="error-text text-sperrschrift pull-right"><b>°Sperrschrift</b></span><!-- Sperrschrift bold begin with degree -->
													<select name="sperrschrift_bold_begin_with_degree" id="sperrschrift_bold_begin_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="sperrschrift_bold_begin_with_asterisk">Sperrschrift fett mit * am Anfang</label><span class="error-text text-sperrschrift pull-right"><b>*Sperrschrift</b></span> <!-- Sperrschrift bold begin with asterisk -->
													<select name="sperrschrift_bold_begin_with_asterisk" id="sperrschrift_bold_begin_with_asterisk" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="kursiv">Kursiv</label><span class="error-text pull-right"><i>Kursiv</i></span>
													<select name="kursiv" id="kursiv" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="kursiv_end_with_t">Kursiv mit t.</label><span class="error-text pull-right"><i>Kursiv, t.</i></span> <!-- Kursiv end with t -->
													<select name="kursiv_end_with_t" id="kursiv_end_with_t" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="kursiv_end_with_tt">Kursiv mit tt.</label><span class="error-text pull-right"><i>Kursiv, tt.</i></span><!-- Kursiv end with tt -->
													<select name="kursiv_end_with_tt" id="kursiv_end_with_tt" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="kursiv_begin_with_degree">Kursiv mit ° am Anfang</label><span class="error-text pull-right"><i>°Kursiv</i></span> <!-- Kursiv begin with degree -->
													<select name="kursiv_begin_with_degree" id="kursiv_begin_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="kursiv_end_with_degree">Kursiv mit ° am Ende</label><span class="error-text pull-right"><i>Kursiv,°</i></span> <!-- Kursiv end with degree -->
													<select name="kursiv_end_with_degree" id="kursiv_end_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="kursiv_begin_with_asterisk">Kursiv mit * am Anfang</label><span class="error-text pull-right"><i>*Kursiv</i></span> <!-- Kursiv begin with asterisk -->
													<select name="kursiv_begin_with_asterisk" id="kursiv_begin_with_asterisk" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="kursiv_begin_with_asterisk_end_with_t">Kursiv mit * am Anfang und t.</label><span class="error-text pull-right"><i>*Kursiv, t.</i></span> <!-- Kursiv begin with asterisk end with t -->
													<select name="kursiv_begin_with_asterisk_end_with_t" id="kursiv_begin_with_asterisk_end_with_t" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="kursiv_begin_with_asterisk_end_with_tt">Kursiv mit * am Anfang und tt.</label><span class="error-text pull-right"><i>*Kursiv, tt.</i></span><!-- Kursiv begin with asterisk end with tt -->
													<select name="kursiv_begin_with_asterisk_end_with_tt" id="kursiv_begin_with_asterisk_end_with_tt" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="kursiv_begin_with_asterisk_end_with_degree">Kursiv mit * am Anfang und ° am Ende</label><span class="error-text pull-right"><i>*Kursiv,°</i></span><!-- Kursiv begin with asterisk end with degree -->
													<select name="kursiv_begin_with_asterisk_end_with_degree" id="kursiv_begin_with_asterisk_end_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label for="kursiv_bold">Kursiv fett</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>Kursiv</b></i></span> <!-- Kursiv bold -->
													<select name="kursiv_bold" id="kursiv_bold" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="kursiv_bold_begin_with_asterisk_end_with_t">Kursiv fett mit * am Anfang und t.</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>*Kursiv, t.</b></i></span> <!-- Kursiv bold begin with asterisk end with t -->
													<select name="kursiv_bold_begin_with_asterisk_end_with_t" id="kursiv_bold_begin_with_asterisk_end_with_t" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="kursiv_bold_begin_with_asterisk_end_with_tt">Kursiv fett mit * am Anfang und tt.</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>*Kursiv, tt.</b></i></span> <!-- Kursiv bold begin with asterisk end with tt -->
													<select name="kursiv_bold_begin_with_asterisk_end_with_tt" id="kursiv_bold_begin_with_asterisk_end_with_tt" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="kursiv_bold_begin_with_degree">Kursiv fett mit ° am Anfang</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>°Kursiv</b></i></span> <!-- Kursiv bold begin with degree -->
													<select name="kursiv_bold_begin_with_degree" id="kursiv_bold_begin_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="kursiv_bold_begin_with_asterisk">Kursiv fett mit * am Anfang</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>*Kursiv</b></i></span> <!-- Kursiv bold begin with asterisk -->
													<select name="kursiv_bold_begin_with_asterisk" id="kursiv_bold_begin_with_asterisk" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="kursiv_bold_begin_with_asterisk_end_with_degree">Kursiv fett mit * am Anfang und ° am Ende</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>*Kursiv,°</b></i></span> <!-- Kursiv bold begin with asterisk end with degree -->
													<select name="kursiv_bold_begin_with_asterisk_end_with_degree" id="kursiv_bold_begin_with_asterisk_end_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="fett">Fett</label> <span class="error-text pull-right"><b>Fett</b></span> 
													<select name="fett" id="fett" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="fett_converted_spaced">Fett (konvertierte Sperrschrift)</label> <span class="error-text pull-right text-sperrschrift"><b>Fett</b></span> 
													<select name="fett_converted_spaced" id="fett_converted_spaced" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="fett_end_with_t">Fett mit t.</label><span class="error-text pull-right"><b>Fett, t.</b></span> <!-- Fett end with t -->
													<select name="fett_end_with_t" id="fett_end_with_t" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="fett_end_with_tt">Fett mit tt.</label><span class="error-text pull-right"><b>Fett, tt.</b></span> <!-- Fett end with tt -->
													<select name="fett_end_with_tt" id="fett_end_with_tt" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="fett_begin_with_degree">Fett mit ° am Anfang</label><span class="error-text pull-right"><b>°Fett</b></span> <!-- Fett begin with degree -->
													<select name="fett_begin_with_degree" id="fett_begin_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="fett_converted_spaced_degree_at_beginning">Fett (konvertierte Sperrschrift) mit ° am Anfang</label><span class="error-text pull-right text-sperrschrift"><b>°Fett</b></span> <!-- Fett begin with degree -->
													<select name="fett_converted_spaced_degree_at_beginning" id="fett_converted_spaced_degree_at_beginning" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="fett_end_with_degree">Fett mit ° am Ende</label><span class="error-text pull-right"><b>Fett,°</b></span> <!-- Fett end with degree -->
													<select name="fett_end_with_degree" id="fett_end_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="fett_begin_with_asterisk">Fett mit * am Anfang</label><span class="error-text pull-right"><b>*Fett</b></span> <!-- Fett begin with asterisk -->
													<select name="fett_begin_with_asterisk" id="fett_begin_with_asterisk" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="fett_converted_spaced_asterisk_at_beginning">Fett (konvertierte Sperrschrift) mit * am Anfang</label><span class="error-text pull-right text-sperrschrift"><b>*Fett</b></span> <!-- Fett begin with asterisk -->
													<select name="fett_converted_spaced_asterisk_at_beginning" id="fett_converted_spaced_asterisk_at_beginning" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="fett_begin_with_asterisk_end_with_t">Fett mit * am Anfang und t.</label><span class="error-text pull-right"><b>*Fett, t.</b></span> <!-- Fett begin with asterisk end with t -->
													<select name="fett_begin_with_asterisk_end_with_t" id="fett_begin_with_asterisk_end_with_t" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="fett_begin_with_asterisk_end_with_tt">Fett mit * am Anfang und tt.</label><span class="error-text pull-right"><b>*Fett, tt.</b></span> <!-- Fett begin with asterisk end with tt -->
													<select name="fett_begin_with_asterisk_end_with_tt" id="fett_begin_with_asterisk_end_with_tt" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="fett_begin_with_asterisk_end_with_degree">Fett mit * am Anfang und °</label><span class="error-text pull-right"><b>*Fett,°</b></span> <!-- Fett begin with asterisk end with degree -->
													<select name="fett_begin_with_asterisk_end_with_degree" id="fett_begin_with_asterisk_end_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="gross">Gross</label><span class="error-text pull-right">GROSS</span>
													<select name="gross" id="gross" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="gross_begin_with_degree">Gross mit ° am Anfang</label><span class="error-text pull-right">°GROSS</span> <!-- Gross begin with degree -->
													<select name="gross_begin_with_degree" id="gross_begin_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="gross_begin_with_asterisk">Gross mit * am Anfang</label><span class="error-text pull-right">*GROSS</span> <!-- Gross begin with asterisk -->
													<select name="gross_begin_with_asterisk" id="gross_begin_with_asterisk" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="gross_bold">Gross fett</label><span class="error-text pull-right"><b>GROSS</b></span> <!-- Gross bold -->
													<select name="gross_bold" id="gross_bold" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="gross_bold_begin_with_degree">Gross fett mit ° am Anfang</label><span class="error-text pull-right"><b>°GROSS</b></span> <!-- Gross bold begin with degree -->
													<select name="gross_bold_begin_with_degree" id="gross_bold_begin_with_degree" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="gross_bold_begin_with_asterisk">Gross fett mit * am Anfang</label><span class="error-text pull-right"><b>*GROSS</b></span> <!-- Gross bold begin with asterisk -->
													<select name="gross_bold_begin_with_asterisk" id="gross_bold_begin_with_asterisk" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="pi_sign">Pi-Zeichen</label><span class="error-text pull-right">π</span>
													<select name="pi_sign" id="pi_sign" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="one_bar">Ein Balken</label><span class="error-text pull-right">|</span>
													<select name="one_bar" id="one_bar" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="two_bar">Zwei Balken</label><span class="error-text pull-right">||</span>
													<select name="two_bar" id="two_bar" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="three_bar">Drei Balken</label><span class="error-text pull-right">|||</span>
													<select name="three_bar" id="three_bar" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="three_and_half_bar">Dreieinhalb Takte</label><span class="error-text pull-right">|||-</span>
													<select name="three_and_half_bar" id="three_and_half_bar" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group">
													<label for="four_bar">Vier Balken</label><span class="error-text pull-right">||||</span>
													<select name="four_bar" id="four_bar" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="four_and_half_bar">Viereinhalb Takte</label><span class="error-text pull-right">||||-</span>
													<select name="four_and_half_bar" id="four_and_half_bar" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
												<div class="form-group hidden">
													<label for="five_bar">Fünf Balken</label><span class="error-text pull-right">|||||</span>
													<select name="five_bar" id="five_bar" class="form-control">
														<option value="">Grade wählen</option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="1.5">1½</option>
														<option value="2">2</option>
														<option value="2.5">2½</option>
														<option value="3">3</option>
														<option value="3.2">3 (2)</option>
														<option value="3.5">3½</option>
														<option value="4">4</option>
														<option value="4.2">4 (2)</option>
														<option value="4.5">4½</option>
														<option value="5">5</option>
														<option value="5.2">5 (2)</option>
												    </select>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-12"><p class="symptom-edit-common-error-text text-danger"></p></div>
								</div>
							</div>
							<!-- symptom settings tab end -->
						</div>
					</div>
			        <!-- Tab end -->
		        </div>
		        <div class="modal-footer">
		        	<input type="hidden" name="symptom_edit_modal_symptom_id" id="symptom_edit_modal_symptom_id">
		        	<input type="hidden" name="symptom_edit_modal_original_source_id" id="symptom_edit_modal_original_source_id">
		        	<input type="hidden" name="symptom_edit_modal_comparison_table" id="symptom_edit_modal_comparison_table">
		        	<input type="hidden" name="symptom_edit_modal_arznei_id" id="symptom_edit_modal_arznei_id">
		        	<input type="hidden" name="original_symptom_encoded_de" id="original_symptom_encoded_de">
		        	<input type="hidden" name="original_symptom_encoded_en" id="original_symptom_encoded_en">
		        	<button type="button" class="btn btn-primary symptom-edit-modal-preview-btn">Preview</button>
		        	<button type="button" class="btn btn-primary symptom-edit-modal-submit-btn hidden">Submit</button>
		        	<button type="button" class="btn btn-primary symptom-edit-preview-modal-back-btn hidden" id="symptom_edit_preview_modal_back_btn">Go Back</button>
		          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        </div>
	    	</form>
	    </div>
    </div>
</div>
<!-- symptom Edit modal end -->

<!-- NonSecureCconnect note modal start -->
<div class="modal fade" id="nscNoteModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	          	<h4 class="modal-title">Nicht Sicher Kommentar</h4>
	        </div>
	        <?php 
	        	if(isset($editingNs) && $editingNs == 1){
	        		echo'<div id="checkingNS" data-mark="'.$editingNs.'"></div>';
	        	}
	        ?>
	        <div id="nsc_note_container" class="modal-body">
	          	<div id="nsc_note_modal_loader" class="form-group text-center">
	          		<span class="loading-msg">Loading informations please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
	          		<span class="error-msg"></span>
				</div>
				<!-- <div id="populated_nsc_note_data">	
          			<div class="row">		
          				<div class="col-sm-12">			
          					<textarea name="nsc_note" id="nsc_note" class="form-control" rows="5" cols="50"></textarea>		
          					<span class="error-text"></span>		
          				</div>	
          			</div>
          		</div> -->
	        </div>
	        <div class="modal-footer">
	          	<button type="button" onclick="addnscNote()" class="btn btn-primary">Save</button>
	          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        </div>
	    </div>
    </div>
</div>
<!-- NonSecureCconnect note modal end -->

<!-- NonSecurePaste note modal start -->
<div class="modal fade" id="nscNoteModalPaste" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	          	<h4 class="modal-title">Nicht Sicher Kommentar</h4>
	        </div>
	        <div id="nsc_note_container_paste" class="modal-body">
	          	<div id="nsc_note_modal_loader_paste" class="form-group text-center">
	          		<span class="loading-msg">Loading informations please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
	          		<span class="error-msg"></span>
				</div>
				<!-- <div id="populated_nsc_note_data">	
          			<div class="row">		
          				<div class="col-sm-12">			
          					<textarea name="nsc_note" id="nsc_note" class="form-control" rows="5" cols="50"></textarea>		
          					<span class="error-text"></span>		
          				</div>	
          			</div>
          		</div> -->
	        </div>
	        <div class="modal-footer">
	          	<button type="button" onclick="addnscNotePaste()" class="btn btn-primary">Save</button>
	          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        </div>
	    </div>
    </div>
</div>
<!-- NonSecurePaste note modal end -->
<!-- General NSC note modal start -->
<div class="modal fade" id="genNscNoteModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	          	<h4 class="modal-title">Nicht Sicher Kommentar</h4>
	        </div>
			<?php 
				if(isset($editingNs) && $editingNs == 1){
					echo'<div id="checkingNS" data-mark="'.$editingNs.'"></div>';
				}
			?>
	        <div id="gen_nsc_note_container" class="modal-body">
	          	<div id="gen_nsc_note_modal_loader" class="form-group text-center">
	          		<span class="loading-msg">Loading informations please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
	          		<span class="error-msg"></span>
				</div>
	        </div>
	        <div class="modal-footer">
	          	<button type="button" onclick="addGenNscNote('1')" class="btn btn-primary">Save</button>
	          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	          	<?php 
	          		$genNsOnDisconnect = '0';
		          	if(isset($editingNs) && $editingNs == 0){
		          		echo '<button type="button" onclick="addGenNscNote('.$genNsOnDisconnect.')" class="btn btn-outline-danger" data-dismiss="modal">Disable</button>';
		          	}
	          	?>
	        </div>
	    </div>
    </div>
</div>
<!-- General NSC note modal end -->
<!-- Global message modal start -->
<div class="modal fade" id="globalMsgModal" role="dialog">
    <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	          	<h4 class="modal-title">Alert</h4>
	        </div>
	        <div id="global_msg_container" class="modal-body">
	          	
	        </div>
	        <div class="modal-footer">
	          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        </div>
	    </div>
    </div>
</div>
<!-- Global message modal end -->

<!-- Translation modal start -->
<div class="modal fade" id="translationModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
	    <div class="modal-content animated bounceInRight">
	    	<form id="translation_form" name="translation_form" action="" method="POST">
		        <div class="modal-header translation-popup-header">
		          	<button type="button" class="close" data-dismiss="modal">&times;</button>
		          	<h4 class="modal-title">Translation</h4>
		        </div>
		        <div id="translation_modal_container" class="modal-body">
		        	<div>
						<div class="row">
							<div class="col-sm-12"><p><b>Symptoms Translation</b></p></div>
							<div class="col-sm-12">
								<table id="resultTable" class="table table-bordered">
									<thead class="heading-table-bg">
										<tr>
											<th style="width: 5%;">Language</th>
											<th style="width: 48%;">Symptom</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<th>German</th>
											<td id="symptom_german_translation"></td>
										</tr>
										<tr>
											<th>English</th>
											<td id="symptom_english_translation"></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12"><p class="common-error-text text-danger"></p></div>
						</div>
					</div>
		        </div>
		        <div class="modal-footer">
		          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        </div>
	    	</form>
	    </div>
    </div>
</div>
<!-- Translation modal end -->

<!-- Search modal start -->
<div class="modal fade" id="symptomSearchModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	        <div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	          	<h4 class="modal-title">Search</h4>
	        </div>
	        <div id="search_container" class="modal-body">
	        	<form id="symptom_search_modal_form" name="symptom_search_modal_form" action="" method="POST">
		          	<div id="search_modal_loader" class="form-group text-center">
		          		<span class="loading-msg">Loading informations please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
		          		<span class="error-msg"></span>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group Text_form_group">
								<label class="search-label">Initial symptom</label>
								<span class="btn-group pull-right" id="status" data-toggle="buttons">
									<label class="btn btn-default btn-comparative btn-xs active">
									<input type="radio" value="1" name="multifeatured_module[module_id][status]" checked="checked">Comparative Symptoms</label>
									<label class="btn btn-default btn-initial btn-xs ">
									<input type="radio" value="2" name="multifeatured_module[module_id][status]">Initial Symptoms</label>
								</span>
								<p id="searchInitialSymptom"></p>
							</div>
						</div>
						<div class="col-sm-12" id="comparing_results_from_search">
							<table id="search_initial_table" class="display table">
								<thead>
									<tr>
										<th class="col-xs-2">Source</th>
										<th>Symptom</th>
									</tr>
								</thead>
								<tbody data-link="row" class="rowlink" id="searchResultTbody">
								</tbody>
							</table>
						</div>

						<div class="col-sm-12 hidden" id="initial_results_from_search">
							<table id="search_initial_table_all" class="display table">
								<thead>
									<tr>
										<th class="col-xs-2">Source</th>
										<th>Symptom</th>
									</tr>
								</thead>
								<tbody data-link="row" class="rowlink" id="searchResultTbody">
								</tbody>
							</table>
						</div>
						
						<div class="col-sm-12">
							<div class="form-group Text_form_group">
								<input type="hidden" name="comparing_source_ids_for_search" id="comparing_source_ids_for_search" value="<?php echo $allInvolvedSourcesIdsOfComparingSource;  ?>">
								<input type="hidden" name="comparison_language_for_search" id="comparison_language_for_search" value="<?php echo $comparisonLanguage;  ?>">
								<input type="hidden" name="comparison_option_for_search" id="comparison_option_for_search" value="<?php echo $comparisonOption;  ?>">
								<input type="hidden" name="comparison_table_to_search" id="comparison_table_to_search" value="<?php echo $comparisonTable;  ?>">
								<input type="hidden" name="initial_search_id" id="initial_search_id" value="0">
							</div>
						</div>
					</div>
				</form>
	        </div>
	        <div class="modal-footer">
	          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        </div>
	    </div>
    </div>
</div>
<!-- Search modal end -->

<!-- Chapter file creation modal start -->
<div class="modal fade" id="chapterFileGenerationModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
	    <div class="modal-content">
			<form action="chapter-download-file-for-model-re-train.php" method="POST" id="chapterFileCreationForm">
				<div class="modal-header">
		          	<button type="button" class="close" data-dismiss="modal">&times;</button>
		          	<h4 class="modal-title">Chapter File Generation</h4>
		        </div>
				<div class="col-sm-12">
					<div id="translation_method_radio_buttons">
						<label class="radio-inline"><input type="radio" name="lang" value="de">German</label>
						<label class="radio-inline"><input type="radio" name="lang" value="en">English</label>
					</div>
					<div class="spacer"></div>
				</div>
				<div class="modal-footer">
		        	<button type="submit" class="btn btn-primary">Submit</button>
		          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        </div>
				<input type="hidden" name="comparison_table_name" value=<?php echo (isset($completedTable))?  $completedTable:  ""?>>
			</form>
	    </div>
    </div>
</div>
<!-- Chapter file creation modal end -->

<!-- Chapter file upload modal start -->
<div class="modal fade" id="chapterFileUploadModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
	    <div class="modal-content" id="chapter_file_upload_body">
			<div id="chapter_file_upload_container" class="modal-body hidden">
				<div class="form-group text-center">
					<span class="loading-msg">Training model please wait... <img src="assets/img/loader.gif" alt="Loading..."></span>
				</div>
			</div>
			<form action="chapter-upload-file-for-model-re-train.php" method="POST" enctype="multipart/form-data" id="chapterFileUploadForm">
				<div class="modal-header">
		          	<button type="button" class="close" data-dismiss="modal">&times;</button>
		          	<h4 class="modal-title">Chapter Model Re-train</h4>
		        </div>
				<div class="col-sm-12">
					<div id="translation_method_radio_buttons">
						<label class="radio-inline"><input type="radio" name="lang" value="de">German</label>
						<label class="radio-inline"><input type="radio" name="lang" value="en">English</label>
					</div>
					<div class="spacer"></div>
				</div>
				<div class="col-sm-12">
					<label for="file">Choose a file:</label>
					<input type="file" id="file" name="file">
					<div class="spacer"></div>
				</div>
				<div class="modal-footer">
		        	<button type="submit" class="btn btn-primary">Submit</button>
		          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        </div>
				<div id="responseMessage"></div>
			</form>
	    </div>
    </div>
</div>
<!-- Chapter file upload modal end -->

<!-- Automatic connection configuration modal start -->
<div class="modal fade" id="automaticConnectionConfiguration" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
	    <div class="modal-content">
			<form action="automatic-connection-list-view.php" method="GET" id="automaticConnectionConfigurationForm">
				<div class="modal-header">
		          	<button type="button" class="close" data-dismiss="modal">&times;</button>
		          	<h4 class="modal-title">Select the percentage for automatic connection</h4>
		        </div>
				<div class="col-sm-12">
					<label class="similarity-rate">Matched percentage(cut-off)<span class="required">*</span></label>
					<select class="form-control save-data" name="automatic_connection_percentage" id="automatic_connection_percentage">
						<?php
							$i=10;
							while($i <= 90)
							{
								?>
								<option value="<?php echo $i; ?>"><?php echo $i." %"; ?></option>
								<?php
								$i = $i+10;  
							}
						?>
					</select>
					<div class="spacer"></div>
				</div>
				<div class="modal-footer">
		        	<button type="submit" class="btn btn-primary">Submit</button>
		          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        </div>
				<input type="hidden" name="comid" value=<?php echo (isset($masterDataID))? $masterDataID: ""?>>
			</form>
	    </div>
    </div>
</div>
<!-- Automatic connection configuration modal end -->

<!-- Automatic connection confirmation modal start -->
<div class="modal fade" id="automaticConnectionConfirmation" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
	    <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Automatic Connection Confirmation</h4>
			</div>
			<div class="col-sm-12">
				<p>Automatic connections are disabled when manual connections are done.</p>
				<p>Do you want to continue with automatic connection process?</p>
				<div class="spacer"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="automaticConnectionConfirmationBtn">Proceed</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
	    </div>
    </div>
</div>
<!-- Automatic connection confirmation modal end -->