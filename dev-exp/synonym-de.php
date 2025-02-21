<?php
	include '../config/route.php';
	include 'sub-section-config.php';
	// include '../api/mainCall.php';
?>
<?php
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Synonym DE</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/jasny-bootstrap/jasny-bootstrap.min.css">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/bootstrap/dist/css/bootstrap.min.css">
  <!-- dropify -->
  <link rel="stylesheet" type="text/css" href="<?php echo $absoluteUrl;?>plugins/dropify/css/dropify.min.css">
  <!-- Font Awesome -->
  <!-- <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/font-awesome/css/font-awesome.min.css"> -->
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/font-awesome/css/fontawesome-all.min.css">
  <!-- <link rel="stylesheet" href="<?php echo $baseUrl;?>plugins/font-awesome/css/fontawesome-all.min.css"> -->
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>assets/css/skins/_all-skins.min.css">
  <!-- Jquery UI-->
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/jquery-ui/themes/base/jquery-ui.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- sweet alert 2 -->
  <link rel="stylesheet" type="text/css" href="<?php echo $absoluteUrl;?>plugins/sweetalert2/sweetalert2.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <!-- <link rel="stylesheet" href="<?php echo $absoluteUrl;?>assets/css/AdminLTE.min.css"> -->
  <!-- custom css -->
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>assets/css/custom.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="assets/css/custom.css">
</head>

<style>
    .highlight-row {
        background-color: orange !important;
    }
</style>


<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 symptoms-container">
            <?php
                $quellen_value = "";
                $importedLanguage = "";

            ?>
            <h2>Synonym DE</h2>   
            <div class="spacer"></div>      
            <div class="">          
                <table class="table table-bordered table-sticky-head table-hover">
                    <thead>
                        <tr>
                            <th style="width:5%;">Word</th>
                            <th style="width:5%;">Synonym</th>
                            <th style="width: 5%;">Cross Reference</th>
                            <th style="width: 5%;">Generic Term</th>
                            <th style="width: 5%;">Sub Term</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php                                                               
                            $result = mysqli_query($db,"SELECT * FROM synonym_de ORDER BY synonym_id DESC"); 
                            while($row = mysqli_fetch_array($result)){   
                                ?>
                                <tr class="<?php echo ($row['synonym_ns'] == 1) ? 'highlight-row' : ''; ?>">
                                    <td><?php echo $row['word']; ?></td>
                                    <td><?php echo $row['strict_synonym']; ?></td>
                                    <td><?php echo $row['synonym_partial_1']; ?></td>
                                    <td><?php echo $row['synonym_general']; ?></td>
                                    <td><?php echo $row['synonym_minor']; ?></td>
                                </tr>

                                <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
            
</div>
<!-- Add symptom edit modal end -->
<!-- jQuery 3 -->
<script src="<?php echo $absoluteUrl;?>plugins/jquery/dist/jquery.min.js"></script>

<!-- jQuery UI 1.11.4 -->
<script src="<?php echo $absoluteUrl;?>plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
	var absoluteUrl = "<?php echo $absoluteUrl;?>";
	var baseApiURL = "<?php echo $baseApiURL;?>";
	var token = "<?php echo $_SESSION['access_token']; ?>";
</script>
<!-- Tinymce -->
<script src="<?php echo $absoluteUrl;?>plugins/tinymce/jquery.tinymce.min.js"></script>
<script src="<?php echo $absoluteUrl;?>plugins/tinymce/jquery.tinymce.config.js"></script>
<script src="<?php echo $absoluteUrl;?>plugins/tinymce/tinymce.min.js"></script>
<script src="<?php echo $absoluteUrl;?>plugins/jasny-bootstrap/jasny-bootstrap.min.js"></script>

<script src="<?php echo $absoluteUrl;?>plugins/jquery-ui/ui/i18n/datepicker-de.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $absoluteUrl;?>plugins/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Dropify -->
<script src="<?php echo $absoluteUrl;?>plugins/dropify/js/dropify.min.js"></script>
<!-- DataTables -->
<script src="<?php echo $absoluteUrl;?>plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $absoluteUrl;?>plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- sweet alert 2 -->
<script src="<?php echo $absoluteUrl;?>plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Select2 -->
<script src="<?php echo $absoluteUrl;?>plugins/select2/dist/js/select2.full.min.js"></script>
<!-- Select2 custom search box placeholder -->
<script src="<?php echo $absoluteUrl;?>assets/js/select2-custom-search-box-placeholder.js"></script>
<!-- FastClick -->
<script src="<?php echo $absoluteUrl;?>plugins/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $absoluteUrl;?>assets/js/adminlte.min.js"></script>
<!-- Jquery validation plugin -->
<script src="<?php echo $absoluteUrl;?>plugins/jquery.validate.min.js"></script>
<!-- custom common js -->
<script src="<?php echo $absoluteUrl;?>assets/js/common.js"></script>
<!-- Advance Search custom js -->
<script src="<?php echo $absoluteUrl;?>assets/js/advanceSearch.js"></script>
<script src="<?php echo $absoluteUrl;?>assets/js/modernizr.js"></script>
<!-- Custom form validation -->
<script src="<?php echo $absoluteUrl;?>assets/js/formValidation.js"></script>
<!-- Ajax blockUI -->
<script src="<?php echo $absoluteUrl;?>plugins/jquery.blockUI.js"></script>
<!-- sweet alert message popup-->
<script src="<?php echo $absoluteUrl;?>/assets/js/alertMessage.js"></script>
<!-- Ajax form submit -->
<script src="<?php echo $absoluteUrl;?>assets/js/ajaxFormSubmit.js"></script>
<!-- Quelle Gradings page js -->
<script src="<?php echo $absoluteUrl;?>assets/js/quelleSettings.js"></script>
<script src="<?php echo $absoluteUrl;?>assets/js/globalGradingSetting.js"></script>
<!--Any error type pop up  -->
<?php if(isset($error)) { ?>
	<script> 
		var errorMessage = '<?php echo $error;?>';
		errorMessagePopUp( errorMessage ); 
	</script>
<?php } ?>
<script>
    $('#quelle_id').select2({
        // options 
        searchInputPlaceholder: 'Search Quelle...'
    });

    $('#quelle_id').on('select2:select', function (e) {
        console.log(e.params.data);
        console.log(quelle_id, e.params.data.id);
    });
</script>
</body>
</html>

