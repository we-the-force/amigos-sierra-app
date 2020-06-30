<?php

use Directus\Application\Http\Request;
use Directus\Application\Http\Response;
use Directus\Services\ItemsService;



return [
  // The endpoint path:
  // '' means it is located at: `/custom/<endpoint-id>`
  // '/` means it is located at: `/custom/<endpoint-id>/`
  // 'test' and `/test` means it is located at: `/custom/<endpoint-id>/test
  // if the handler is a Closure or Anonymous function, it's binded to the app container. Which means $this = to the app container.
    '' => [
        'method' => 'POST',
        'handler' => function (Request $request, Response $response) {
        // Get all answers from DB
            $itemsService = new ItemsService($this);
            // $email = $request->getAttribute('email');
            $params = $request->getQueryParams();
            // $license = $itemsService->find('licenses', $serial, $params);
            $date = (int)$params["expiration"];
            // $date = 1595998800;
            // $date=date_format($date, 'U');
            // echo date_timestamp_get($date);
            // // $url = 'https://wetheforcestudios.com/api/public/carl-donations/mail';

            // //The data you want to send via POST
            // // $fields = [
            // //     'to' => '',
            // //     '__EVENTVALIDATION' => $valid,
            // //     'btnSubmit'         => 'Submit'
            // // ];

            // //url-ify the data for the POST
            // $data = '{ "name": "Amigos de la Sierra", "type": "PaymentLink", "recurrent": false, "expired_at": 1593556289, "allowed_payment_methods": [   "cash",   "card" ], "needs_shipping_contact": false, "order_template": {   "line_items": [       {     "name": "Amigos de la Sierra",     "description": "Donación", "unit_price": '.$params['price'].',     "quantity": 1       }   ],   "currency": "MXN",   "customer_info": {       "name": "Donador anónimo",                 "email": "administracion@amigosdelasierra.org",                 "phone": "8446222889"   } }}';
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://api.conekta.io/checkouts",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              // CURLOPT_POSTFIELDS => $data,
              CURLOPT_POSTFIELDS =>"{\n  \"name\": \"Amigos de la Sierra\",\n  \"type\": \"PaymentLink\",\n  \"recurrent\": false,\n  \"expired_at\": ".$date.",\n  \"allowed_payment_methods\": [\n    \"cash\",\n    \"card\"\n  ],\n  \"needs_shipping_contact\": false,\n  \"order_template\": {\n    \"line_items\": [\n        {\n      \"name\": \"Amigos de la Sierra\",\n      \"description\": \"Donación\",\n  \"unit_price\": ".$params["price"].",\n      \"quantity\": 1\n        }\n    ],\n    \"currency\": \"MXN\",\n    \"customer_info\": {\n        \"name\": \"Donador anónimo\",\n                  \"email\": \"administracion@amigosdelasierra.org\",\n                  \"phone\": \"8446222889\"\n    }\n  }\n}",
              // CURLOPT_POSTFIELDS =>"{\n  \"name\": \"Carl and the plague\",\n  \"type\": \"PaymentLink\",\n  \"recurrent\": false,\n  \"expired_at\": ".$date.",\n  \"allowed_payment_methods\": [\n    \"cash\",\n    \"card\"\n  ],\n  \"needs_shipping_contact\": false,\n  \"order_template\": {\n    \"line_items\": [\n        {\n      \"name\": \"Carl and the plague\",\n      \"description\": \"License\",\n  \"unit_price\": 50000,\n      \"quantity\": 1\n        }\n    ],\n    \"currency\": \"MXN\",\n    \"customer_info\": {\n        \"name\": \"Donador Anónimo\",\n                  \"email\": \"will@wetheforce.com\",\n                  \"phone\": \"8441763270\"\n    }\n  }\n}",
              CURLOPT_HTTPHEADER => array(
                "accept: application/vnd.conekta-v2.0.0+json",
                "access-control-allow-origin: *",
                "cache-control: no-cache",
                "Content-Type: application/json",
                "Authorization: Basic a2V5XzZ2VjJ6Mkh5SjdOS3hNcWU1cmJlcVE6"
              ),
            ));

            $respuesta = curl_exec($curl);
            curl_close($curl);
            $respuesta = json_decode($respuesta, true);

            return $response->withJson([
                'paymentLink' => $respuesta,
            ]);
           
    }
    ]
];
