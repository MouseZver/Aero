<?php

namespace Aero;

use Aero;

class Main extends Application
{
	private
		$PAGE_PATCH, # Путь к паге/страница
		$_starting = [],
		$_memory = NULL;
	
	public function setParameters( $OBJECT, $ARR )
	{
		foreach ( $ARR AS $NAME => $VALUE )
		{
			$OBJECT -> $NAME = $VALUE;
		}
		
		return $this;
	}
	public function Starting( string $string )
	{
		if ( $this -> _memory === NULL ) 
		{
			$this -> _memory = memory_get_usage ();
			$this -> _starting[] = [ $_SERVER['REQUEST_TIME_FLOAT'], 'STARTING...' ];
		}
		
		$this -> _starting[] = [ microtime ( 1 ), $string ];
	}
	public function setTransport()
	{
		
	}
	public function getTransport()
	{
		
	}
	public function runController()
	{
		
	}
	public function run()
	{
		if ( isset ( $this -> get ) )
		{
			$this -> setBeginRequest();
		}
		
		register_shutdown_function ( [ Aero::class, 'Fluex' ] );
		return $this;
	}
}