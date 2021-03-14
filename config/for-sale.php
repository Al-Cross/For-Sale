<?php

return [
    'currency' => '€',

    'membership' => [
        'basic' => [
            'ad_limit' => 3
        ],
    	'advanced' => [
    		'price' => 3000,
    		'ad_limit' => 4
    	],
    	'premium' => [
    		'price' => 8000,
    		'ad_limit' => 10
    	]
    ],

    'prices' => [
        'ad_extention' => 199,
        'featured' => 1000
    ],

    'honeypot' => [
        'enabled' => env('HONEYPOT_ENABLED', true),
        'decoy_field' => 'telephone',
        'timestamp_field' => 'timestamp',
        'min_time' => 5
    ],
];
