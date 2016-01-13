<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id				=	$_SESSION["USER_id"];	//รหัสพนักงาน
		$id=$_GET['id'];
		
		$sqlOpen="select * from st_warehouse_location where locationno='$id'";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryOpen=sqlsrv_query($con,$sqlOpen,$params,$options);
		//$rowOpen=sqlsrv_num_rows($qryOpen);
		$re=sqlsrv_fetch_array($qryOpen)
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
	<div class="header"><h3>แก้ไขคลังสินค้า <?=$id;?> </h3><!---หัวเรื่องหลัก-->
           <p>
		    <input type="button" value="ค้นหาคลังสินค้า" id="btn" onclick="window.location='?page=from_warehouse_location';" class="inner_position_right" >
		   </p><!---หัวเรื่องรอง-->
		   
	</div><div class="sep"></div>
		<!---เนื้อหา-->
<form  method="post" name="frmuser" id="frmuser" action="?page=save_warehouse_location&do=edit" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>ชื่อคลัง</B></td><td><input type="text" value="<?=$re['locationname'];?>" id="txt_locationname" name="txt_locationname" style="width:300px;" required/>
&nbsp;<B style="color:red;text-align:center;">*</B>
</td></tr>
<tr><td colspan="2">&nbsp;<input type="hidden" id="id_location" name="id_location" value="<?=$id;?>"></td></tr>
<tr><td width="120"><B>สาขาที่</B></td><td><input type="text" value="<?=$re['Branch'];?>" id="Branch" name="Branch" style="width:300px;" ></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>เลขกำกับภาษี</B></td><td><input type="text" value="<?=$re['Tax_ID'];?>" id="TAX" name="TAX" style="width:300px;" ></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>รายละเอียด</B></td><td><input type="text" value="<?=$re['Remark'];?>" id="txt_detail" name="txt_detail" style="width:300px;"></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>เบอร์โทร</B></td><td><input type="text" id="Phonenumber" name="Phonenumber" value="<?=$re['Phone'];?>" style="width:300px;" maxlength="10" onKeyUp="if(this.value*1!=this.value) this.value='' ;"></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>ที่อยู่ : </B></td><td>เลขที่ : &nbsp;<input type="text" id="AddressNum" name="AddressNum" value="<?=$re['AddressNum'];?>" style="width:100px;">&nbsp;&nbsp;หมู่ : &nbsp;<input type="text" id="AddressMu" name="AddressMu" value="<?=$re['AddressMu'];?>" style="width:100px;"></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120">&nbsp;</td><td>จังหวัด : <select style="width:150px;text-align:left;" id="txt_pro"  name="txt_pro" required>
				<?$province="SELECT * FROM dc_province where PROVINCE_CODE ='$re[PROVINCE_CODE]' ";
					$province=sqlsrv_query($con,$province,$params,$options);
					$province=sqlsrv_fetch_array($province);?>
				<option value="<?=$re['PROVINCE_CODE'];?>">-<?=$province['PROVINCE_NAME'];?>-</option>
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
			<?$amphur="SELECT * FROM dc_amphur where AMPHUR_CODE='$re[AMPHUR_CODE]' ";
					$amphur=sqlsrv_query($con,$amphur,$params,$options);
					$amphur=sqlsrv_fetch_array($amphur);?>
				<option value="<?=$re['AMPHUR_CODE'];?>">-<?=$amphur['AMPHUR_NAME'];?>-</option>
	        </select>
			
			ตำบล :<select style="width:150px;text-align:left;" id="txt_dis"  name="txt_dis" required>
			 <?$district="SELECT * FROM dc_district where DISTRICT_CODE='$re[DISTRICT_CODE]' ";
					$district=sqlsrv_query($con,$district,$params,$options);
					$district=sqlsrv_fetch_array($district);?>
				<option value="<?=$re['DISTRICT_CODE'];?>">-<?=$district['DISTRICT_NAME'];?>-</option>
			</select>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>

	<tr><td width="180"><B>รหัสคลังสินค้าAX</B></td><td><input type="text" value="<?=$re['locationAx'];?>" id="txt_AX" name="txt_AX" style="width:300px;"></td></tr>
</td></tr><tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="180"><B>ตัวย่อบัญชี</B></td><td><input type="text" value="<?=$re['Acc_Doc'];?>" id="txt_ACC" name="txt_ACC" style="width:300px;"></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td><B>บริษัท</B></td><td>
	<select id="txt_COMPANY" name="txt_COMPANY"  style="width:300px;">
	<?$company="SELECT COMPANYCODE,COMPANYNAME  FROM st_companyinfo_exp where COMPANYCODE='$re[Companyname]' ";
		$company=sqlsrv_query($con,$company,$params,$options);
		$company=sqlsrv_fetch_array($company);?>
	<option value="<?=$re['Companyname'];?>" > **<?=$company['COMPANYNAME'];?>** </option>
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
</div><!--/-box-->
</div><!--/-container_box-->
<div id="DivSave" ></div>
</body>
</html>
