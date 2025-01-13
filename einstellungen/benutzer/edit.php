<?php
include '../../lang/EnglishWords.php';
include '../../lang/GermanWords.php';
include '../../config/route.php';
include '../../api/benutzer.php';
include '../../inc/header.php';
include '../../inc/sidebar.php';
?>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
	  Change User
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $absoluteUrl;?>"><i class="fa fa-dashboard"></i> <?php echo $home; ?></a></li>
        <li class=""> <a href="<?php echo $absoluteUrl;?>einstellungen/benutzer/">User</a></li>
        <li class="active"> Change User</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-md-12">
				<div class="box box-success">
		            <div class="box-header with-border">
		              <p>The fields marked with * are mandatory</p>
		            </div>
		            <!-- /.box-header -->
		            <!-- form start -->
		            <form id="editBenutzerForm" class="content-form" data-action="update" data-source="user" data-source_id_value="<?php echo $benutzer['id'];?>" data-source_id_name="id" autocomplete="off">
		              <div class="box-body">
		              	<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="first_name">First Name*</label><span class="error-text"></span>
									<input type="text" class="form-control" name="first_name"  id="first_name" value="<?php echo $benutzer['first_name'];?>" autofocus required>
								</div>
								<div class="form-group">
									<label for="last_name">Last Name*</label><span class="error-text"></span>
									<input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $benutzer['last_name'];?>" required>
								</div>
								<div class="form-group">
									<label for="initials">Initials</label><span class="error-text"></span>
									<input type="text" class="form-control" id="initials" name="initials" value="<?php echo $benutzer['initials'];?>">
								</div>
								<div class="form-group">
									<label for="company">Organisation</label>
									<input type="text" class="form-control"  name="company" id="company" value="<?php echo $benutzer['company'];?>">
								</div>
								<div class="form-group">
									<label for="email">Email*</label><span class="error-text"></span>
									<input type="text" class="form-control" id="email" name="email" value="<?php echo $benutzer['email'];?>" required>
								</div>
								<div class="form-group">
									<label for="phone">Phone</label>
									<input type="text" class="form-control" id="phone" value="<?php echo $benutzer['phone'];?>" name="phone">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="username">User Name*</label><span class="error-text"></span>
									<input type="text" class="form-control" id="username" name="username" value="<?php echo $benutzer['username'];?>" required>
								</div>
								<div class="form-group">
                                    <label for="password">Password</label><span class="error-text"></span>
                                    <input type="password" class="form-control" id="password" name="password" value="">
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation ">Confirm Password</label><span class="error-text"></span>
                                    <input type="password" class="form-control" id="password_confirmation " name="password_confirmation" value="">
                                </div>
                                <div class="from-group">
                                	<label>Activated</label>
                                    <div class="radio" style="margin-bottom: 20px;">
                                        <label style="margin-right: 30px;">
                                            <input name="active" id="aktiv" value="1" type="radio" <?php if($benutzer['active'] == 1) echo 'checked'; ?>>
											active
                                        </label>
                                        <label>
                                            <input name="active" id="inaktiv" value="0" type="radio" <?php if($benutzer['active'] == 0) echo 'checked'; ?>>
                                            inactive
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
									<label for="user_type">UserType*</label><span class="error-text"></span>
									<select class="form-control" name="user_type" id="user_type" >
										<option value="">Choose User</option>
										<option value="2" <?php if($benutzer['user_type'] == 2) echo 'selected'; ?>>Editor</option>
										<option value="3" <?php if($benutzer['user_type'] == 3) echo 'selected'; ?>>Guest</option>
									</select>
								</div>
							</div>
						</div>
		              </div>
		              <!-- /.box-body -->

		              <div class="box-footer">
		              	<input class="btn btn-success" type="submit" value="Änderungen speichern" name="ÄnderungenSpeichern" id="saveFormBtn">
						<a class="btn btn-default" href="<?php echo $absoluteUrl;?>einstellungen/benutzer/" id="cancelBtn">Cancel</a>
						<a href="<?php echo $absoluteUrl;?>einstellungen/benutzer/" class="pull-right btn btn-primary" style="background: #000;">Return</a>
		              </div>
		            </form>
		          </div>
			</div>
		</div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
include '../../inc/footer.php';
?>