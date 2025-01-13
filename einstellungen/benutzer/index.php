<?php
include '../../lang/GermanWords.php';
include '../../lang/EnglishWords.php';
include '../../config/route.php';
if(isset($_SESSION['user_type']) && ($_SESSION['user_type'] == 3) && ($_SESSION['user_type'] == 2)) {
	header('Location: '.$absoluteUrl);
}
include '../../api/mainCall.php';
$benutzer = '';
$get_data = '';
$response = '';
$get_data = callAPI('GET', $baseApiURL.'user/all?is_paginate=0', false);
$response = json_decode($get_data, true);
$status = $response['status'];
switch ($status) {
	case 0:
		header('Location: '.$absoluteUrl.'unauthorised');
		break;
	case 2:
		$benutzer = $response['content']['data'];
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
        User
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $absoluteUrl;?>"><i class="fa fa-dashboard"></i> <?php echo $home; ?></a></li>
        <li class="active">User</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-md-12">
				<div class="box box-success">
		            <div class="box-header with-border">
						<h3 class="box-title">
							<a href="<?php echo $absoluteUrl;?>einstellungen/benutzer/add" class="btn btn-success"><i class="fa fa-plus"></i> &nbsp; New User</a>
						</h3>
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body">
			            <form id="listViewForm" data-action="delete" data-source="user" data-source_id_name="id">
		            		<div class="table-responsive">
					            <table id="dataTable" class="table-loader table table-bordered table-striped display table-hover custom-table">
					                <thead>
						                <tr>
						                	<th class="rowlink-skip dt-body-center no-sort"><button class="btn btn-danger btn-sm delete-row"  title="Löschen"><i class="fa fa-trash"></i></button></th>
											 <th>Name</th>
											<th>Initials</th>
											<th>Email</th>
											<th>User Type</th>
											<th class="no-sort">Actions</th>
						                </tr>
					                </thead>
					                <tbody data-link="row" class="rowlink">
					                	<?php 
					                	if($benutzer != null && $benutzer != '') { 
					                		foreach ($benutzer as $key => $user) { ?>

							                <tr>
							                	<td class="rowlink-skip"><?php echo $user['id']; ?></td>
												<td><a href="#rowlinkModal" 
														data-id="<?php echo $user['id']; ?>" data-type="benutzer" data-title="Benutzer" 
														data-toggle="modal"><?php echo $user['first_name']. ' ' .$user['last_name'];  ?></a></td>
												<td><?php echo $user['initials']; ?></td>
												<td><?php echo $user['email']; ?></td>
												<td><?php if($user['user_type'] == 2) echo 'Bearbeiter'; else echo 'Gast' ; ?></td>
												<td class="rowlink-skip">
													<a class="btn btn-warning btn-sm" href="<?php echo $absoluteUrl;?>einstellungen/benutzer/edit?benutzer_id=<?php echo $user['id']; ?>" title="Ändern"><i class="fa fa-edit"></i></a>
			            	       	            </td>
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
