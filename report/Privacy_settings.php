<?//------------------------------------------------------แก้ไข โดย PONG 24/06/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id=$_SESSION["USER_id"];	//รหัสพนักงาน

		$sqlOpen="select * from st_user where User_id='$USER_id'";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryOpen=sqlsrv_query($con,$sqlOpen,$params,$options);
		//$rowOpen=sqlsrv_num_rows($qryOpen);
		$re=sqlsrv_fetch_array($qryOpen);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>


<script type="text/javascript">
$(function(){	
			
		$('#save').button();
		$('#add').button();
		
	
	var requiredCheckboxes = $(':checkbox[name="txtType[]"][required]');
	requiredCheckboxes.change(function(){
	if(requiredCheckboxes.is(':checked')) { requiredCheckboxes.removeAttr('required');}
	else {
            requiredCheckboxes.attr('required', 'required');
        }
    });//
		
		
		});//function	
</script>
</head>
<body>
<div class="container_box">
    <div id="box">
	<div class="header"><h3>แก้ไขUser&nbsp;&nbsp;<?=$re['name'];?></h3><!---หัวเรื่องหลัก-->
          

<form  method="post" name="frmuser" id="frmuser" action="?page=save_privacysettings" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2"  ><div class="h_head"></div></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>รหัสผ่านเก่า</td><td><input type="password"  id="pass_old" name="pass_old" style="width:300px;" required/>
&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>รหัสผ่านใหม่</td><td><input type="password"  id="pass_new" name="pass_new" style="width:300px;" required/>
&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>ยืนยันรหัสผ่านใหม่</td><td><input type="password"  id="pass_complete" name="pass_complete" style="width:300px;" required/>
&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>ชื่อ</td><td><input type="text"  id="name_" name="name_" value="<?=$re['name'];?>" style="width:300px;" ></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>นามสกุล</td><td><input type="text" id="name_s" name="name_s" value="<?=$re['surname'];?>" style="width:300px;" ></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>


<tr><td colspan="2" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />
<input type="submit" id="save" name="save" value="save">			</tr>	
</table>
</form>
</div> <!--/-box-->
</div> <!--/-container_box-->
<div id="DivSave" ></div>
</body>
</html>