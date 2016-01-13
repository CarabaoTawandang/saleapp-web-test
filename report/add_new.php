<?//--------------------------------------DREAM 10/7/58
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$sqlOpen="select  RoleName_Linename,RoleID_Lineid from st_user_rolemaster_detail";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryOpen=sqlsrv_query($con,$sqlOpen,$params,$options);
		$rowOpen=sqlsrv_num_rows($qryOpen);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
$(function(){	
			
		$('#save').button();
		$('#btn_add').button();
		$('#txt_day').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

                                                });
		$('#txt_day1').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

                                });
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

      <div class="header">
        
        <h3>เพิ่มข้อมูลข่าว</h3>
            
          <p>
		  <input type="button" value="ค้นหาข้อมูลข่าว" id="btn_add" onclick="window.location='?page=from_new';"  class="inner_position_right">
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
<form  method="post" name="frmuser" id="frmuser" action="?page=save_new" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>ชื่อเรื่อง</B></td><td><input type="text" id="txtnew" name="txtnew" style="width:300px;"  required/>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>

	
	
	
</td></tr>

<tr><td ><B>วันที่ของข่าว</B></td><td><input type="text" id="txt_day" name="txt_day" required/>
&nbsp;<B>ถึง</B>&nbsp;<input type="text" id="txt_day1" name="txt_day1" required/>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td ><B>รายละเอียด</B></td><td><textarea type="text" id="remark" name="remark" rows="5" cols="50"> </textarea>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>


	
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td ><B>ตำแหน่งที่ใช้ในการแจ้งข่าว</B></td><td>
	<? 	
	$i=1;
		while($open1=sqlsrv_fetch_array($qryOpen)){
	?>
	<input type="checkbox"  name="txtType[]" value="<?=$open1['RoleID_Lineid'];?>" /><?=$open1['RoleName_Linename'];?>
	<? $i++;} ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<B style="color:red;text-align:center;">*(เลือกได้มากกว่า1ประเภท)</B>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td><B>บริษัท</B></td><td>
<select id="txt_COMPANY" name="txt_COMPANY"  style="width:300px;">
	<?	$sql="SELECT COMPANYCODE,COMPANYNAME  FROM st_companyinfo_exp   ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry);

		
			?>
			<option value="<?print $detail['COMPANYCODE']?>" ><?print $detail['COMPANYNAME']?></option>
		
			<?
			}

		
	
	?>

	</select>&nbsp;<B style="color:red;text-align:center;">*</B>
	</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />
<input type="submit" id="save" name="save" value="save">			</tr>	
</table>
</form>
</div>
</div>
<div id="DivSave" ></div>
</body>
</html>