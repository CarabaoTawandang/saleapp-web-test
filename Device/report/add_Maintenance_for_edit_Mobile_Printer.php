<?//---------------------------------แก้ไข โดย pong 17/09/2015-------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		
		$id=$_GET['id'];
		
		$OPEN="select *from st_Device_Mobile_Printer where Mac ='$id'  ";
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

		$('#Date_receiver1').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

                                });
	
		

	
		$('#mac').ready(function(){
				$('#mac_show').html("<img src='../images/89.gif'>");
				$.ajax({
					url:'report/mac_show.php',
					type:'POST',
						data:$('#frmuser').serialize(),
				
					success:function(result){
						$('#mac_show').html(result);
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
<form  method="post" name="frmuser" id="frmuser" action="?page=save_Maintenance_for_edit_Mobile_Printer" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2" align="right">&nbsp;&nbsp;<B style="color:red;text-align:center;">เครื่องหมาย *  หมายถึงต้องใส่ข้อมูลในช่องนั้นด้วยคะ</B></td></tr>
<tr><td width="150"><B>อุปกรณ์</B></td>
<td><select id="Equipment" name="Equipment"  style="width:150px;" disabled>
	<option value="MP">Mobile Printer</option>
	</select>
	<tr><td colspan="2">&nbsp;</td></tr>

<table id="MP" name="MP"  border="0" align="center"  class="box" width="1124px">

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>รหัส Mac</B></td><td>
<input value="<?=$OPEN['Mac'];?>" id="mac" name="mac"  style="width:200px; background-color:#EDEDED;" readonly>

</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>รหัส Serial number</B></td><td><text id="mac_show" name="mac_show"></text></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>การซ่อม</B></td><td>

<select id="Category1" name="Category1"  style="width:200px;" >
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
<tr><td width="150"><B>คำอธิบาย</B></td><td><textarea rows="4" cols="50" type="text" id="Description1" name="Description1"  ></textarea></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>สถานะ</B></td><td>

<select id="Status1" name="Status1"  style="width:200px;" >
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
<tr><td width="150"><B>ค่าซ่อม</B></td><td><input type="text" id="Cost1" name="Cost1" class="M" onKeyUp="if(this.value*1!=this.value) this.value='' ;" ></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>วันที่ส่งซ่อม</B></td><td><input type="text" id="Date_receiver1" name="Date_receiver1" class="M" ></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>

</table>

	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />
<input type="submit" id="save" name="save" value="save">
<input type="button" value="cancel" id="cancel" onclick="window.location='?page=edit_Mobile_Printer&id=<?=$id;?>';" ></tr>	
</table>
</form>
</div>
</div>
<div id="DivSave" ></div>
</body>
</html>