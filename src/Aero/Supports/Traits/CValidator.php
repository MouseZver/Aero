<?php

namespace Aero\Support;

use Aero;

trait Validator
{
	public function __set( $name, $value ): void
	{
		Aero::setLog( sprintf ( '<%s> function <%s> ( %s, %s )', __CLASS__, __FUNCTION__, $name, $value ) );
		
		$this -> $name = $value;
	}
	public function __get( $name )
	{
		Aero::setLog( sprintf ( '<%s> function <%s> ( %s )', __CLASS__, __FUNCTION__, $name ) );
		
		return ( $this -> $name ?? FALSE );
	}
	public function __isset( $name ): bool
	{
		Aero::setLog( sprintf ( '<%s> function <%s> ( %s )', __CLASS__, __FUNCTION__, $name ) );
		
		return isset ( $this -> $name );
	}
	public function __unset( $name ): void
	{
		Aero::setLog( sprintf ( '<%s> function <%s> ( %s )', __CLASS__, __FUNCTION__, $name ) );
		
		unset ( $this -> $name );
	}
}