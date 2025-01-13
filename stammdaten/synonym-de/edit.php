<?php
include '../../lang/GermanWords.php';
include '../../config/route.php';
include '../../api/synonym-de.php';
include '../../inc/header.php';
include '../../inc/sidebar.php';
?>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Ändern Synonym
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $absoluteUrl;?>"><i class="fa fa-dashboard"></i> <?php echo $home; ?></a></li>
        <li class=""> <a href="<?php echo $absoluteUrl;?>stammdaten/synonym-de/"> Synonym</a></li>
        <li class="active">  Ändern Synonym</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-md-12">
				<div class="box box-success">
		            <div class="box-header with-border">
		              <p>Die mit * gekennzeichneten Felder sind Pflichtfelder</p>
		            </div>
		            <!-- /.box-header -->
		            <!-- form start -->
		            <form class="content-form" id="addSynonymDeForm" data-action="update" data-source="synonym-de" data-source_id_value="<?php echo $synonymDe['synonym_id'];?>" data-source_id_name="synonym" autocomplete="off">
		              <div class="box-body">
		              	<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="word">Wort*</label><span class="error-text"></span>
									<input type="text" class="form-control" id="word" name="word" value="<?php echo $synonymDe['word']; ?>" required autofocus>
									<div class="synonym_ns_checkbox"><input type="checkbox" name="synonym_ns" id="synonym_ns_check" <?php echo ($synonymDe['synonym_ns'] == "1")? "checked value='1'" : "value='0'" ; ?>> Doubtful</div>
								</div>
								<div class="form-group">
									<label for="strict_synonym">Striktes Synonym*</label><span class="error-text"></span>
									<input type="text" class="form-control" id="strict_synonym" name="strict_synonym" value="<?php echo $synonymDe['strict_synonym']; ?>" required>
									<small>Fügen Sie kommagetrennte Werte hinzu(i.e.: <b>ache, aching, agony</b>)</small>
								</div>
								<div class="form-group">
									<label for="synonym_partial_1">Cross Reference</label><span class="error-text"></span>
									<input type="text" class="form-control" id="synonym_partial_1" name="synonym_partial_1" value="<?php echo $synonymDe['synonym_partial_1']; ?>">
									<small>Fügen Sie kommagetrennte Werte hinzu(i.e.: <b>ache, aching, agony</b>)</small>
								</div>
								<div class="form-group">
									<label for="synonym_partial_2">Hyperlink</label><span class="error-text"></span>
									<input type="text" class="form-control" id="synonym_partial_2" name="synonym_partial_2" value="<?php echo $synonymDe['synonym_partial_2']; ?>">
									<small>Fügen Sie kommagetrennte Werte hinzu(i.e.: <b>ache, aching, agony</b>)</small>
								</div>
								<div class="form-group">
									<label for="synonym_general">Hyperonym (Oberbegriff)</label><span class="error-text"></span>
									<input type="text" class="form-control" id="synonym_general" name="synonym_general" value="<?php echo $synonymDe['synonym_general']; ?>">
									<small>Fügen Sie kommagetrennte Werte hinzu(i.e.: <b>ache, aching, agony</b>)</small>
								</div>
								<div class="form-group">
									<label for="synonym_minor">Hyponym (Unterbegriff)</label><span class="error-text"></span>
									<input type="text" class="form-control" id="synonym_minor" name="synonym_minor" value="<?php echo $synonymDe['synonym_minor']; ?>">
									<small>Fügen Sie kommagetrennte Werte hinzu(i.e.: <b>ache, aching, agony</b>)</small>
								</div>
								<div class="form-group">
									<label for="synonym_nn">Synonym NN</label><span class="error-text"></span>
									<input type="text" class="form-control" id="synonym_nn" name="synonym_nn" value="<?php echo $synonymDe['synonym_nn']; ?>">
									<small>Fügen Sie kommagetrennte Werte hinzu(i.e.: <b>ache, aching, agony</b>)</small>
								</div>
								<div class="form-group">
									<label for="synonym_reference_id">Source Reference</label><span class="error-text"></span>
									<select id="synonym_reference_id" class="select2 form-control" multiple="multiple" data-placeholder="Select References" name="synonym_reference_id[]">
										<?php 
										$synonymReferenceIdArray = array();
											if(!empty($synonymDe['synonymreference'])){
												$arraySize = count($synonymDe['synonymreference']);
												$i = 0;
												while($i < $arraySize){
													array_push($synonymReferenceIdArray, $synonymDe['synonymreference'][$i]["synonym_reference_id"]);
													?>
													<option value="<?php echo $synonymDe['synonymreference'][$i]["synonym_reference_id"];?>" selected><?php echo $synonymDe['synonymreference'][$i]["titel"];?></option>
													<?php
													$i++;
												}
											}
										?>
										<?php 
											foreach ($synonymReferences as $key => $synonymRef) { 
												if(!(in_array($synonymRef['synonym_reference_id'],$synonymReferenceIdArray))){
													?>
													<option value="<?php echo $synonymRef['synonym_reference_id'];?>"><?php echo $synonymRef['titel'];?></option>
												<?php
												}
											} 
										?>
									</select>
									<div class="synonym_ns_checkbox"><input type="checkbox" name="source_reference_ns" id="source_reference_ns_check" <?php echo ($synonymDe['source_reference_ns'] == "1")? "checked value='1'" : "value='0'" ; ?>> Doubtful</div>
								</div>
								<div class="form-group">
									<label for="synonym_comment">Comments</label><span class="error-text"></span>
									<input type="text" class="form-control" id="synonym_comment" name="synonym_comment" value="<?php echo $synonymDe['synonym_comment']; ?>">
								</div>
							</div>
						</div>
		              </div>
		              <!-- /.box-body -->

		              <div class="box-footer">
		                <input class="btn btn-success" type="submit" value="Änderungen speichern" name="ÄnderungenSpeichern" id="saveFormBtn">
						<a class="btn btn-default" href="<?php echo $absoluteUrl;?>stammdaten/synonym-de/" id="cancelBtn">Abbrechen</a>
						<a href="<?php echo $absoluteUrl;?>stammdaten/synonym-de/" class="pull-right btn btn-primary" style="background: #000;">Zurück</a>
		              </div>
		            </form>
		          </div>
			</div>
		</div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
include '../../inc/footer.php';
?>