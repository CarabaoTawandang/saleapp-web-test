<?//	//------------------------------------------------------------------สร้างโดย Numphung(น้ำผึ้ง) ปี2557
include("includes/config.php");

	if($_POST["hd_cmd"]=="LoginSys")
	{		
		$pwd = base64_encode(trim($_POST["txt_pwd"]));
		$username	= trim($_POST['txt_username']);
		$number		=	trim($_POST['number']);
		//print $username.$pwd.$number;
		$sql2="SELECT  *  ";
		$sql2.="FROM st_user  ";
		 $sql2.="where User_name='$username' and User_Pass='$pwd'  ";
		 $sql2;
		
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qry2=sqlsrv_query($con,$sql2,$params,$options);
		$row2=sqlsrv_num_rows($qry2);	
		$detail2=sqlsrv_fetch_array($qry2);
		if($row2>=1)
		{//	$sql3="Update Mkt_user SET ";
			$_SESSION["USER_name"] = $detail2['User_name'];		//username เข้าระบบ
			$_SESSION["NAME"]=$detail2['name'];			//ชื่อของUser
			$_SESSION["USER_id"]=$detail2['User_id'];			//รหัสทส(  ทีม)
			$_SESSION["USER_TYPE"] = $detail2['User_Type'];		//user/admin
			$_SESSION["RoleID"] = $detail2['RoleID'];		//ตำแหน่ง
			
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
		<?}//else 
		//  print $sql2;
	}
	if($_POST["hd_cmd"]=="สมัครUser")
	{		
	?>
				<script type='text/javascript'>
					location='add_userOut.php';
				</script>
	<?
	}
	?>
<script type="text/javascript">
				
				
		function valid()
		{document.getElementById("hd_cmd").value ="LoginSys";
		//alert (document.getElementById("hd_cmd").value);
		var frm = document.getElementById("frm_login").submit();
		}
		
		function valid2()
		{document.getElementById("hd_cmd").value ="สมัครUser";
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
			
				<input id="txt_username" name="txt_username" type="text"   size="20"  value=""/></td>
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
			<td align="center">
			<input type="hidden" id="hd_cmd"  name="hd_cmd" />
				
				<input id="btn_login" name="btn_login" type="button" value="Login"  onclick="valid()"/> 
				<input id="btn_reset" name="btn_reset" type="reset" value="Reset" />
				<input id="btn_addUser" name="btn_addUser" type="button" value="สมัครUser" onclick="valid2()"/>						
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
<td align="center" style="color:#CCC;text-align:center;"> Verion 1 <br>@2558  Updated on 27 พฤษภาคม  2558</td>
</tr>
</table>
	