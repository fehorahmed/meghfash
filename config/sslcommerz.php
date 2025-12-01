<?php

// SSLCommerz configuration

// $apiDomain = env('SSLCZ_TESTMODE') ? "https://sandbox.sslcommerz.com" : "https://securepay.sslcommerz.com";
$apiDomain = "https://securepay.sslcommerz.com";
return [
	'apiCredentials' => [
		'store_id' => 'livesdfsd',
		'store_password' => 'B9C9E154775',
	],
	'apiUrl' => [
		'make_payment' => "/gwprocess/v4/api.php",
		'transaction_status' => "/validator/api/merchantTransIDvalidationAPI.php",
		'order_validate' => "/validator/api/validationserverAPI.php",
		'refund_payment' => "/validator/api/merchantTransIDvalidationAPI.php",
		'refund_status' => "/validator/api/merchantTransIDvalidationAPI.php",
	],
	'apiDomain' => $apiDomain,
	'connect_from_localhost' => false, // For Sandbox, use "true", For Live, use "false"
	'success_url' => '/ssl-payment/success',
	'failed_url' => '/ssl-payment/fail',
	'cancel_url' => '/ssl-payment/cancel',
	'ipn_url' => '/ssl-payment/ipn',
];