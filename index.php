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
        <h1>SymCom</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="well well-lg box box-success">
            <h2>Willkommen in SymCom!</h2><!-- <h2>Welcome to SymCom!</h2> -->
            <hr>
            <p>Hier entsteht eine referenzierte Materia medica, die direkt aus den Primärquellen der Homöopathie erstellt wird.</p>
            <p class="lead">
                <a title="More info" class="btn btn-success" href="<?php echo $absoluteUrl;?>about-symcom">Mehr Infos ...</a>
            </p>
        </div>
        <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
include 'inc/footer.php';
?>