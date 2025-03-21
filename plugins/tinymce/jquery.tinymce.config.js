$(function() {
	var tinymce_path = '/plugins/tinymce/';
	var tinymce_images_upload_url = '/postAcceptor.php';
	
	var tinymce_options = {

		height : '154px',

		language : 'de',

		entity_encoding : "raw",

		style_formats : [
			{
				title : 'Sperrschrift',
				inline : 'span', 
				classes : 'text-sperrschrift'
			},
			{
	      		title: 'GROSS',
	      		inline: 'bdi', // tag defination: "<bdi>" Isolates a part of text that might be formatted in a different direction from other text outside it
				classes : 'text-gross'
	    	}
		],

		statusbar: false,
		menubar: false,

		plugins : [ "responsivefilemanager,table,image,imagetools,charmap,link,code,textcolor,searchreplace,paste,visualchars" ],

		toolbar : "undo redo | styleselect | bold italic AddSpace ",
		
		paste_word_valid_elements: "b,strong,i,em,h1,h2,u,p,ol,ul,li,a[href],span,color,font-size,font-color,font-family,mark,table,tr,td",
    	
    	paste_retain_style_properties: "letter-spacing font-weight",

		content_css : [ absoluteUrl+"plugins/tinymce/css/text.css" ],

		formats: {
	       custom_format: {inline: 'span', attributes: {class: 'text-sperrschrift'}}
	    },

		setup: function(editor) {
	        editor.addButton('AddSpace', {
	            icon: 'space fa fa-fw fa-arrows-h',
	            tooltip: "Add Space",
	            onPostRender: function() {
				    var _this = this;   // reference to the button itself
				    editor.on('NodeChange', function(e) {
				        _this.active($( editor.selection.getNode() ).hasClass('text-sperrschrift'));
				    })
				},
	            onclick: function() {
	                tinymce.activeEditor.formatter.toggle('custom_format')
	            }

	        });
		}
	};

	$('textarea.texteditor').tinymce(tinymce_options);


	// Added Config for large and samll editor
	var tinymce_options_large = {
		
		// Location of TinyMCE script
		script_url : tinymce_path + "tinymce.min.js",

		relative_urls : false,

		//document_base_url : "/mukesh/add-space/",

		height : '300px',
		// width : '600px',

		language : 'en',

		// theme : "modern",

		external_filemanager_path : "/plugins/trippo/filemanager/",
		filemanager_title : "Dateiverwaltung",
		filemanager_access_key : "x8n38n1l9dm2mMds",

		entity_encoding : "raw",
		style_formats : [
			{
				title : 'Sperrschrift',
				inline : 'span', 
				classes : 'text-sperrschrift'
			},
			{
	      		title: 'GROSS',
	      		inline: 'bdi', // tag defination: "<bdi>" Isolates a part of text that might be formatted in a different direction from other text outside it
				classes : 'text-gross'
	    	}
		],

		extended_valid_elements : "ss",
		custom_elements : "ss",

		image_advtab : true,
		menubar: false,
		plugins : [ "responsivefilemanager,table,image,imagetools,charmap,link,code,textcolor,searchreplace,paste,visualchars" ],
		toolbar : "undo redo | styleselect | bold italic | AddSpace",
		paste_word_valid_elements: "b,strong,i,em,h1,h2,u,p,ol,ul,li,a[href],span,color,font-size,font-color,font-family,mark,table,tr,td",
    	paste_retain_style_properties: "letter-spacing",
		content_css : [ "plugins/tinymce/css/text.css" ],

		formats: {
	       // Other formats...
	       custom_format: {inline: 'span', attributes: {class: 'text-sperrschrift'}}
	    },
		setup: function(editor) {
	        editor.addButton('AddSpace', {
	            //icon: 'space fa fa-fw fa-arrows-h',
	            image: 'plugins/tinymce/icons/icons8-add-white-space-30.png',
	            tooltip: "Add Space",
	            onPostRender: function() {
				    var _this = this;   // reference to the button itself
				    editor.on('NodeChange', function(e) {
				        _this.active($( editor.selection.getNode() ).hasClass('text-sperrschrift'));
				    })
				},
	            onclick: function() {
	                tinymce.activeEditor.formatter.toggle('custom_format')
	            }
	        });
		}
	};

	var tinymce_options_small = {
		
		// Location of TinyMCE script
		script_url : tinymce_path + "tinymce.min.js",

		relative_urls : false,

		//document_base_url : "/mukesh/add-space/",

		height : '100px',
		// width : '600px',

		language : 'en',

		// theme : "modern",

		external_filemanager_path : "/plugins/trippo/filemanager/",
		filemanager_title : "Dateiverwaltung",
		filemanager_access_key : "x8n38n1l9dm2mMds",

		entity_encoding : "raw",
		style_formats : [
			{
				title : 'Sperrschrift',
				inline : 'span', 
				classes : 'text-sperrschrift'
			},
			{
	      		title: 'GROSS',
	      		inline: 'bdi', // tag defination: "<bdi>" Isolates a part of text that might be formatted in a different direction from other text outside it
				classes : 'text-gross'
	    	}
		],

		extended_valid_elements : "ss",
		custom_elements : "ss",

		image_advtab : true,
		menubar: false,

		plugins : [ "responsivefilemanager,table,image,imagetools,charmap,link,code,textcolor,searchreplace,paste,visualchars" ],
		toolbar : "undo redo | styleselect | bold italic | AddSpace",
		paste_word_valid_elements: "b,strong,i,em,h1,h2,u,p,ol,ul,li,a[href],span,color,font-size,font-color,font-family,mark,table,tr,td",
    	paste_retain_style_properties: "letter-spacing",
		content_css : [ "plugins/tinymce/css/text.css" ],

		formats: {
	       // Other formats...
	       custom_format: {inline: 'span', attributes: {class: 'text-sperrschrift'}}
	    },
		setup: function(editor) {
	        editor.addButton('AddSpace', {
	            //icon: 'space fa fa-fw fa-arrows-h',
	            image: 'plugins/tinymce/icons/icons8-add-white-space-30.png',
	            tooltip: "Add Space",
	            onPostRender: function() {
				    var _this = this;   // reference to the button itself
				    editor.on('NodeChange', function(e) {
				        _this.active($( editor.selection.getNode() ).hasClass('text-sperrschrift'));
				    })
				},
	            onclick: function() {
	                tinymce.activeEditor.formatter.toggle('custom_format')
	            }
	        });
		}
	};

	$('textarea.texteditor-large').tinymce(tinymce_options_large);
	$('textarea.texteditor-small').tinymce(tinymce_options_small);
});