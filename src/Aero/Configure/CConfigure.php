<?php

namespace Aero;

class Massive
{
	public
		$EMAIL_DEFAULT_SITE = '',	# Email support
		$START_DEFAULT_INDEX = '',	# Default web page
		$CHARSET = 'UTF-8',			# Encoding server
		$DEFAULT_INDEX_PAGE = 'start',
		
		$AUTOLOAD = [
			'AuthManager' => [
				'namespace' => [ AuthManager::class => System\User\CAuthIndetify::class ],
				'value' => [
					'limit' => '+ 30 day',
					'USERNAME' => 'Гость',
					'COOKIENAME' => 'AuthMe'
				],
				'load' => [ 'Session' ]
			],
			'SQL' => [
				'namespace' => [ SQL::class => Database\CConnection::class ],
				'value' => [
					'HOST' => '127.0.0.1',
					'DB_NAME' => 'ray_local',
					'CHARSET' => 'utf8',
					'ATTR' => [
						\PDO::ATTR_ERRMODE				=> \PDO::ERRMODE_EXCEPTION,
						\PDO::ATTR_DEFAULT_FETCH_MODE	=> \PDO::FETCH_ASSOC,
						\PDO::ATTR_EMULATE_PREPARES		=> FALSE,
					]
				]
			],
			'Session' => [
				'namespace' => [ Session::class => System\Header\CHttpSession::class ],
				'value' => [
					'SESSID' => 'PHP7SESSID'
				]
			]
		];
	
	/* public function __construct ( callable $SORT )
	{
		uasort ( $this -> AUTOLOAD, $SORT( 'priority' ) );
	} */
}

/* return [
	'Aero' => [
		'DB' => [
			'HOST' => 'localhost',
			'DB_NAME' = 'ray_local',
			'USER' = 'root',
			'PASSWORD' = '',
			'CHARSET' = 'utf8'
		]
	]
]; */