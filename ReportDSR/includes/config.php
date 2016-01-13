<?php
	$myServer = 'saletools.carabao.co.th';
	$myUser = 'saletools';
	$myPass = 'YveTbHP6';
	
	$dbname = 'SALESTOOLS_CARABAODC';
	$pre_qry = 'SET NAMES TIS620';
	$con=sqlsrv_connect($myServer,array("Database"=>$dbname,"UID"=>$myUser,"PWD"=>$myPass,"CharacterSet"=>"UTF-8"));
	
	
?>