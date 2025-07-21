<?php
require __DIR__ . '/vendor/autoload.php';

use Jjacobstech\Roqqu\RoqquApi;
error_reporting(3);


function test(){

      // $ROQQU_PRIVATE_KEY = 
      // 'RAKPRAV66p544g6df59a63f5cf5715a456cac1c4bab613a9032a8ea9fd6fe3e3df4356217cb6f851748263021966';

      $ROQQU_PUBLIC_KEY = 'RAKPUD0cba90c6jo06c95d884a51135eefb700ec98b8bd40df4dc702d296caa61748263021966';

     $ROQQU_URL="https://roqqu-api.redocly.app/_mock/apis/";

      $roqqu = new RoqquApi($ROQQU_PRIVATE_KEY = "agageq",$ROQQU_PUBLIC_KEY,$ROQQU_URL);
  var_dump ($roqqu->customersBlacklist(1,1));
}

test();