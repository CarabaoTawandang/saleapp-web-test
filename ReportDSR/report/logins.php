
<?//	include("includes/config3.php");
include("includes/config.php");

	if($_POST["hd_cmd"]=="LoginSys")
	{		
		$pwd = base64_encode(trim($_POST["txt_pwd"]));
		
	
		
		$username	= trim($_POST['txt_username']);
		$number		=	trim($_POST['number']);
		
		

		
		//print $username.$pwd.$number;
		
		
		  $sql2="SELECT  user_name,t_group  ";
		  $sql2.="FROM  login_username  ";
		  $sql2.="where user_name='$username' and password='$pwd'  and status='Y' ";
		  $params = array();
				$options=  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$qry2=sqlsrv_query($con,$sql2,$params,$options);


				$row2=sqlsrv_num_rows($qry2);
				
				$detail2=sqlsrv_fetch_array($qry2);
				
				if($row2>=1){
				
			//	$sql3="Update Mkt_user SET ";
				
				$_SESSION["_USER_ID"] = $detail2['user_name'];
				//$_SESSION["_USER_LEVEL"]=$detail2['User_level'];
				$_SESSION["_USER_TYPE"] = $detail2['t_group'];
				
				
				
		
				
			//	$url ='index.php';
				?>
					
					<script type='text/javascript'>
					location='index.php';
				</script>
				<?
				//location="login/from_login.php";
				
				
					?>
			
				<?
				

				
				}//if row
				
				else{?>
				<script type="text/javascript">
					alert("ตรวจสอบชื่อผู้ใช้และรหัสชื่อผู้ใช้งานใหม่");
				</script>
				
				<?
				}//else 
				
		//  print $sql2;
		
		
		
	}

?>
<script type="text/javascript">
				
				
			function valid()
		{
		
				document.getElementById("hd_cmd").value ="LoginSys";
				//alert (document.getElementById("hd_cmd").value);
				var frm = document.getElementById("frm_login").submit();

		
			
	 }	
				
			$(function(){	
				$('#txt_username').keypress(function(e){
				
				if(e.which==13 ){
					//alert("Enter");
					$('#txt_pwd').focus();
					
				}
				
			});
			
			});
				
</script>
<?//print $pwd = base64_encode ("usertel");?>


<form action="" method="post" name="frm_login" id="frm_login" >
<table cellpadding="1" cellspacing="1" width="10%" border="0"  align="center">
<tr>
	<td align="center"  width="50px" >		
	<img src="./images/c2.jpg" width='380' height='140'    />
		<!--<img src="./images/login.bmp" />-->
		
	<!--EDIT BY TOM	<fieldset style="width:280px;">	 -->
      <fieldset style="width:350px;"  >			
  
		<legend style="color:#006400;text-align:center;font-weight:bold;">Login : </legend>

		<table cellpadding="1" cellspacing="1" border="0">
		<tr>
			<td style="color:#006400;text-align:center;font-weight:bold;font-weight:bold;" >Username : </td>
			
			<td>
			
				<input id="txt_username" name="txt_username" type="text"   size="20"  value=" "/></td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td style="color:#006400;text-align:center;font-weight:bold;" >Password : </td>
			
			<td>
				<input id="txt_pwd" name="txt_pwd" type="password"  size="20"  ></td>
		</tr>
			<tr><td colspan="2">&nbsp;</td></tr>

			<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			<input type="hidden" id="hd_cmd"  name="hd_cmd" />
				
				<input id="btn_login" name="btn_login" type="button" value="Login"  onclick="valid()"/> 
				<input id="btn_reset" name="btn_reset" type="reset" value="Reset" />					
			</td>
		<!--	<td>
			<a href="" id="btSend">Login</a>
			<a href="" id="btn_reset" type="reset"    value="Reset">Reset</a>
			</td>-->
		</tr>

		</table>
		</fieldset>		
	</td>
</tr>

</table>
</form>

<table cellpadding="1" cellspacing="1" width="380px" border="0" align="center">
<tr>
<td align="center" style="color:#CCC;text-align:center;"> @2015  Updated on 27 August 2015</td>
</tr>
</table>