<?php
/*   Connect  Database     */
	$myServer = 'db.carabao.com';
	$myUser = 'hpadmin';
	$myPass = 'GcdtCHSp1';
	
	$dbname = 'SALES_DB_DEV';
	$con=sqlsrv_connect($myServer,array("Database"=>$dbname,"UID"=>$myUser,"PWD"=>$myPass,"CharacterSet"=>"UTF-8"));

?>