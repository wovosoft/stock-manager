<?php
return [
    'mode' => 'utf-8',
    'format' => 'A4',
    'author' => 'Wovosoft',
    'subject' => 'Application Form',
    'keywords' => '',
    'creator' => 'WovoSoft',
    'display_mode' => 'fullpage',
    'tempDir' => base_path('../temp/'),
    'font_path' => storage_path('/fonts/'),
    'font_data' => [
        'bangla' => [
            'R' => 'SolaimanLipi.ttf',    // regular font
            'B' => 'SolaimanLipi.ttf',       // optional: bold font
            'I' => 'SolaimanLipi.ttf',     // optional: italic font
            'BI' => 'SolaimanLipi.ttf', // optional: bold-italic font
            'useOTL' => 0xFF,
            'useKashida' => 75,
        ]
        // ...add as many as you want.
    ]
];
