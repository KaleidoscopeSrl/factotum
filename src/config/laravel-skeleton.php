<?php

return [
	'repositories' => [
		'pagination' => [
			'limit' => 10
		]
	],
	'console' => [
		'makers' => [
			'services' => [
				'path' => app_path('Services'),
				'namespace' => 'Kaleidoscope\\Factotum\\Services'
			],
			'models' => [
				'path' => app_path('Models'),
				'namespace' => 'Kaleidoscope\\Factotum\\Models'
			],
			'filters' => [
				'path' => app_path('Filters'),
				'namespace' => 'Kaleidoscope\\Factotum\\Filters'
			],
			'validators' => [
				'path' => app_path('Validators'),
				'namespace' => 'Kaleidoscope\\Factotum\\Validators'
			],
			'transformers' => [
				'path' => app_path('Transformers'),
				'namespace' => 'Kaleidoscope\\Factotum\\Transformers'
			],
			'repositories' => [
				'path' => app_path('Repositories'),
				'namespace' => 'Kaleidoscope\\Factotum\\Repositories'
			],
			'controllers' => [
				'path' => app_path('Http/Controllers'),
				'namespace' => 'Kaleidoscope\\Factotum\\Http\\Controllers'
			],
		]
	]
];
