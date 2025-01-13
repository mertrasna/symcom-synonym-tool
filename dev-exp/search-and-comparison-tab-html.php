<div class="col-sm-12">
	<div class="fancy-collapse-panel">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a class="collapsed" data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">SEARCH</a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <form id="symptom_search_form" name="symptom_search_form" action="" method="POST">
                      <div id="search_container" class="panel-body">
                          <!-- Search fields Strat -->
                      	<div class="row">
							<div class="col-sm-8">
								<div class="form-group Text_form_group">
									<label class="search-label">Search</label>
									<input type="text" name="search_keyword" id="search_keyword" class="form-control" placeholder="Search for words or part of words, from one or multiple sources">
									<span class="error-text"></span>
								</div>
							</div>
							<div class="col-sm-4"></div>
						</div>
						<div class="row">
							<div class="col-sm-8">
								<div class="form-group Text_form_group">
									<label class="search-sources-label">Source(s)</label>
									<select class="select2 form-control" name="search_sources[]" id="search_sources" multiple="multiple" data-placeholder="Select one or multiple sources">
							   			<option value="">Select</option>
							   			<?php 
							   				echo getAllSourcesSelectBox();
								   		?>
							   		</select>
							   		<span class="error-text"></span>
								</div>
							</div>
							<div class="col-sm-4"></div>
						</div>
						<div class="form-group">
							<div class="spacer15"></div>
							<button type="submit" id="search_submit_btn" class="btn comparison-tab-submit-btn" type="button">SEARCH</button>
						</div>
						<!-- Search fields End -->
                      </div>
                  </form>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">SOURCE COMPARISON</a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                  <form id="symptom_comparison_form" name="symptom_comparison_form" action="" method="POST">	
                      <div id="comparison_container" class="panel-body">
                      	<!-- Source comparison fields Strat -->
                      	<div class="row">
							<div class="col-sm-6">
								<div class="form-group Text_form_group">
									<label class="similarity-rate">Matched percentage(cut-off)<span class="required">*</span></label>
								   	<select class="form-control save-data" name="similarity_rate" id="similarity_rate">
								   		<?php
											$i=0;
											while($i <= 10)
											{	
												if($i>=0){
													?>
													<option <?php echo ($i == $similarityRate) ? 'selected' : ''; ?> value="<?php echo $i; ?>"><?php echo $i." %"; ?></option>
													<?php
												}
												$i = $i+1;  
											}
											?>
											<option <?php $i = 12; echo ($i == $similarityRate) ? 'selected' : ''; ?> value="<?php echo $i; ?>"><?php echo $i." %"; ?></option>
											<?php
											?>
											<option <?php $i = 15; echo ($i == $similarityRate) ? 'selected' : ''; ?> value="<?php echo $i; ?>"><?php echo $i." %"; ?></option>
											<?php
											?>
											<option <?php $i = 17; echo ($i == $similarityRate) ? 'selected' : ''; ?> value="<?php echo $i; ?>"><?php echo $i." %"; ?></option>
											<?php
											$i = 20;
											while($i <= 50)
											{	
												if($i>=20){
													?>
													<option <?php echo ($i == $similarityRate) ? 'selected' : ''; ?> value="<?php echo $i; ?>"><?php echo $i." %"; ?></option>
													<?php
												}
												$i = $i+5;  
											}
								   		?>
								   	</select>
								   	<span class="error-text"></span>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group Text_form_group">
									<label class="language-label">Language<span class="required">*</span></label>
								   	<select class="form-control save-data" name="comparison_language" id="comparison_language">
								   		<option value="">Select</option>
								   		<option <?php echo (isset($comparisonLanguage) AND $comparisonLanguage == 'de') ? 'selected' : ''; ?> value="de">German</option>
								   		<option <?php echo (isset($comparisonLanguage) AND $comparisonLanguage == 'en') ? 'selected' : ''; ?> value="en">English</option>
								   	</select>	
								   	<span class="error-text <?php if(isset($error_msg['comparison_language']) AND $error_msg['comparison_language'] != ""){ echo 'text-danger'; } ?>"><?php if(isset($error_msg['comparison_language']) AND $error_msg['comparison_language'] != ""){ echo $error_msg['comparison_language']; } ?></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group Text_form_group">
									<label class="control-label">Remedy<span class="required">*</span></label>
								   	<select class="select2 form-control save-data" name="arznei_id" id="arznei_id" <?php if($is_opened_a_saved_comparison == 1){ ?> readonly <?php } ?>>
								   		<option value="">Select</option>
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
							<div class="col-sm-6">
								<div class="form-group Text_form_group">
									<label class="comparing-option-label">Comparison option</label>
									<select class="form-control save-data" name="comparison_option" id="comparison_option">
										<option value="1" <?php echo ($comparisonOption == 1) ? 'selected' : ''; ?>>Compare only symptoms</option>
										<option value="2" <?php echo ($comparisonOption == 2) ? 'selected' : ''; ?>>Compare whole symptom text</option>
									</select>
									<span class="error-text"></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group Text_form_group">
									<label class="control-label">Initial source<span class="required">*</span></label>
									<div id="initial_source_cnr">
										<select class="select2 form-control save-data" name="initial_source" id="initial_source" <?php if($is_opened_a_saved_comparison == 1){ ?> readonly <?php } ?>>
											<option value="">Select</option>
											<?php echo " initialSourceId ".$initialSourceId; ?>
											<?php echo getInitialSourceSelectbox($initialSourceId, $arzneiId); ?>
									   	</select>
									   	<span class="error-text <?php if(isset($error_msg['initial_source']) AND $error_msg['initial_source'] != ""){ echo 'text-danger'; } ?>"><?php if(isset($error_msg['initial_source']) AND $error_msg['initial_source'] != ""){ echo $error_msg['initial_source']; } ?></span>
									</div>	
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group Text_form_group">
									<label class="control-label">Comparison source(s)<span class="required">*</span></label>
									<div id="comparing_source_cnr">
										<select class="select2 form-control save-data" name="comparing_sources[]" id="comparing_sources" multiple="multiple" data-placeholder="Search comparison source(s)" <?php if($is_opened_a_saved_comparison == 1){ ?> readonly <?php } ?>>
								   			<option value="">Select</option>
								   			<?php 
								   				echo getComparingSourceSelectbox($initialSourceId, $comparingSourceIds, $arzneiId);
									   		?>
								   		</select>
								   		<span class="error-text <?php if(isset($error_msg['comparing_sources']) AND $error_msg['comparing_sources'] != ""){ echo 'text-danger'; } ?>"><?php if(isset($error_msg['comparing_sources']) AND $error_msg['comparing_sources'] != ""){ echo $error_msg['comparing_sources']; } ?></span>
									</div>
								</div>
							</div>
						</div>						
						<div class="form-group">
							<div class="spacer15"></div>
                  			<input type="hidden" name="is_opened_a_saved_comparison" id="is_opened_a_saved_comparison" value="<?php if($is_opened_a_saved_comparison == 1){ echo 1; } ?>">
                  			<?php if(!isset($historyPage)){ ?>
								<button type="submit" id="compare_submit" name="compare_submit" class="btn comparison-tab-submit-btn" >COMPARE</button>
							<?php } ?>
							<span class="pull-right stop-word-link">
								<a class="stop-word-anchor-tag" title="Stop words" target="_blank" href="<?php echo $baseUrl."stop-words.php"; ?>">Click Here</a> to see the active stop words
							</span>
						</div>
                      	<!-- Source comparison fields end -->
                      </div>
                  </form>
                  	<input type="hidden" name="saved_initial_source_id" id="saved_initial_source_id" value="<?php echo $initialSourceId; ?>">
                  	<input type="hidden" name="hidden_comparison_language" id="hidden_comparison_language" value="<?php echo $comparisonLanguage; ?>">
					<input type="hidden" name="saved_comparison_comparing_source_ids_comma_separated" id="saved_comparison_comparing_source_ids_comma_separated" value="<?php echo $savedComparisonComparingSourceIdsCommaSeparated; ?>">
                </div>
            </div>
        </div>
	</div>
	<div id="loader" class="form-group text-center hidden">
		Loading is not complete please wait <img src="../assets/img/loader.gif" alt="Loading...">
	</div>
</div>