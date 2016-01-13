<?//---------------------------------แก้ไข โดย pong 11/09/2015-------------------
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
		$('#Receive').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

                                });
			
	$('#dc').change(function(){
				$('#User_show').html("<img src='../images/89.gif'>");
				$.ajax({
					url:'report/User_show.php',
					type:'POST',
						data:$('#frmuser').serialize(),
				
					success:function(result){
						$('#User_show').html(result);
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
        
        <h3>เพิ่ม Tablet</h3>
            
          <p>
		  
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
<form  method="post" name="frmuser" id="frmuser" action="?page=save_Tablet" >
<table cellpadding="0" cellspacing="0"  border="0" align="center" width="1124px">

<tr><td colspan="4" align="right">&nbsp;&nbsp;<B style="color:red;text-align:center;">เครื่องหมาย *  หมายถึงต้องใส่ข้อมูลในช่องนั้นด้วยคะ</B></td></tr>
<tr><td colspan="4">&nbsp;</td></tr>

<tr>
<td width="120"><B>IMEI</B></td><td width="250"><input type="text" id="IMEI" name="IMEI" required/>&nbsp;<B style="color:red;text-align:center;">*</B></td>
<td width="120"><B>ยี่ห้อ</B></td><td><input type="text" id="Manufacturer" name="Manufacturer" ></td>
</tr>
<tr><td colspan="4">&nbsp;</td></tr>

<tr>
<td width="120"><B>Serial number</B></td><td><input type="text" id="Serial" name="Serial" required/>&nbsp;<B style="color:red;text-align:center;">*</B></td>
<td width="120"><B>ผู้จัดจำหน่าย</B></td><td><input type="text" id="Supplier" name="Supplier" >
</tr>
<tr><td colspan="4">&nbsp;</td></tr>
<tr>
<td width="120"><B>Serial Sim.</B></td><td><input type="text" id="SIM" name="SIM" ></td>
<td width="120"><B>RAM</B></td><td><input type="text" id="RAM" name="RAM" ></td>
</tr>
<tr><td colspan="4">&nbsp;</td></tr>
<tr>
<td width="120"><B>PO No.</B></td><td><input type="text" id="PO" name="PO" ></td>
<td width="120"><B>ROM</B></td><td><input type="text" id="Memory" name="Memory" ></td>
</tr>
<tr><td colspan="4">&nbsp;</td></tr>
<tr>
<td width="120"><B>Model</B></td><td><input type="text" id="Model_num" name="Model_num" ></td>
<td width="120"><B>Total ROM</B></td><td><input type="text" id="size_M" name="size_M" ></td>
</tr>
<tr><td colspan="4">&nbsp;</td></tr>
<tr>
<td width="120"><B>วันที่รับของ</B></td><td><input type="text" id="Receive" name="Receive" ></td>
<td width="120"><B>รับประกัน</B></td><td><input type="text" id="Warranty" name="Warranty" ></td>
</tr>
<tr><td colspan="4">&nbsp;</td></tr>
<tr>


<td width="120"><B>สถานะ</B></td><td>
<select id="status" name="status"  style="width:150px;" >
	<option value="">--เลือก--</option>
	<option value="Stand by">Stand by</option>
	<option value="In used">In used</option>
	<option value="Repair">Repair</option>
	<option value="Life off">Life off</option>
	<option value="Develop">Develop</option>
	<option value="Salestools">Salestools</option>
	<option value="Spare DC">Spare DC</option>
	</select>


</td>
</tr>


<tr><td colspan="4">&nbsp;</td></tr>
<tr>
<td width="120"><B>หมายเหตุ</B></td><td colspan="4"><textarea type="text" id="remark" name="remark" rows="3" cols="75"></textarea></td>

</tr>


	<tr><td colspan="4">&nbsp;</td></tr>
	<tr><td colspan="4">&nbsp;</td></tr>
<tr><td colspan="4" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />
<input type="submit" id="save" name="save" value="save">
<input type="button" value="cancel" id="cancel" onclick="window.location='?page=from_asset#tabs-1';" ></tr>	

</table>
</form>
</div>
</div>
</body>
</html>