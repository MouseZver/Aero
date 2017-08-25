<?php

namespace Aero;

use Aero;

class Engine extends Module
{
	private 
		# class all autoloads and parameters
		$_COMPLECT = [],
		
		# loading parameters object classes
		$_COMPONENT = [],
		
		# ?
		$_S = NULL,
		
		# access load namespace > name class
		$_SPL = [],
		
		# Configures all
		$_CONFIG;
	
	
	public
		$_HeadTitle;
	
	use Support\Validator;
	
	
	public function Configure( Massive $C )
	{
		$this -> _CONFIG = $C;
		
		return $this;
	}
	public function setSpl( string $C, string $K )
	{
		$this -> _SPL[$C] = $K;
		
		return $this;
	}
	public function setComplect( string $K, array $A )
	{
		$this -> _COMPLECT[$K] = $A;
		
		return $this;
	}
	public function loadComplect( string $SPL ): void
	{
		$META = $this -> _COMPLECT[$this -> _SPL[$SPL]];
		
		if ( isset ( $META['load'] ) )
		{
			foreach ( $META['load'] AS $NAME_COMPONENT )
			{
				if ( isset ( $this -> _COMPLECT[$NAME_COMPONENT]['class'] ) )
				{
					$this -> loadComplect( $this -> _COMPLECT[$NAME_COMPONENT]['class'] );
				}
			}
		}
		
		$C = Aero::AppCore( $META['class'] );
		
		unset ( $this -> _SPL[$SPL], $META['class'], $META['load'] );
		
		$this -> setParameters( $C, $META ) -> _COMPONENT[$SPL] = $C;
	}
}
