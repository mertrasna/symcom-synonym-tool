
	<footer class="main-footer">
		<div class="pull-right hidden-xs">
			<b><?php echo $version;?></b> 1.0.0
		</div>
		<strong><?php echo $copyright;?> &copy; 2016-2020 <a href="<?php echo $absoluteUrl;?>">SymCom</a>.</strong> <?php echo $all_rights_reserved;?>.
	</footer>
	<div class="modal fade" id="rowlinkModal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<!-- Default box -->
					<div class="box box-success">
						<div class="box-body" id="rowlinkModalDetails">
							
						</div>
					</div>
					<!-- /.box -->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
				</div>
			</div>
		<!-- /.modal-content -->
		</div>
	<!-- /.modal-dialog -->
	</div>
</div>
<!-- ./wrapper -->


<div class="cd-cover-layer"></div> <!-- cover main content when search form is open -->
<!-- jQuery 3 -->
<script src="<?php echo $absoluteUrl;?>plugins/jquery/dist/jquery.min.js"></script>

<!-- jQuery UI 1.11.4 -->
<!-- <script src="<?php echo $absoluteUrl;?>plugins/jquery-ui/jquery-ui.min.js"></script> -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
	var absoluteUrl = "<?php echo $absoluteUrl;?>";
	var baseApiURL = "<?php echo $baseApiURL;?>";
	var token = "<?php echo isset($_SESSION['access_token']) ? $_SESSION['access_token'] : ''; ?>";
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
<?php if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 3 ) { ?>
<script src="<?php echo $absoluteUrl;?>assets/js/dataTablesConfigPublic.js"></script>
<?php  } ?>
<?php if(isset($_SESSION['user_type']) && ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2 )) { ?>
<script src="<?php echo $absoluteUrl;?>assets/js/dataTablesConfig.js"></script>
<?php  } ?>
<!-- jquery highlight -->
<script src="<?php echo $absoluteUrl;?>assets/js/jquery.highlight.js"></script>
<!-- search highlight -->
<script src="<?php echo $absoluteUrl;?>assets/js/searchHighlight.min.js"></script>
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
</body>
</html>
