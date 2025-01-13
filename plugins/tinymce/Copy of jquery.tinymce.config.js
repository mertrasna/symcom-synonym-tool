$(function() {
	var tinymce_path = '/vendor/tinymce/';
	var tinymce_images_upload_url = '/postAcceptor.php';

	var tinymce_options = {

		// Location of TinyMCE script
		script_url : tinymce_path + "tinymce.min.js",

		height : '300px',
		// width : '600px',

		language : 'de',

		// General options
		theme : "modern",

		// plugins : "responsivefilemanager,table,image,imagetools,charmap,link,code,textcolor,searchreplace,paste,visualchars",
		plugins : "autoresize,table,image,imagetools,charmap,link,code,textcolor,paste,visualchars",

		image_advtab : true,

		external_filemanager_path : "/trippo/filemanager/",
		filemanager_title : "Dateiverwaltung",
		filemanager_access_key : "x8n38n1l9dm2mMds",

		external_plugins : {
			"filemanager" : "/assets/filemanager/plugin.min.js"
		},


		file_browser_callback : function(field_name, url, type, win) {
			if (type == 'image')
				$('#UploadForm input').click();
		},

		entity_encoding : "raw",
		style_formats : [ {
			title : 'Sperrschrift',
			inline : 'span',
			classes : 'text-sperrschrift'
		}],

		extended_valid_elements : "ss",
    custom_elements: "ss",
		
		// Example content CSS (should be your site CSS)
		content_css : "/assets/css/text.css",

		image_list : tinymce_path + "lists/image_list.php",
		media_url : tinymce_path + "lists/media_list.php",
		images_upload_url : tinymce_images_upload_url,
		automatic_uploads : true,

	/*
	 * images_upload_handler : function(blobInfo, success, failure) { var xhr,
	 * formData;
	 * 
	 * xhr = new XMLHttpRequest(); xhr.withCredentials = false; xhr.open('POST',
	 * tinymce_images_upload_url);
	 * 
	 * xhr.onload = function() { var json;
	 * 
	 * if (xhr.status != 200) { failure('HTTP Error: ' + xhr.status); return; }
	 * 
	 * json = JSON.parse(xhr.responseText);
	 * 
	 * if (!json || typeof json.location != 'string') { failure('Invalid JSON: ' +
	 * xhr.responseText); return; }
	 * 
	 * success(json.location); };
	 * 
	 * formData = new FormData(); formData.append('file', blobInfo.blob(),
	 * blobInfo.filename());
	 * 
	 * xhr.send(formData); }
	 */
	};

	$('textarea.texteditor').tinymce(tinymce_options);

	/*
	 * var minimal_tinymce_options = $.extend({}, tinymce_options);
	 * minimal_tinymce_options.theme = "simple";
	 * 
	 * $('textarea.mini-texteditor').tinymce(minimal_tinymce_options);
	 */

});