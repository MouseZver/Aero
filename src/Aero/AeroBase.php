<?php

namespace Aero;

use Aero;

class AeroBase
{
	public static $APP = NULL;
	private static 
		$XDEBUG = false,
		$L = [];
	
	protected static $NAMESPACESMAP = [
		Main::class					=> Application\CMain::class,
		Application::class			=> Application\CApplication::class,
		Massive::class				=> Configure\CConfigure::class,
		Engine::class				=> Application\CEngine::class,
		Module::class				=> Application\CModule::class,
		Support\Validator::class	=> Supports\traits\CValidator::class
	];
	
	public static function setLog( string $string )
	{
		if ( self::$APP !== NULL && self::$XDEBUG ) 
			self::$APP -> Starting( $string );
	}
	public static function setPatchMap( string $NAME, string $PATCH )
	{
		self::$NAMESPACESMAP[$NAME] = $PATCH;
	}
	public static function AppCore( $CLASS, $A = NULL )
	{
		self::setLog( "load class > {$CLASS}..." );
		
		return new $CLASS( $A );
	}
	public static function autoload( $CLASS )
	{
		if ( isset ( self::$NAMESPACESMAP[$CLASS] ) )	# Преобразование загруженной директории из имени пространства
		{
			$CLASS = self::$NAMESPACESMAP[$CLASS];
		}
		elseif ( strpos ( $CLASS, Page::class ) !== FALSE )	# Проверка пространства и создании пути к паге страницы
		{
			$CLASS = 'public' . substr ( $CLASS, 9 );
		}
		
		include dirname ( __FILE__, 2 ) . DIRECTORY_SEPARATOR . strtr ( $CLASS, '\\', DIRECTORY_SEPARATOR ) . '.php';
		
		#self::Controll( $_NAMESPACE );
	}
	public static function isSPL( string $A ): bool
	{
		return ( self::$APP !== NULL && isset ( self::$APP -> _SPL[$A] ) );
	}
	public static function Controll( string $A )
	{
		if ( self::isSPL( $A ) )
		{
			self::$APP -> loadComplect( $A );
		}
	}
	public static function Component( string $A )
	{			
		if ( !isset ( self::$APP -> _COMPLECT[$A] ) )
		{
			return NULL;
		}
		if ( isset ( self::$APP -> _SPL[self::$APP -> _COMPLECT[$A]['class']] ) )
		{
			self::$APP -> loadComplect( self::$APP -> _COMPLECT[$A]['class'] );
		}
		
		return self::$APP -> _COMPONENT[self::$APP -> _COMPLECT[$A]['class']];
	}
	public static function __callStatic( $NAME, $ARGUMENTS = NULL )
	{
		return self::$APP -> $NAME( $ARGUMENTS );
	}
}
