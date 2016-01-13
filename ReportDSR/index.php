<?
	session_start();
	set_time_limit(0);
	//ini_set('max_execution_time', 300);
	include("includes/config.php");
	require('Paginator.php');
	ini_set('session.gc_maxlifetime', 3600);
	//print " ==  ".$_SESSION["_USER_TYPE"];
	
	function location($url){
	?>
		<script type='text/javascript'>
			location='<?=$url?>';
		</script>
	<?
}

	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>WEB APPLICATION DRS </title>
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all" />    	
	<script type='text/javascript' src='jQuery/jquery-1.9.1.min.js'></script>
	<script type='text/javascript' src='jQuery/jquery-ui-1.10.0.custom.min.js'></script>
	<link rel='stylesheet' type='text/css' href='jQuery/ui-lightness/jquery-ui-1.10.0.custom.css'>
	<script type="text/javascript" src="menu/jsddm.js"></script>
	<script type="text/javascript" src="jQuery/path.js"></script>
	
<script type="text/javascript" src="menu/jquery_2.js.js"></script>
    <script type="text/javascript" src="menu/menu.js"></script>
	
	
	
	<style type="text/css">
		@import url(menu/jsddm.css);
			@import url(menu/menu.css);
	</style>

	<script type='text/javascript'>
		$(function(){
			$('#select').change(function(){
				$.ajax({
					url:'get_data.php',
					type:'POST',
					data:'value='+$('#select').prop('value'),
					//data:{name:'1'}
					success:function(result){
						$('#show').html(result);
					}
				});
			});
			
			$('#txtDate').datepicker({
				dateFormat:'yy-mm-dd'
			});
			
			Path.listen();
		});
	
		

		$(function(){
	
			
			$('#Re1').click(function(){
				$('#show').html("<img src='images/c3.jpg'>").css({'text-align':'center'});

			});
			
			$('#fromReportByUser').click(function(){
				$('#show').html("<img src='images/89.gif'>").css({'text-align':'center'});
				$.ajax({
					url:'report/fromReportByUser.php',
					type:'POST',
					data:'',
					success:function(result){
						$('#show').html(result);
								
					}
				});
			});
			$('#fromReportAve').click(function(){
				$('#show').html("<img src='images/89.gif'>").css({'text-align':'center'});
				$.ajax({
					url:'report/fromReportAve.php',
					type:'POST',
					data:'',
					success:function(result){
						$('#show').html(result);
								
					}
				});
			});
			
			$('#fromReportMTD').click(function(){
				$('#show').html("<img src='images/89.gif'>").css({'text-align':'center'});
				$.ajax({
					url:'report/fromReportMTD.php',
					type:'POST',
					data:'',
					success:function(result){
						$('#show').html(result);
								
					}
				});
			});
			
			$('#logout').click(function(){
				$('#show').html("<img src='images/89.gif'>").css({'text-align':'center'});
				$.ajax({
					url:'report/logout.php',
					type:'POST',
					data:'',
					success:function(result){
						$('#show').html(result);
								
					}
				});
			});
			
			
			
			
		});
		


	</script>
</head>
<body >
		
		<table width="100px" cellpadding="0" cellspacing="0" align="center" height="80px" border="0"  >
		<tr>
			<td height="80" >
			<? if($_SESSION["_USER_ID"] !="") { include('includes/inc_header.php'); }?></td>
	   </tr>
		<tr>
			<td height="70px"><?//include('menu/menu.php');?>
			<? if($_SESSION["_USER_ID"] !="") { include('menu/menu.php');}?>
			
			</td>
		</tr>
	



</table>
<div id="show">
<?
		if($_POST['hd_cmd']=="add")
		{

		include ("report/form_card.php");
		
		}	
		
		if($_GET['_no_serial']!="" )
		{
		
		include("report/edit_card.php");
		}
		
		if($_GET['_no_se']!="" )
		{
		
		include("report/delete_card.php");
		}
		
		if($_POST['hd_cmd2']=="edit")
		{
		
		include("report/save_edit_card.php");
		
		}	
		
		
		if($_POST['cmd_up']=="upload")
		{
		include("report/upload_esso1.php");
		}
		if($_POST['cmd_up']=="uploadk")
		{
		include("report/upload_esso2.php");
		}
		
		if($_POST['cmd_up']=="upload_op")
		{
		include("report/upload_dailyop.php");
		}
		if($_POST['cmd_up']=="upload_re")
		{
		include("report/upload_dailyre.php");
		}
		if($_POST['cmd_up']=="upload_box")
		{
		include("report/upload_box.php");
		}
		
		
		else if($_GET['op']=="ss" || $_GET['op']=="sp")
		{
		include ("report/form_esso.php");
		}	
		else if(!isset($_SESSION["_USER_ID"])){ include("report/logins.php");} 
		//else {include("index.php");} 	
?>
</div>
</body>
</html>