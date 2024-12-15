<?php
	/** 
	 * Author - Pushpendra Singh Thakur <thakur@bucorel.com>
	 * Copyright - Business Computing Research Laboratory <www.bucorel.com>
	 */

	include 'db.php';
	include 'output.php';
	
	switch(  $_SERVER['REQUEST_METHOD'] ){
		case 'GET':
			readUserData();
			break;
		case 'POST':
			writeUserData();
			break;
		case 'PUT':
			writeUserData();
			break;
		case 'DELETE':
			//echo 'delete';
			deleteUserData();
			break;
		default:
			echo 'Unknown method';
	}	

	function readUserData(){
		if( isset( $_REQUEST['uid'] )  &&  filter_var( $_REQUEST['uid'], FILTER_VALIDATE_INT ) !== false ){
			readSingleRecord( $_REQUEST['uid'] );
		}else{
			readAllRecords();
		}
	}
	
	function readSingleRecord( int $uid ){
		$output = array();
		
		$db = getDb();
		$sql = "select * from users where uid=$1";
		$records = pg_query_params( $db, $sql, array( $uid ) );
		
		while( $row = pg_fetch_assoc( $records ) ){
			//print_r( $row );
			array_push( $output, $row );
		}
		
		header( 'Content-Type:application/json' );
		echo json_encode( $output );
	}
	
	function readAllRecords(){
		$output = array();
		
		$db = getDb();
		$sql = "select * from users";
		$records = pg_query_params( $db, $sql, array() );
		
		while( $row = pg_fetch_assoc( $records ) ){
			//print_r( $row );
			array_push( $output, $row );
		}
		
		header( 'Content-Type:application/json' );
		echo json_encode( $output );
	}
	
	function writeUserData(){
		if( isset( $_REQUEST['uid'] )  &&  filter_var( $_REQUEST['uid'], FILTER_VALIDATE_INT ) !== false ){
			updateUserRecord( $_REQUEST['uid'] );
		}else{
			insertUserRecord();
		}
	}
	
	function insertUserRecord(){
		validateUserInput();
		
		$db = getDb();
		
		$passKey = sha1( time() );
		
		$sql = "insert into users (uname,phone,pass_key) values ($1,$2,$3) returning uid";
		$result = pg_query_params( $db, $sql, array( $_REQUEST['uname'], $_REQUEST['phone'], $passKey ) );
		while( $row = pg_fetch_assoc( $result ) ){
			$output = array();
			$output['uid'] = $row['uid'];
			$output['pass_key'] = $passKey;
			showData( $output );
		}
	}
	
	
	function validateUserInput(){
		if( !isset( $_REQUEST['uname'] ) || $_REQUEST['uname'] == "" ){
			showValidationError( 'Please enter user name', 'uname' );
		}
		
		if( !isset( $_REQUEST['phone'] ) || $_REQUEST['phone'] == "" ){
			showValidationError( 'Please enter phone', 'phone' );
		}
	}
	

?>
