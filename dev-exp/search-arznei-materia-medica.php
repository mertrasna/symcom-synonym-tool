<div class="col-sm-12">
	<div class="fancy-collapse-panel">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	        <div class="panel panel-default">
	            <div class="panel-heading" role="tab" id="headingOne">
	                <h4 class="panel-title">
	                    <a class="collapsed" data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">SEARCH ARZNEI</a>
	                </h4>
	            </div>
	            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
              		<form id="arznei_search_medica" name="arznei_search_medica" action="" method="GET">
	                  	<div id="search_container" class="panel-body">
	                      	<!-- Search fields Strat -->
		                  	<div class="row">
		                  		<div class="col-sm-4">
									<div class="form-group Text_form_group">
										<label class="control-label">Arznei<span class="required">*</span></label>
									   	<select class="select2 form-control save-data" name="arznei_id_custom" id="arznei_id" <?php if($is_opened_a_saved_comparison == 1){ ?> readonly <?php } ?>>
									   		<option value="">All</option>
									   		<?php
												$arzneiResult = mysqli_query($db,"SELECT arznei_id, titel FROM arznei");
												while($arzneiRow = mysqli_fetch_array($arzneiResult)){
													$selected = ($arzneiRow['arznei_id'] == $arzneiId) ? 'selected' : '';
													echo '<option '.$selected.' value="'.$arzneiRow['arznei_id'].'">'.$arzneiRow['titel'].'</option>';
												}
											?>
									   	</select>
									   	<span class="error-text <?php if(isset($error_msg['arznei_id']) AND $error_msg['arznei_id'] != ""){ echo 'text-danger'; } ?>"><?php if(isset($error_msg['arznei_id']) AND $error_msg['arznei_id'] != ""){ echo $error_msg['arznei_id']; } ?></span>	
									</div>
								</div>
								<div class="col-sm-4">
									<label class="control-label">Jahr</label>
									<input type="text" id="jahr" name="jahr_custom" class="form-control">
								</div>
								<div class="col-sm-4">
									<label class="control-label">Date</label>
									<input type="date" id="date" name="date_custom" class="form-control">
								</div>
		                  	</div>
		                  	<div class="row">
		                  		<div class="col-sm-4">
									<label class="control-label">Titel</label>
									<input type="text" id="titel" name="titel_custom" class="form-control">
								</div>
								<div class="col-sm-4">
									<label class="control-label">Kürzel</label>
									<input type="text" id="code" name="code_custom" class="form-control">
								</div>
								<div class="col-sm-4"></div>
		                  	</div>
		                  	<input type="hidden" name="custom_form_submission">
							<div class="form-group">
								<div class="spacer15"></div>
								<button type="submit" class="btn comparison-tab-submit-btn">SEARCH</button>
							</div>
							<!-- Search fields End -->
	                  	</div>
              		</form>
	            </div>
	        </div>
        </div>
    </div>
</div>