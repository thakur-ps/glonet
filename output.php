<?php
	function showValidationError( $message, $field ){
		$output = array('status'=>0,'msg'=>$message,'field'=>$field);
		header( 'Content-Type:application/json' );
		echo json_encode( $output );
		exit;
	}
	
	function showData( $data ){
		$output = array('status'=>1,'msg'=>'ok','data'=>$data);
		header( 'Content-Type:application/json' );
		echo json_encode( $output );
		exit;
	}
	
	function showOk( $message ){
		$output = array('status'=>1,'msg'=>$message);
		header( 'Content-Type:application/json' );
		echo json_encode( $output );
		exit;
	}
?>
