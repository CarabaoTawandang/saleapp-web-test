<?//------------------------------------------------------แก้ไข โดย DREAM 6/07/2558------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id				=	$_SESSION["USER_id"];	//รหัสพนักงาน
		$id=$_GET['id'];
		
		$sqlOpen="select * from st_item_unit where st_unit_id='$id'";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryOpen=sqlsrv_query($con,$sqlOpen,$params,$options);
		//$rowOpen=sqlsrv_num_rows($qryOpen);
		$re=sqlsrv_fetch_array($qryOpen);

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
	<div class="header"><h3>แก้ไขหน่วยของสินค้า&nbsp;<?=$id;?></h3><!---หัวเรื่องหลัก-->
        <p>&nbsp;</p><!---หัวเรื่องรอง-->
		<input type="button" value="ค้นหาหน่วยสินค้า" id="add" onclick="window.location='?page=from_item';" class="inner_position_right" >
	</div><div class="sep"></div>
		<!---เนื้อหา-->
<form  method="post" name="frmuser" id="frmuser" action="?page=save_item_unit&do=edit&id=<?=$re['st_unit_id'];?>" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>ชื่อหน่วยของสินค้า</td><td><input type="text" value="<?=$re['st_unit_name']; ?>" id="name_unit" name="name_unit" readonly required/>

</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="180"><B>หมายเหตุ</td><td><input type="text" value="<?=$re['Remark'];?>" id="remark" name="remark" style="width:300px;" ></td></tr>
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
	</select>&nbsp;<B style="color:red;text-align:center;">*</B>
	</td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />
<input type="submit" id="save" name="save" value="save">			</tr>	
</table>
</form>
</div> <!--/-box-->
</div> <!--/-container_box-->
<div id="DivSave" ></div>
</body>
</html>