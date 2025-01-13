<?php
	include '../config/route.php';
	include 'sub-section-config.php';
?>
<?php  
	if(isset($_POST['upd_submit_hidden_eng']) AND $_POST['upd_submit_hidden_eng'] == "Update"){
		$stopwordsResult = mysqli_query($db,"SELECT * FROM stop_words WHERE language = 'english'");
		while($stopwordsRow = mysqli_fetch_array($stopwordsResult)){
			$name = $stopwordsRow['id'];
			$active = (isset($_POST[$name]) AND $_POST[$name] != "") ? $_POST[$name] : 0;
			$updateQuery="UPDATE stop_words SET active = '".$active."' WHERE id = '".$stopwordsRow['id']."'";
			$db->query($updateQuery);
		}
		header('Location: '.$baseUrl.'stop-words.php#english');
		exit();
	}

	if(isset($_POST['upd_submit_hidden_de']) AND $_POST['upd_submit_hidden_de'] == "Update"){
		$stopwordsResult = mysqli_query($db,"SELECT * FROM stop_words WHERE language = 'german'");
		while($stopwordsRow = mysqli_fetch_array($stopwordsResult)){
			$name = $stopwordsRow['id'];
			$active = (isset($_POST[$name]) AND $_POST[$name] != "") ? $_POST[$name] : 0;
			$updateQuery="UPDATE stop_words SET active = '".$active."' WHERE id = '".$stopwordsRow['id']."'";
			$db->query($updateQuery);
		}
		header('Location: '.$baseUrl.'stop-words.php#german');
		exit();
	}
	if(isset($_POST['add_submit_hidden']) AND $_POST['add_submit_hidden'] == "Save"){
		$urlPram = "stop-words.php";
		if(isset($_POST['stop_word']) AND $_POST['stop_word'] != ""){
			$stopWord = mysqli_real_escape_string($db, trim($_POST['stop_word']));
			$language = (isset($_POST['language']) AND $_POST['language'] != "") ? mysqli_real_escape_string($db, trim($_POST['language'])) : 'english';
			$stopwordsResult = mysqli_query($db,"SELECT id FROM stop_words WHERE name = '".$stopWord."'");
			if(mysqli_num_rows($stopwordsResult) == 0){
				$insertQuery="INSERT INTO stop_words (name, language) VALUES (NULLIF('".$stopWord."', ''), '".$language."')";
				$db->query($insertQuery);
				$urlPram .= '#'.$language;
			}
			else{
				$urlPram .= "?error=1#".$language;
			}
		}
		header('Location: '.$baseUrl.$urlPram);
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Stop words</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<!-- Font Awesome -->
  	<link rel="stylesheet" href="plugins/font-awesome/css/fontawesome-all.min.css">
  	<!-- Select2 -->
  	<link rel="stylesheet" href="plugins/select2/dist/css/select2.min.css">
  	<!-- custom -->
  	<link rel="stylesheet" href="assets/css/custom.css">
</head>
<body>
	<div class="container">
		<?php 
			if(isset($_GET['error'])){
				switch ($_GET['error']) {
				 	case 1:
				 		$err_msg = "This stop word is already added.";
				 		break;
				 	
				 	default:
				 		$err_msg = "";
				 		break;
				} 
		?>	
			<div class="row text-center"><span class="text-danger text-center"><strong><?php echo $err_msg; ?></strong></span></div>
			<div class="spacer"></div>
		<?php 
			} 
		?>
		<div id="loader" class="form-group text-center">
			Loading is not complete please wait <img src="assets/img/loader.gif" alt="Loading...">
		</div>
		<h2>Stop words</h2>
		<small>Checked words will be ignored in comparison, you can uncheck the words that you want to include in the comparison and click on the save button below</small>
		<br><hr><a href="materia-medica.php">Go back to materia medica</a>
		<div class="spacer"></div>
		<ul class="nav nav-tabs" id="myTab">
		    <li class="active"><a data-toggle="tab" href="#english">English</a></li>
		    <li><a data-toggle="tab" href="#german">German</a></li>
		</ul>
		<div class="tab-content">
		    <div id="english" class="tab-pane fade in active">
		      	<form id="english_stop_form" name="english_stop_form" action="" class="unclicable" method="POST">
					<h3>Add new <a href="javascript:void(0)" title="Add stop word" onclick="openModal('english')"><i class="far fa-plus-square"></i></a></h3>
					<div class="spacer"></div>
					<div class="row">
						<?php
							$stopwordsResult = mysqli_query($db,"SELECT * FROM stop_words where language = 'english' ORDER BY name ASC");
							$cnt = 1;
							$isClosed = 0;
							while($stopwordsRow = mysqli_fetch_array($stopwordsResult)){
								if($cnt == 1)
									echo '<ul class="col-sm-3">';
								?>
								<li><input type="checkbox" name="<?php echo $stopwordsRow['id']; ?>" value="1" <?php if($stopwordsRow['active'] == 1){ echo 'checked'; } ?>> <?php echo $stopwordsRow['name']; ?></li>
								<?php
								if($cnt == 80){
									echo '</ul>';
									$cnt = 1;
									$isClosed = 1;
								}else
									$cnt++;
							}
							if($isClosed == 0)
								echo '</ul>';
						?>
					</div>
					
					<div class="form-group text-center">
						<div class="spacer"></div>
						<input type="hidden" name="upd_submit_hidden_eng" value="Update">
						<button id="eng_submit_btn" class="btn btn-success" type="button" onclick="stopWordUpdEng()">Save</button>
					</div>
				</form>
		    </div>
		    <div id="german" class="tab-pane fade">
		      	<form id="german_stop_form" name="german_stop_form" action="" class="unclicable" method="POST">
					<h3>Add new <a href="javascript:void(0)" title="Add stop word" onclick="openModal('german')"><i class="far fa-plus-square"></i></a></h3>
					<div class="spacer"></div>
					<div class="row">
						<?php
							$stopwordsResult = mysqli_query($db,"SELECT * FROM stop_words where language = 'german' ORDER BY name ASC");
							$cnt = 1;
							$isClosed = 0;
							while($stopwordsRow = mysqli_fetch_array($stopwordsResult)){
								if($cnt == 1)
									echo '<ul class="col-sm-3">';
								?>
								<li><input type="checkbox" name="<?php echo $stopwordsRow['id']; ?>" value="1" <?php if($stopwordsRow['active'] == 1){ echo 'checked'; } ?>> <?php echo $stopwordsRow['name']; ?></li>
								<?php
								if($cnt == 80){
									echo '</ul>';
									$cnt = 1;
									$isClosed = 1;
								}else
									$cnt++;
							}
							if($isClosed == 0)
								echo '</ul>';
						?>
					</div>
					
					<div class="form-group text-center">
						<div class="spacer"></div>
						<input type="hidden" name="upd_submit_hidden_de" value="Update">
						<button id="de_submit_btn" class="btn btn-success" type="button" onclick="stopWordUpdDe()">Save</button>
					</div>
				</form>
		    </div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="stopwordModal" role="dialog">
	    <div class="modal-dialog modal-md">
	    	<form name="add_stop_word_form" id="add_stop_word_form" method="POST">
	    		<div class="modal-content">
			        <div class="modal-header">
			          	<button type="button" class="close" data-dismiss="modal">&times;</button>
			          	<h4 class="modal-title">Add stop word</h4>
			        </div>
			        <div class="modal-body">
			          	<div class="row">
							<div class="col-sm-8 col-sm-offset-2">
								<div class="form-group Text_form_group">
									<label class="comparing-option-label">Stop word</label>
									<input type="text" class="form-control" name="stop_word" id="stop_word" placeholder="Stop word">
									<span class="error-text"></span>
								</div>
							</div>
						</div>
			        </div>
			        <div class="modal-footer">
			        	<input type="hidden" name="add_submit_hidden" value="Save">
			        	<input type="hidden" name="language" id="language" value="">
			          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			          	<button type="button" class="btn btn-success" name="add_stop_word_btn" id="add_stop_word_btn" onclick="adStopWordEng()">Save</button>
			        </div>
			    </div>
	    	</form>
	    </div>
	</div>
	<script type="text/javascript" src="plugins/jquery/jquery/jquery-3.3.1.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<!-- Select2 -->
	<script src="plugins/select2/dist/js/select2.full.min.js"></script>
	<script src="assets/js/select2-custom-search-box-placeholder.js"></script>
	<script type="text/javascript">
		$(window).bind("load", function() {
			console.log('loaded');
			$("#loader").addClass("hidden");
			$("#english_stop_form").removeClass('unclicable');
			$("#german_stop_form").removeClass('unclicable');
		});

		$('#myTab a').click(function(e) {
		  e.preventDefault();
		  $(this).tab('show');
		});

		// // store the currently selected tab in the hash value
		// $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
		//   var id = $(e.target).attr("href").substr(1);
		//   window.location.hash = id;
		// });

		// on load of the page: switch to the currently selected tab
		var hash = window.location.hash;
		$('#myTab a[href="' + hash + '"]').tab('show');
		$('html, body').animate({
            scrollTop: $("body").offset().top
        }, 1000);

		function openModal(language){
			$("#language").val(language);
			$("#stop_word").next().html('');
			$("#stop_word").next().removeClass('text-danger');
			$("#stopwordModal").modal('show');
		}

		function stopWordUpdEng(){
			$('#eng_submit_btn').prop('disabled', true);
			$("#loader").removeClass("hidden");
			$("#english_stop_form").addClass('unclicable');
			$("#english_stop_form").submit();
		}

		function stopWordUpdDe(){
			$('#de_submit_btn').prop('disabled', true);
			$("#loader").removeClass("hidden");
			$("#german_stop_form").addClass('unclicable');
			$("#german_stop_form").submit();
		}

		function adStopWordEng(){
			var stop_word = $("#stop_word").val();
			var error_count = 0;

			if(stop_word == ""){
				$("#stop_word").next().html('Required');
				$("#stop_word").next().addClass('text-danger');
				error_count++;
			}else{
				$("#stop_word").next().html('');
				$("#stop_word").next().removeClass('text-danger');
			}

			if(error_count == 0){
				$('#add_stop_word_btn').prop('disabled', true);
				$("#loader").removeClass("hidden");
				$("#add_stop_word_form").submit();
			}else{
				return false;
			}
		}
	</script>
</body>
</html>
<?php
	include 'includes/php-foot-includes.php';
?>