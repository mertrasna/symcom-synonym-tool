<?php
include '../../lang/GermanWords.php';
include '../../config/route.php';
include '../../api/mainCall.php';

$synonymEn = [];
$get_data = '';
$response = [];
$get_data = callAPI('GET', $baseApiURL.'synonym-en/all?is_paginate=0', false);
$response = json_decode($get_data, true);
$status = $response['status'];
switch ($status) {
	case 0:
		header('Location: '.$absoluteUrl.'unauthorised');
		break;
	case 2:
		$synonymEn = $response['content']['data'];
		break;
	case 6:
		$error = $response['message'];
		break;
	default:
		break;
}
include '../../inc/header.php';
include '../../inc/sidebar.php';
?>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Synonym
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $absoluteUrl;?>"><i class="fa fa-dashboard"></i> <?php echo $home; ?></a></li>
        <li class="active">Synonym</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-md-12">
				<div class="box box-success">
					<?php if(isset($_SESSION['user_type']) && ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2)) { ?>
		            <div class="box-header with-border">
						<h3 class="box-title">
							<a href="<?php echo $absoluteUrl;?>stammdaten/synonym-en/add" class="btn btn-success"><i class="fa fa-plus"></i> &nbsp; Neues Synonym</a>
						</h3>
		            </div>
		            <?php  } ?>
		            <!-- /.box-header -->
		            <div class="box-body">
			            <form id="listViewForm" data-action="delete" data-source="synonym-en" data-source_id_name="synonym_id">
		            		<div class="table-responsive">
					            <table id="dataTable" class="table-loader table table-bordered table-striped display table-hover custom-table">
					                <thead>
						                <tr>
						                	<?php if(isset($_SESSION['user_type']) && ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2)) { ?>
						                	<th class="rowlink-skip dt-body-center no-sort"><button class="btn btn-danger btn-sm delete-row"  title="Löschen"><i class="fa fa-trash"></i></button></th>
						                	<?php  } ?>
											<th>Wort</th>
											<th>Striktes Synonym</th>
											<th>Cross Reference</th>
											<th>HyperLink</th>
											<th>Hyperonym (Oberbegriff)</th>
											<th>Hyponym (Unterbegriff)</th>
											<th>References</th>
											<?php /*<th>Synonym NN</th>*/ ?>
											<?php if(isset($_SESSION['user_type']) && ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2)) { ?>
											<th class="no-sort">Aktionen</th>
											<?php  } ?>
						                </tr>
					                </thead>
					                <tbody data-link="row" class="rowlink">
					                	<?php 
					                	if($synonymEn != null && $synonymEn != '') { 
					                		foreach ($synonymEn as $key => $synon) { ?>

							                <tr>
							                	<?php if(isset($_SESSION['user_type']) && ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2)) { ?>
							                	<td class="rowlink-skip"><?php echo $synon['synonym_id']; ?></td>
							                	<?php  } ?>
												<td <?php if ($synon['synonym_ns']=="1") echo "class='ns_bg_color'"?>>
													<a href="#rowlinkModal" data-id="<?php echo $synon['synonym_id']; ?>" data-type="synonym_en" data-title="Synonym" data-toggle="modal"><?php echo $synon['word']; ?></a>
												</td>
												<td><?php echo $synon['strict_synonym']; ?></td>
												<td><?php echo $synon['synonym_partial_1']; ?></td>
												<td><?php echo $synon['synonym_partial_2']; ?></td>
												<td><?php echo $synon['synonym_general']; ?></td>
												<td><?php echo $synon['synonym_minor']; ?></td>
												<td <?php if ($synon['source_reference_ns']=="1") echo "class='ns_bg_color'"?>>
													<?php
														$referencesArray = array(); 
														if(!empty($synon['synonymreference'])){
															$arraySize = count($synon['synonymreference']);
															$i = 0;
															while($i < $arraySize){
																array_push($referencesArray, $synon['synonymreference'][$i]["titel"]);
																$i++;
															}
														}
														$referencesArrayString = implode(",",$referencesArray);
														echo $referencesArrayString;
													?>
												</td>
												<?php /*<td><?php echo $synon['synonym_nn']; ?></td>*/ ?>
												<?php if(isset($_SESSION['user_type']) && ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2)) { ?>
												<td class="rowlink-skip">
													<a class="btn btn-warning btn-sm" href="<?php echo $absoluteUrl;?>stammdaten/synonym-en/edit?synonym_id=<?php echo $synon['synonym_id']; ?>" title="Ändern"><i class="fa fa-edit"></i></a>
			            	       	            </td>
			            	       	            <?php  } ?>
							                </tr>
							            <?php } 
							            } ?>
						            </tbody>
					            </table>
					        </div>
				        </form> 
			        </div>
			            <!-- /.box-body -->
		        </div>
			</div>
		</div> <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
include '../../inc/footer.php';
?>