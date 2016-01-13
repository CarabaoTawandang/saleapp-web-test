<?php
	$myServer = 'db.carabao.com';
	$myUser = 'hpadmin';
	$myPass = 'GcdtCHSp1';
	
	$dbname = 'SALES_DB_TEST';
	$con=sqlsrv_connect($myServer,array("Database"=>$dbname,"UID"=>$myUser,"PWD"=>$myPass,"CharacterSet"=>"UTF-8"));
	
	
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		
		
	$year = substr(date('Y')+543,2,2);
	$date = date('Y-m-d');
?>