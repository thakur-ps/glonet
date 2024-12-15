<?php
	/** 
	 * Author - Pushpendra Singh Thakur <thakur@bucorel.com>
	 * Copyright - Business Computing Research Laboratory <www.bucorel.com>
	 */
	
	function getDb(){
		/*
		$db = pg_connect( "host=localhost port=5432 dbname=glonet user=postgres password=highrisk" );
		return $db;
		*/
		return pg_connect( "host=localhost port=5432 dbname=glonet user=postgres password=highrisk" );
	}
?>
