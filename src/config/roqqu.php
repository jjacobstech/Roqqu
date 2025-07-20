<?php

return [
      'api' => [
            'private_key' => env('ROQQU_PRIVATE_KEY'),
            'public_key' => env('ROQQU_PUBLIC_KEY'),
            'url' => env('ROQQU_URL', 'https://roqqu-api.redocly.app/_mock/apis'),
      ],
      'timeout' => 30
];
