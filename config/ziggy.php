<?php
return [
//    'only' => ['Backend.*'],
    'groups' => [
        'Backend' => ['Backend.*', 'Wovosoft.*'],
        'Api' => ['Api.*'],
    ],
//    'except' => ['_debugbar.*', 'horizon.*', 'api.*'],
];
