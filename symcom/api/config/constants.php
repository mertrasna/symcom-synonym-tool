<?php
	$configArray = array();
	$configArray2 = array();
	if (app()->environment('development')) {
		$configArray2 ['api_base_path'] = 'http://localhost/symcom-synonym-tool/symcom/api/public/';  
	} 
	$configArray = [
		// 'api_base_path' => 'http://dev.reference-repertory.com/symcom/api/public/',
	    'return_array' => [
	    	'status' => 1,
			'content' => '',
			'message' => 'Blank initialization state'
	    ],
	    'data_per_page' => 20,
	    'is_paginate' => 1,
	    'date_format' => 'd/m/Y',
	    'date_time_format' => 'd/m/Y h:i A',
	    'user_type' => [
	    	1 => 'Admin',
	    	2 => 'Bearbeiter',
	    	3 => 'Gast',
	    ],
	    'system_admin' => [
	    	1 => [
		    	'username' => 'admin',
				'slug' => 'admin',
				'user_type' => 1,
				'salutation' => null,
				'first_name' => 'Symcom',
				'last_name' => 'Admin',
				'full_name' => 'Symcom Admin',
				'phone' => null,
				'active' => 1,
				'company' => 'Symcom',
			],
			3 => [
		    	'username' => 'backupadmin',
				'slug' => 'backupadmin',
				'user_type' => 1,
				'salutation' => null,
				'first_name' => 'Symcom',
				'last_name' => 'Backup Admin',
				'full_name' => 'Symcom Backup Admin',
				'phone' => null,
				'active' => 1,
				'company' => 'Symcom',
			]
	    ],
	    'land' => [
	    	1 => 'Deutschland',
	    	2 => 'Schweiz',
	    	3 => 'Österreich',
	    	4 => 'Niederlande',
	    ],
	    'quelle_schemas' => [
	    	1 => 'Andere',
	    	2 => 'Monographien',
	    	3 => 'Sammelwerke mit Kopf-zu-Fußschema',
	    	3 => 'Sammelwerke mit Kopf-zu-Fußschema',
	    	4 => 'Sammelwerke ohne Kopf-zu-Fußschema',
	    ],
	    'titles' => [
	    	'Prof.' => 'Prof.',
	    	'Dr.' => 'Dr.',
	    	'Mr.' => 'Mr.',
	    	'Prof. Dr.' => 'Prof. Dr.',
	    	'Dr. Dr.' => 'Dr. Dr.',
	    ]
	];

	return array_merge($configArray, $configArray2);
?>