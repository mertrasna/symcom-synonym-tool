<?php
include 'lang/GermanWords.php';
include 'config/route.php';

if(isset($_SESSION['access_token'])) {
    header('Location: '.$absoluteUrl);
}
$usernameCookie = '';
$passwordCookie = '';
if(isset($_COOKIE['username']) && isset($_COOKIE['password'])) { 
    $usernameCookie = $_COOKIE['username'];
    $passwordCookie = $_COOKIE['password'];
}
include 'api/login.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-control" content="public">
    <title>Symcom | Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/font-awesome/css/font-awesome.min.css">
    <!-- sweet alert 2 -->
    <link rel="stylesheet" type="text/css" href="<?php echo $absoluteUrl;?>plugins/sweetalert2/sweetalert2.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/Ionicons/css/ionicons.min.css">
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
            <form class="sc-kVfTjK llGERO" id="loginForm" autocomplete="off" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="sc-gjAXCV irlZp">
                    <label class="sc-dOkuiw iMAhFM">Username</label><span class="error-text"></span>
                    <input class="sc-hMjcWo dxJQAa" name="username" placeholder="Username" type="text" id="username" value="<?php echo $usernameCookie ?>" autofocus>
                </div>
                <div class="sc-bQQHgq elQaKU">
                    <div class="sc-gjAXCV irlZp">
                        <label class="sc-dOkuiw iMAhFM">Kennwort</label><span class="error-text"></span>
                        <input class="sc-hMjcWo dxJQAa" name="password" placeholder="●●●●●●●●" type="password" id="password" value="<?php echo $passwordCookie ?>">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="checkbox icheck">
                                    <label>
                                      <input type="checkbox" id="rememberMe" <?php if(!empty($usernameCookie) && !empty($passwordCookie)) echo 'checked'; ?>> Erinnere dich an mich
                                    </label>
                                </div>
                            </div>
                            <div class="sc-eAudoH fbHQWt col-xs-6"><a href="<?php echo $absoluteUrl;?>vergessen-passwort">Ihr Kennwort vergessen?</a></div>
                        </div>
                    </div>
                </div>
                <button class="sc-frpTsy iQoeKm sc-dxgOiQ crAxhg">Einloggen</button>
            </form>
            <div class="sc-cFMgCN cndWlt">
                <a href="#" class="sc-jbxdUx jWPjDn">Habe kein Konto?</a>
            </div>
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
    <!-- custom js -->
    <script src="<?php echo $absoluteUrl;?>/assets/js/login.js"></script>
    <!-- sweet alert message popup-->
    <script src="<?php echo $absoluteUrl;?>/assets/js/alertMessage.js"></script>
   <!-- jQuery cookie plugin -->
    <script src="<?php echo $absoluteUrl;?>plugins/jquery.cookie.min.js"></script>
    <?php if(isset($error)) { ?>
    <script>
        var errorMessage = '<?php echo $error;?>';
        errorMessagePopUp( errorMessage ); 
    </script>
    <?php } ?>
</body>
</html>
