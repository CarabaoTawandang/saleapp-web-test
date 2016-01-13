<?//---------------------------------แก้ไข โดย pong 03/07/2015-------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$sqlOpen="select st_item_product.* from st_item_product";
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
        
        <h3>เพิ่มสินค้า</h3>
            
          <p>
		  <input type="button" value="ค้นหาสินค้า" id="btn_add" onclick="window.location='?page=from_item';"  class="inner_position_right">
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
<form  method="post" name="frmuser" id="frmuser" enctype="multipart/form-data" action="?page=save_item_product" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2"  ><div class="h_head"></div></td></tr>
<tr><td colspan="2" align="right">&nbsp;&nbsp;<B style="color:red;text-align:center;">เครื่องหมาย *  หมายถึงต้องใส่ข้อมูลในช่องนั้นด้วยคะ</B></td></tr>
<tr><td width="120"><B>ประเภทสินค้า</B></td><td>
	<select id="txt_type" name="txt_type"  style="width:170px;" required/>
	<option value="" > - เลือกประเภทสินค้า - </option>
	<?	$sql="SELECT prd_type_id,prd_type_nm  FROM st_item_type";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry);

		
			?>
			<option value="<?print $detail['prd_type_id']?>" >
			<?print $detail['prd_type_nm']?></option>
		
			<?
			}

		
	
	?>
	</select>
	&nbsp;<B style="color:red;text-align:center;">*</B>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>ชื่อสินค้า</B></td><td><input type="text" id="txtITEM" name="txtITEM" required/>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>ชื่อย่อสินค้า</B></td><td><input type="text" id="txtITEM_" name="txtITEM_" ></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>รหัสสินค้า</B></td><td><input type="text" id="P_code" name="P_code" required/>&nbsp;<B style="color:red;text-align:center;">ห้ามซ้ำและห้ามแก้ไข</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td><B>กลุ่มสินค้า</B></td><td>
	<select id="txt_group" name="txt_group"  style="width:140px;" required/>
	<option value="" > - เลือกกลุ่มสินค้า - </option>
	<?	$sql="select prd_grp_id,prd_grp_nm from st_item_group";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry);

		
			?>
			<option value="<?print $detail['prd_grp_id']?>" ><?print $detail['prd_grp_nm']?></option>
		
			<?
			}

		
	
	?>
	</select>
	&nbsp;<B style="color:red;text-align:center;">*</B>
	</td></tr><tr><td colspan="2">&nbsp;</td></tr>
<tr><td><B>หน่วย</B></td><td>
	<select id="txt_unit" name="txt_unit"  style="width:110px;" required/>
	<option value="" > - เลือกหน่วย- </option>
	<?	$sql="select st_unit_id,st_unit_name from st_item_unit";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry);

		
			?>
			<option value="<?print $detail['st_unit_id']?>" ><?print $detail['st_unit_name']?></option>
		
			<?
			}

		
	
	?>
	</select>
	&nbsp;<B style="color:red;text-align:center;">*</B>
	</td></tr>
	</td></tr><tr><td colspan="2">&nbsp;</td></tr>
<tr><td><B>รูป</B></td><td><input type="file" id="txt_file" name="txt_file"></td>
	<tr><td colspan="2">&nbsp;</td></tr>

<tr><td width="150"><B>หมายเหตุ</B></td><td><input type="text" id="txt_remark"align="center" name="txt_remark" size="35"></td></tr>
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
<tr><td colspan="2" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />
<input type="submit" id="save" name="save" value="save">			</tr>	
</table>
</form>
</div>
</div>
<div id="DivSave" ></div>
</body>
</html>