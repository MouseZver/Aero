<?php

/*
Насильственное деяние авторизации пользователя с помощью
БД, а не после работой с session_start :\
Ps: Исправленно
*/

namespace Aero;

use Aero;

class AuthManager
{
	public function __construct()
	{
		$this -> Auth();
	}
	public function __set( $NAME, $VALUE )
	{
		if ( isset ( $this -> $NAME ) ) return FALSE;
		
		$this -> $NAME = $VALUE;
	}
	public function __get( $NAME )
	{
		
	}
	public function Auth()
	{		
		SQL::P( "DELETE FROM SESSREM WHERE TIMEOUT < {$_SERVER['REQUEST_TIME']}" );
		
		if ( ( $_SESSION['LOGGED'] ?? 0 ) === TRUE && SQL::P( 'SELECT SID FROM SESSREM WHERE UID = ?', [ $_SESSION['ID'] ] ) -> fetchColumn() == $_COOKIE['AuthMe'] )
		{
			$this -> UID				= $_SESSION['ID'];
			$this -> USERNAME			= $_SESSION['USERNAME'];
			$this -> GROUP_TITLE		= $_SESSION['NAME'];
			$this -> GROUP_ACCESS		= $_SESSION['ACCESS'];
			$this -> GROUP_COLOR		= $_SESSION['COLOR'];
			$this -> USER_LOGGED_IN		= $_SESSION['LOGGED'];
		}
		elseif ( filter_input ( INPUT_COOKIE, 'AuthMe', FILTER_DEFAULT, [ 'options' => [ 'regexp' => '/^[a-f0-9]{32}$/' ] ] ) )
		{
			$SQL = 'SELECT 
				U.ID, 
				U.USERNAME, 
				U.PASSWORD, 
				G.NAME, 
				G.ACCESS, 
				G.COLOR, 
				B.ID AS BAN
			FROM 
				SESSREM S
				LEFT JOIN USRACCOUNT U ON U.ID = S.UID
				LEFT JOIN GROUP_USER G ON G.ID = U.STATUS
				LEFT JOIN USRBANNED B ON B.UID = U.ID
			WHERE 
				S.SID = ?';
			
			$PDO = SQL::P( $SQL, [ $_COOKIE['AuthMe'] ] );
			
			if ( $PDO -> rowCount() > 0 )
			{
				$U = $PDO -> fetch();
				
				if ( $U['BAN'] !== NULL )
				{
					$this -> USER_BANNED_IN = TRUE;
					
					setcookie ( 'AuthMe', '', -1 );
				}
				elseif ( md5 ( $U['ID'] . $U['USERNAME'] . $U['PASSWORD'] ) == $_COOKIE['AuthMe'] )
				{
					$this -> UID				= $_SESSION['ID']		= $U['ID'];
					$this -> USERNAME			= $_SESSION['USERNAME']	= $U['USERNAME'];
					$this -> GROUP_TITLE		= $_SESSION['NAME']		= $U['NAME'];
					$this -> GROUP_ACCESS		= $_SESSION['ACCESS']	= $U['ACCESS'];
					$this -> GROUP_COLOR		= $_SESSION['COLOR']	= $U['COLOR'];
					$this -> USER_LOGGED_IN		= $_SESSION['LOGGED']	= TRUE;
					
					SQL::P( 'UPDATE SESSREM SET TIMEOUT = ? WHERE SID = ?', [ strtotime ( $this -> limit ), $_COOKIE['AuthMe'] ]  );
					
					SQL::P( 'UPDATE USRACCOUNT SET LASTONLINE = ? WHERE ID = ?', [ $_SERVER['REQUEST_TIME'], $this -> UID ] );
					
					setcookie ( 'AuthMe', $_COOKIE['AuthMe'], strtotime ( $this -> limit ), '/' );
				}
				else
				{
					# передать сообщение с ip о левой куки с попыткой обхода.
				}
			}
			else
			{
				setcookie ( 'AuthMe', '', -1 );
			}
		}
		else
		{
			$this -> USER_LOGGED_IN = 222;
		}
		
		return $this;
	}
}
/* 
SQL::S( 'TABLE', function ( Purpure $P )
{
	$P -> column( 'ID', 't2.LOL' );
	$P -> join( 'TABLE2' ) -> on( [ 't2.LOL' => [ '!=', 't1.ID' ] ] );
	$P -> where( [ 'ID' => '>' ] );
	$P -> order( 'ID', 'DESC' );
	$P -> limit( [ 0, 25 ] );
} ) */