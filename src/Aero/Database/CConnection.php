<?php

namespace Aero;

use Aero;

class SQL
{
	private const USER = 'root';
	private const PASSWORD = '';

	public static function __set_state( $P )
	{
		return new \PDO( sprintf ( $P['DNS'], $P['HOST'], $P['DBNAME'], $P['CHARSET'] ),
			self::USER,
			self::PASSWORD,
			$P['ATTR']
		);
	}
	private static function init()
	{
		return Aero::Component( 'SQL' );
	}
	/* public static function C( string $TABLE, callable $CALLABLE )
	{
		self::set( 'create', $TABLE ) -> responce( $CALLABLE );
	}
	public static function I()
	{
		
	}
	public static function S()
	{
		
	} */
	public static function __callStatic( $method, $args )
	{
		return call_user_func_array ( [ self::init(), $method ], $args );
	}
	public static function P( $sql, $args = NULL )
	{
		$shtm = self::init() -> prepare( $sql );
		
		return $shtm -> execute( $args );
	}
}



