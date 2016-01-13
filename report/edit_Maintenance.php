<?//---------------------------------แก้ไข โดย pong 17/09/2015-------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		
		$id=$_GET['id'];
		
		$OPEN="select *from st_D_Maintenance where ID_Maintenance ='$id'  ";
		$OPEN=sqlsrv_query($con,$OPEN,$params,$options);
		$OPEN=sqlsrv_fetch_array($OPEN);
		
		
		$c="select Category_name from st_D_Maintenance_Category where Category_ID='$OPEN[Category]' ";
		$c =sqlsrv_query($con,$c,$params,$options);
		$c=sqlsrv_fetch_array($c);
		
		$s="select  Status_NAME from st_D_Status where Status_ID='$OPEN[Status]' ";
		$s =sqlsrv_query($con,$s,$params,$options);
		$s=sqlsrv_fetch_array($s);
		
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
        } else {
            $('#TL').hide();
			$("input.T").attr("disabled", true);
			$('#Category').attr("disabled", true);
			$('#Status').attr("disabled", true);	
			$('#Description').attr("disabled", true);
        } 
		});
		
		$("#Equipment").ready(function(){
		 if($('#Equipment').val() == 'TL') {
            $('#TL').show();
			$('#Equipment').attr("disabled", true);
	
        } else {
            $('#TL').hide();
	
        } 
		});
		
		$("#Equipment").click(function(){
		 if($('#Equipment').val() == 'MP') {
            $('#MP').show();
			$("input.M").removeAttr("disabled");
			$('#Category1').removeAttr("disabled");
			$('#Status1').removeAttr("disabled");	
			$('#Description1').removeAttr("disabled");	
        } else {
            $('#MP').hide();
			$("input.M").attr("disabled", true);	
			$('#Category1').attr("disabled", true);
			$('#Status1').attr("disabled", true);
			$('#Description1').attr("disabled", true);			
        } 
		});
			
		
		
		$("#Equipment").ready(function(){
		 if($('#Equipment').val() == 'MP') {
            $('#MP').show();
			$('#Equipment').attr("disabled", true);
			
        } else {
            $('#MP').hide();
				
        } 
		});
		
		$('#edit_Check_TL').change(function(){
		if (this.checked) {

			$("input.T").removeAttr("disabled");
			$('#Category').removeAttr("disabled");
			$('#Status').removeAttr("disabled");
			$('#Description').removeAttr("disabled");	
		} else {

			$("input.T").attr("disabled", true);
			$('#Category').attr("disabled", true);
			$('#Status').attr("disabled", true);	
			$('#Description').attr("disabled", true);
		}
		});
		$('#edit_Check_MP').change(function(){
		if (this.checked) {

			$("input.M").removeAttr("disabled");
			$('#Category1').removeAttr("disabled");
			$('#Status1').removeAttr("disabled");	
			$('#Description1').removeAttr("disabled");	
		} else {

			$("input.M").attr("disabled", true);	
			$('#Category1').attr("disabled", true);
			$('#Status1').attr("disabled", true);
			$('#Description1').attr("disabled", true);	
		}
		});
		

		
		});//function	
</script>
</head>
<body>
<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>แก้ไขรายการซ่อมบำรุง&nbsp;<?=$OPEN['ID_Maintenance'];?></h3>
          
          <p>
		  <input type="button" value="ค้นหารายการซ่อมบำรุง" id="btn_back" onclick="window.location='?page=from_Maintenance';"  class="inner_position_right">
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
<form  method="post" name="frmuser" id="frmuser" action="?page=save_Maintenance&do=edit"  >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2" align="right">&nbsp;&nbsp;<B style="color:red;text-align:center;">เครื่องหมาย *  หมายถึงต้องใส่ข้อมูลในช่องนั้นด้วยคะ</B></td></tr>
<tr><td width="150"><B>อุปกรณ์</B></td>
<input type="hidden" value="<?=$OPEN['ID_Maintenance'];?>" id="ID_M" name="ID_M">  
<td><select id="Equipment" name="Equipment"  style="width:150px;" required>
	<option value="<?=$OPEN['Equipment'];?>"><?if($OPEN['Equipment']=="TL"){echo "Tablet";}else{echo "Mobile Printer";}?></option>
	<option value="TL">Tablet</option>
	<option value="MP">Mobile Printer</option>
	</select>
	<tr><td colspan="2">&nbsp;</td></tr>
