<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$sqlOpen="select cust_type_id,cust_type_name from st_cust_type";
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
		$('#btn').button();
	
	$('#txt_geo').change(function(){
				$('#txt_check').html("<img src='images/89.gif'>");
				$.ajax({
					url:'report/province.php',
					type:'POST',
					data:'value='+$('#txt_geo').prop('value'),
					//alert("phung");
					//data:{name:'1'}
					success:function(result){
						$('#txt_pro').html(result);
					}
				});
		});	
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
		$('#txt_aum').change(function(){
				//$.getZipCode();
				$.ajax({
					url:'report/zipcodes.php',
					type:'POST',
					data:'value='+$('#txt_aum').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						//alert(result);
						$('#txt_zip').prop('value',result);
					}
				});
			});
		$('#txt_aum').change(function(){
				//$.getZipCode();
				$.ajax({
					url:'report/zipcodes.php',
					type:'POST',
					data:'value='+$('#txt_aum').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						//alert(result);
						$('#txt_zip2').prop('value',result);
					}
				});
			});
		$('#txt_custType').change(function(){
				
				$.ajax({
					url:'report/custgroup.php',
					type:'POST',
					data:'value='+$('#txt_custType').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_custgroup').html(result);
					}
				});
		});
			
		$('#save').click(function(){
					/*alert('Test');*/
					 if($('#txt_custType').prop('value')=='')  {alert("โปรดใส่ประเภทร้าน  !"); }
					
					/*else if(($('#txt_custType').prop('value')!= 'V') && ($('#txt_custType').prop('value')!= 'S')
					&& ($('#txt_idCust').prop('value')== '')
					){alert("โปรดใส่รหัสร้าน !");}*/
					else if(
					(($('#txt_custType').prop('value')!= 'S')&& ($('#txt_idCust').prop('value')== ''))||(($('#txt_custType').prop('value')!= 'V')&& ($('#txt_idCust').prop('value')== ''))
					
					){alert("โปรดใส่รหัสร้าน !");}
					
					
					else if($('#txt_name').prop('value')=='')  {alert("โปรดใส่ชื่อร้าน !");}
					else if($('#txt_AddressNum1').prop('value')=='')  {alert("โปรดใส่บ้านเลขที่ !");}
					else if($('#txt_AddressMu').prop('value')=='')  {alert("โปรดใส่หมู่ที่ !");}
					else if($('#txt_geo').prop('value')=='')  {alert("โปรดใส่ภาค !");}
					else if($('#txt_pro').prop('value')=='')  {alert("โปรดใส่จังหวัด  !");}
					else if($('#txt_aum').prop('value')=='')  {alert("โปรดใส่อำเภอ  !"); }
					else if($('#txt_dis').prop('value')=='')  {alert("โปรดใส่ตำบล  !"); }
					
					
					else {
					$('#txt_check').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/save_cust.php',
						type:'POST',
						data:$('#frmuser').serialize(),
						success:function(result){
							$('#DivSave').html(result);
							}
							});
							
						}	
		});
		$('#txt_custType').change(function(){
				//alert($('#txt_custType').prop('value'));
				if(($('#txt_custType').prop('value')=='V')||($('#txt_custType').prop('value')=='S')||($('#txt_custType').prop('value')==''))
				{
				//alert("ok");
				$("#txt_idCust").prop("disabled", !$(this).is(':checked'));
				document.frmuser.txt_idCust.value = "";
				}
				else
				{
				//alert("No");
				$("#txt_idCust").prop("disabled", $(this).is(':checked'));
				}
					
				
   });
		
});//function	
</script>
</head>
<body>
<div class="container_box">
    <div id="box">
	<div class="header"><h3>เพิ่มร้านค้า</h3><!---หัวเรื่องหลัก-->
           <p>&nbsp;</p><!---หัวเรื่องรอง-->
		   <input type="button" value="ค้นหาร้านค้า" id="btn" onclick="window.location='?page=from_cust';" class="inner_position_right" >
	</div><div class="sep"></div>
		<!---เนื้อหา-->
