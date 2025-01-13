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
	        	<button type="button" onclick="updateComment()" class="btn btn-primary">Save</button>
	          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
	          	<button type="button" onclick="updateFootnote()" class="btn btn-primary">Save</button>
	          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        </div>
	    </div>
    </div>
</div>
<!-- Footnote modal end -->

<!-- NSC note modal start -->
<div class="modal fade" id="nscNoteModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	          	<h4 class="modal-title">Nicht Sicher Kommentar</h4>
	        </div>
	        <div id="nsc_note_container" class="modal-body">
	          	<div id="nsc_note_modal_loader" class="form-group text-center">
	          		<span class="loading-msg">Loading informations please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
	          		<span class="error-msg"></span>
				</div>
	        </div>
	        <div class="modal-footer">
	          	<button type="button" onclick="addnscNote()" class="btn btn-primary">Save</button>
	          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        </div>
	    </div>
    </div>
</div>
<!-- NSC note modal end -->

<!-- NSP note modal start -->
<div class="modal fade" id="nspNoteModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	          	<h4 class="modal-title">Nicht Sicher Kommentar</h4>
	        </div>
	        <div id="nsp_note_container" class="modal-body">
	          	<div id="nsp_note_modal_loader" class="form-group text-center">
	          		<span class="loading-msg">Loading informations please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
	          		<span class="error-msg"></span>
				</div>
	        </div>
	        <div class="modal-footer">
	          	<button type="button" onclick="addnspNote()" class="btn btn-primary">Save</button>
	          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        </div>
	    </div>
    </div>
</div>
<!-- NSP note modal end -->

<!-- Save comparison need user action modal start -->
<div class="modal fade" id="saveComparisonModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	          	<h4 class="modal-title">Save</h4>
	        </div>
	        <div id="save_comparison_modal_container" class="modal-body">
	          	<div id="save_comparison_modal_loader" class="form-group text-center">
	          		<span class="loading-msg">Loading informations please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
	          		<span class="error-msg"></span>
				</div>
	        </div>
	        <div class="modal-footer">
	          	<button type="button" id="save_on_existing_btn" onclick="saveComparisonOnExisting()" class="btn btn-info">Save</button>
	          	<!-- <button type="button" onclick="saveComparisonAsNew()" class="btn btn-primary">Save as new</button> -->
	          	<button type="button" onclick="saveComparisonCancel()" class="btn btn-default">Cancel</button>
	        </div>
	    </div>
    </div>
</div>
<!-- Save comparison need user action modal end -->

<!-- Swap connection confirm modal start -->
<div class="modal fade" id="swapConnectionConfirmModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	          	<h4 class="modal-title">Confirm</h4>
	        </div>
	        <div id="swap_connection_confirm_modal_container" class="modal-body">
	          	<div id="swap_connection_confirm_modal_loader" class="form-group text-center">
	          		<span class="loading-msg">Loading informations please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
	          		<span class="error-msg"></span>
				</div>
	        </div>
	        <div class="modal-footer">
	          	<button type="button" id="swap_connect_cancel_btn" class="btn btn-default" data-dismiss="modal">Cancel</button>
	          	<button type="button" id="swap_connect_yes_btn" class="btn btn-info">Ok</button>
	        </div>
	    </div>
    </div>
</div>
<!-- Swap connection confirm modal end -->

