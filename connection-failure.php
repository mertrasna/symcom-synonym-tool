<?php
include 'lang/GermanWords.php';
include 'config/route.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-control" content="public">
    <title>Symcom | Error</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/font-awesome/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $absoluteUrl;?>assets/css/AdminLTE.min.css">
    <!-- custom css -->
    <link rel="stylesheet" href="<?php echo $absoluteUrl;?>assets/css/custom.css">
    <link rel="stylesheet" href="<?php echo $absoluteUrl;?>assets/css/login.css">
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style type="text/css">
        .notfound-404 {
            height: 150px;
        }
        .notfound-404 h1 {
            font-size: 120px;
            font-weight: 700;
            margin: 0px;
            color: #262626;
            text-transform: uppercase;
        }
        .notfound h2 {
            font-size: 16px;
            font-weight: 400;
            text-transform: uppercase;
            color: #151515;
            margin-top: 0px;
            margin-bottom: 25px;
            line-height: 24px;
        }
        .notfound .notfound-404 h1>span {
            color: #00b7ff;
        }
    </style>
</head>
<body>
    <div class="sc-igwadP kESmeQ">
        <div class="sc-ckYZGd UpIaV sc-caSCKo jMJptc">
            <img class="sc-cnTzU hihcIW sc-eweMDZ fBsUCS" src="<?php echo $absoluteUrl;?>assets/img/leaves-top.svg">
            <img class="sc-dXLFzO dVQlII sc-eweMDZ fBsUCS" src="<?php echo $absoluteUrl;?>assets/img/leaves-bottom.svg">
            <div class="sc-eQGPmX eCgWac logo-div">
                <img alt="Acorns" src="<?php echo $absoluteUrl;?>assets/img/logo-big.png">
            </div>
            <div class="notfound text-center">
                <div class="notfound-404">
                    <h1>5<span>0</span>0</h1>
                </div>
                <h2>Zurzeit ist der Symcom Server nicht verfügbar, um die Anfrage zu bearbeiten</h2>
                <a class="btn btn-success" href="<?php echo $absoluteUrl;?>">Zurück nach Hause</a>
            </div>
        </div>
    </div>

    <!-- jQuery 3 -->
    <script src="<?php echo $absoluteUrl;?>plugins/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo $absoluteUrl;?>plugins/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
