<?php
$methods = [
	'submitAmbassador' => [
		'params' => [
			[
				'name' => 'firstname',
				'source' => 'p',
				'pattern' => '',
				'required' => true,
				'default' => ''
			],
			[
				'name' => 'secondname',
				'source' => 'p',
				'pattern' => '',
				'required' => true,
				'default' => ''
			],
			[
				'name' => 'position',
				'source' => 'p',
				'pattern' => '',
				'required' => true,
				'default' => ''
			],
			[
				'name' => 'phone',
				'source' => 'p',
				'pattern' => '/^\+380\d{9}$/',
				'required' => false,
				'default' => 'No Phone Number'
			],
			[
				'name' => 'email',
				'source' => 'p',
				'pattern' => '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',
				'required' => false,
				'default' => 'No Email'
			],
		]
	]
];
