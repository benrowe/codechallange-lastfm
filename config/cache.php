<?php

return [
    'driver' => getenv('CACHE_DRIVER'),
    'drivers' => [
        'file' => [
            'driver' => 'file',
            'path' => App\path(getenv('CACHE_FILE_PATH')),
        ],
    ]
];