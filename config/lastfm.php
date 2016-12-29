<?php

return [
    'pagination' => [
        'limit' => getenv('LASTFM_PAGINATION_LIMIT'),
    ],
    'api_key' => getenv('LASTFM_KEY'),
    'api_secret' => getenv('LASTFM_SECRET'),
];