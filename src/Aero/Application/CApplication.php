<?php

namespace Aero;

use Aero;

abstract class Application extends Engine
{	
	public 
		$controll = [],
		$defaultAction;
	
	abstract public function setParameters( $A, $B );
	
	public function __construct ( $SETTINGS )
	{
		Aero::$APP = $this;
		
		$this -> AutoLoad( ( $C = Aero::AppCore( $SETTINGS ) ) -> AUTOLOAD );
		unset ( $C -> AUTOLOAD );
			
		$this -> Configure( $C ) -> init();
	}
	protected function AutoLoad( array $LIST )
	{
		foreach ( $LIST AS $K => $CONF )
		{
			$CLASS = key ( $CONF['namespace'] );
			
			Aero::setPatchMap( $CLASS, $CONF['namespace'][$CLASS] );
			
			$this -> setSpl( $CLASS, $K ) -> setComplect( $K, [ 'class' => $CLASS ] );
			
			if ( isset ( $CONF['value'] ) ) $this -> setComplect( $K, array_merge ( $this -> _COMPLECT[$K], $CONF['value'] ) );
			
			if ( isset ( $CONF['load'] ) ) $this -> setComplect( $K, array_merge ( $this -> _COMPLECT[$K], [ 'load' => $CONF['load'] ] ) );
		}
	}
	public function init()
	{
		#Aero::Component( 'AuthManager' );
	}
}