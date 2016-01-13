<?//------------------------------------------------------แก้ไข โดย DREAM&PONG 16/07/2558------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id				=	$_SESSION["USER_id"];	//รหัสพนักงาน
		$id=$_GET['id'];
		
		$sqlOpen="select * from st_item_product where P_Code='$id' ";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryOpen=sqlsrv_query($con,$sqlOpen,$params,$options);
		$re=sqlsrv_fetch_array($qryOpen);
		
		$sqlOpen2="select * from st_item_price where P_Code='$id' ";
		$qryOpen2=sqlsrv_query($con,$sqlOpen2,$params,$options);
		$re2=sqlsrv_fetch_array($qryOpen2);
		
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>


<script type="text/javascript">
$(function(){	
			
		$('#save').button();
		$('#add').button();
		
	
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
	<div class="header"><h3>แก้ไขสินค้า&nbsp;<?=$re['PRODUCTNAME'];?></h3><!---หัวเรื่องหลัก-->
           <p>&nbsp;</p><!---หัวเรื่องรอง-->
		   <h5><input type="button" value="ค้นหาสินค้า" id="add" onclick="window.location='?page=from_item';" class="inner_position_right" ></h5>
	</div><div class="sep"></div><br>
		<!---เนื้อหา-->
<form  method="post" name="frmuser" id="frmuser" action="?page=save_item_product&do=edit" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2"  ><div class="h_head"></div></td></tr>
<tr><td colspan="2" align="right">&nbsp;&nbsp;<B style="color:red;text-align:center;">เครื่องหมาย *  หมายถึงต้องใส่ข้อมูลในช่องนั้นด้วยคะ</B></td></tr>
<tr><td width="120"><B>ประเภทสินค้า</B></td><td>
	<select id="txt_type" name="txt_type"  style="width:170px;" required/>
	<option value="<?=$re['prd_type_id'];?>" ><?=$re['prd_type_nm'];?></option>
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
<tr><td width="120"><B>ชื่อสินค้า</B></td><td><input type="text" value="<?=$re['PRODUCTNAME'];?>" id="txtITEM" name="txtITEM" required/>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>ชื่อย่อสินค้า</B></td><td><input type="text" value="<?=$re['PRODUCTSHORTNAME'];?>" id="txtITEM_" name="txtITEM_" ></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="120"><B>รหัสสินค้า</B></td><td><input type="text"value="<?=$re['P_Code'];?>" id="P_code" name="P_code" disabled>&nbsp;<B style="color:red;text-align:center;">ห้ามซ้ำและห้ามแก้ไข</B></td></tr>
<input type="hidden"value="<?=$re['P_Code'];?>" id="code" name="code">
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td><B>กลุ่มสินค้า</B></td><td>
	<select id="txt_group" name="txt_group"  style="width:140px;" required/>
	<option value="<?=$re['prd_grp_id'];?>" > <?=$re['prd_grp_nm'];?> </option>
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
	<select id="txt_unit" name="txt_unit"  style="width:110px;" disabled >
	<option value="<?=$re['st_unit_id'];?>" > <?=$re['st_unit_id'];?> </option>

	</select>
	&nbsp;<B style="color:red;text-align:center;">*</B>
	</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>

<tr><td width="150"><B>หมายเหตุ</B></td><td><input value="<?=$re['Remark'];?>" type="text" id="txt_remark"align="center" name="txt_remark" size="35"></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td><B>บริษัท</B></td><td>
	<select id="txt_COMPANY" name="txt_COMPANY"  style="width:300px;">
	<?$company="SELECT COMPANYCODE,COMPANYNAME  FROM st_companyinfo_exp where COMPANYCODE='$re[COMPANYCODE]' ";
		$company=sqlsrv_query($con,$company,$params,$options);
		$company=sqlsrv_fetch_array($company);?>
	<option value="<?=$re['COMPANYCODE'];?>" > **<?=$company['COMPANYNAME'];?>** </option>
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
<input type="submit" id="save" name="save" value="save"></tr>	
</table>
</form>
</div> <!--/-box-->
</div> <!--/-container_box-->
<div id="DivSave" ></div>
</body>
</html>