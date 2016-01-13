<?
//------------------------------------------------------แก้ไข โดย DREAM  30/6/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id				=	$_SESSION["USER_id"];	
		$id=$_GET['id'];
		

		$sqlOpen="select *from dc_district where DISTRICT_ID='$id'";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryOpen=sqlsrv_query($con,$sqlOpen,$params,$options);
		//$rowOpen=sqlsrv_num_rows($qryOpen);
		$re=sqlsrv_fetch_array($qryOpen)

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<script type="text/javascript">
$(function(){	
			
		$('#btn_add').button();
	});//function	
</script>
<script type="text/javascript">
$(function(){	
			
		$('#save').button();
	
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
	<div class="header"><h3>แก้ไขข้อมูลตำบล<?=$re['DISTRICT_NAME'];?></h3><!---หัวเรื่องหลัก-->
           <p><!---หัวเรื่องรอง-->
		  		  <input type="button" value="ค้นหาตำบล" id="btn_add" onclick="window.location='?page=from_district';" align="center" class="inner_position_right" >
	</p>
	</div><div class="sep"></div><br>
		<!---เนื้อหา-->
<form  method="post" name="frmuser" id="frmuser" action="?page=save_district&do=edit" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2"  ><div class="h_head"> <input type="hidden" id="id_district" name="id_district" value="<?=$id;?>"></div></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>ชื่อตำบล</td><td><input type="text" value="<?=$re['DISTRICT_NAME'];?>" id="txt_districtname" name="txt_districtname" style="width:300px;" required/></td></tr>
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