<form  method="post" name="frmuser" id="frmuser" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2"  ><div class="h_head"></div></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>ประเภทร้าน  :</B></td><td>
	<select id="txt_custType" name="txt_custType"  style="width:170px;" required/>
	<option value="" > - เลือกประเภทร้านค้า - </option>
	<?	$sql="SELECT cust_type_id,cust_type_name  FROM st_cust_type";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry);

		
			?>
			<option value="<?print $detail['cust_type_id']?>" ><?print $detail['cust_type_name']?></option>
		
			<?
			}

		
	
	?>
	</select>
	<B style="color:red;text-align:center;">*</B>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>รูปแบบ  :</B></td><td>
	<select id="txt_custgroup" name="txt_custgroup"  style="width:170px;" required/>
	<option value="" > - select- </option>
	
	</select>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>รหัสร้านค้า</B></td><td><input type="text" id="txt_idCust" name="txt_idCust" style="width:300px;" disabled="" />
<B style="color:red;text-align:center;">* ประเภทร้านปลีกและร้านลูกซับไม่ต้องใส่</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>ชื่อร้านค้า</B></td><td><input type="text" id="txt_name" name="txt_name" style="width:300px;" required/>
<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>เบอร์โทร</B></td><td><input type="text" id="txt_Phone" name="txt_Phone" style="width:300px;"></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>บ้านเลขที่</B></td><td>
<input type="text" id="txt_AddressNum1" name="txt_AddressNum1" size="1" required/>&nbsp;/&nbsp;
<input type="text" id="txt_AddressNum2" name="txt_AddressNum2" size="1"><B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>หมู่</B></td><td><input type="text" id="txt_AddressMu" name="txt_AddressMu" size="5">
<B style="color:red;text-align:center;">*</B>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>ภาค : </B></td><td>
	<select id="txt_geo" name="txt_geo"  style="width:150px;" required/>
		<option value=""> - Selete -</option>
	<?	  $sql="select GEO_CODE,GEO_NAME
			from dc_geography ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j++){

		$detail=sqlsrv_fetch_array($qry);
			?>
			<option value="<?print $detail['GEO_CODE'];?>" ><?print $detail['GEO_NAME'];?></option>
		
			<?
			}

		
	
	?>
	</select>
	<B style="color:red;text-align:center;">*</B>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>จังหวัด : </B></td><td>
	<select id="txt_pro" name="txt_pro"   style="width:150px;" required/>
		<option value="" > - Selete -</option>
	</select>
	<B style="color:red;text-align:center;">*</B>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>อำเภอ / แขวง  :</B></td><td>
	<select id="txt_aum" name="txt_aum"   style="width:150px;" required/>
		<option value="" > - Selete -</option>
		<B style="color:red;text-align:center;">*</B>
	</select>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>ตำบล / แขวง  :</B></td><td>
	<select id="txt_dis" name="txt_dis"   style="width:150px;" required/>
		<option value="" > - Selete -</option>
	</select>
	<B style="color:red;text-align:center;">*</B>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>รหัสไปรษณีย์  :</B></td><td>
	<input id="txt_zip" name="txt_zip" type="text"   size="20"  value=""  disabled="disabled"  />
	<input id="txt_zip2" name="txt_zip2" type="hidden"   size="20"     />
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>latitude  :</B></td><td>
	<input id="txt_lat" name="txt_lat" type="text"   size="20"     />
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>longitude  :</B></td><td>
	<input id="txt_long" name="txt_long" type="text"   size="20"     />
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
	</select>
	</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" align="left" >
<input type="button" id="save" name="save" value="save">			</tr>	
</table>
</form>
</div><!--/-box-->
</div><!--/-container_box-->
<div id="DivSave" ></div>
</body>
</html>