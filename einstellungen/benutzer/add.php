<?php
include '../../lang/GermanWords.php';
include '../../lang/EnglishWords.php';
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
	  	New User
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $absoluteUrl;?>"><i class="fa fa-dashboard"></i> <?php echo $home; ?></a></li>
        <li class=""> <a href="<?php echo $absoluteUrl;?>einstellungen/benutzer/">User</a></li>
        <li class="active"> New User</li>
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
		            <form class="content-form" id="addBenutzerForm" data-action="add" data-source="user" autocomplete="off">
		              <div class="box-body">
		              	<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="first_name">First Name*</label><span class="error-text"></span>
									<input type="text" class="form-control" name="first_name"  id="vorname" autofocus required>
								</div>
								<div class="form-group">
									<label for="last_name">Last Name*</label><span class="error-text"></span>
									<input type="text" class="form-control" id="last_name" name="last_name" required>
								</div>
								<div class="form-group">
									<label for="last_name">Initials </label><span class="error-text"></span>
									<input type="text" class="form-control" id="initials" name="initials" required>
								</div>
								<div class="form-group">
									<label for="company">Organisation</label>
									<input type="text" class="form-control"  name="company" id="company">
								</div>
								<div class="form-group">
									<label for="email">Email*</label><span class="error-text"></span>
									<input type="text" class="form-control" id="email" name="email" required>
								</div>
								<div class="form-group">
									<label for="phone">Phone</label>
									<input type="text" class="form-control" id="phone" name="phone">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="username">User Name*</label><span class="error-text"></span>
									<input type="text" class="form-control" id="username" name="username" required>
								</div>
								<div class="form-group">
                                    <label for="password">Password*</label><span class="error-text"></span>
                                    <input type="password" class="form-control" id="password" name="password" >
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation ">Confirm Password*</label><span class="error-text"></span>
                                    <input type="password" class="form-control" id="password_confirmation " name="password_confirmation">
                                </div>
                                <div class="from-group">
                                	<label>Activated</label>
                                    <div class="radio" style="margin-bottom: 20px;">
                                        <label style="margin-right: 30px;">
                                            <input name="active" id="aktiv" value="1" type="radio" checked>
                                             active
                                        </label>
                                        <label>
                                            <input name="active" id="inaktiv" value="0" type="radio">
                                            inactive
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
									<label for="user_type">User Type*</label><span class="error-text"></span>
									<select class="form-control" name="user_type" id="user_type" >
										<option value="">Select User</option>
										<option value="2">Editor</option>
										<option value="3">Guest</option>
									</select>
								</div>
							</div>
						</div>
		              </div>
		              <!-- /.box-body -->

		              <div class="box-footer">
		                <input class="btn btn-success" type="submit" value="Speichern" name="Speichern" id="saveFormBtn">
						<a class="btn btn-default" href="<?php echo $absoluteUrl;?>einstellungen/benutzer/" id="cancelBtn">Cancel</a>
						<button type="reset" id="reset" class="sr-only"></button>
						<a href="<?php echo $absoluteUrl;?>einstellungen/benutzer/" class="pull-right btn btn-primary" style="background: #000;">Return</a>
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