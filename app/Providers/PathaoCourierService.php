<?php

namespace App\Providers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\General; // Assuming your model is General

class PathaoCourierService
{
    protected $baseUrl;
    protected $clientId;
    protected $clientSecret;
    protected $username;
    protected $password;
    protected $grantType;

    public function __construct()
    {
        
         $general = General::first();
        
        // $this->baseUrl = 'https://courier-api-sandbox.pathao.com';
        $this->baseUrl = 'https://api-hermes.pathao.com';
        $this->clientId = $general->patho_client_id;
        $this->clientSecret = $general->patho_client_secret;
        $this->username = $general->patho_username;
        $this->password = $general->patho_password;
        $this->grantType = 'password';
    }
    
    public function authenticate2($action){
        $client = new Client();
        
        if($action=='Carrybee'){
            $url ='https://developers.carrybee.com/api/login';
            $response = $client->post($url, [
                'form_params' => [
                    'grant_type' => $this->grantType,
                    'email' => general()->carrybee_username,
                    'password' => general()->carrybee_password,
                ]
            ]);
            
            $data = json_decode($response->getBody()->getContents(), true);
            if (isset($data['data']['token'])) {
                return $data['data']['token'];
            } else {
                throw new \Exception('Access token or refresh token not received.');
            }
            
        }else{
            try {
                $general = General::first();
                if ($general->patho_token_at && Carbon::parse($general->patho_token_at)->diffInDays(Carbon::now()) < 4) {
                    return $general->patho_access_token;
                } else {
                    $url = $this->baseUrl . '/aladdin/api/v1/issue-token';
                    $response = $client->post($url, [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Accept' => 'application/json',
                        ],
                        'json' => [
                            'grant_type'    => $this->grantType,
                            'client_id'     => $this->clientId,
                            'client_secret' => $this->clientSecret,
                            'username'      => $this->username,
                            'password'      => $this->password,
                        ],
                    ]);
            
                    $data = json_decode($response->getBody()->getContents(), true);
            
                    if (isset($data['access_token']) && isset($data['refresh_token'])) {
                        $general = General::first();
                        $general->patho_access_token = $data['access_token'];
                        $general->patho_refresh_token = $data['refresh_token'];
                        $general->patho_token_at = Carbon::now();
                        $general->save();
            
                        return $data['access_token'];
                    } else {
                        throw new \Exception('Access token or refresh token not received.');
                    }
                }
            } catch (RequestException $e) {
                if ($e->hasResponse()) {
                    $errorResponse = $e->getResponse()->getBody()->getContents();
                    return 'Request Error: ' . $errorResponse;
                }
                return 'Request Exception: ' . $e->getMessage();
            } catch (\Exception $e) {
                return 'General Error: ' . $e->getMessage();
            }
        }
        
