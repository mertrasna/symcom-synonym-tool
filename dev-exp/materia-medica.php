<?php
    include '../lang/GermanWords.php';
    include '../config/route.php';
    include 'sub-section-config.php';
    // include '../api/mainCall.php';
?>
<?php
    /*
	* Here we are displying the Materia medicas. The sources which are available for comparison are listed here. 
	* Once a particular source is used in creating another source(means saved comparison) then that source no longer will be the part of the materia medica.  
	*/
	$is_opened_a_saved_comparison = (isset($comparisonTableDataArr['is_opened_a_saved_comparison']) AND !empty($comparisonTableDataArr['is_opened_a_saved_comparison'])) ? $comparisonTableDataArr['is_opened_a_saved_comparison'] : "";
	$arzneiId = (isset($_GET['arznei_id_custom']) AND $_GET['arznei_id_custom'] != "") ? $_GET['arznei_id_custom'] : "";
	$arzneiHead = "Materia Medica";
	if($arzneiId != ""){
		$arzneiHeadResult = mysqli_query($db,"SELECT titel FROM arznei WHERE arznei_id = $arzneiId");
		if(mysqli_num_rows($arzneiHeadResult) > 0){
			$arzneiHeadData = mysqli_fetch_assoc($arzneiHeadResult);
			$arzneiHead = (isset($arzneiHeadData['titel']) AND $arzneiHeadData['titel'] != "") ? $arzneiHeadData['titel'] : "Materia Medica";
		}
	}
?>
<?php
    include '../inc/header.php';
    include '../inc/sidebar.php';
