<?//--------------------------------------DREAM&PONG 27/7/58
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$sqlOpen="SELECT * from st_item_product 
where prd_type_id ='S001'";
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

</head>
<body>
<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>เพิ่มข้อมูลโปรโมชั่นส่วนลด</h3>
            
          <p>
		  <input type="button" value="ค้นหาโปรโมชั่น" id="btn_add" onclick="window.location='?page=from_promotion';"  class="inner_position_right">
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
<form  method="post" name="frmuser" id="frmuser" action="?page=save_promotion" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2"  ><div class="h_head"></div></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" align="right">&nbsp;&nbsp;<B style="color:red;text-align:center;">เครื่องหมาย *  หมายถึงต้องใส่ข้อมูลในช่องนั้นด้วยคะ</B></td></tr>
<tr><td width="150"><B>ชื่อโปรโมชั่น</B></td><td><input type="text" id="txt_promotion" name="txt_promotion" size="50"required/>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>รายละเอียด</B></td><td><textarea type="text" id="detail" name="detail" rows="5" cols="52"> </textarea>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
	
	
	


<tr><td ><B>วันที่เริ่มต้น-สิ้นสุด</B></td><td><input type="text" id="txt_day" name="txt_day" required/>
&nbsp;<B>ถึง</B>&nbsp;<input type="text" id="txt_day1" name="txt_day1" required/>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>


<tr><td colspan="2">&nbsp;</td></tr>


	
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>DC</B></td>
<td><select id="DC" name="DC"  style="width:150px;" required >
	<option value="">--เลือก--</option>
	<?$sql2="select * from st_user_group_dc order by dc_groupid asc";
				$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$qry2	 = @sqlsrv_query($con,$sql2,$params,$options);				
			while($re2=sqlsrv_fetch_array($qry2))
			{
?>
<option value="<?=$re2['dc_groupid'];?>"><?=$re2['dc_groupname']; ?></option>
<? } ?>
	</select>&nbsp;<B style="color:red;text-align:center;">*</B></td>
	<tr><td colspan="2">&nbsp;</td></tr>
<tr><td ><B>ตำแหน่งที่ใช้</B></td><td>
<select id="txt_Role" name="txt_Role"  style="width:170px;"required>
	<option value="">-เลือกตำแหน่ง-</option>
	<?$sql="select  RoleName_Linename,RoleID_Lineid from st_user_rolemaster_detail";
		$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry);?>
			
			<option value="<?print $detail['RoleID_Lineid']?>" ><?print $detail['RoleName_Linename']?></option>
		<?
		}
		?>
			
</select>&nbsp;<B style="color:red;text-align:center;">*</B>			
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td ><B>สินค้าที่ร่วมรายการ</B>&nbsp;<B style="color:red;text-align:center;">*</B></td><td>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td ></td><td>
	<? 	
	$i=1;
		while($open1=sqlsrv_fetch_array($qryOpen)){ 
		$P_Code=$open1['P_Code'];
	?>
	<script type="text/javascript">
$(function(){	
			
		$('#save').button();
		$('#btn_add').button();
		$('#txt_day').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

                                                });
		$('#txt_day1').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

                                });
	var requiredCheckboxes = $(':checkbox[name="txtType[]"][required]');
	requiredCheckboxes.change(function(){
	if(requiredCheckboxes.is(':checked')) { requiredCheckboxes.removeAttr('required');}
	else {
            requiredCheckboxes.attr('required', 'required');
        }
    });//
	
	 $('#checkItem_<?=$P_Code;?>').change(function(){
	
		
		$("#count_<?=$P_Code;?>").prop("disabled", !$(this).is(':checked'));
					if(document.frmuser.count_<?=$P_Code;?>.disabled)
					{document.frmuser.count_<?=$P_Code;?>.value = "";
					}
					else {document.frmuser.count_<?=$P_Code;?>.value = "";}
				
				$("#discount_<?=$P_Code;?>").prop("disabled", !$(this).is(':checked'));
					if(document.frmuser.discount_<?=$P_Code;?>.disabled)
					{document.frmuser.discount_<?=$P_Code;?>.value = "";
					}
					else {document.frmuser.discount_<?=$P_Code;?>.value = "";}
					
					
			
	});
		
});//function		
</script>

<table border="0">
<tr>
<td width="200"><input type="checkbox" id="checkItem_<?=$P_Code;?>" name="checkItem_<?=$P_Code;?>" value="<?=$P_Code;?>" /><?=$open1['PRODUCTNAME'];?> </td>

	<td width="250">จำนวนเริ่มต้นที่&nbsp;&nbsp;<input type="text" id="count_<?=$P_Code;?>" name="count_<?=$P_Code;?>" size="10" disabled="" onKeyUp="if(this.value*1!=this.value) this.value='' ;" >&nbsp;<?=$open1['st_unit_id'];?></td>
	<td width="200">ลดไป&nbsp;&nbsp;<input type="text" id="discount_<?=$P_Code;?>" name="discount_<?=$P_Code;?>" size="10" disabled="" onKeyUp="if(this.value*1!=this.value) this.value='' ;">&nbsp;บาท</td>
</tr>

	<? $i++;} ?>
</table>	
</tr></td>
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
	<tr><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" /><input type="submit" id="save" name="save" value="save">
</td></tr>	



</table >
</form>
</div>
</div>
<div id="DivSave" ></div>
</body>
</html>