<?php

namespace Jjacobstech\Roqqu;

use GuzzleHttp\Client;

class RoqquApi
{
      private $client;

      private $public_key;

      public function __construct(string $private_key, string $public_key, string $url, $timeout = 30)
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

      public function getBalance(string $email, string $token)
      {

            try {

                  $params = [
                        'email' => $email,
                        'token' => $token
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

      public function getWallet(string $token)
      {


            try {

                  $params = ['token' => $token];

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

      public function getAddresses(string $network)
      {

            try {
                  $params = ['network' => $network];

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

      public function generateWallet(string $network, string $email, string $firstname, string $lastname)
      {
            try {

                  $params = [
                        'network' => $network,
                        'customer' => [
                              'email' => $email,
                              'first_name' => $firstname,
                              'last_name' => $lastname
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

      public function sendCoin(string $amount, string $network, string $to, string $token)
      {
            try {
                  $params = [
                        'amount'   => $amount,
                        'network'   => $network,
                        'to'   => $to,
                        'token'   => $token
                  ];

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

      public function deleteWallet()
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

      public function whatNetwork(string $address)
      {

            try {
                  $params = ['address' => $address];

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

      public function getNetwork(string $network)
      {

            try {
                  $params = ['network' => $network];

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

      public function generateMerchantWallet(string $network)
      {

            try {
                  $params = ['network' => $network];

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
      public function history(string $token, string $email, string $network, string $direction, string $timestamp, string $status)
      {

            try {
                  $params = [
                        'token'     => $token,
                        'email'     => $email,
                        'network'   => $network,
                        'direction' => $direction,
                        'timestamp' => $timestamp,
                        'status' => $status
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

      public function customersBlacklist(string $email, string $reason)
      {

            try {
                  $params = [
                        'reason'  => $reason,
                        'email'     => $email
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

      public function customersWhitelist(string $email, string $reason)
      {

            try {
                  $params = [
                        'reason'     => $reason,
                        'email'     => $email
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

      public function setIp(string $ip_name, string $ip_address)
      {

            try {

                  $params = [
                        'ip_name' => $ip_name,
                        'ip_address' => $ip_address
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

      public function analyticsVolume(string $interval = 'daily')
      {
            try {

                  $response = $this->client->get("analytics/volume?interval=$interval");

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

      public function  tradeBuy(float $amount, string $token)
      {
            try {

                  $params = [
                        'amount' => $amount,
                        'token' => $token
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

      public function  tradeSell(float $amount, string $token)
      {


            try {

                  $params = [
                        'amount' => $amount,
                        'token' => $token
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

      public function  tradeSwap(float $amount, string $from, string $to)
      {


            try {

                  $params = [
                        'amount' => $amount,
                        'from' => $from,
                        'to' => $to
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

      public function searchBlockchainTxhash(string $network, string $tx_hash)
      {

            try {

                  $params =  [
                        'network' => $network,
                        'tx_hash' => $tx_hash
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

      public function requeryBep20(string $tx_hash)
      {

            try {

                  $params =  [
                        'tx_hash' => $tx_hash
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

      public function refund(string $refid)
      {

            try {

                  $params = [
                        'refid' => $refid
                  ];
                  $response = $this->client->post('transaction/refund', $params);


                  $data = json_decode($response->getBody(), true);

                  return $data;
            } catch (\Throwable $th) {

                  return [
                        'success' => false,
                        'error' => $th->getMessage()
                  ];
            }
      }

      public function networkFee(string $network)
      {

            try {

                  $params = [
                        'network' => $network
                  ];

                  $response = $this->client->post('transaction/network-fee', $params);

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
