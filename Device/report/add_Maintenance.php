<?//---------------------------------แก้ไข โดย pong 17/09/2015-------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
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
		$('#Date_receiver1').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

                                });
			
		$("#Equipment").click(function(){
		 if($('#Equipment').val() == 'TL') {
            $('#TL').show();
			$("input.T").removeAttr("disabled");
			$('#Category').removeAttr("disabled");
			$('#Status').removeAttr("disabled");
			$('#Description').removeAttr("disabled");
			$('#IMEI').removeAttr("disabled");
        } else {
            $('#TL').hide();
			$("input.T").attr("disabled", true);
			$('#Category').attr("disabled", true);
			$('#Status').attr("disabled", true);	
			$('#Description').attr("disabled", true);
			$('#IMEI').attr("disabled", true);
        } 
		});
		
		$("#Equipment").click(function(){
		 if($('#Equipment').val() == 'MP') {
            $('#MP').show();
			$("input.M").removeAttr("disabled");
			$('#Category1').removeAttr("disabled");
			$('#Status1').removeAttr("disabled");	
			$('#Description1').removeAttr("disabled");
			$('#mac').removeAttr("disabled");				
        } else {
            $('#MP').hide();
			$("input.M").attr("disabled", true);	
			$('#Category1').attr("disabled", true);
			$('#Status1').attr("disabled", true);
			$('#Description1').attr("disabled", true);		
			$('#mac').attr("disabled", true);			
        } 
		});
		
		$('#IMEI').change(function(){
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
	
		$('#mac').change(function(){
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
<form  method="post" name="frmuser" id="frmuser" action="?page=save_Maintenance" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2" align="right">&nbsp;&nbsp;<B style="color:red;text-align:center;">เครื่องหมาย *  หมายถึงต้องใส่ข้อมูลในช่องนั้นด้วยคะ</B></td></tr>
<tr><td width="150"><B>อุปกรณ์</B></td>
<td><select id="Equipment" name="Equipment"  style="width:150px;" required>
	<option value="">--เลือก--</option>
	<option value="TL">Tablet</option>
	<option value="MP">Mobile Printer</option>
	</select>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr> 
	<tr><td colspan="2">&nbsp;</td></tr>
<table hidden id="TL" name="TL"  border="0" align="center"  class="box" width="1124px" >
<tr><td colspan="2">&nbsp;</td></tr>

<tr><td width="120"><B>รหัส IMEI</B></td><td>
<select id="IMEI" name="IMEI"  style="width:200px;" disabled required>
<option value="">--เลือก--</option>
	<?$sql2="select imei from st_device_tablet_detail  ";
				$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$qry2	 = @sqlsrv_query($con,$sql2,$params,$options);				
			while($re2=sqlsrv_fetch_array($qry2))
			{
?>
<option value="<?=$re2['imei'];?>"><?=$re2['imei']; ?></option>
<? } ?>
	</select>
&nbsp;<B style="color:red;text-align:center;">*</B>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>รหัส Serial number</B></td><td><text id="emi_show" name="emi_show"></text></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>การซ่อม</B></td><td>

<select id="Category" name="Category"  style="width:200px;" disabled >
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
<tr><td width="150"><B>คำอธิบาย</B></td><td><textarea rows="4" cols="50" type="text" id="Description" name="Description" disabled  ></textarea></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>สถานะ</B></td><td>

<select id="Status" name="Status"  style="width:200px;"disabled  >
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
<tr><td width="150"><B>ค่าซ่อม</B></td><td><input type="text" id="Cost" name="Cost" class="T" onKeyUp="if(this.value*1!=this.value) this.value='' ;" disabled ></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>วันที่ส่งซ่อม</B></td><td><input type="text" id="Date_receiver" name="Date_receiver" class="T" disabled ></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>

</table>
<table hidden id="MP" name="MP"  border="0" align="center"  class="box" width="1124px">

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>รหัส Mac</B></td><td>
<select id="mac" name="mac"  style="width:200px;" disabled required>
<option value="">--เลือก--</option>
	<?$sql2="select Mac from st_Device_Mobile_Printer  ";
				$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$qry2	 = @sqlsrv_query($con,$sql2,$params,$options);				
			while($re2=sqlsrv_fetch_array($qry2))
			{
?>
<option value="<?=$re2['Mac'];?>"><?=$re2['Mac']; ?></option>
<? } ?>
	</select>
&nbsp;<B style="color:red;text-align:center;">*</B>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>รหัส Serial number</B></td><td><text id="mac_show" name="mac_show"></text></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>การซ่อม</B></td><td>

<select id="Category1" name="Category1"  style="width:200px;" disabled>
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
<tr><td width="150"><B>คำอธิบาย</B></td><td><textarea rows="4" cols="50" type="text" id="Description1" name="Description1" disabled ></textarea></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>สถานะ</B></td><td>

<select id="Status1" name="Status1"  style="width:200px;"disabled >
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
<tr><td width="150"><B>ค่าซ่อม</B></td><td><input type="text" id="Cost1" name="Cost1" class="M" onKeyUp="if(this.value*1!=this.value) this.value='' ;" disabled></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>วันที่ส่งซ่อม</B></td><td><input type="text" id="Date_receiver1" name="Date_receiver1" class="M" disabled></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>

</table>

	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />
<input type="submit" id="save" name="save" value="save">
<input type="button" value="cancel" id="cancel" onclick="window.location='?page=from_asset#tabs-3';" ></tr>	
</table>
</form>
</div>
</div>
<div id="DivSave" ></div>
</body>
</html>