?>
<!-- custom -->
<link rel="stylesheet" href="assets/css/custom.css">
<!-- new comparison table style -->
<link rel="stylesheet" href="assets/css/new-comparison-table-style.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
	    <h1>Materia Medica</h1>
	    <ol class="breadcrumb">
	    	<li><a href="<?php echo $absoluteUrl;?>"><i class="fa fa-dashboard"></i> <?php echo $home; ?></a></li>
	    	<li class="active">Materia Medica</li>
	    </ol>
	</section>

  	<!-- Main content -->
  	<section class="content">
    <!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-md-12">
				<div class="box box-success">
					<?php //if(isset($_SESSION['user_type']) && ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2)) { ?>
            		<!-- <div class="box-header with-border">
		              	<h3 class="box-title">
		              		<a href="<#" class="btn btn-success"><i class="fa fa-plus"></i> &nbsp; Add</a>
		              	</h3>
	            	</div> -->
			     	<?php  //} ?>
		    		<!-- /.box-header -->
		    		<div class="box-body">
                        <div id="loader" class="form-group text-center">
                            Loading is not complete please wait <img src="assets/img/loader.gif" alt="Loading...">
                        </div>
                        <div class="row">
                            <!-- materia medica arznei search list -->
                            <?php include 'search-arznei-materia-medica.php'; ?>
                        </div>
                        <div class="row">  
                            <div class="col-sm-12">
                                <h2><?php echo $arzneiHead; ?></h2> 
                                <div id="comparison_result_cnr" class="master-table-cnr"> 
                                    <form name="result_frm" id="result_frm" action="" method="POST">  
                                        <table class="table table-bordered heading-table heading-table-bg table-vertical-middle-td">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;">Status</th>
                                                    <th style="width: 5%;" class="text-center">Initials</th>
                                                    <th style="width: 5%;" class="text-center">Jahr</th>
                                                    <th style="width: 7.8%;" class="text-center">Kürzel</th>
                                                    <th style="width: 18%;">Titel</th>
                                                    <th style="width: 5%;" class="text-center">Final View</th>
                                                    <th style="width: 10%;" class="text-center">Synonym Classification</th>
                                                    <th style="width: 11%;">Date</th>
                                                    <th style="width: 14%;">Arznei</th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <table class="table table-bordered table-vertical-middle-td table-hover" id="searchTable">
                                            <tbody>
                                                <?php
                                                    //conditions custom
                                                    $conditions = " AND "; 
                                                    $conditions .= !empty( $_GET["arznei_id_custom"] ) ? "QIM.arznei_id =". $_GET['arznei_id_custom'] ." AND " : "";
                                                    $conditions .= !empty( $_GET["jahr_custom"] ) ? "Q.jahr LIKE '%". $_GET['jahr_custom'] ."%' AND " : "";
                                                    $conditions .= !empty( $_GET["date_custom"] ) ? "QIM.ersteller_datum LIKE '%". $_GET['date_custom'] ."%' AND " : "";
                                                    $conditions .= !empty( $_GET["titel_custom"] ) ? "Q.titel LIKE '%". $_GET['titel_custom'] ."%' AND " : "";
                                                    $conditions .= !empty( $_GET["code_custom"] ) ? "Q.code LIKE '%". $_GET['code_custom'] ."%' AND " : "";
                                                    $conditions = rtrim($conditions, " AND");
                                                    // $comparisonCompletedResult = mysqli_query($db, "SELECT C.*, A.titel FROM pre_comparison_master_data AS C LEFT JOIN arznei AS A ON C.arznei_id = A.arznei_id WHERE C.status = 'done'");
                                                    if(!empty($_GET)){
                                                        $isEmpty = 1;
                                                        // Combined sources
                                                        // $comparisonCompletedResult = mysqli_query($db, "SELECT QIM.*, Q.code, Q.titel, Q.jahr, Q.band, Q.nummer, Q.auflage, Q.quelle_type_id, Q.autor_or_herausgeber as bucher_autor_or_herausgeber, PCM.id AS pre_comparison_master_data_id, PCM.comparison_save_status, PCM.final_view, PCM.rmm, PCM.editor_ini FROM quelle_import_master AS QIM LEFT JOIN quelle AS Q ON QIM.quelle_id = Q.quelle_id LEFT JOIN pre_comparison_master_data AS PCM ON QIM.quelle_id = PCM.quelle_id WHERE Q.is_materia_medica = 1 AND Q.quelle_type_id = 3 $conditions ORDER BY QIM.ersteller_datum DESC");
                                                        $comparisonCompletedResult = mysqli_query($db, "SELECT QIM.*, Q.code, Q.titel, Q.jahr, Q.band, Q.nummer, Q.auflage, Q.quelle_type_id, Q.autor_or_herausgeber as bucher_autor_or_herausgeber, PCM.id AS pre_comparison_master_data_id, PCM.comparison_save_status, PCM.final_view, PCM.rmm, PCM.editor_ini FROM quelle_import_master AS QIM JOIN arznei_quelle AS arz_quelle ON QIM.quelle_id = arz_quelle.quelle_id AND QIM.arznei_id = arz_quelle.arznei_id JOIN quelle AS Q ON QIM.quelle_id = Q.quelle_id JOIN pre_comparison_master_data AS PCM ON QIM.quelle_id = PCM.quelle_id WHERE Q.is_materia_medica = 1 AND Q.quelle_type_id = 3 $conditions ORDER BY QIM.ersteller_datum DESC");
                                                        if(mysqli_num_rows($comparisonCompletedResult) > 0){
                                                            $isEmpty = 0;
                                                            while($row = mysqli_fetch_array($comparisonCompletedResult)){
                                                                $preComMaster = $db->query("SELECT id FROM pre_comparison_master_data where arznei_id = '".$row['arznei_id']."' AND (initial_source = '".$row['quelle_id']."' OR FIND_IN_SET('".$row['quelle_id']."', comparing_sources) > 0)");
                                                                if($preComMaster->num_rows == 0){
                                                                    $isSaved = 0;
                                                                ?>
                                                                <tr id="row_<?php echo $row['id']; ?>">
                                                                    <td style="width: 5%;" class="text-center">
                                                                        <?php 
                                                                            if($row['pre_comparison_master_data_id'] != ""){ 
                                                                                if($row['comparison_save_status'] == 1)
                                                                                    echo "<span class='status-yellow-circle'></span>";
                                                                                else if($row['comparison_save_status'] == 2){
                                                                                    echo "<span class='status-green-circle'></span>";
                                                                                    $isSaved = 1;
                                                                                }else if($row['comparison_save_status'] == 3){
                                                                                    echo "<span class='status-orange-circle'></span>";
                                                                                }
                                                                                else
                                                                                    echo "<span class='status-blue-circle'></span>";
                                                                            }else{
                                                                                echo "-"; 
                                                                                $isSaved = 1;
                                                                            } 
                                                                        ?>
                                                                    </td>
																	<td style="width: 5%;" class="text-center"><?php echo $row['editor_ini']; ?></td>
                                                                    <td style="width: 5%;" class="text-center"><?php echo $row['jahr']; ?></td>
                                                                    <td style="width: 7.8%;" class="text-center">
                                                                        <?php 
                                                                        if($row['quelle_type_id'] != 3){
                                                                            // echo $row['code'];
                                                                            echo "-";
                                                                        }else{
                                                                            echo "-";
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td id="comparison_name_container_<?php echo $row['quelle_id']; ?>" style="width: 18%;">
																		<a class="text-info history-table-anchor-tag" href="symptoms.php?mid=<?php echo $row['id']; ?>"><?php echo $row['titel']; ?></a>
                                                                    </td>
                                                                    <td style="width: 5%;" class="text-center">
                                                                        <?php 
                                                                            echo "-";
                                                                        ?>
                                                                    </td>
                                                                    <td style="width: 10%;" class="text-center">
																		<a id="" title="Synonyms classification" class="text-primary" href="javascript:void(0)"><i class="fa fa-list-ol"></i></a> 
                                                                    </td>
                                                                    <td style="width: 11%;">
																		<?php
																			$dateToDisplay = ($row['stand'] != "") ? $row['stand'] : $row['ersteller_datum']; 
																			echo date('d/m/Y h:i A', strtotime($dateToDisplay)); 
																		?>
																	</td>
                                                                    <td style="width: 14%;">
                                                                        <?php
                                                                            $arzneiTitle = "";
                                                                            $arzneiResult = mysqli_query($db,"SELECT arznei_id, titel FROM arznei WHERE arznei_id = '".$row['arznei_id']."'");
                                                                            if(mysqli_num_rows($arzneiResult) > 0){
                                                                                $arzneiData = mysqli_fetch_assoc($arzneiResult);
                                                                                $arzneiTitle = (isset($arzneiData['titel']) AND $arzneiData['titel'] != "") ? $arzneiData['titel'] : "";
                                                                            }
                                                                            echo $arzneiTitle;
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                }
                                                            }
                                                        }
                                                        // Single sources
                                                        // $comparisonCompletedResult = mysqli_query($db, "SELECT QIM.*, Q.code, Q.titel, Q.jahr, Q.band, Q.nummer, Q.auflage, Q.quelle_type_id, Q.autor_or_herausgeber as bucher_autor_or_herausgeber, PCM.id AS pre_comparison_master_data_id, PCM.comparison_save_status, PCM.final_view, PCM.rmm, Q.editor_ini FROM quelle_import_master AS QIM LEFT JOIN quelle AS Q ON QIM.quelle_id = Q.quelle_id LEFT JOIN pre_comparison_master_data AS PCM ON QIM.quelle_id = PCM.quelle_id WHERE Q.is_materia_medica = 1 AND Q.quelle_type_id != 3 $conditions ORDER BY QIM.ersteller_datum DESC");
                                                        $comparisonCompletedResult = mysqli_query($db, "SELECT QIM.*, Q.code, Q.titel, Q.jahr, Q.band, Q.nummer, Q.auflage, Q.quelle_type_id, Q.autor_or_herausgeber as bucher_autor_or_herausgeber, PCM.id AS pre_comparison_master_data_id, PCM.comparison_save_status, PCM.final_view, PCM.rmm, Q.editor_ini FROM quelle_import_master AS QIM JOIN arznei_quelle AS arz_quelle ON QIM.quelle_id = arz_quelle.quelle_id AND QIM.arznei_id = arz_quelle.arznei_id JOIN quelle AS Q ON QIM.quelle_id = Q.quelle_id LEFT JOIN pre_comparison_master_data AS PCM ON QIM.quelle_id = PCM.quelle_id WHERE Q.is_materia_medica = 1 AND Q.quelle_type_id != 3 $conditions ORDER BY QIM.ersteller_datum DESC");
                                                        if(mysqli_num_rows($comparisonCompletedResult) > 0){
                                                            $isEmpty = 0;
                                                            while($row = mysqli_fetch_array($comparisonCompletedResult)){
                                                                $preComMaster = $db->query("SELECT id FROM pre_comparison_master_data where arznei_id = '".$row['arznei_id']."' AND (initial_source = '".$row['quelle_id']."' OR FIND_IN_SET('".$row['quelle_id']."', comparing_sources) > 0)");
                                                                if($preComMaster->num_rows == 0){
                                                                    $isSaved = 0;
                                                                ?>
                                                                <tr id="row_<?php echo $row['id']; ?>">
                                                                    <td style="width: 5%;" class="text-center">
                                                                        <?php 
                                                                            if($row['pre_comparison_master_data_id'] != ""){ 
                                                                                if($row['comparison_save_status'] == 1)
                                                                                    echo "<span class='status-yellow-circle'></span>";
                                                                                else if($row['comparison_save_status'] == 2){
                                                                                    echo "<span class='status-green-circle'></span>";
                                                                                    $isSaved = 1;
                                                                                }else if($row['comparison_save_status'] == 3){
                                                                                    echo "<span class='status-orange-circle'></span>";
                                                                                }
                                                                                else
                                                                                    echo "<span class='status-blue-circle'></span>";
                                                                            }else{
                                                                                echo "-"; 
                                                                                $isSaved = 1;
                                                                            } 
                                                                        ?>
                                                                    </td>
                                                                    <td style="width: 5%;" class="text-center"><?php echo $row['editor_ini']; ?></td>
                                                                    <td style="width: 5%;" class="text-center"><?php echo $row['jahr']; ?></td>
                                                                    <td style="width: 7.8%;" class="text-center">
                                                                        <?php 
                                                                        if($row['quelle_type_id'] != 3){
                                                                            $quellenCode = getQuelleAbbreviationForMainSection($row['quelle_id']);
                                                                            echo $quellenCode;
                                                                        }else{
                                                                            echo "-";
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td id="comparison_name_container_<?php echo $row['quelle_id']; ?>" style="width: 18%;">
																	<a class="text-info history-table-anchor-tag" href="symptoms.php?mid=<?php echo $row['id']; ?>"><?php echo $row['titel']; ?></a>
                                                                    </td>
                                                                    <td style="width: 5%;" class="text-center">
                                                                        <?php 
																			echo "-";
                                                                        ?>
                                                                    </td>
                                                                    <td style="width: 10%;" class="text-center">
																		<a id="" title="Synonyms classification" class="text-primary" href="../synonym-tool/all-symptoms.php?mid=<?php echo $row['id']; ?>"><i class="fa fa-list-ol"></i></a> 
                                                                    </td>
                                                                    <td style="width: 11%;">
																		<?php 
																			$dateToDisplay = ($row['stand'] != "") ? $row['stand'] : $row['ersteller_datum']; 
																			echo date('d/m/Y h:i A', strtotime($dateToDisplay)); 
																		?>
																	</td>
                                                                    <td style="width: 14%;">
                                                                        <?php
                                                                            $arzneiTitle = "";
                                                                            $arzneiResult = mysqli_query($db,"SELECT arznei_id, titel FROM arznei WHERE arznei_id = '".$row['arznei_id']."'");
                                                                            if(mysqli_num_rows($arzneiResult) > 0){
                                                                                $arzneiData = mysqli_fetch_assoc($arzneiResult);
                                                                                $arzneiTitle = (isset($arzneiData['titel']) AND $arzneiData['titel'] != "") ? $arzneiData['titel'] : "";
                                                                            }
                                                                            echo $arzneiTitle;
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                }
                                                            }
                                                        }
                                                        if($isEmpty == 1)
                                                        {
                                                            ?>
                                                            <tr>
                                                                <td colspan="10" class="text-center">No records found</td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }else
                                                    {
                                                        ?>
                                                        <tr>
                                                            <td colspan="10" class="text-center">No records found</td>
                                                        </tr>
                                                        <?php
                                                    }	
                                                ?>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div id="common_small_loader" class="hidden">
                            <div class="overlayLoaderBody">
                                <p>Please wait. Data is loading.. <img src="../assets/img/loader.gif" alt="Loading..."></p>
                            </div>
                        </div>

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
                        <div class="modal fade" id="translationModal" role="dialog" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form id="add_translation_form" name="add_translation_form" action="" method="POST">
                                        <div class="modal-header">
                                            <button type="button" class="close add-translation-modal-btn" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Add translation 2</h4>
                                        </div>
                                        <div id="translation_container" class="modal-body">
                                            <div id="translation_modal_loader" class="form-group text-center hidden">
                                                <span class="loading-msg">Process is in progress please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
                                                <span class="error-msg"></span>
                                            </div>
                                            <div class="row add-translation-input-field-container">
                                                <div class="col-sm-12">
                                                    <label class="control-label">Translation Method<span class="required">*</span></label>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div id="translation_method_radio_buttons">
                                                        <label class="radio-inline"><input type="radio" name="translation_method" value="Professional Translation">Professional Translation</label>
                                                        <label class="radio-inline"><input type="radio" name="translation_method" value="Google Translation">Google Translation</label>
                                                    </div>
                                                    <span class="error-msg"></span>
                                                    <div class="spacer"></div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label class="control-label">Text Editor<span class="required">*</span></label>
                                                    <textarea id="translation_symptoms" name="translation_symptoms" class="texteditor" aria-hidden="true"></textarea>
                                                    <span class="error-msg"></span>	
                                                    <div class="spacer"></div>
                                                    <span class="add-translation-global-error-msg"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="add_translation_master_id" id="add_translation_master_id">
                                            <input type="hidden" name="add_translation_arznei_id" id="add_translation_arznei_id">
                                            <input type="hidden" name="add_translation_quelle_id" id="add_translation_quelle_id">
                                            <input type="hidden" name="add_translation_language" id="add_translation_language">
                                            <button type="submit" class="btn btn-primary add-translation-modal-btn">Submit</button>
                                            <button type="button" class="btn btn-default add-translation-modal-btn" data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Translation modal end -->

                        <!-- Add translation user approval modal start -->
                        <div class="modal fade" id="translationUserApprovalModal" role="dialog" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <!-- <form id="translation_user_approval_form" name="translation_user_approval_form" action="" method="POST"> -->
                                        <div class="modal-header">
                                            <button type="button" class="close translation-user-approval-modal-cancel-btn" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Need confirmation</h4>
                                        </div>
                                        <div id="translation_user_approval_container" class="modal-body">
                                            <div id="translation_user_approval_modal_loader" class="form-group text-center hidden">
                                                <span class="loading-msg">Process is in progress please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
                                                <span class="error-msg"></span>
                                            </div>
                                            <div class="row">
                                                <div id="translation_user_approval_content" class="col-sm-12">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="translation_user_approval_master_id" id="translation_user_approval_master_id">
                                            <input type="hidden" name="translation_user_approval_arznei_id" id="translation_user_approval_arznei_id">
                                            <input type="hidden" name="translation_user_approval_quelle_id" id="translation_user_approval_quelle_id">
                                            <input type="hidden" name="translation_user_approval_language" id="translation_user_approval_language">
                                            <input type="hidden" name="translation_user_approval_temp_symptom_id" id="translation_user_approval_temp_symptom_id">
                                            <button type="submit" id="translation_user_approval_modal_continue_btn" class="btn btn-primary translation-user-approval-modal-continue-btn">Continue</button>
                                            <button type="button" id="translation_user_approval_modal_delete_btn" class="btn btn-danger translation-user-approval-modal-delete-btn">Delete</button>
                                            <button type="button" class="btn btn-default translation-user-approval-modal-cancel-btn">Cancel</button>
                                        </div>
                                    <!-- </form> -->
                                </div>
                            </div>
                        </div>
                        <!-- Add translation user approval modal end -->
			        </div>
          			<!-- /.box-body -->
		    	</div>
			</div>
		</div>
	    <!-- /.row -->
  	</section>
  	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
include '../inc/footer.php';
?>
<script src="assets/js/common.js"></script>
<script type="text/javascript">
	//arznei custom search starts
	$('#arznei_id').select2({
		// options 
		searchInputPlaceholder: 'Search Arznei...'
	});

	$('body').on( 'submit', '#arznei_search_medica', function(e) {
		var arznei_id = $("#arznei_id").val();
		console.log(arznei_id);
	});
	//arznei custom search ends

	$(window).bind("load", function() {
		console.log('loaded');
		$("#loader").addClass("hidden");
	});
</script>