<table hidden id="TL" name="TL"  border="0" align="center"  class="box" width="1124px" >
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>รหัส IMEI</B></td><td><input type="text" value="<?=$OPEN['IMEI']; ?>" id="IMEI" name="IMEI" class="T" disabled required/>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>รหัส Serial number</B></td><td><input type="text" value="<?=$OPEN['Serial_No']; ?>" id="Serial" name="Serial" class="T" disabled required/>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>การซ่อม</B></td><td>

<select id="Category" name="Category"  style="width:200px;" disabled >
<option value="<?=$OPEN['Category']; ?>"><?=$c['Category_name']; ?></option>
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
<tr><td width="150"><B>คำอธิบาย</B></td><td><textarea rows="4" cols="50" type="text"  id="Description" name="Description" disabled  ><?=$OPEN['Description']; ?></textarea></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>สถานะ</B></td><td>

<select id="Status" name="Status"  style="width:200px;"disabled  >
<option value="<?=$OPEN['Status']; ?>"><?=$s['Status_NAME']; ?></option>
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
<tr><td width="150"><B>ค่าซ่อม</B></td><td><input type="text" value="<?=$OPEN['Cost']; ?>" id="Cost" name="Cost" class="T" onKeyUp="if(this.value*1!=this.value) this.value='' ;" disabled ></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>วันที่ส่งซ่อม</B></td><td><input type="text" value="<?=date_format($OPEN['Date_receiver'],'d/m/Y');?>" id="Date_receiver" name="Date_receiver" class="T" disabled ></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="4"><input type="checkbox" id="edit_Check_TL" name="edit_Check_TL" >&nbsp;<b style="color:blue;text-align:center;">แก้ไข</b></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
</table>
<table hidden id="MP" name="MP"  border="0" align="center"  class="box" width="1124px">

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>รหัส Serial number</B></td><td><input type="text" value="<?=$OPEN['Serial_No']; ?>" id="Serial1" name="Serial1" class="M" disabled required/>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>การซ่อม</B></td><td>

<select id="Category1" name="Category1"  style="width:200px;" disabled>
<option value="<?=$OPEN['Category']; ?>"><?=$c['Category_name']; ?></option>
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
<tr><td width="150"><B>คำอธิบาย</B></td><td><textarea rows="4" cols="50" type="text"  id="Description1" name="Description1" disabled ><?=$OPEN['Description']; ?></textarea></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>สถานะ</B></td><td>

<select id="Status1" name="Status1"  style="width:200px;"disabled >
<option value="<?=$OPEN['Status']; ?>"><?=$s['Status_NAME']; ?></option>
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
<tr><td width="150"><B>ค่าซ่อม</B></td><td><input value="<?=$OPEN['Cost']; ?>" type="text" id="Cost1" name="Cost1" class="M" onKeyUp="if(this.value*1!=this.value) this.value='' ;" disabled></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>วันที่ส่งซ่อม</B></td><td><input value="<?=date_format($OPEN['Date_receiver'],'d/m/Y');?>" type="text" id="Date_receiver1" name="Date_receiver1" class="M" disabled></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="4"><input type="checkbox" id="edit_Check_MP" name="edit_Check_MP" >&nbsp;<b style="color:blue;text-align:center;">แก้ไข</b></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
</table>

	

<tr>
	<td colspan="2" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />
<input type="submit" id="save" name="save" value="save">
<input type="button" value="cancel" id="cancel" onclick="window.location='?page=from_Maintenance';" ></tr>	
</table>
</form>
</div>
</div>

</body>
</html>