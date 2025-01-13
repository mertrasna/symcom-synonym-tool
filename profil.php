<?php
include 'lang/GermanWords.php';
include 'config/route.php';
if(!isset($_SESSION['access_token'])) {
    header('Location: '.$absoluteUrl.'login');
}
include 'inc/header.php';
include 'inc/sidebar.php';
?>
 

  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Profil</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $absoluteUrl;?>"><i class="fa fa-dashboard"></i> <?php echo $home; ?></a></li>
            <li class="active"> Profil</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <a href="<?php echo $absoluteUrl;?>andere-passwort" class="btn btn-danger pull-right"  title="LÃ¶schen">Ändere das Passwort</a>
                   </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form id="changeEmail" class="content-form" data-source="user" data-action="update-email">
                        <input type="hidden" name="">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="callout callout-info">
                                        <p>Wenn Sie lhr Passwort vergessen, sender wir ihnen einen Reset-Link zu dieser Email</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="admin_email">Email*</label><span class="error-text"></span>
                                        <input type="email" class="form-control" value="<?php if(isset($_SESSION['email'])) echo $_SESSION['email']; ?>" id="admin_email" name="email" required autofocus>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <input class="btn btn-success" type="submit" id="saveFormBtn" value="Aktualisieren" name="admin_email_update">
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
include 'inc/footer.php';
?>