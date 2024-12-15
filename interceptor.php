<?php
	/** 
	 * Author - Pushpendra Singh Thakur <thakur@bucorel.com>
	 * Copyright - Business Computing Research Laboratory <www.bucorel.com>
	 */
	function getMethod(){
		switch(  $_SERVER['REQUEST_METHOD'] ){
			case 'GET':
				echo 'get';
				break;
			case 'POST':
				echo 'post';
				break;
			case 'PUT':
				echo 'put';
				break;
			case 'DELETE':
				echo 'delete';
				break;
			default:
				echo 'Unknown method';
		}
	}
?>
