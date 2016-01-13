<?//---------------------------------แก้ไข โดย pong 17/09/2015-------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$id=$_GET['id'];
		
		$OPEN="select *from st_device_tablet_detail where imei ='$id'  ";
		$OPEN=sqlsrv_query($con,$OPEN,$params,$options);
		$OPEN=sqlsrv_fetch_array($OPEN);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
$(function(){	
			
		$('#save').button();
		$('#cancel').button();
		$('#btn_back').button();
	var requiredCheckboxes = $(':checkbox[name="txtType[]"][required]');
	requiredCheckboxes.change(function(){
	if(requiredCheckboxes.is(':checked')) { requiredCheckboxes.removeAttr('required');}
	else {
            requiredCheckboxes.attr('required', 'required');
        }
    });//
		$('#Date_receiver').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

                                });
	
	
		$('#IMEI').ready(function(){
				$('#emi_show').html("<img src='../images/89.gif'>");
				$.ajax({
					url:'report/emi_show.php',
					type:'POST',
						data:$('#frmuser').serialize(),
				
					success:function(result){
						$('#emi_show').html(result);
					}
				});
	});
	
		
		
		});//function	
</script>
</head>
<body>
<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>เพิ่มรายการซ่อมบำรุง</h3>
            
          <p>
		
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
<form  method="post" name="frmuser" id="frmuser" action="?page=save_Maintenance_for_edit_tablet" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>อุปกรณ์</B></td>
<td><select id="Equipment" name="Equipment"  style="width:150px;" disabled>
	<option value="TL">Tablet</option>

	</select></td></tr> 
	<tr><td colspan="2">&nbsp;</td></tr>
<table id="TL" name="TL"  border="0" align="center"  class="box" width="1124px" >
<tr><td colspan="2">&nbsp;</td></tr>

<tr><td width="120"><B>รหัส IMEI</B></td><td>
<input value="<?=$OPEN['imei'];?>" id="IMEI" name="IMEI"  style="width:200px; background-color:#EDEDED;" readonly>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>รหัส Serial number</B></td><td><text id="emi_show" name="emi_show"></text></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>การซ่อม</B></td><td>

<select id="Category" name="Category"  style="width:200px;"  >
<option value="">--เลือก--</option>
	<?$sql2="select * from st_D_Maintenance_Category  ";
				$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$qry2	 = @sqlsrv_query($con,$sql2,$params,$options);				
			while($re2=sqlsrv_fetch_array($qry2))
			{
?>
<option value="<?=$re2['Category_ID'];?>"><?=$re2['Category_name']; ?></option>
<? } ?>
	</select></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>คำอธิบาย</B></td><td><textarea rows="4" cols="50" type="text" id="Description" name="Description"  ></textarea></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>สถานะ</B></td><td>

<select id="Status" name="Status"  style="width:200px;" >
<option value="">--เลือก--</option>
	<?$sql2="select * from st_D_Status  ";
				$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$qry2	 = @sqlsrv_query($con,$sql2,$params,$options);				
			while($re2=sqlsrv_fetch_array($qry2))
			{
?>
<option value="<?=$re2['Status_ID'];?>"><?=$re2['Status_NAME']; ?></option>
<? } ?>
	</select></td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>ค่าซ่อม</B></td><td><input type="text" id="Cost" name="Cost" onKeyUp="if(this.value*1!=this.value) this.value='' ;"></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>วันที่ส่งซ่อม</B></td><td><input type="text" id="Date_receiver" name="Date_receiver" ></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>

</table>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />
<input type="submit" id="save" name="save" value="save">
<input type="button" value="cancel" id="cancel" onclick="window.location='?page=edit_Tablet&id=<?=$id;?>';" ></tr>	
</table>
</form>
</div>
</div>
<div id="DivSave" ></div>
</body>
</html>