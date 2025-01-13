<?php
include 'lang/GermanWords.php';
include 'config/route.php';
if(isset($_SESSION['access_token'])) {
    header('Location: '.$absoluteUrl);
}
$token = '';
if(isset($_GET['token'])) {
    $token = $_GET['token'];
}
include 'api/reset-password.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-control" content="public">
    <title>Symcom | Zurücksetzen Passwort</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/font-awesome/css/font-awesome.min.css">
    <!-- sweet alert 2 -->
    <link rel="stylesheet" type="text/css" href="<?php echo $absoluteUrl;?>plugins/sweetalert2/sweetalert2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $absoluteUrl;?>assets/css/AdminLTE.min.css">
    <!-- custom css -->
    <link rel="stylesheet" href="<?php echo $absoluteUrl;?>assets/css/custom.css">
    <link rel="stylesheet" href="<?php echo $absoluteUrl;?>assets/css/login.css">
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body>
    <div class="sc-igwadP kESmeQ">
        <div class="sc-ckYZGd UpIaV sc-caSCKo jMJptc">
            <img class="sc-cnTzU hihcIW sc-eweMDZ fBsUCS" src="<?php echo $absoluteUrl;?>assets/img/leaves-top.svg">
            <img class="sc-dXLFzO dVQlII sc-eweMDZ fBsUCS" src="<?php echo $absoluteUrl;?>assets/img/leaves-bottom.svg">
            <div class="sc-eQGPmX eCgWac logo-div">
                <img alt="Acorns" src="<?php echo $absoluteUrl;?>assets/img/logo-big.png">
            </div>
            <?php if(isset($success)) { ?>
                <p class="text-center"><?php echo $success;?></p>
                <a href="<?php echo $absoluteUrl;?>login" class="sc-frpTsy iQoeKm sc-dxgOiQ crAxhg">Zurück zum Login</a>
            <?php } else { ?>
            <form class="sc-kVfTjK llGERO" id="resetPasswordForm" autocomplete="off" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="hidden" name="token" value="<?php echo $token;?>">
                <div class="sc-gjAXCV irlZp">
                    <label class="sc-dOkuiw iMAhFM">Neues Passwort*</label><span class="error-text"></span>
                    <input class="sc-hMjcWo dxJQAa" name="password" type="password" id="password" autofocus>
                </div>
                <div class="sc-gjAXCV irlZp">
                    <label class="sc-dOkuiw iMAhFM">Bestätige Passwort*</label><span class="error-text"></span>
                    <input class="sc-hMjcWo dxJQAa" name="password_confirmation" type="password" id="password_confirmation">
                </div>
                <button class="sc-frpTsy iQoeKm sc-dxgOiQ crAxhg">Einreichen</button>
            </form>
             <?php } ?>
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery 3 -->
    <script src="<?php echo $absoluteUrl;?>plugins/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo $absoluteUrl;?>plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- jquery validation -->
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
    <!-- sweet alert -->
    <script src="<?php echo $absoluteUrl;?>plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- sweet alert message popup-->
    <script src="<?php echo $absoluteUrl;?>/assets/js/alertMessage.js"></script>
    <!-- custom js -->
    <script src="<?php echo $absoluteUrl;?>/assets/js/login.js"></script>
   
    <?php if(isset($error)) { ?>
    <script>
        var errorMessage = '<?php echo $error;?>';
        errorMessagePopUp( errorMessage ); 
    </script>
    <?php } ?>
</body>
</html>