<!-- Connect Edit modal start -->
<div class="modal fade" id="connectEditModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	    	<form id="connect_edit_form" name="connect_edit_form" action="" method="POST">
		        <div class="modal-header">
		          	<button type="button" class="close" data-dismiss="modal">&times;</button>
		          	<h4 class="modal-title">Connect/Paste Edit</h4>
		        </div>
		        <div id="connect_edit_modal_container" class="modal-body">
		          	<div id="connect_edit_modal_loader" class="form-group text-center">
		          		<span class="loading-msg">Loading informations please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
		          		<span class="error-msg"></span>
					</div>
					<div id="connect_edit_symptom_de_container" class="row">
	          			<div class="col-sm-12"><p><b>Symptom (de)</b></p></div>
	          			<div class="col-sm-12">
	          				<textarea id="fv_symptom_de" name="fv_symptom_de" class="texteditor-small" aria-hidden="true"></textarea>
	          				<span class="fv-symptom-de-error error-text text-danger"></span>
	          			</div>
	          		</div>
					<div id="connect_edit_symptom_en_container" class="row">
						<div class="spacer"></div>
	          			<div class="col-sm-12"><p><b>Symptom (en)</b></p></div>
	          			<div class="col-sm-12">
	          				<textarea id="fv_symptom_en" name="fv_symptom_en" class="texteditor-small" aria-hidden="true"></textarea>
	          				<span class="fv-symptom-en-error error-text text-danger"></span>
	          			</div>
	          		</div>
		        </div>
		        <div class="modal-footer">
		        	<input type="hidden" name="fv_symptom_id" id="fv_symptom_id">
		        	<input type="hidden" name="fv_initial_source_symptom_id" id="fv_initial_source_symptom_id">
		        	<input type="hidden" name="fv_comparing_source_symptom_id" id="fv_comparing_source_symptom_id">
		        	<input type="hidden" name="fv_comparison_option" id="fv_comparison_option">
		        	<input type="hidden" name="fv_unique_id" id="fv_unique_id">
		        	<input type="hidden" name="fv_connection_or_paste_type" id="fv_connection_or_paste_type">
		        	<input type="hidden" name="fv_arznei_id" id="fv_arznei_id">
		        	<button type="submit" class="btn btn-primary connect-edit-modal-submit-btn">Submit</button>
		          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        </div>
	    	</form>
	    </div>
    </div>
