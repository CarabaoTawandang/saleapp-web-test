<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
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
		$('#btn').button();
	var requiredCheckboxes = $(':checkbox[name="txtType[]"][required]');
	requiredCheckboxes.change(function(){
	if(requiredCheckboxes.is(':checked')) { requiredCheckboxes.removeAttr('required');}
	else {
            requiredCheckboxes.attr('required', 'required');
        }
    });//
	
		$('#txt_pro').change(function(){
				
				$.ajax({
					url:'report/aumphur.php',
					type:'POST',
					data:'value='+$('#txt_pro').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_aum').html(result);
					}
				});
			});		
				
						$('#txt_aum').change(function(){
				//$.getZipCode();
				$.ajax({
					url:'report/district.php',
					type:'POST',
					data:'value='+$('#txt_aum').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_dis').html(result);
					}
				});
			});	
			
		
		});//function	
</script>
</head>
<body>
<div class="container_box">
    <div id="box">
	<div class="header"><h3>เพิ่มคลังสินค้า</h3><!---หัวเรื่องหลัก-->
           <p>&nbsp;</p><!---หัวเรื่องรอง-->
		   <input type="button" value="ค้นหาคลังสินค้า" id="btn" onclick="window.location='?page=from_warehouse_location';" class="inner_position_right" >
	</div><div class="sep"></div>
		<!---เนื้อหา-->
<form  method="post" name="frmuser" id="frmuser" action="?page=save_warehouse_location" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2"  ><div class="h_head"></div></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>ชื่อคลัง</B></td><td><input type="text" id="txt_locationname" name="txt_locationname" style="width:300px;" required/>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>สาขาที่</B></td><td><input type="text" id="Branch" name="Branch" style="width:300px;" required/>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>เลขกำกับภาษี</B></td><td><input type="text" id="TAX" name="TAX" style="width:300px;" ></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>รายละเอียด</B></td><td><input type="text" id="txt_detail" name="txt_detail" style="width:300px;"></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>เบอร์โทร</B></td><td><input type="text" id="Phonenumber" name="Phonenumber" style="width:300px;" maxlength="10" onKeyUp="if(this.value*1!=this.value) this.value='' ;"></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>ที่อยู่ : </B></td><td>เลขที่ : &nbsp;<input type="text" id="AddressNum" name="AddressNum" style="width:100px;">&nbsp;&nbsp;หมู่ : &nbsp;<input type="text" id="AddressMu" name="AddressMu" style="width:100px;"></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120">&nbsp;</td><td>จังหวัด : <select style="width:150px;text-align:left;" id="txt_pro"  name="txt_pro" required>
				<option value="">-เลือก-</option>
				<?
				$sql3="SELECT * FROM dc_province  order by PROVINCE_NAME asc  ";
				$params = array();
				$options=  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$qry3=sqlsrv_query($con,$sql3,$params,$options);
				$row3=sqlsrv_num_rows($qry3);
				for($i=0;$i<$row3;$i+=1)
				{
				$detail3=sqlsrv_fetch_array($qry3);
				?>
				<option value="<?print $detail3['PROVINCE_CODE']?>"><?print $detail3['PROVINCE_NAME']   ?></option>
				<?}?>
			</select>
			อำเภอ : <select style="width:150px;text-align:left;" id="txt_aum"  name="txt_aum" required>
				<option value="">-เลือก-</option>
	        </select>
			ตำบล :<select style="width:150px;text-align:left;" id="txt_dis"  name="txt_dis" required>
			 <option value="">-เลือก-</option>
			</select>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="180"><B>รหัสคลังสินค้าAX</B></td><td><input type="text" id="txt_AX" name="txt_AX" style="width:300px;"></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="180"><B>ตัวย่อบัญชี</B></td><td><input type="text" id="txt_ACC" name="txt_ACC" style="width:300px;"></td></tr>
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
	</td></tr><tr><td colspan="2">&nbsp;</td></tr>
	
	<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />
<input type="submit" id="save" name="save" value="save">			</tr>	
</table>
</form>
</div><!--/-box-->
</div><!--/-container_box-->
<div id="DivSave" ></div>
</body>
</html>