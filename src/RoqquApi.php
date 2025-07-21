<?php

namespace Jjacobstech\Roqqu;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoqquApi
{
      private $client;

      private $public_key;

      public function __construct($private_key, $public_key, $url, $timeout = 30)
      {

            /*
        *  Copy this to your env file
        * ROQQU_PRIVATE_KEY=RAKPRAV66p544g6df59a63f5cf5715a456cac1c4bab613a9032a8ea9fd6fe3e3df4356217cb6f851748263021966
        * ROQQU_PUBLIC_KEY=RAKPUD0cba90c6jo06c95d884a51135eefb700ec98b8bd40df4dc702d296caa61748263021966
        * ROQQU_URL=https://roqqu-api.redocly.app/_mock/apis/
        *
        * MAKE SURE Url in .env file does not have a trailing slash like the above url
        */

            $this->public_key = $public_key;
            $this->client = new Client([
                  'base_uri' => $url,
                  'timeout' => $timeout,
                  'headers' => [
                        'Authorization' => "Bearer $private_key",
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/x-www-form-urlencoded',
                  ]
            ]);
      }

      public function getBalance($email,$token)
      {

            try {
                  $validator = (object)  Validator::validate([
                        'email' => $email,
                        'token' => $token
                  ], [
                        'email'   => 'required|email',
                        'token'   => 'required|string',
                  ]);

                  $params = [
                        'email' => $validator->email,
                        'token' => $validator->token
                  ];           

                  $response = $this->client->post('wallets/get-wallet', [
                        'form_params' => $params
                  ]);

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function getWallet($token)
      {

         $validator = (object)  Validator::validate($token, [
                  'token'   => 'required|string',
            ]);
            try {

                  $params = ['token' => $validator->token];

                  $response = $this->client->post('wallets/get-wallet', [
                        'form_params' => $params
                  ]);


                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function getAddresses($network)
      {

            $validator = (object)  Validator::validate(
                  ['network' => $network], 
                  ['network'   => 'required|string']);
     
            try {
                 $params = ['network' => $validator->network];

                  $response = $this->client->post('wallets/get-addresses', [
                        'form_params' => $params

                  ]);


                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function generateWallet($network, $email, $firstname, $lastname)
      {

            $validator = (object) Validator::validate(
                  [
                        'network'   => $network,
                        'email'     => $email,
                        'firstname' => $firstname,
                        'lastname'  => $lastname
                  ],
            [
                  'network'   => 'required|string',
                  'email'     => 'required|email',
                  'firstname' => 'required|string',
                  'lastname'  => 'required|string',
            ]);
            try {

                  $params = [
                        'network' => $validator->network,
                        'customer' => [
                              'email' => $validator->email,
                              'first_name' => $validator->firstname,
                              'last_name' => $validator->lastname
                        ]
                  ];

                  $response = $this->client->post('wallets/generate-wallet', options: [
                        'Content-Type'  => 'application/json',
                        'json' => $params
                  ]);


                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function sendCoin($amount, $network, $to, $token)
      {
            $validator = (object) Validator::validate(
                  [
                        'amount'   => $amount,
                        'network'   => $network,
                        'to'   => $to,
                        'token'   => $token
                  ],
            [
                  'amount'   => 'required|string',
                  'network'   => 'required|string',
                  'to'   => 'required|string',
                  'token'   => 'required|string',
            ]);

            try {
                  $params = 

                  $response = $this->client->post('wallets/send', [
                        'form_params' => $params
                  ]);


                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function deleteWallet(Request $request)
      {
            try {


                  $response = $this->client->delete('wallets/delete');


                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function whatNetwork(Request $request)
      {

            $request->validate([
                  'address'   => 'required|string',
            ]);

            try {
                  $params = ['address' => $request->get('address')];

                  $response = $this->client->post('wallets/what-network', [
                        'form_params' => $params
                  ]);


                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      // Fix Later - Issue is from roqqu
      public function getNetworks()
      {

            try {

                  $response = $this->client->post('wallets/get-all-networks', [
                        // 'headers' => [
                        //     'Content-Type' => 'application/x-www-form-urlencoded',
                        // ],
                        // 'form_params' => []
                  ]);

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function getNetwork(Request $request)
      {
            $request->validate([
                  'network'   => 'required|string',
            ]);

            try {
                  $params = ['network' => $request->get('network')];

                  $response = $this->client->post('wallets/get-network', [
                        'form_params' => $params
                  ]);

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function generateMerchantWallet(Request $request)
      {
            $request->validate([
                  'network'   => 'required|string',
            ]);

            try {
                  $params = ['network' => $request->get('network')];

                  $response = $this->client->post('wallets/generate-merchant-wallet', [
                        'json' => $params
                  ]);

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }
      public function history(Request $request)
      {
            $request->validate([

                  'token'   => 'required|string',
                  'email'     => 'required|email',
                  'network'   => 'required|string',
                  'direction'   => 'required|string',
                  'timestamp'   => 'required|date',
                  'status'   => 'required|integer|in:0,1',
            ]);

            try {
                  $params = [
                        'token'     => $request->get('token'),
                        'email'     => $request->get('email'),
                        'network'   => $request->get('network'),
                        'direction' => $request->get('direction'),
                        'timestamp' => $request->get('timestamp'),
                        'status' => $request->get('status')
                  ];

                  $response = $this->client->post('history', $params);

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function customers()
      {
            try {

                  $response = $this->client->get('customers');

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function customersBlacklist(Request $request)
      {

            $request->validate([
                  'email'   => 'required|email',
                  'reason'   => 'required|string',
            ]);

            try {
                  $params = [
                        'email' => $request->get('email'),
                        'reason' => $request->get('reason')
                  ];

                  $response = $this->client->post('customers/blacklist', [
                        'form_params' => $params
                  ]);

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function customersWhitelist(Request $request)
      {

            $request->validate([
                  'email'   => 'required|email',
                  'reason'   => 'required|string',

            ]);

            try {

                  $params = [
                        'email' => $request->get('email'),
                        'reason' => $request->get('reason')
                  ];

                  $response = $this->client->post('customers/whitelist', [
                        'form_params' => $params
                  ]);

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function getIp()
      {
            try {

                  $response = $this->client->get('ip');

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function setIp(Request $request)
      {

            $request->validate([
                  'ip_name'   => 'required|string',
                  'ip_address'   => 'required|string',
            ]);

            try {

                  $params = [
                        'ip_name' => $request->get('ip_name'),
                        'ip_address' => $request->get('ip_address')
                  ];

                  $response = $this->client->post('ip', [
                        'form_params' => $params
                  ]);

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function webhooks()
      {
            try {

                  $response = $this->client->get('webhooks');

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function analyticsVolume(Request $request)
      {
            $query = $request->get('interval') ?? 'daily';
            try {

                  $response = $this->client->get("analytics/volume?interval=$query");

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function analyticsWalletGeneration()
      {
            try {

                  $response = $this->client->get("analytics/wallet-generation");

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function analyticsStats()
      {
            try {

                  $response = $this->client->get("analytics/stats");

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function analyticsWalletStats()
      {
            try {

                  $response = $this->client->get("analytics/wallet-stats");

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function  tradeBuy(Request $request)
      {

            $request->validate([
                  'amount'   => 'required|numeric',
                  'token'   => 'required|string',
            ]);

            try {

                  $params = [
                        'amount' => $request->get('amount'),
                        'token' => $request->get('token')
                  ];

                  $response = $this->client->post('trade/buy', $params);

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function  tradeSell(Request $request)
      {

            $request->validate([
                  'amount'   => 'required|numeric',
                  'token'   => 'required|string',
            ]);

            try {

                  $params = [
                        'amount' => $request->get('amount'),
                        'token' => $request->get('token')
                  ];

                  $response = $this->client->post('trade/sell', $params);

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function  tradeSwap(Request $request)
      {

            $request->validate([
                  'amount'   => 'required|numeric',
                  'from'   => 'required|string',
                  'to'   => 'required|string'
            ]);

            try {

                  $params = [
                        'amount' => $request->get('amount'),
                        'from' => $request->get('from'),
                        'to' => $request->get('to')
                  ];

                  $response = $this->client->post('trade/swap', $params);

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function  tradeTokens()
      {
            try {

                  $response = $this->client->get('tokens');

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function transactionTokenDeposit()
      {
            try {

                  $response = $this->client->get('transaction/token-deposit');

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function transactionTokenWithdrawal()
      {
            try {

                  $response = $this->client->get('transaction/token-withdrawal');

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function transactionDeposit(String $slug)
      {

            try {

                  $response = $this->client->get("transaction/deposit/$slug");

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function transactionStatus(string $slug)
      {

            try {

                  $response = $this->client->get("transaction/status/$slug");

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function transactionRefid(string $slug)
      {
            try {

                  $response = $this->client->get("transaction/refid/$slug");

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function searchBlockchainTxhash(Request $request)
      {
            $request->validate([
                  'network'   => 'required|string',
                  'tx_hash'   => 'required|string'
            ]);
            try {

                  $params =  [
                        'network' => $request->get('network'),
                        'tx_hash' => $request->get('tx_hash')
                  ];
                  $response = $this->client->post('transaction/search-blockchain-txhash', [
                        'form_params' => $params

                  ]);


                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function requeryBep20(Request $request)
      {
            $request->validate([
                  'tx_hash'   => 'required|string'
            ]);
            try {

                  $params =  [
                        'tx_hash' => $request->get('tx_hash')
                  ];
                  $response = $this->client->post('transaction/requery/bep20', [
                        'form_params' => $params

                  ]);


                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function refund(Request $request)
      {
            $request->validate([
                  'refid'   => 'required|string'
            ]);
            try {


                  $refid = $request->get('refid');

                  $response = $this->client->post('transaction/refund', [
                        'refid' => $refid
                  ]);


                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function networkFee(Request $request)
      {
            $request->validate([
                  'network'   => 'required|string'
            ]);
            try {


                  $network = $request->get('network');

                  $response = $this->client->post('transaction/network-fee', [
                        'network' => $network
                  ]);

                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }
}
