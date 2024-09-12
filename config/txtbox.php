<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | TxtBox API Key
    |--------------------------------------------------------------------------
    | 
    | API Key from your TxtBox account.
    |
    | You need a valid API key with enough TxtBox SMS credits for it to work.
    | Get your API key at: https://www.txtbox.com/api-keys (sign in required)
    |
    */
	
    'api_key' => env('TXTBOX_API_KEY', 'c70b05e11f368adf37216ec84c64c3b4'),
    'api_endpoint' => env('TXTBOX_API_ENDPOINT', 'https://ws-v2.txtbox.com/messaging/v1/sms/push')

];