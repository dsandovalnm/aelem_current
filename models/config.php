<?php
   setlocale(LC_TIME, 'es_ES.UTF-8');

	define('KEY','3ncryp7_aelem');
	define('COD','AES-128-ECB');


	define('DB_HOST','localhost');
	define('DB_USERNAME','root');
	define('DB_PASSWORD','');
	define('DB_NAME','aelem');
	define('DB_CHARSET','utf8');


	define('BASE_URL','https://ayudaenlasemociones.com/');
	define('APP_URL','https://ayudaenlasemociones.com/plataforma/');
	define('CURRENT_URL', $_SERVER['REQUEST_URI']);

	/* PAYPAL */
		/* Sandbox */
			// define('PP_CLIENT_ID','AZQ_GUoxi8jz-s2YRkKvTl5Lmsa7zCCTHNh8sc3KhTY3CEKFu-yh6EDQBIfFwJgEeiQA0K2sJp4ETvtU');
			// define('PP_SECRET_KEY','EFnDCg25VyZk6_HXiYL7xnAAvk9u3KXSeSJV9zkJF-__zQpqWsUbw6yPoEuvOgKkqqFoHCOkAaOUABbW');
			// define('PP_URL','https://api-m.sandbox.paypal.com/v1/');

		/* Prod */
			define('PP_CLIENT_ID','AR_BFXkvEVSi6m6RFcfJ9NcL6inuVzvyR_ND1YwLF8r7Fu_hIqPI8a6BVnRph6T6XTwIsf6XhDJD_Ehc');
			define('PP_SECRET_KEY','EFQpvAsjv2zxmDhGqm-Xi5FA7G0LKlWIiOKo3XvqhED8mvW2ydP2i7fNiuM542t2spLDx-wHAZWik_jh');
			define('PP_URL','https://api-m.paypal.com/v1/');
	
	
	/* MERCADOPAGO */
		/* SandBox */
			// define('MP_PUBLIK_KEY','APP_USR-98217ea7-f786-4a38-b55e-15d0b47d4009');
			// define('MP_ACCESS_TOKEN','APP_USR-2070888904962361-071312-c9ffe6d16f7cfb873dadf84455ddbf2e-790422985');
			//	define('MP_COLLECTION_ID','790422985');
			// define('MP_URL','https://api.mercadopago.com/preapproval/');

		/* Prod */
			define('MP_PUBLIK_KEY','APP_USR-0244953e-01a7-4a7e-b7e3-92acb5ea6c85');
			define('MP_ACCESS_TOKEN','APP_USR-6478616094748034-070913-354f94cb6cff1a8c3847b04bf87b3498-232038519');
			define('MP_COLLECTOR_ID','232038519');
			define('MP_URL','https://api.mercadopago.com/preapproval/');


	//Client Id MP 6478616094748034
	//Client Secret MP H1KO0d5haSuuB3boj5HmVRNx1OeDxwp5
