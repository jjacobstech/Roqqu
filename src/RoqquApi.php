<?php 
namespace Jjacobstech\Roqqu;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class RoqquApi
{
      private $client;

      public function __construct()
      {

            /*
        *  Copy this to your env file
        * ROQQU_PRIVATE_KEY=RASPRIV09df395f942922f76149a63f5cf5715a456cac1c4bab613a9032a8ea9fd6fe3e3df4356217cb6f851748263021966
        * ROQQU_PUBLIC_KEY=RASPUB0cba90cee97436c95d884a51135eefb700ec98b8bd40df4dc702d296caa61748263021966
        * ROQQU_URL=https://roqqu-api.redocly.app/_mock/apis/
        *
        * MAKE SURE Url in .env file does not have a trailing slash like the above url
        */

            $private_key = config('roqqu.api.private_key');
            $url = config('roqqu.api.url');
            $timeout = config('roqqu.timeout');
            $this->public_key = config('roqqu.api.public_key');
            $this->client =  new Client([
                  'base_uri' => $url,
                  'timeout' => $timeout,
                  'headers' => [
                        'Authorization' => "Bearer $private_key",
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/x-www-form-urlencoded',
                  ]
            ]);
      }

      public function getBalance(Request $request)
      {

            $request->validate([
                  'email' => 'required|email',
                  'token'   => 'required|string',
            ]);

            try {

                  $body = [
                        'email' =>  $request->get('email'),
                        'token' =>  $request->get('token')
                  ];

                  $response = $this->client->post('wallets/get-wallet', [
                        'form_params' => $body
                  ]);


                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
            }
      }

      public function getWallet(Request $request)
      {

            $request->validate([
                  'token'   => 'required|string',
            ]);
            try {
                  $token = $request->get('token');

                  $response = $this->client->post('wallets/get-wallet', [
                        'form_params' => [
                              'token' => $token,
                        ]

                  ]);


                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
            }
      }

      public function getAddresses(Request $request)
      {

            $request->validate([
                  'network'   => 'required|string',
            ]);
            try {
                  $network = $request->get('network');

                  $response = $this->client->post('wallets/get-addresses', [
                        'form_params' => [
                              'network' => $network
                        ]

                  ]);


                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
            }
      }

      public function generateWallet(Request $request)
      {

            $request->validate([
                  'network'   => 'required|string',
                  'email'     => 'required|email',
                  'firstname' => 'required|string',
                  'lastname'  => 'required|string',
            ]);
            try {

                  $params = [
                        'network' => $request->get('network'),
                        'customer' => [
                              'email' => $request->get('email'),
                              'first_name' => $request->get('firstname'),
                              'last_name' => $request->get('lastname')
                        ]
                  ];

                  $response = $this->client->post('wallets/generate-wallet', options: [
                        'Content-Type'  => 'application/json',
                        'json' => $params
                  ]);


                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
            }
      }

      public function sendCoin(Request $request)
      {

            $request->validate([
                  'amount'   => 'required|string',
                  'network'   => 'required|string',
                  'to'   => 'required|string',
                  'token'   => 'required|string',
            ]);

            try {
                  $params = ['network' => $request->get('network')];

                  $response = $this->client->post('wallets/send', [
                        'form_params' => $params
                  ]);


                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
            }
      }

      public function deleteWallet(Request $request)
      {
            try {


                  $response = $this->client->delete('wallets/delete');


                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
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


                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
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

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
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

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
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

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
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

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                              'status' => $request->get('status')
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
            }
      }

      public function customers()
      {
            try {

                  $response = $this->client->get('customers');

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
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

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
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

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
            }
      }

      public function getIp()
      {
            try {

                  $response = $this->client->get('ip');

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
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

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
            }
      }

      public function webhooks()
      {
            try {

                  $response = $this->client->get('webhooks');

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
            }
      }

      public function analyticsVolume(Request $request)
      {
            $query = $request->get('interval') ?? 'daily';
            try {

                  $response = $this->client->get("analytics/volume?interval=$query");

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
            }
      }

      public function analyticsWalletGeneration()
      {
            try {

                  $response = $this->client->get("analytics/wallet-generation");

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
            }
      }

      public function analyticsStats()
      {
            try {

                  $response = $this->client->get("analytics/stats");

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
            }
      }

      public function analyticsWalletStats()
      {
            try {

                  $response = $this->client->get("analytics/wallet-stats");

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
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

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                              'purchased' => true
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
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

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                              'sold' => true
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
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

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
            }
      }

      public function  tradeTokens()
      {
            try {

                  $response = $this->client->get('tokens');

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
            }
      }

      public function transactionTokenDeposit()
      {
            try {

                  $response = $this->client->get('transaction/token-deposit');

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
            }
      }

      public function transactionTokenWithdrawal()
      {
            try {

                  $response = $this->client->get('transaction/token-withdrawal');

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
            }
      }

      public function transactionDeposit(String $slug)
      {

            try {

                  $response = $this->client->get("transaction/deposit/$slug");

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
            }
      }

      public function transactionStatus(string $slug)
      {

            try {

                  $response = $this->client->get("transaction/status/$slug");

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
            }
      }

      public function transactionRefid(string $slug)
      {
            try {

                  $response = $this->client->get("transaction/refid/$slug");

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
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


                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
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


                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
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


                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
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

                  return response()->json(
                        [
                              'success' => true,
                              'data' => json_decode($response->getBody(), true),
                        ]
                  );
            } catch (\Throwable $th) {
                  return response()->json([
                        'success' => false,
                        'error' => $th->getMessage(),
                  ], 500);
            }
      }
}
