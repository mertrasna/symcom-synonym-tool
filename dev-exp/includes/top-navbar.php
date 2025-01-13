<?php $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
<nav class="navbar navbar-inverse">
    <div class="navbar-header">
     	<a class="navbar-brand" href="http://www.newrepertory.com/"><img class="img-responsive" src="http://www.newrepertory.com/assets/img/logo-big.png" alt="Symcom"></a>
    </div>
  	<ul class="nav navbar-nav">
    	<li><a class="<?php if(preg_match("/index/", $actual_link) OR $actual_link == $baseUrl) echo 'active'; ?>" href="<?php echo $baseUrl ?>">Import</a></li>
    	<li><a class="<?php if(preg_match("/comparison/", $actual_link) AND !preg_match("/comparison-history/", $actual_link)) echo 'active'; ?>" href="<?php echo $baseUrl ?>comparison.php">Comparison</a></li>
    	<li><a class="<?php if(preg_match("/materia-medica/", $actual_link)) echo 'active'; ?>" href="<?php echo $baseUrl ?>materia-medica.php">Materia Medica</a></li>
    	<li><a class="<?php if(preg_match("/history/", $actual_link) AND !preg_match("/comparison-history/", $actual_link)) echo 'active'; ?>" href="<?php echo $baseUrl ?>history.php">History</a></li>
  	</ul>
</nav>