# Roqqu

This is Roqqu's SDK for Laravel application

After installation, copy this to your .env file

Copy this to your env file
```env
ROQQU_PRIVATE_KEY=RAKPRAV66p544g6df59a63f5cf5715a456cac1c4bab613a9032a8ea9fd6fe3e3df4356217cb6f851748263021966
ROQQU_PUBLIC_KEY=RAKPUD0cba90c6jo06c95d884a51135eefb700ec98b8bd40df4dc702d296caa61748263021966
ROQQU_URL=`https://roqqu-api.redocly.app/_mock/apis/`
```
Then run:
``` shell
PHP artisan vendor:publish --tag=roqqu-config

```
to publish the config file to laravel config foldere

```php
<?php

return [
      'api' => [
            'private_key' => env('ROQQU_PRIVATE_KEY'),
            'public_key' => env('ROQQU_PUBLIC_KEY'),
            'url' => env('ROQQU_URL', 'https://roqqu-api.redocly.app/_mock/apis'),
      ],
      'timeout' => 30
];

```

Then you can use it like this:

```php
<?php
function myRoqqu(){
      
$private_key = config('roqqu.api.private_key');
$public_key = config('roqqu.api.public_key');
$url = config('roqqu.api.url');
$timeout = config('roqqu.timeout');

$roqqu = new RoqquApi($private_key, $public_key, $url, $timeout);

$response = $roqqu->customersBlacklist("jacobsjoshua81@gmail.com",  'reason');

return $response;
}
```

## Author

* [Jacobs Joshua](https://github.com/jjacobstech)
* [jacobsjoshua81@gmail.com](mailto:jacobsjoshua81@gmail.com)
