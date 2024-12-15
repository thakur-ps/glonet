<?php
	include 'db.php';
	include 'output.php';
	
	switch(  $_SERVER['REQUEST_METHOD'] ){
		case 'GET':
			readPostData();
			break;
		case 'POST':
			writePostData();
			break;
		case 'PUT':
			writePostData();
			break;
		case 'DELETE':
			//echo 'delete';
			deletePostData();
			break;
		default:
			echo 'Unknown method';
	}
	
	
	function readPostData(){
		$db = getDb();
		$output = array();
		
		//if( isset( $_REQUEST['last'] ) && filter_var($_REQUEST['last'], FILTER_VALIDATE_INT) === true ){
		if( isset( $_REQUEST['last'] )  ){
			if( $_REQUEST['last'] > 0 ){
				$sql = "select * from posts where pid<$1 order by pid desc limit 2";
				$posts = pg_query_params( $db, $sql, array( $_REQUEST['last'] ) );
			}
		}else{
			$sql = "select * from posts order by pid desc limit 2";
			$posts = pg_query_params( $db, $sql, array() );
		}
		
		while( $row = pg_fetch_assoc( $posts ) ){
			array_push( $output, $row );
		}
		
		showData( $output );
	}
	
	function writePostData(){
		validatePostInput();
		$db = getDb();
		
		$t = time();
		
		$sql = "insert into posts (tstamp, creator, msg) values ($1, $2, $3) returning pid";
		$result = pg_query_params( $db, $sql, array( $t, $_REQUEST['creator'], $_REQUEST['msg'] ) );
		while( $row = pg_fetch_assoc( $result ) ){
			//$pid = $row['pid'];
			showData( $row );
		}
	}
	
	
	function validatePostInput(){
		if( !isset( $_REQUEST['creator'] ) || filter_var($_REQUEST['creator'], FILTER_VALIDATE_INT ) === false ){
			showValidationError( 'INVALID_CREATOR', 'creator' );
		}
		
		if( !isset( $_REQUEST['msg'] ) || $_REQUEST['msg'] == "" ){
			showValidationError( 'ERROR_EMPTY_MSG', 'msg' );
		}
		
		if( strlen( $_REQUEST['msg'] ) > 1000 ){
			showValidationError( 'ERROR_MSG_TOO_BIG', 'msg' );
		}
	}
	
	function deletePostData(){
		if( !isset( $_REQUEST['pid'] ) || filter_var($_REQUEST['pid'], FILTER_VALIDATE_INT ) === false ){
			showValidationError( 'INVALID_POST_ID', 'pid' );
		}
		
		$db = getDb();
		$sql = "delete from posts where pid=$1";
		$result = pg_query_params( $db, $sql, array( $_REQUEST['pid'] ) );
		//showData( array('msg'=>'') );
		showOk( 'DELETED' );
	}
?>
