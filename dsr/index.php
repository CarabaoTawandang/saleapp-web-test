<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
	session_start();  //เปิดseeion	
	set_time_limit(0);//เป็นการกำหนดให้ server run ได้ ตราบนานเท่านาน
	include("../includes/config.php"); //connect database db.carabao.com
	ini_set('session.gc_maxlifetime', 3600); //การกำหนดค่า Session Timeout
	
	session_unregister("name");//ลบเซกชั่น
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title>WEB SaleApp DSR</title>

<link href="../css2/css.css" rel="stylesheet" type="text/css">
 <script src="../css2/ddmenu.js" type="text/javascript"></script>
 <!---------เดิม---->
<script type='text/javascript' src='../jQuery/jquery-1.9.1.min.js'></script>
<script type='text/javascript' src='../jQuery/jquery-ui-1.10.0.custom.min.js'></script>
<link rel='stylesheet' type='text/css' href='../jQuery/ui-lightness/jquery-ui-1.10.0.custom.css'>
<link rel='stylesheet' type='text/css' href='../jQuery/ui-lightness/jquery-ui-1.10.0.custom.min.css'>

<script type="text/javascript" src="../jQuery/path.js"></script>
<script type='text/javascript' src='../jQuery/time/jquery-1.7.2.min.js'></script>

<script type='text/javascript' src='../jQuery/time/jquery-ui.js'></script>
<script type='text/javascript' src='../jQuery/time/jquery.ui.timepicker.js'></script>
<link rel='stylesheet' type='text/css' href='../jQuery/time/jquery.ui.timepicker.css'>

<script type='text/javascript'>
	
	$(function(){ //---------------------------function หน้าPAGE
	
			
			$('#logout').click(function(){
				$('#show').html("<img src='../images/89.gif'>").css({'text-align':'center'});
				$.ajax({
					url:'logout.php',
					type:'POST',
					data:'',
					success:function(result){
						$('#show').html(result);
								
					}
				});
			});
			
	}); //---------------------------จบ function หน้าPAGE
	</script>
</head>

<body>

	
<header></header>

<?php 
if($_SESSION["USER_name"]) 
{ 
include 'header.php';// menu
	ECHO "<DIV ID='show'>";
	echo "<br><br>";	 
	include 'content.php'; //page
	ECHO "</DIV>";
include '../report/footer.php'; //footer
}
else
{
	echo "<script type=\"text/javascript\">";
	echo "window.location='login.php';";
	echo "</script>";
}
?>
</body>

</html>
