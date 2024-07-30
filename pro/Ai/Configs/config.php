<?php
return [
    'default'    => env("AI_PROVIDER", 'main'),
    'providers'  => [
        'main' => [
            'driver'      => '',
            'api_key'     => env('AI_MAIN_API_KEY'),
            'model'       => env('AI_MAIN_MODEL'),
            'temperature' => 0,
            "max_tokens"  => 2048
        ]
    ],
    "data_types" => [
        "title"   => [
            'temperature' => 1,
            "max_tokens"  => 30
        ],
        "content" => [
            'temperature' => 1,
            "max_tokens"  => 150
        ],
    ]
];
