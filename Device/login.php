<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
	session_start();  //เปิดseeion	
	set_time_limit(0);//เป็นการกำหนดให้ server run ได้ ตราบนานเท่านาน
	include("../includes/config.php"); //connect database db.carabao.com
	ini_set('session.gc_maxlifetime', 3600); //การกำหนดค่า Session Timeout
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login SaleApp ทรัพย์สิน</title>
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
</head>
<script type="text/javascript">

$(function(){	
			
		$('#login').click(function(){
					if(($('#txt_username').prop('value')=='')&&($('#txt_pwd').prop('value')==''))
					{alert("โปรดใส่ Username และ Password !");}
					else {
					$('#txt_search').html("<img src='../images/89.gif'>");
					$.ajax({
						
						url:'check_login.php',
						type:'POST',
						data:$('#signup').serialize(),
						success:function(result){
							$('#txt_search').html(result);
							}
							});
							
						}	
		});
		$('#txt_username').focus();	
				$('#txt_username').keypress(function(e){
				if(e.which==13 ){
					//alert("Enter");
					$('#txt_pwd').focus();
					
				}
				});
				$('#txt_pwd').keypress(function(ee){
				if(ee.which==13 ){
					//alert("Enter");
					$('#login').focus();
					
				}
				});
	});//function	
</script>

<body>

	
<header></header>


           <Br>   <Br>
<div class="container">

  <form id="signup"  name="signup"  method="post" >
	<div class="header"><h3>Login ทรัพย์สิน</h3>
        <p>กรุณาใส่ Username และ  Password</p>
	</div>
    <div class="sep"></div>
	<div class="inputs">  
        <p><Br><Br>
        Username:&nbsp;
          <input type="text"   style="width:160px" id="txt_username" name="txt_username" />
          <Br>   <Br>
        Password:&nbsp;&nbsp; 
          <input type="password"  style="width:160px"  id="txt_pwd" name="txt_pwd" />
          
          
          <Br>   
      
     <Br>
          
        <div align="center">
		<input type="hidden" id="hd_cmd"  name="hd_cmd" />
        <input type="button" value="login" class="myButton_login" id="login" name ="login"/> 
		<input type="reset" value="reset" class="myButton_login" > 
		</div>
        
    </div>

    </form>
    
    
    
    

</div>



<br>


<br><br>
<div id="txt_search" align="center"></div>
<?php include 'report/footer.php'; ?></header>
        	
</body>
</html>