</div>
<!-- Connect Edit modal end -->

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
		        	<!-- Tab start -->
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
									<div id="symptom_edit_symptom_de_container" class="row">
					          			<div class="col-sm-12">
					          				<div><b>Symptom(de)</b></div>
					          				<p><small>This is the imported version of the symptom. Program will automatically create the converted version after submit.</small></p>
					          			</div>
					          			<div class="col-sm-12">
					          				<textarea id="symptom_edit_de" name="symptom_edit_de" class="texteditor-small" aria-hidden="true"></textarea>
					          				<span class="symptom-edit-de-error error-text text-danger"></span>
					          			</div>
					          		</div>
									<div id="symptom_edit_symptom_en_container" class="row">
										<div class="spacer"></div>
					          			<div class="col-sm-12">
					          				<div><b>Symptom(en)</b></div>
					          				<p><small>This is the imported version of the symptom. Program will automatically create the converted version after submit.</small></p>
					          			</div>
					          			<div class="col-sm-12">
					          				<textarea id="symptom_edit_en" name="symptom_edit_en" class="texteditor-small" aria-hidden="true"></textarea>
					          				<span class="symptom-edit-en-error error-text text-danger"></span>
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
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="normal_within_parentheses">Normal in Klammern</label><span class="error-text pull-right">(Normal)</span> <!-- Normal within parentheses -->
												<select name="normal_within_parentheses" id="normal_within_parentheses" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="normal_end_with_t">Normal mit t.</label><span class="error-text pull-right">Normal, t.</span> <!-- Normal end with t -->
												<select name="normal_end_with_t" id="normal_end_with_t" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="normal_end_with_tt">Normal mit tt.</label><span class="error-text pull-right">Normal, tt.</span> <!-- Normal end with tt -->
												<select name="normal_end_with_tt" id="normal_end_with_tt" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="normal_begin_with_degree">Normal mit ° am Anfang</label><span class="error-text pull-right">°Normal</span> <!-- Normal begin with degree -->
												<select name="normal_begin_with_degree" id="normal_begin_with_degree" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="normal_end_with_degree">Normal mit ° am Ende</label><span class="error-text pull-right">Normal,°</span> <!-- Normal end with degree -->
												<select name="normal_end_with_degree" id="normal_end_with_degree" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="normal_begin_with_asterisk">Normal mit * am Anfang</label><span class="error-text pull-right">*Normal</span> <!-- Normal begin with asterisk -->
												<select name="normal_begin_with_asterisk" id="normal_begin_with_asterisk" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="normal_begin_with_asterisk_end_with_t">Normal mit * am Anfang und t.</label><span class="error-text pull-right">*Normal, t.</span> <!-- Normal begin with asterisk end with t -->
												<select name="normal_begin_with_asterisk_end_with_t" id="normal_begin_with_asterisk_end_with_t" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="normal_begin_with_asterisk_end_with_tt">Normal mit * am Anfang und tt.</label><span class="error-text pull-right">*Normal, tt.</span> <!-- Normal begin with asterisk end with tt -->
												<select name="normal_begin_with_asterisk_end_with_tt" id="normal_begin_with_asterisk_end_with_tt" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="normal_begin_with_asterisk_end_with_degree">Normal mit * am Anfang und °</label><span class="error-text pull-right">*Normal,°</span> <!-- Normal begin with asterisk end with degree -->
												<select name="normal_begin_with_asterisk_end_with_degree" id="normal_begin_with_asterisk_end_with_degree" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="sperrschrift">Sperrschrift</label><span class="error-text text-sperrschrift pull-right">Sperrschrift</span>
												<select name="sperrschrift" id="sperrschrift" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="sperrschrift_begin_with_degree">Sperrschrift mit ° am Anfang</label><span class="error-text text-sperrschrift pull-right">°Sperrschrift</span> <!-- Sperrschrift begin with degree -->
												<select name="sperrschrift_begin_with_degree" id="sperrschrift_begin_with_degree" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="sperrschrift_begin_with_asterisk">Sperrschrift mit * am Anfang</label><span class="error-text text-sperrschrift pull-right">*Sperrschrift</span><!-- Sperrschrift begin with asterisk -->
												<select name="sperrschrift_begin_with_asterisk" id="sperrschrift_begin_with_asterisk" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="sperrschrift_bold">Sperrschrift fett</label><span class="error-text text-sperrschrift pull-right"><b>Sperrschrift</b></span><!-- Sperrschrift bold -->
												<select name="sperrschrift_bold" id="sperrschrift_bold" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="sperrschrift_bold_begin_with_degree">Sperrschrift fett mit ° am Anfang</label><span class="error-text text-sperrschrift pull-right"><b>°Sperrschrift</b></span><!-- Sperrschrift bold begin with degree -->
												<select name="sperrschrift_bold_begin_with_degree" id="sperrschrift_bold_begin_with_degree" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="sperrschrift_bold_begin_with_asterisk">Sperrschrift fett mit * am Anfang</label><span class="error-text text-sperrschrift pull-right"><b>*Sperrschrift</b></span> <!-- Sperrschrift bold begin with asterisk -->
												<select name="sperrschrift_bold_begin_with_asterisk" id="sperrschrift_bold_begin_with_asterisk" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="kursiv">Kursiv</label><span class="error-text pull-right"><i>Kursiv</i></span>
												<select name="kursiv" id="kursiv" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="kursiv_end_with_t">Kursiv mit t.</label><span class="error-text pull-right"><i>Kursiv, t.</i></span> <!-- Kursiv end with t -->
												<select name="kursiv_end_with_t" id="kursiv_end_with_t" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="kursiv_end_with_tt">Kursiv mit tt.</label><span class="error-text pull-right"><i>Kursiv, tt.</i></span><!-- Kursiv end with tt -->
												<select name="kursiv_end_with_tt" id="kursiv_end_with_tt" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="kursiv_begin_with_degree">Kursiv mit ° am Anfang</label><span class="error-text pull-right"><i>°Kursiv</i></span> <!-- Kursiv begin with degree -->
												<select name="kursiv_begin_with_degree" id="kursiv_begin_with_degree" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="kursiv_end_with_degree">Kursiv mit ° am Ende</label><span class="error-text pull-right"><i>Kursiv,°</i></span> <!-- Kursiv end with degree -->
												<select name="kursiv_end_with_degree" id="kursiv_end_with_degree" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="kursiv_begin_with_asterisk">Kursiv mit * am Anfang</label><span class="error-text pull-right"><i>*Kursiv</i></span> <!-- Kursiv begin with asterisk -->
												<select name="kursiv_begin_with_asterisk" id="kursiv_begin_with_asterisk" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="kursiv_begin_with_asterisk_end_with_t">Kursiv mit * am Anfang und t.</label><span class="error-text pull-right"><i>*Kursiv, t.</i></span> <!-- Kursiv begin with asterisk end with t -->
												<select name="kursiv_begin_with_asterisk_end_with_t" id="kursiv_begin_with_asterisk_end_with_t" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label for="kursiv_begin_with_asterisk_end_with_tt">Kursiv mit * am Anfang und tt.</label><span class="error-text pull-right"><i>*Kursiv, tt.</i></span><!-- Kursiv begin with asterisk end with tt -->
												<select name="kursiv_begin_with_asterisk_end_with_tt" id="kursiv_begin_with_asterisk_end_with_tt" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="kursiv_begin_with_asterisk_end_with_degree">Kursiv mit * am Anfang und ° am Ende</label><span class="error-text pull-right"><i>*Kursiv,°</i></span><!-- Kursiv begin with asterisk end with degree -->
												<select name="kursiv_begin_with_asterisk_end_with_degree" id="kursiv_begin_with_asterisk_end_with_degree" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="kursiv_bold">Kursiv fett</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>Kursiv</b></i></span> <!-- Kursiv bold -->
												<select name="kursiv_bold" id="kursiv_bold" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="kursiv_bold_begin_with_asterisk_end_with_t">Kursiv fett mit * am Anfang und t.</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>*Kursiv, t.</b></i></span> <!-- Kursiv bold begin with asterisk end with t -->
												<select name="kursiv_bold_begin_with_asterisk_end_with_t" id="kursiv_bold_begin_with_asterisk_end_with_t" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="kursiv_bold_begin_with_asterisk_end_with_tt">Kursiv fett mit * am Anfang und tt.</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>*Kursiv, tt.</b></i></span> <!-- Kursiv bold begin with asterisk end with tt -->
												<select name="kursiv_bold_begin_with_asterisk_end_with_tt" id="kursiv_bold_begin_with_asterisk_end_with_tt" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="kursiv_bold_begin_with_degree">Kursiv fett mit ° am Anfang</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>°Kursiv</b></i></span> <!-- Kursiv bold begin with degree -->
												<select name="kursiv_bold_begin_with_degree" id="kursiv_bold_begin_with_degree" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="kursiv_bold_begin_with_asterisk">Kursiv fett mit * am Anfang</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>*Kursiv</b></i></span> <!-- Kursiv bold begin with asterisk -->
												<select name="kursiv_bold_begin_with_asterisk" id="kursiv_bold_begin_with_asterisk" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="kursiv_bold_begin_with_asterisk_end_with_degree">Kursiv fett mit * am Anfang und ° am Ende</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>*Kursiv,°</b></i></span> <!-- Kursiv bold begin with asterisk end with degree -->
												<select name="kursiv_bold_begin_with_asterisk_end_with_degree" id="kursiv_bold_begin_with_asterisk_end_with_degree" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="fett">Fett</label> <span class="error-text pull-right"><b>Fett</b></span> 
												<select name="fett" id="fett" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="fett_end_with_t">Fett mit t.</label><span class="error-text pull-right"><b>Fett, t.</b></span> <!-- Fett end with t -->
												<select name="fett_end_with_t" id="fett_end_with_t" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="fett_end_with_tt">Fett mit tt.</label><span class="error-text pull-right"><b>Fett, tt.</b></span> <!-- Fett end with tt -->
												<select name="fett_end_with_tt" id="fett_end_with_tt" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="fett_begin_with_degree">Fett mit ° am Anfang</label><span class="error-text pull-right"><b>°Fett</b></span> <!-- Fett begin with degree -->
												<select name="fett_begin_with_degree" id="fett_begin_with_degree" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="fett_end_with_degree">Fett mit ° am Ende</label><span class="error-text pull-right"><b>Fett,°</b></span> <!-- Fett end with degree -->
												<select name="fett_end_with_degree" id="fett_end_with_degree" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="fett_begin_with_asterisk">Fett mit * am Anfang</label><span class="error-text pull-right"><b>*Fett</b></span> <!-- Fett begin with asterisk -->
												<select name="fett_begin_with_asterisk" id="fett_begin_with_asterisk" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="fett_begin_with_asterisk_end_with_t">Fett mit * am Anfang und t.</label><span class="error-text pull-right"><b>*Fett, t.</b></span> <!-- Fett begin with asterisk end with t -->
												<select name="fett_begin_with_asterisk_end_with_t" id="fett_begin_with_asterisk_end_with_t" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="fett_begin_with_asterisk_end_with_tt">Fett mit * am Anfang und tt.</label><span class="error-text pull-right"><b>*Fett, tt.</b></span> <!-- Fett begin with asterisk end with tt -->
												<select name="fett_begin_with_asterisk_end_with_tt" id="fett_begin_with_asterisk_end_with_tt" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="fett_begin_with_asterisk_end_with_degree">Fett mit * am Anfang und °</label><span class="error-text pull-right"><b>*Fett,°</b></span> <!-- Fett begin with asterisk end with degree -->
												<select name="fett_begin_with_asterisk_end_with_degree" id="fett_begin_with_asterisk_end_with_degree" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="gross">Gross</label><span class="error-text pull-right">GROSS</span>
												<select name="gross" id="gross" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="gross_begin_with_degree">Gross mit ° am Anfang</label><span class="error-text pull-right">°GROSS</span> <!-- Gross begin with degree -->
												<select name="gross_begin_with_degree" id="gross_begin_with_degree" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="gross_begin_with_asterisk">Gross mit * am Anfang</label><span class="error-text pull-right">*GROSS</span> <!-- Gross begin with asterisk -->
												<select name="gross_begin_with_asterisk" id="gross_begin_with_asterisk" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="gross_bold">Gross fett</label><span class="error-text pull-right"><b>GROSS</b></span> <!-- Gross bold -->
												<select name="gross_bold" id="gross_bold" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="gross_bold_begin_with_degree">Gross fett mit ° am Anfang</label><span class="error-text pull-right"><b>°GROSS</b></span> <!-- Gross bold begin with degree -->
												<select name="gross_bold_begin_with_degree" id="gross_bold_begin_with_degree" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
											    </select>
											</div>
											<div class="form-group">
												<label for="gross_bold_begin_with_asterisk">Gross fett mit * am Anfang</label><span class="error-text pull-right"><b>*GROSS</b></span> <!-- Gross bold begin with asterisk -->
												<select name="gross_bold_begin_with_asterisk" id="gross_bold_begin_with_asterisk" class="form-control">
													<option value="">Grade wählen</option>
													<option value="1">1</option>
													<option value="1.5">1.5</option>
													<option value="2">2</option>
													<option value="2.5">2.5</option>
													<option value="3">3</option>
													<option value="3.5">3.5</option>
													<option value="4">4</option>
													<option value="4.5">4.5</option>
													<option value="5">5</option>
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
			        <!-- Tab end -->
		        </div>
		        <div class="modal-footer">
		        	<input type="hidden" name="symptom_edit_modal_symptom_id" id="symptom_edit_modal_symptom_id">
		        	<input type="hidden" name="symptom_edit_modal_original_source_id" id="symptom_edit_modal_original_source_id">
		        	<button type="button" class="btn btn-primary symptom-edit-modal-submit-btn">Submit</button>
		          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        </div>
	    	</form>
	    </div>
    </div>
</div>
<!-- symptom Edit modal end -->

<!-- Global message modal start -->
<div class="modal fade" id="reloadPageModal" role="dialog">
    <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	          	<h4 class="modal-title">Alert</h4>
	        </div>
	        <div id="reload_page_modal_container" class="modal-body">
	          	
	        </div>
	        <div class="modal-footer">
	          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        </div>
	    </div>
    </div>
</div>
<!-- Global message modal end -->

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