        return $action;
    }

    public function authenticate()
    {
        
        

        $client = new Client();
        
        try {
            // Sending request to get the token
            $response = $client->post("{$this->baseUrl}/aladdin/api/v1/issue-token", [
                'form_params' => [
                    'grant_type' => $this->grantType,
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'username' => $this->username,
                    'password' => $this->password,
                ]
            ]);

            // Get the response data
            $data = json_decode($response->getBody()->getContents(), true);

            // Check if the token was received
            if (isset($data['access_token']) && isset($data['refresh_token'])) {
                // Save refresh token securely
                $general = General::first(); // Retrieve the general model or create it if needed
                $general->patho_access_token = $data['access_token'];
                $general->patho_refresh_token = $data['refresh_token'];
                $general->save();

                return $data['access_token'];
            } else {
                throw new \Exception('Access token or refresh token not received.');
            }

        } catch (RequestException $e) {
            // Handle error properly
            return 'Error: ' . $e->getMessage();
        }
    }

    // You may want to implement a method to refresh the token when needed
    public function refreshAccessToken($refreshToken)
    {
        $client = new Client();

        try {
            $response = $client->post("{$this->baseUrl}/aladdin/api/v1/refresh-token", [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'refresh_token' => $refreshToken,
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            // Save the new tokens
            if (isset($data['access_token']) && isset($data['refresh_token'])) {
                $general = General::first();
                $general->patho_access_token = $data['access_token'];
                $general->patho_refresh_token = $data['refresh_token'];
                $general->save();

                return $data['access_token'];
            } else {
                throw new \Exception('Failed to refresh access token.');
            }

        } catch (RequestException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
    
    public function userDeliveryStatus($number){
        
        $client = new Client();
        
        $accessToken = $this->authenticate2('Pathao');
        
        $orderData = [
                'phone' => $number,
            ];
        
        $response = $client->post("{$this->baseUrl}/aladdin/api/v1/user/success", [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer {$accessToken}",
                ],
                'json' => $orderData,
            ]);
    
            $data = json_decode($response->getBody()->getContents(), true);
        
        return $data;
    }
    
    public function placeNewOrder($order)
    {
        $client = new Client();
        
        try {
            
            
            
            if($order->courier=='Carrybee'){
                
                $accessToken = $this->authenticate2($order->courier);
                
                $orderData = [
                    'store_id' => $order->courier_store,
                    'merchant_order_id' => $order->invoice?:$order->id,
                    'recipient_name' => $order->name,
                    'recipient_phone' => $order->mobile,
                    'recipient_address' => $order->fullAddress(),
                    'city_id' => $order->courier_city,
                    'zone_id' => $order->courier_zone,
                    'delivery_type' => 48,
                    'product_type' => 2,
                    'quantity' => $order->items->sum('quantity'),
                    'weight' => 0.5,
                    'item_desc' => $order->getDescription(),
                    'amount_collect' => $order->due_amount,
                    'special_instraction' => $order->delivered_msg,
                ];
        
                $response = $client->post("https://developers.carrybee.com/api/orders", [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => "Bearer {$accessToken}",
                    ],
                    'json' => $orderData,
                ]);
                
                $data = json_decode($response->getBody()->getContents(), true);
                if (isset($data['data']['consignment_id'])) {
                    $order->courier_id = $data['data']['consignment_id'];
                    $order->courier_data = json_encode($data);
                    $order->created_at = Carbon::now();
                    $order->save();
                    return $data;
                } else {
                    throw new \Exception('Consignment ID not found in response.');
                }
                
            }elseif($order->courier=='Steadfast'){
                
                $orderData = [
                    'invoice' => $order->invoice?:$order->id,
                    'recipient_name' => $order->name,
                    'recipient_phone' => $order->mobile,
                    'recipient_address' => $order->fullAddress(),
                    'item_description' => $order->getDescription(),
                    'cod_amount' => $order->due_amount,
                    'note' => $order->delivered_msg,
                ];
        
                $response = $client->post("https://portal.packzy.com/api/v1/create_order", [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Api-Key' => general()->steadfast_api_key,
                        'Secret-Key' => general()->steadfast_secret_key,
                    ],
                    'json' => $orderData,
                ]);
                
                $data = json_decode($response->getBody()->getContents(), true);
                
                if (isset($data['consignment']['tracking_code'])) {
                    $order->courier_id = $data['consignment']['tracking_code'];
                    $order->courier_data = json_encode($data);
                    $order->created_at = Carbon::now();
                    $order->save();
                    return $data;
                } else {
                    throw new \Exception('Consignment ID not found in response.');
                }
                
                
            }elseif($order->courier=='Pathao'){
                $accessToken = $this->authenticate2($order->courier);
                $orderData = [
                    'store_id' => $order->courier_store,
                    'merchant_order_id' => $order->invoice?:$order->id,
                    'recipient_name' => $order->name,
                    'recipient_phone' => $order->mobile,
                    'recipient_address' => $order->fullAddress(),
                    'recipient_city' => $order->courier_city,
                    'recipient_zone' => $order->courier_zone,
                    'delivery_type' => 48,
                    'item_type' => 2,
                    'item_quantity' => $order->items->sum('quantity'),
                    'item_weight' => 0.5,
                    'item_description' => $order->getDescription(),
                    'amount_to_collect' => (int) round($order->due_amount),
                    'special_instruction' => $order->delivered_msg,
                ];
        
                $response = $client->post("{$this->baseUrl}/aladdin/api/v1/orders", [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => "Bearer {$accessToken}",
                    ],
                    'json' => $orderData,
                ]);
            
                
                $data = json_decode($response->getBody()->getContents(), true);
                if (isset($data['data']['consignment_id'])) {
                    $order->courier_id = $data['data']['consignment_id'];
                    $order->courier_data = json_encode($data);
                    $order->created_at = Carbon::now();
                    $order->save();
                    return $data;
                } else {
                    throw new \Exception('Consignment ID not found in response.');
                }
        
            }
            
    
        } catch (RequestException $e) {
            return 'Error: ' . $e->getMessage();
        }
        
        
            
        // try {
        //     $accessToken = $this->getAccessToken(); // Get the valid access token
    
        //     $orderData = [
        //         'store_id' => $order->courier_store,
        //         'merchant_order_id' => $order->invoice?:$order->id,
        //         'recipient_name' => $order->name,
        //         'recipient_phone' => $order->mobile,
        //         'recipient_address' => $order->fullAddress(),
        //         'recipient_city' => $order->courier_city,
        //         'recipient_zone' => $order->courier_zone,
        //         'delivery_type' => 48,
        //         'item_type' => 2,
        //         'item_quantity' => $order->items->sum('quantity'),
        //         'item_weight' => 0.5,
        //         'item_description' => $order->getDescription(),
        //         'amount_to_collect' => $order->due_amount,
        //         'special_instruction' => $order->delivered_msg,
        //     ];
    
        //     $response = $client->post("{$this->baseUrl}/aladdin/api/v1/orders", [
        //         'headers' => [
        //             'Content-Type' => 'application/json',
        //             'Authorization' => "Bearer {$accessToken}",
        //         ],
        //         'json' => $orderData,
        //     ]);
    
        //     $data = json_decode($response->getBody()->getContents(), true);
    
        //     if ($response->getStatusCode() == 200) {
        //         $order->courier_id = $data['data']['consignment_id'];
        //         $order->courier_data = json_encode($data);
        //         $order->save();
        //         return $data;
        //     } else {
        //         throw new \Exception('Failed to place order: ' . ($data['message'] ?? 'Unknown error'));
        //     }
    
        // } catch (RequestException $e) {
        //     return 'Error: ' . $e->getMessage();
        // }
    }
    
    
    
    public function StatusCourierOrder($order)
    {
        $client = new Client();
    
        try {
            
            if($order->courier=='Steadfast'){
                $consignmentId = $order->courier_id;
                $response = $client->get("https://portal.packzy.com/api/v1/status_by_trackingcode/{$consignmentId}", [
                    'headers' => [
                        'Api-Key' => general()->steadfast_api_key,
                        'Secret-Key' => general()->steadfast_secret_key,
                    ],
                ]);
                
                $data = json_decode($response->getBody()->getContents(), true);
    
                if ($response->getStatusCode() == 200 && isset($data['delivery_status'])) {
                    $status = ucwords(str_replace('_', ' ', strtolower($data['delivery_status'])));
                    
                    if ($status === 'Delivered' || $status === 'Exchange') {
                        $order->order_status = 'delivered';
                    } elseif ($status === 'Paid Return' || $status === 'Return') {
                        $order->order_status = 'returned';
                    }
                    $order->courier_status = $status;
                    $order->save();
                    return $data;
                }
            }else{
                
                $accessToken = $this->authenticate2('Pathao'); // You must have a valid access token
                $consignmentId = $order->courier_id; // consignment ID saved earlier
        
                // Make GET request to fetch order info
                $response = $client->get("{$this->baseUrl}/aladdin/api/v1/orders/{$consignmentId}/info", [
                    'headers' => [
                        'Authorization' => "Bearer {$accessToken}",
                    ],
                ]);
        
                $data = json_decode($response->getBody()->getContents(), true);
        
                if ($response->getStatusCode() == 200) {
                    // Save the status or data to your DB
                    $order->courier_data = json_encode($data);
                    if(isset($data['data']['order_status']) && $data['data']['order_status'] === 'Delivered') {
                    $order->order_status='delivered';
                    }elseif(isset($data['data']['order_status']) && ($data['data']['order_status'] === 'Paid Return' || $data['data']['order_status'] === 'Return')){
                    $order->order_status='returned';
                    }
                    $order->courier_status = $data['data']['order_status'];
                    $order->save();
                    return $data;
                } else {
                    throw new \Exception('Failed to fetch courier status: ' . ($data['message'] ?? 'Unknown error'));
                }
            }
    
        } catch (RequestException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    
    public function getStores($action)
    {
        $client = new Client();
    
        try {
            
            $accessToken = $this->authenticate2($action); 
            
            if($action=='Carrybee'){
                $response = $client->get("https://developers.carrybee.com/api/stores", [
                    'headers' => [
                        'Content-Type' => 'application/json; charset=UTF-8',
                        'Authorization' => "Bearer {$accessToken}",
                    ],
                ]);
                $json =json_decode($response->getBody(), true);
                if(isset($json['data'])){
                    return $json['data'];
                }
                return ['error' => 'Missing get data'];
            }else{
                $response = $client->get("{$this->baseUrl}/aladdin/api/v1/stores", [
                    'headers' => [
                        'Content-Type' => 'application/json; charset=UTF-8',
                        'Authorization' => "Bearer {$accessToken}",
                    ],
                ]);
                
                $json =json_decode($response->getBody(), true);
                if(isset($json['data']['data'])){
                    return $json['data']['data'];
                }
                return ['error' => 'Missing get data'];
                
            }
    
            
    
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
    // public function getStores()
    // {
    //     $client = new Client();
    
    //     try {
    //         $accessToken = $this->getAccessToken();
    
    //         $response = $client->get("{$this->baseUrl}/aladdin/api/v1/stores", [
    //             'headers' => [
    //                 'Content-Type' => 'application/json; charset=UTF-8',
    //                 'Authorization' => "Bearer {$accessToken}",
    //             ],
    //         ]);
    
    //         return json_decode($response->getBody(), true);
    
    //     } catch (\Exception $e) {
    //         return ['error' => $e->getMessage()];
    //     }
    // }
    
    public function getDistricts($action)
    {
        $client = new Client();
    
        try {
            $accessToken = $this->authenticate2($action); 
            if($action=='Carrybee'){
                $response = $client->get("https://developers.carrybee.com/api/city-list", [
                    'headers' => [
                        'Content-Type' => 'application/json; charset=UTF-8',
                        'Authorization' => "Bearer {$accessToken}",
                    ],
                ]);
            }else{
                $response = $client->get("{$this->baseUrl}/aladdin/api/v1/city-list", [
                    'headers' => [
                        'Content-Type' => 'application/json; charset=UTF-8',
                        'Authorization' => "Bearer {$accessToken}",
                    ],
                ]);
            }
            
            $json =json_decode($response->getBody(), true);
            if(isset($json['data']['data'])){
                return $json['data']['data'];
            }
            return ['error' => 'Missing get data'];
    
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
    // public function getDistricts()
    // {
    //     $client = new Client();
    
    //     try {
    //         $accessToken = $this->getAccessToken();
    
    //         $response = $client->get("{$this->baseUrl}/aladdin/api/v1/city-list", [
    //             'headers' => [
    //                 'Content-Type' => 'application/json; charset=UTF-8',
    //                 'Authorization' => "Bearer {$accessToken}",
    //             ],
    //         ]);
    
    //         return json_decode($response->getBody(), true);
    
    //     } catch (\Exception $e) {
    //         return ['error' => $e->getMessage()];
    //     }
    // }
    
    public function getZones($action,$cityId)
    {
        $client = new Client();
    
        try {
            $accessToken = $this->authenticate2($action); 
            if($action=='Carrybee'){
                $response = $client->get("https://developers.carrybee.com/api/cities/{$cityId}/zones", [
                    'headers' => [
                        'Content-Type' => 'application/json; charset=UTF-8',
                        'Authorization' => "Bearer {$accessToken}",
                    ],
                ]);
            }else{
                $response = $client->get("{$this->baseUrl}/aladdin/api/v1/cities/{$cityId}/zone-list", [
                    'headers' => [
                        'Content-Type' => 'application/json; charset=UTF-8',
                        'Authorization' => "Bearer {$accessToken}",
                    ],
                ]);
            }
            
            $json =json_decode($response->getBody(), true);
            if(isset($json['data']['data'])){
                return $json['data']['data'];
            }
            return ['error' => 'Missing get data'];
    
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
    // public function getZones($cityId)
    // {
    //     $client = new Client();
    
    //     try {
    //         $accessToken = $this->getAccessToken();
    
    //         $response = $client->get("{$this->baseUrl}/aladdin/api/v1/cities/{$cityId}/zone-list", [
    //             'headers' => [
    //                 'Content-Type' => 'application/json; charset=UTF-8',
    //                 'Authorization' => "Bearer {$accessToken}",
    //             ],
    //         ]);
    
    //         return json_decode($response->getBody(), true);
    
    //     } catch (\Exception $e) {
    //         return ['error' => $e->getMessage()];
    //     }
    // }


    
    
    private function getAccessToken()
    {
        $general = General::first();
        return $general->patho_access_token; // Assuming the access token is stored in the General model
    }
    
    
}
