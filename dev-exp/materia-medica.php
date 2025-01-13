<?php
    include '../lang/GermanWords.php';
    include '../config/route.php';
    include 'sub-section-config.php';
    include '../api/mainCall.php';
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

	$('body').on( 'change', '#comparison_save_status', function(e) {
		var action = "";
		var is_data_found = 0;

		if($(this).prop("checked") == true) {
			action = "check";
		}else{
			action = "uncheck";
		}

		console.log(action);

		// $( ".vbtn-has-connection" ).each(function() {
		// 	is_data_found = 1;
		// 	var isConnectionLoaded = $(this).attr("data-is-connection-loaded");
		// 	if(action == "check"){
		// 		if(isConnectionLoaded != 1)
		// 			$(this).click();	
		// 	}else if(action == "uncheck"){
		// 		if(isConnectionLoaded == 1)
		// 			$(this).click();
		// 	}
		// })

		// if(is_data_found == 0){
		// 	$(this).prop("checked", false);
		// }
	});

	function deleteTheComparison(id){
		var con = confirm("Are you sure you want to delete?");
		if (con)
		{
			$('#delete_'+id).prop('disabled', true);
			$('#delete_'+id).html('<img src="assets/img/loader.gif" alt="Loader">');
			$.ajax({
				type: 'POST',
				url: 'delete-comparison-new.php',
				data: {
					id: id
				},
				dataType: "json",
				success: function( response ) {
					console.log(response);
					if(response.status == "success"){
						location.reload();
					}else{
						var deleteHtml = '<a id="delete_'+id+'" onclick="deleteTheComparison('+id+')" class="text-info history-table-anchor-tag" href="javascript:void(0)">Delete</a>';
						
						$('#delete_'+id).prop('disabled', false);
						$('#delete_'+id).html(deleteHtml);
						$("#global_msg_container").html('<p class="text-center">'+response.message+'</p>');
						$("#globalMsgModal").modal('show');
					}
				}
			}).fail(function (response) {
				var deleteHtml = '<a id="delete_'+id+'" onclick="deleteTheComparison('+id+')" class="text-info history-table-anchor-tag" href="javascript:void(0)">Delete</a>';

				$('#delete_'+id).prop('disabled', false);
				$('#delete_'+id).html(deleteHtml);
				$("#global_msg_container").html('<p class="text-center">Operation failed. Please retry!</p>');
				$("#globalMsgModal").modal('show');

				if ( window.console && window.console.log ) {
					console.log( response );
				}
			});
		}
		else
		{
			return false;
		}
	}

	function deleteTheQuelle(quelle_id, arznei_id){
		var con = confirm("Deleting this Quelle will delete it's all conections and related comparison where this source is used, are you sure you want to delete?");
		if (con)
		{
			$('#delete_'+quelle_id).prop('disabled', true);
			$('#delete_'+quelle_id).html('<img src="assets/img/loader.gif" alt="Loader">');
			$.ajax({
				type: 'POST',
				url: 'delete-quelle-new.php',
				data: {
					quelle_id: quelle_id,
					arznei_id: arznei_id
				},
				dataType: "json",
				success: function( response ) {
					console.log(response);
					if(response.status == "success"){
						location.reload();
						// $('#delete_'+quelle_id).prop('disabled', false);
						// $('#delete_'+quelle_id).html('<i class="fas fa-trash-alt"></i>');
						// $("#row_"+quelle_id).remove();
					}else{
						$('#delete_'+quelle_id).prop('disabled', false);
						$('#delete_'+quelle_id).html('<i class="fas fa-trash-alt"></i>');
						$("#global_msg_container").html('<p class="text-center">'+response.message+'</p>');
						$("#globalMsgModal").modal('show');
					}
				}
			}).fail(function (response) {
				$('#delete_'+quelle_id).prop('disabled', false);
				$('#delete_'+quelle_id).html('<i class="fas fa-trash-alt"></i>');
				$("#global_msg_container").html('<p class="text-center">Operation failed. Please retry!</p>');
				$("#globalMsgModal").modal('show');

				if ( window.console && window.console.log ) {
					console.log( response );
				}
			});
		}
		else
		{
			return false;
		}
	}

	function addTranslation(quelle_id, arznei_id, master_id, language){
		var $th = $("#"+language+"_translation_btn_container_"+master_id);
		if($th.hasClass('processing'))
			return;
		$th.addClass('processing');
		var error_count = 0;

		if(master_id == "")
			error_count++;
		if(arznei_id == "")
			error_count++;
		if(quelle_id == "")
			error_count++;

		if(error_count == 0) {
			$.ajax({
				type: 'POST',
				url: 'get-translation-approvable-data.php',
				data: {
					add_translation_master_id: master_id,
					add_translation_quelle_id: quelle_id,
					add_translation_arznei_id: arznei_id,
					add_translation_language: language
				},
				dataType: "json",
				success: function( response ) {
					console.log(response);
					if(response.status == "success"){
						if (typeof(response.result_data) != "undefined" && response.result_data !== null && response.result_data != ""){
							// $("#translation_user_approval_modal_loader").addClass('hidden');
							var resultData = null;
							try {
								resultData = JSON.parse(response.result_data); 
							} catch (e) {
								resultData = response.result_data;
							}
							var Beschreibung_de = (typeof(resultData.Beschreibung_de) != "undefined" && resultData.Beschreibung_de !== null && resultData.Beschreibung_de != "") ? b64DecodeUnicode(resultData.Beschreibung_de) : "";
							var Beschreibung_en = (typeof(resultData.Beschreibung_en) != "undefined" && resultData.Beschreibung_en !== null && resultData.Beschreibung_en != "") ? b64DecodeUnicode(resultData.Beschreibung_en) : "";
							var html = '';
							html += '<table class="table table-bordered">';
							html += '	<tr>';
							html += '		<th class="text-center" style="width:50%">German</th>';
							html += '		<th class="text-center" style="width:50%">English</th>';
							html += '	</tr>';
							html += '	<tr>';
							html += '		<td>'+Beschreibung_de+'</td>';
							html += '		<td>'+Beschreibung_en+'</td>';
							html += '	</tr>';
							html += '</table>';

							$("#translation_user_approval_master_id").val(master_id);
							$("#translation_user_approval_arznei_id").val(arznei_id);
							$("#translation_user_approval_quelle_id").val(quelle_id);
							$("#translation_user_approval_language").val(language);
							$("#translation_user_approval_temp_symptom_id").val(resultData.temp_symptom_id);
							$("#translation_user_approval_content").html(html);

							// Open translation user approval modal
							$("#translation_user_approval_modal_loader .error-msg").html('');
							if(!$("#translation_user_approval_modal_loader").hasClass('hidden'))
								$("#translation_user_approval_modal_loader").addClass('hidden');
							$("#translationUserApprovalModal").modal('show');
							$th.removeClass('processing');
						} else {

							$("#add_translation_master_id").val(master_id);
							$("#add_translation_arznei_id").val(arznei_id);
							$("#add_translation_quelle_id").val(quelle_id);
							$("#add_translation_language").val(language);
							$("#translationModal").modal('show');
							$th.removeClass('processing');
						}
						
					}else{
						var msg = (typeof(response.message) != "undefined" && response.message !== null && response.message != "") ? response.message : "Something went wrong, Please reload the page and try again."; 
						$("#global_msg_container").html('<p class="text-center">'+msg+'</p>');
						$("#globalMsgModal").modal('show');
						$th.removeClass('processing');
					}
				}
			}).fail(function (response) {
				$("#global_msg_container").html('<p class="text-center">Something went wrong, Please reload the page and try again!</p>');
				$("#globalMsgModal").modal('show');
				$th.removeClass('processing');
				if ( window.console && window.console.log ) {
					console.log( response );
				}
			});
		} else {
			$("#global_msg_container").html('<p class="text-center">Something went wrong, Please reload the page and try again!</p>');
			$("#globalMsgModal").modal('show');
			$th.removeClass('processing');
		}
	}

	$('#translationModal').on('hidden.bs.modal', function () {
		$('#add_translation_form').trigger("reset");
		$("#translation_symptoms").next().html('');
		$("#translation_symptoms").next().removeClass('text-danger');
		$("#translation_method_radio_buttons").next().html('');
		$("#translation_method_radio_buttons").next().removeClass('text-danger');
		$(".add-translation-global-error-msg").html('');
		$(".add-translation-global-error-msg").removeClass('text-danger');
	    $("#add_translation_master_id").val("");
	    $("#add_translation_arznei_id").val("");
		$("#add_translation_quelle_id").val("");
		$("#add_translation_language").val("");
		if(!$('#translation_modal_loader').hasClass('hidden'))
			$('#translation_modal_loader').addClass('hidden');
		$(".add-translation-input-field-container").removeClass('hidden');
		$('.add-translation-modal-btn').prop('disabled', false);
		$("#add_translation_form").removeClass('processing');
	})

	$('body').on( 'submit', '#add_translation_form', function(e) {
		e.preventDefault();
		var $th = $(this);
		if($th.hasClass('processing'))
			return;
		$th.addClass('processing');

		if(!$('#translation_modal_loader').hasClass('hidden'))
			$('#translation_modal_loader').addClass('hidden');
		$(".add-translation-input-field-container").removeClass('hidden');
		$('.add-translation-modal-btn').prop('disabled', false);

		var translation_symptoms = $("#translation_symptoms").val();
		var add_translation_arznei_id = $("#add_translation_arznei_id").val();
		var add_translation_master_id = $("#add_translation_master_id").val();
		var add_translation_quelle_id = $("#add_translation_quelle_id").val();
		var add_translation_language = $("#add_translation_language").val();
		var error_count = 0;

		if(translation_symptoms == ""){
			$("#translation_symptoms").next().html('Please input translated symptoms');
			$("#translation_symptoms").next().addClass('text-danger');
			error_count++;
		}else{
			$("#translation_symptoms").next().html('');
			$("#translation_symptoms").next().removeClass('text-danger');
		}
		if ($('input[name="translation_method"]:checked').length == 0) {
			$("#translation_method_radio_buttons").next().html('Please select translation method');
			$("#translation_method_radio_buttons").next().addClass('text-danger');
			error_count++;
		}else{
			$("#translation_method_radio_buttons").next().html('');
			$("#translation_method_radio_buttons").next().removeClass('text-danger');
		}
		if(add_translation_arznei_id == ""){
			$(".add-translation-global-error-msg").html('Some internal required data not found, please re-load the page and try again.');
			$(".add-translation-global-error-msg").addClass('text-danger');
			error_count++;
		}else{
			$(".add-translation-global-error-msg").html('');
			$(".add-translation-global-error-msg").removeClass('text-danger');
		}
		if(add_translation_master_id == ""){
			$(".add-translation-global-error-msg").html('Some internal required data not found, please re-load the page and try again.');
			$(".add-translation-global-error-msg").addClass('text-danger');
			error_count++;
		}else{
			$(".add-translation-global-error-msg").html('');
			$(".add-translation-global-error-msg").removeClass('text-danger');
		}
		if(add_translation_quelle_id == ""){
			$(".add-translation-global-error-msg").html('Some internal required data not found, please re-load the page and try again.');
			$(".add-translation-global-error-msg").addClass('text-danger');
			error_count++;
		}else{
			$(".add-translation-global-error-msg").html('');
			$(".add-translation-global-error-msg").removeClass('text-danger');
		}
		if(add_translation_language == ""){
			$(".add-translation-global-error-msg").html('Some internal required data not found, please re-load the page and try again.');
			$(".add-translation-global-error-msg").addClass('text-danger');
			error_count++;
		}else{
			$(".add-translation-global-error-msg").html('');
			$(".add-translation-global-error-msg").removeClass('text-danger');
		}

		if(error_count == 0){
			$('.add-translation-modal-btn').prop('disabled', true);
			$("#translation_modal_loader").removeClass('hidden');
			$(".add-translation-input-field-container").addClass('hidden');
			
			// Form data
			var data = $(this).serialize();

			// Checking if all the selected sources symptoms available in selected language
			$.ajax({
				type: 'POST',
				url: 'add-source-translation.php',
				data: {
					form: data
				},
				dataType: "json",
				success: function( response ) {
					console.log(response);
					// return false;
					if(response.status == "success"){
						// if(add_translation_language == "de")
						// 	$("#de_translation_btn_container_"+add_translation_master_id).html('<a id="" title="Symptoms available in German" class="text-success" onclick="" href="javascript:void(0)"><i class="fas fa-clipboard-check mm-fa-icon"></i></a>');
						// else
						// 	$("#en_translation_btn_container_"+add_translation_master_id).html('<a id="" title="Symptoms available in English" class="text-success" onclick="" href="javascript:void(0)"><i class="fas fa-clipboard-check mm-fa-icon"></i></a>');

						$("#translationModal").modal('hide');
						location.reload();
						
					}else if(response.status == "need_approval"){
						$("#translationModal").modal('hide');
						translationUserApproval(add_translation_master_id, add_translation_quelle_id, add_translation_arznei_id, add_translation_language);
					}else{
						var msg = (typeof(response.message) != "undefined" && response.message !== null && response.message != "") ? response.message : "Something went wrong, Please reload the page and try again."; 
						$('#translation_modal_loader').removeClass('hidden');
						$("#translation_modal_loader .loading-msg").addClass('hidden');
						$('#translation_modal_loader .error-msg').html(msg);
						setTimeout(function(){
							if(!$('#translation_modal_loader').hasClass('hidden')){
								$('#translation_modal_loader').addClass('hidden');
								$("#translation_modal_loader .loading-msg").removeClass('hidden');
								$('#translation_modal_loader .error-msg').html('');
							}
							$th.removeClass('processing');
							$(".add-translation-input-field-container").removeClass('hidden');
							$('.add-translation-modal-btn').prop('disabled', false);
							console.log(response);
						}, 3000);
						// $th.removeClass('processing');
						// if(!$('#translation_modal_loader').hasClass('hidden'))
						// 	$('#translation_modal_loader').addClass('hidden');
						// $(".add-translation-input-field-container").removeClass('hidden');
						// $('.add-translation-modal-btn').prop('disabled', false);
						// console.log(response);
					}
				}
			}).fail(function (response) {
				$th.removeClass('processing');
				if(!$('#translation_modal_loader').hasClass('hidden'))
					$('#translation_modal_loader').addClass('hidden');
				$(".add-translation-input-field-container").removeClass('hidden');
				$('.add-translation-modal-btn').prop('disabled', false);
				if ( window.console && window.console.log ) {
					console.log( response );
				}
			});

		} else {
			$th.removeClass('processing');
			return false;
		}
	});

	function translationUserApproval(add_translation_master_id, add_translation_quelle_id, add_translation_arznei_id, add_translation_language){
		$("#translation_user_approval_modal_loader .loading-msg").removeClass('hidden');
		$("#translation_user_approval_modal_loader .error-msg").html('');
		if($("#translation_user_approval_modal_loader").hasClass('hidden'))
			$("#translation_user_approval_modal_loader").removeClass('hidden');
		$("#translationUserApprovalModal").modal('show');
		// $('.translation-user-approval-modal-continue-btn').prop('disabled', false);
		// $('.translation-user-approval-modal-delete-btn').prop('disabled', false);
		// $('.translation-user-approval-modal-cancel-btn').prop('disabled', false);

		$.ajax({
			type: 'POST',
			url: 'get-translation-approvable-data.php',
			data: {
				add_translation_master_id: add_translation_master_id,
				add_translation_quelle_id: add_translation_quelle_id,
				add_translation_arznei_id: add_translation_arznei_id,
				add_translation_language: add_translation_language
			},
			dataType: "json",
			success: function( response ) {
				console.log(response);
				$('.translation-user-approval-modal-continue-btn').prop('disabled', false);
				$('.translation-user-approval-modal-delete-btn').prop('disabled', false);
				$('.translation-user-approval-modal-cancel-btn').prop('disabled', false);
				if(response.status == "success"){
					if (typeof(response.result_data) != "undefined" && response.result_data !== null && response.result_data != ""){
						$("#translation_user_approval_modal_loader").addClass('hidden');
						var resultData = null;
						try {
							resultData = JSON.parse(response.result_data); 
						} catch (e) {
							resultData = response.result_data;
						}
						var Beschreibung_de = (typeof(resultData.Beschreibung_de) != "undefined" && resultData.Beschreibung_de !== null && resultData.Beschreibung_de != "") ? b64DecodeUnicode(resultData.Beschreibung_de) : "";
						var Beschreibung_en = (typeof(resultData.Beschreibung_en) != "undefined" && resultData.Beschreibung_en !== null && resultData.Beschreibung_en != "") ? b64DecodeUnicode(resultData.Beschreibung_en) : "";
						var html = '';
						html += '<table class="table table-bordered">';
						html += '	<tr>';
						html += '		<th class="text-center" style="width:50%">German</th>';
						html += '		<th class="text-center" style="width:50%">English</th>';
						html += '	</tr>';
						html += '	<tr>';
						html += '		<td>'+Beschreibung_de+'</td>';
						html += '		<td>'+Beschreibung_en+'</td>';
						html += '	</tr>';
						html += '</table>';

						$("#translation_user_approval_master_id").val(add_translation_master_id);
						$("#translation_user_approval_arznei_id").val(add_translation_arznei_id);
						$("#translation_user_approval_quelle_id").val(add_translation_quelle_id);
						$("#translation_user_approval_language").val(add_translation_language);
						$("#translation_user_approval_temp_symptom_id").val(resultData.temp_symptom_id);
						$("#translation_user_approval_content").html(html);

					} else {
						var msg = (typeof(response.message) != "undefined" && response.message !== null && response.message != "") ? response.message : "Something went wrong, Please reload the page and try again."; 
						$("#translation_user_approval_modal_loader .loading-msg").addClass('hidden');
						$("#translation_user_approval_modal_loader .error-msg").html(msg);
						$('.translation-user-approval-modal-continue-btn').prop('disabled', true);
					}
					
				}else{
					var msg = (typeof(response.message) != "undefined" && response.message !== null && response.message != "") ? response.message : "Something went wrong, Please reload the page and try again."; 
					$("#translation_user_approval_modal_loader .loading-msg").addClass('hidden');
					$("#translation_user_approval_modal_loader .error-msg").html(msg);
					$('.translation-user-approval-modal-continue-btn').prop('disabled', true);
				}
			}
		}).fail(function (response) {
			$('.translation-user-approval-modal-continue-btn').prop('disabled', false);
			$('.translation-user-approval-modal-delete-btn').prop('disabled', false);
			$('.translation-user-approval-modal-cancel-btn').prop('disabled', false);
			var msg = (typeof(response.message) != "undefined" && response.message !== null && response.message != "") ? response.message : "Something went wrong, Please reload the page and try again."; 
			$("#translation_user_approval_modal_loader .loading-msg").addClass('hidden');
			$("#translation_user_approval_modal_loader .error-msg").html(msg);
			var msg = (typeof(response.message) != "undefined" && response.message !== null && response.message != "") ? response.message : "Something went wrong, Please reload the page and try again."; 
			$('.translation-user-approval-modal-continue-btn').prop('disabled', true);
			if ( window.console && window.console.log ) {
				console.log( response );
			}
		});
	}

	$(document).on('click', '#translation_user_approval_modal_continue_btn', function(e){
		// e.preventDefault();
		// var $th = $(this);
		// if($th.hasClass('processing'))
			// return;
		// $th.addClass('processing');
		$('.translation-user-approval-modal-continue-btn').prop('disabled', true);
		$('.translation-user-approval-modal-delete-btn').prop('disabled', true);
		$('.translation-user-approval-modal-cancel-btn').prop('disabled', true);

		var translation_user_approval_master_id = $("#translation_user_approval_master_id").val();
		var translation_user_approval_arznei_id = $("#translation_user_approval_arznei_id").val();
		var translation_user_approval_quelle_id = $("#translation_user_approval_quelle_id").val();
		var translation_user_approval_language = $("#translation_user_approval_language").val();
		var translation_user_approval_temp_symptom_id = $("#translation_user_approval_temp_symptom_id").val();
		var error_count = 0;

		if(translation_user_approval_master_id == "")
			error_count++;
		if(translation_user_approval_arznei_id == "")
			error_count++;
		if(translation_user_approval_quelle_id == "")
			error_count++;
		if(translation_user_approval_temp_symptom_id == "")
			error_count++;

		if(error_count == 0) {
			$("#translation_user_approval_modal_loader .loading-msg").removeClass('hidden');
			$("#translation_user_approval_modal_loader .error-msg").html('');
			if($("#translation_user_approval_modal_loader").hasClass('hidden'))
				$("#translation_user_approval_modal_loader").removeClass('hidden');

			$.ajax({
				type: 'POST',
				url: 'translation-approvable-actions.php',
				data: {
					add_translation_master_id: translation_user_approval_master_id,
					add_translation_quelle_id: translation_user_approval_quelle_id,
					add_translation_arznei_id: translation_user_approval_arznei_id,
					add_translation_language: translation_user_approval_language,
					temp_symptom_id: translation_user_approval_temp_symptom_id,
					action: 'continue'
				},
				dataType: "json",
				success: function( response ) {
					console.log(response);
					if(response.status == "success"){
						var resultData = null;
						try {
							resultData = JSON.parse(response.result_data); 
						} catch (e) {
							resultData = response.result_data;
						}
						if (typeof(resultData.need_approval) != "undefined" && resultData.need_approval !== null && resultData.need_approval != ""){
							// $th.removeClass('processing');
							translationUserApproval(translation_user_approval_master_id, translation_user_approval_quelle_id, translation_user_approval_arznei_id, translation_user_approval_language)
						}else{
							// $th.removeClass('processing');
							// Removing "Processing" class from add translation icon button to make it working
							// var $another_th = $("#"+translation_user_approval_language+"_translation_btn_container_"+translation_user_approval_master_id);
							// $another_th.removeClass('processing'); 

							$("#translation_user_approval_modal_loader .loading-msg").removeClass('hidden');
							$("#translation_user_approval_modal_loader .error-msg").html('');
							if(!$("#translation_user_approval_modal_loader").hasClass('hidden'))
								$("#translation_user_approval_modal_loader").addClass('hidden');
							
							$("#translation_user_approval_master_id").val('');
							$("#translation_user_approval_arznei_id").val('');
							$("#translation_user_approval_quelle_id").val('');
							$("#translation_user_approval_language").val('');
							$("#translation_user_approval_temp_symptom_id").val('');
							$("#translation_user_approval_content").html('');
							
							if(translation_user_approval_language == "de")
								$("#de_translation_btn_container_"+translation_user_approval_master_id).html('<a id="" title="Symptoms available in German" class="text-success" onclick="" href="javascript:void(0)"><i class="fas fa-clipboard-check mm-fa-icon"></i></a>');
							else
								$("#en_translation_btn_container_"+translation_user_approval_master_id).html('<a id="" title="Symptoms available in English" class="text-success" onclick="" href="javascript:void(0)"><i class="fas fa-clipboard-check mm-fa-icon"></i></a>');

							$("#translationUserApprovalModal").modal('hide');
							$('.translation-user-approval-modal-continue-btn').prop('disabled', false);
							$('.translation-user-approval-modal-delete-btn').prop('disabled', false);
							$('.translation-user-approval-modal-cancel-btn').prop('disabled', false);

							location.reload();
						}
						
					}else{
						var msg = (typeof(response.message) != "undefined" && response.message !== null && response.message != "") ? response.message : "Something went wrong, Please reload the page and try again."; 
						if(!$("#translation_user_approval_modal_loader .loading-msg").hasClass('hidden'))
							$("#translation_user_approval_modal_loader .loading-msg").addClass('hidden');
						$("#translation_user_approval_modal_loader .error-msg").html(msg);
						if($("#translation_user_approval_modal_loader").hasClass('hidden'))
							$("#translation_user_approval_modal_loader").removeClass('hidden');
						$('.translation-user-approval-modal-continue-btn').prop('disabled', false);
						$('.translation-user-approval-modal-delete-btn').prop('disabled', false);
						$('.translation-user-approval-modal-cancel-btn').prop('disabled', false);
						// $th.removeClass('processing');
					}
				}
			}).fail(function (response) {
				if(!$("#translation_user_approval_modal_loader .loading-msg").hasClass('hidden'))
					$("#translation_user_approval_modal_loader .loading-msg").addClass('hidden');
				$("#translation_user_approval_modal_loader .error-msg").html('<p class="text-center">Something went wrong, Please reload the page and try again!</p>');
				if($("#translation_user_approval_modal_loader").hasClass('hidden'))
					$("#translation_user_approval_modal_loader").removeClass('hidden');
				$('.translation-user-approval-modal-continue-btn').prop('disabled', false);
				$('.translation-user-approval-modal-delete-btn').prop('disabled', false);
				$('.translation-user-approval-modal-cancel-btn').prop('disabled', false);
				// $th.removeClass('processing');
				if ( window.console && window.console.log ) {
					console.log( response );
				}
			});

		} else {
			if(!$("#translation_user_approval_modal_loader .loading-msg").hasClass('hidden'))
				$("#translation_user_approval_modal_loader .loading-msg").addClass('hidden');
			$("#translation_user_approval_modal_loader .error-msg").html('<p class="text-center">Something went wrong, Please reload the page and try again!</p>');
			if($("#translation_user_approval_modal_loader").hasClass('hidden'))
				$("#translation_user_approval_modal_loader").removeClass('hidden');
			$('.translation-user-approval-modal-continue-btn').prop('disabled', false);
			$('.translation-user-approval-modal-delete-btn').prop('disabled', false);
			$('.translation-user-approval-modal-cancel-btn').prop('disabled', false);
			// $th.removeClass('processing');
		}
	});

	$(document).on('click', '#translation_user_approval_modal_delete_btn', function(e){
		
		$('.translation-user-approval-modal-continue-btn').prop('disabled', true);
		$('.translation-user-approval-modal-delete-btn').prop('disabled', true);
		$('.translation-user-approval-modal-cancel-btn').prop('disabled', true);

		var translation_user_approval_master_id = $("#translation_user_approval_master_id").val();
		var translation_user_approval_arznei_id = $("#translation_user_approval_arznei_id").val();
		var translation_user_approval_quelle_id = $("#translation_user_approval_quelle_id").val();
		var translation_user_approval_language = $("#translation_user_approval_language").val();
		var error_count = 0;

		if(translation_user_approval_master_id == "")
			error_count++;
		if(translation_user_approval_arznei_id == "")
			error_count++;
		if(translation_user_approval_quelle_id == "")
			error_count++;

		if(error_count == 0) {
			$("#translation_user_approval_modal_loader .loading-msg").removeClass('hidden');
			$("#translation_user_approval_modal_loader .error-msg").html('');
			if($("#translation_user_approval_modal_loader").hasClass('hidden'))
				$("#translation_user_approval_modal_loader").removeClass('hidden');

			$.ajax({
				type: 'POST',
				url: 'translation-approvable-actions.php',
				data: {
					add_translation_master_id: translation_user_approval_master_id,
					add_translation_quelle_id: translation_user_approval_quelle_id,
					add_translation_arznei_id: translation_user_approval_arznei_id,
					add_translation_language: translation_user_approval_language,
					action: 'delete'
				},
				dataType: "json",
				success: function( response ) {
					console.log(response);
					if(response.status == "success"){
						
						// Removing "Processing" class from add translation icon button to make it working
						// var $th = $("#"+translation_user_approval_language+"_translation_btn_container_"+translation_user_approval_master_id);
						// $th.removeClass('processing'); 

						$("#translation_user_approval_modal_loader .loading-msg").removeClass('hidden');
						$("#translation_user_approval_modal_loader .error-msg").html('');
						if(!$("#translation_user_approval_modal_loader").hasClass('hidden'))
							$("#translation_user_approval_modal_loader").addClass('hidden');
						
						$("#translation_user_approval_master_id").val('');
						$("#translation_user_approval_arznei_id").val('');
						$("#translation_user_approval_quelle_id").val('');
						$("#translation_user_approval_language").val('');
						$("#translation_user_approval_temp_symptom_id").val('');
						$("#translation_user_approval_content").html('');
						
						$("#translationUserApprovalModal").modal('hide');
						
					}else{
						var msg = (typeof(response.message) != "undefined" && response.message !== null && response.message != "") ? response.message : "Something went wrong, Please reload the page and try again."; 
						if(!$("#translation_user_approval_modal_loader .loading-msg").hasClass('hidden'))
							$("#translation_user_approval_modal_loader .loading-msg").addClass('hidden');
						$("#translation_user_approval_modal_loader .error-msg").html(msg);
						if($("#translation_user_approval_modal_loader").hasClass('hidden'))
							$("#translation_user_approval_modal_loader").removeClass('hidden');
						$('.translation-user-approval-modal-continue-btn').prop('disabled', false);
						$('.translation-user-approval-modal-delete-btn').prop('disabled', false);
						$('.translation-user-approval-modal-cancel-btn').prop('disabled', false);
						// $th.removeClass('processing');
					}
				}
			}).fail(function (response) {
				if(!$("#translation_user_approval_modal_loader .loading-msg").hasClass('hidden'))
					$("#translation_user_approval_modal_loader .loading-msg").addClass('hidden');
				$("#translation_user_approval_modal_loader .error-msg").html('<p class="text-center">Something went wrong, Please reload the page and try again!</p>');
				if($("#translation_user_approval_modal_loader").hasClass('hidden'))
					$("#translation_user_approval_modal_loader").removeClass('hidden');
				$('.translation-user-approval-modal-continue-btn').prop('disabled', false);
				$('.translation-user-approval-modal-delete-btn').prop('disabled', false);
				$('.translation-user-approval-modal-cancel-btn').prop('disabled', false);
				// $th.removeClass('processing');
				if ( window.console && window.console.log ) {
					console.log( response );
				}
			});

		} else {
			if(!$("#translation_user_approval_modal_loader .loading-msg").hasClass('hidden'))
				$("#translation_user_approval_modal_loader .loading-msg").addClass('hidden');
			$("#translation_user_approval_modal_loader .error-msg").html('<p class="text-center">Something went wrong, Please reload the page and try again!</p>');
			if($("#translation_user_approval_modal_loader").hasClass('hidden'))
				$("#translation_user_approval_modal_loader").removeClass('hidden');
			$('.translation-user-approval-modal-continue-btn').prop('disabled', false);
			$('.translation-user-approval-modal-delete-btn').prop('disabled', false);
			$('.translation-user-approval-modal-cancel-btn').prop('disabled', false);
			// $th.removeClass('processing');
		}	
	});

	$(document).on('click', '.translation-user-approval-modal-cancel-btn', function(){
		var translation_user_approval_master_id = $("#translation_user_approval_master_id").val();
		var translation_user_approval_arznei_id = $("#translation_user_approval_arznei_id").val();
		var translation_user_approval_language = $("#translation_user_approval_language").val();
		// Removing "Processing" class from add translation icon button to make it working
		// var $th = $("#"+translation_user_approval_language+"_translation_btn_container_"+translation_user_approval_master_id);
		// $th.removeClass('processing'); 

		$("#translation_user_approval_modal_loader .loading-msg").removeClass('hidden');
		$("#translation_user_approval_modal_loader .error-msg").html('');
		if(!$("#translation_user_approval_modal_loader").hasClass('hidden'))
			$("#translation_user_approval_modal_loader").addClass('hidden');
		
		$("#translation_user_approval_master_id").val('');
		$("#translation_user_approval_arznei_id").val('');
		$("#translation_user_approval_quelle_id").val('');
		$("#translation_user_approval_language").val('');
		$("#translation_user_approval_temp_symptom_id").val('');
		$("#translation_user_approval_content").html('');
		
		$("#translationUserApprovalModal").modal('hide');
	});

	// Changing comparison name START
	$(document).on('click', '.edit-comparison-name', function(){
		var quelleId = $(this).attr("data-quelle-id");
	    var existingComparisonName = $(this).attr("data-existing-comparison-name");
	    var arzneiId = $(this).attr("data-arznei-id");
	    var preComparisonMasterDataId = $(this).attr("data-pre-comparison-master-data-id");
	    existingComparisonName = existingComparisonName.trim();
	    $("#comparison_name_container_"+quelleId).html('<span><img src="assets/img/loader.gif" alt="Loader"></span>');
	    $("#edit_container_"+quelleId).html('<span><img src="assets/img/loader.gif" alt="Loader"></span>');

	    var comNameHtml = "";
	    comNameHtml += '<div class="input-group">';
	    comNameHtml += '	<input type="text" autocomplete="off" name="edit_comparison_name_'+quelleId+'" id="edit_comparison_name_'+quelleId+'" value="'+existingComparisonName+'" class="form-control" placeholder="Comparison name">';
	    comNameHtml += '	<div class="input-group-btn">';
	    comNameHtml += '		<button id="save_'+quelleId+'" data-quelle-id="'+quelleId+'" data-arznei-id="'+arzneiId+'" data-existing-comparison-name="'+existingComparisonName+'" data-pre-comparison-master-data-id="'+preComparisonMasterDataId+'" title="Save" class="btn btn-default save-edit" type="button"><i class="fas fa-save mm-fa-icon text-success"></i></button>';
	    comNameHtml += '	</div>';
	    comNameHtml += '</div>';

	    var cancelHtml = '<a id="cancel_'+quelleId+'" data-quelle-id="'+quelleId+'" data-arznei-id="'+arzneiId+'" data-existing-comparison-name="'+existingComparisonName+'" data-pre-comparison-master-data-id="'+preComparisonMasterDataId+'" title="Cancel" class="text-danger edit-cancel" href="javascript:void(0)"><i class="fas fa-window-close mm-fa-icon"></i></a>';

	    $("#comparison_name_container_"+quelleId).html(comNameHtml);
	    $("#edit_container_"+quelleId).html(cancelHtml);
	});

	$(document).on('click', '.edit-cancel', function(){
		var quelleId = $(this).attr("data-quelle-id");
		var arzneiId = $(this).attr("data-arznei-id");
	    var existingComparisonName = $(this).attr("data-existing-comparison-name");
	    var preComparisonMasterDataId = $(this).attr("data-pre-comparison-master-data-id");
	    existingComparisonName = existingComparisonName.trim();
	    $("#comparison_name_container_"+quelleId).html('<span><img src="assets/img/loader.gif" alt="Loader"></span>');
	    $("#edit_container_"+quelleId).html('<span><img src="assets/img/loader.gif" alt="Loader"></span>');

	    var editHtml = '<a id="edit_'+quelleId+'" data-quelle-id="'+quelleId+'" data-arznei-id="'+arzneiId+'" data-existing-comparison-name="'+existingComparisonName+'" data-pre-comparison-master-data-id="'+preComparisonMasterDataId+'" title="Edit comparison name" class="text-info edit-comparison-name" href="javascript:void(0)"><i class="fas fa-edit mm-fa-icon"></i></a>';

	    var existingComparisonNameHtml = '<a class="text-info history-table-anchor-tag" href="comparison.php?comid='+preComparisonMasterDataId+'">'+existingComparisonName+'</a>';
	    $("#comparison_name_container_"+quelleId).html(existingComparisonNameHtml);
	    $("#edit_container_"+quelleId).html(editHtml);
	});


	$(document).on('click', '.save-edit', function(){
		var quelleId = $(this).attr("data-quelle-id");
		var arzneiId = $(this).attr("data-arznei-id");
	    var existingComparisonName = $(this).attr("data-existing-comparison-name");
	    var preComparisonMasterDataId = $(this).attr("data-pre-comparison-master-data-id");
	    existingComparisonName = existingComparisonName.trim();

	    var comparison_name = $("#edit_comparison_name_"+quelleId).val().trim();
	    $("#comparison_name_container_"+quelleId).html('<span><img src="assets/img/loader.gif" alt="Loader"></span>');
	    $("#edit_container_"+quelleId).html('<span><img src="assets/img/loader.gif" alt="Loader"></span>');
	    if(comparison_name != ""){
	    	$.ajax({
				type: 'POST',
				url: 'update-comparison-name-new.php',
				data: {
					comparison_name: comparison_name,
					quelle_id: quelleId,
					arznei_id: arzneiId,
					existing_comparison_name: existingComparisonName
				},
				dataType: "json",
				success: function( response ) {
					console.log(response);
					if(response.status == "success"){
					    var editHtml = '<a id="edit_'+quelleId+'" data-quelle-id="'+quelleId+'" data-arznei-id="'+arzneiId+'" data-existing-comparison-name="'+comparison_name+'" data-pre-comparison-master-data-id="'+preComparisonMasterDataId+'" title="Edit comparison name" class="text-info edit-comparison-name" href="javascript:void(0)"><i class="fas fa-edit mm-fa-icon"></i></a>';

					    var newComparisonNameHtml = '<a class="text-info history-table-anchor-tag" href="comparison.php?comid='+preComparisonMasterDataId+'">'+comparison_name+'</a>';
					    $("#comparison_name_container_"+quelleId).html(newComparisonNameHtml);
	    				$("#edit_container_"+quelleId).html(editHtml);
					}else{
						var comNameHtml = "";
					    comNameHtml += '<div class="input-group">';
					    comNameHtml += '	<input type="text" autocomplete="off" name="edit_comparison_name_'+quelleId+'" id="edit_comparison_name_'+quelleId+'" value="'+comparison_name+'"  class="form-control" placeholder="Comparison name">';
					    comNameHtml += '	<div class="input-group-btn">';
					    comNameHtml += '		<button id="save_'+quelleId+'" data-quelle-id="'+quelleId+'" data-arznei-id="'+arzneiId+'" data-existing-comparison-name="'+existingComparisonName+'" data-pre-comparison-master-data-id="'+preComparisonMasterDataId+'" title="Save" class="btn btn-default save-edit" type="button"><i class="fas fa-save mm-fa-icon text-success"></i></button>';
					    comNameHtml += '	</div>';
					    comNameHtml += '</div>';

					    var cancelHtml = '<a id="cancel_'+quelleId+'" data-quelle-id="'+quelleId+'" data-arznei-id="'+arzneiId+'" data-existing-comparison-name="'+existingComparisonName+'" data-pre-comparison-master-data-id="'+preComparisonMasterDataId+'" title="Cancel" class="text-danger edit-cancel" href="javascript:void(0)"><i class="fas fa-window-close mm-fa-icon"></i></a>';

					    $("#comparison_name_container_"+quelleId).html(comNameHtml);
					    $("#edit_container_"+quelleId).html(cancelHtml);

						$("#global_msg_container").html('<p class="text-center text-danger">'+response.message+'</p>');
						$("#globalMsgModal").modal('show');
						
					}
				}
			}).fail(function (response) {
				var editHtml = '<a id="edit_'+quelleId+'" data-quelle-id="'+quelleId+'" data-arznei-id="'+arzneiId+'" data-existing-comparison-name="'+existingComparisonName+'" data-pre-comparison-master-data-id="'+preComparisonMasterDataId+'" title="Edit comparison name" class="text-info edit-comparison-name" href="javascript:void(0)"><i class="fas fa-edit mm-fa-icon"></i></a>';
				var existingComparisonNameHtml = '<a class="text-info history-table-anchor-tag" href="comparison.php?comid='+preComparisonMasterDataId+'">'+existingComparisonName+'</a>';
				$("#comparison_name_container_"+quelleId).html(existingComparisonNameHtml);
	    		$("#edit_container_"+quelleId).html(editHtml);
				$("#global_msg_container").html('<p class="text-center text-danger">Operation failed. Somethig went wrong!</p>');
				$("#globalMsgModal").modal('show');

				if ( window.console && window.console.log ) {
					console.log( response );
				}
			});
	    } else {
	    	var editHtml = '<a id="edit_'+quelleId+'" data-quelle-id="'+quelleId+'" data-arznei-id="'+arzneiId+'" data-existing-comparison-name="'+existingComparisonName+'" data-pre-comparison-master-data-id="'+preComparisonMasterDataId+'" title="Edit comparison name" class="text-info edit-comparison-name" href="javascript:void(0)"><i class="fas fa-edit mm-fa-icon"></i></a>';
	    	var existingComparisonNameHtml = '<a class="text-info history-table-anchor-tag" href="comparison.php?comid='+preComparisonMasterDataId+'">'+existingComparisonName+'</a>';
	    	$("#comparison_name_container_"+quelleId).html(existingComparisonNameHtml);
	    	$("#edit_container_"+quelleId).html(editHtml);
	    }
	});
	// Changing comparison name END

	$(document).on('click', '.download-source', function(e){
		var mid =  $(this).attr("data-quelle-import-master-id");
		var lang =  $(this).attr("data-language");
		var isSaved =  $(this).attr("data-is-saved");
		if(mid != "" && lang != "" && isSaved != ""){
			if(isSaved == 1){
				var win = window.open("<?php echo $baseUrl; ?>download-in-word-document.php?mid="+mid+"&lang="+lang, "_blank");
				if (win) {
				    //Browser has allowed it to be opened
				    win.focus();
				} else {
				    //Browser has blocked it
				    // alert('Please allow popups for this website');
				    $("#global_msg_container").html('<p class="text-center">Please allow popups for this website</p>');
					$("#globalMsgModal").modal('show');
				}
			} else {
				$("#global_msg_container").html('<p class="text-center">The comparison is not saved yet! Please save the comparison before download.</p>');
				$("#globalMsgModal").modal('show');
			}
		}
		else
		{
			$("#global_msg_container").html('<p class="text-center">Could not start the download, required data not found.</p>');
			$("#globalMsgModal").modal('show');
		}
	});

	$(document).on('click', '.synonym-up-to-date-btn', function(e){
		$("#common_small_loader").removeClass('hidden');
		var quelleId =  $(this).attr("data-quelle-id");
		var arzneiId =  $(this).attr("data-arznei-id");
		var mId =  $(this).attr("data-quelle-import-master-id");
		if(quelleId != "" && arzneiId != "" && mId != ""){
			$.ajax({
				type: 'POST',
				url: 'up-to-date-symptom-synonyms.php',
				data: {
					quelle_id: quelleId,
					arznei_id: arzneiId,
					quelle_import_master_id: mId
				},
				dataType: "json",
				success: function( response ) {
					console.log(response);
					if(response.status == "success"){
						$("#common_small_loader").addClass('hidden');
					    location.reload();
					}else{
						$("#common_small_loader").addClass('hidden');
						$("#global_msg_container").html('<p class="text-center text-danger">'+response.message+'</p>');
						$("#globalMsgModal").modal('show');
					}
				}
			}).fail(function (response) {
				$("#common_small_loader").addClass('hidden');
				$("#global_msg_container").html('<p class="text-center text-danger">Operation failed. Somethig went wrong!</p>');
				$("#globalMsgModal").modal('show');
				if ( window.console && window.console.log ) {
					console.log( response );
				}
			});
		}
		else
		{
			$("#common_small_loader").addClass('hidden');
			$("#global_msg_container").html('<p class="text-center">Required data not found.</p>');
			$("#globalMsgModal").modal('show');
		}
	});

	$(document).on('click', '.onRmm', function (){
		var thisId = $(this).attr('id');
		var thisIdArray = thisId.split("_");
		var pre_comparison_id = thisIdArray[1];
		$.ajax({
			async:false,
			type: "POST",
			url: "final-view-control.php",
			data: "pre_comparison_id="+pre_comparison_id,
			dataType: "JSON",
			success: function(returnedData){
				console.log(returnedData);
				try {
					created = JSON.parse(returnedData.created); 
				} catch (e) {
					created = returnedData.created;
				}
				if(created == 0){
					console.log('deleted');
					if($('#'+thisId).children().hasClass('fa-check')){
						$('#'+thisId).children().removeClass('fa-check');
						$('#'+thisId).children().addClass('fa-window-minimize');
					}
				}else{
					console.log('created');
					if($('#'+thisId).children().hasClass('fa-window-minimize')){
						$('#'+thisId).children().removeClass('fa-window-minimize');
						$('#'+thisId).children().addClass('fa-check');
					}
				}
			},
			error: function(xhr, textStatus, error){
				console.log(xhr.statusText);
				console.log(textStatus);
				console.log(error);
			}
		});
	});

</script>