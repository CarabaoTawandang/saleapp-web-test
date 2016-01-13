<?//------------------------------------------------------แก้ไข โดย DREAM 23/07/2558------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id=$_SESSION["USER_id"];	//รหัสพนักงาน
		$id=$_GET['id'];
	
		$sqlOpen="select *from st_promotion_head where PromotionId ='$id'  ";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryOpen=sqlsrv_query($con,$sqlOpen,$params,$options);
		$pp=sqlsrv_fetch_array($qryOpen);
		
		$sqlOpen1="select *from st_promotion_detail where PromotionId ='$id' ";
		$qryOpen1=sqlsrv_query($con,$sqlOpen1,$params,$options);
		$pp_=sqlsrv_fetch_array($qryOpen1);
		
		$sqlOpen2="select *from st_companyinfo_exp where COMPANYCODE ='$pp[COMPANYCODE]' ";
		$qryOpen2=sqlsrv_query($con,$sqlOpen2,$params,$options);
		$company=sqlsrv_fetch_array($qryOpen2);
		
		$DC__="SELECT * from st_user_group_dc where dc_groupid='$pp[dc_groupid]' ";
		$DC__=sqlsrv_query($con,$DC__,$params,$options);
		$DC__=sqlsrv_fetch_array($DC__);
		
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
		$('#txt_day').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

                                                });
		$('#txt_day1').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

                                });		
		
		
		});//function	
</script>
</head>
<body>
<div class="container_box">
    <div id="box">
	<div class="header"><h3>แก้ไขโปรโมชั่นส่วนลด&nbsp;<?=$pp['PromotionName'];?></h3>
           <p>&nbsp;</p><!---หัวเรื่องรอง-->
		  <h5> <input type="button" value="ค้นหาโปรโมชั่น " id="add" onclick="window.location='?page=from_promotion';" class="inner_position_right" ></h5>
	</div><div class="sep"></div><br>
		<!---เนื้อหา-->
<form  method="post" name="frmuser" id="frmuser" action="?page=save_promotion&do=edit" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2"  ><div class="h_head"></div></td></tr>
<tr><td colspan="2" align="right">&nbsp;&nbsp;<B style="color:red;text-align:center;">เครื่องหมาย *  หมายถึงต้องใส่ข้อมูลในช่องนั้นด้วยคะ</B></td></tr>
<tr><td width="150"><B>ชื่อโปรโมชั่น</td><td><input type="text" id="txt_promotion" name="txt_promotion" value="<?=$pp['PromotionName'];?>" size="50" required/>&nbsp;<B style="color:red;text-align:center;">*</B></div></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>รายละเอียด</td><td><textarea type="text" id="detail" name="detail"  rows="5" cols="52"><?=$pp['PromotionRemark'];?> </textarea>&nbsp;</div><B style="color:red;text-align:center;">*</B></div></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>วันที่เริ่มต้น-สิ้นสุด</B></td><td><input type="text" id="txt_day" name="txt_day" value="<?=date_format($pp['DateBegin'],'Y/m/d');?>" required/>
&nbsp;<B>ถึง</B>&nbsp;<input type="text" id="txt_day1" name="txt_day1" value="<?=date_format($pp['DateEnd'],'Y/m/d');?>"  required/>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>DC</B></td>
<td>
	
<input value="<?=$DC__['dc_groupname'];?>" type="text" id="DC" name="DC" disabled></td>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td ><B>ตำแหน่งที่ใช้</B></td><td>
<select id="txt_Role" name="txt_Role"  style="width:170px;"required>
	<option value="<?=$pp['RoleID'];?>">**<?=$pp['RoleName'];?>**</option>
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
<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td ><B>สินค้าที่ร่วมรายการ</B>&nbsp;<B style="color:red;text-align:center;">*</B></td><td>
<tr><td ></td><td>
	<table >
<?$sqlOpen="SELECT * from st_item_product 
where prd_type_id ='S001'";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryOpen=sqlsrv_query($con,$sqlOpen,$params,$options);
		$rowOpen=sqlsrv_num_rows($qryOpen);
		$i=1;
		while($open1=sqlsrv_fetch_array($qryOpen)){ 
		$P_Code=$open1['P_Code'];
		$check_="SELECT * from st_promotion_detail where PromotionId ='$id'and P_Code_start='$pp_[P_Code_start]' ";
		$check=sqlsrv_query($con,$check_,$params,$options);
		$rowCheck=sqlsrv_num_rows($check);
		
		
		$ox="select *from st_promotion_detail where PromotionId ='$id' ";
		$ox=sqlsrv_query($con,$ox,$params,$options);
		$ox=sqlsrv_fetch_array($ox);
		?>
<script>
$(function(){
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
	});
	</script>
<tr>
	<?
		$sqlCheck="select * from st_promotion_detail where PromotionId='$id' and P_Code_start='$P_Code' ";
		$qryCheck=sqlsrv_query($con,$sqlCheck,$params,$options);
		$reCheck=sqlsrv_fetch_array($qryCheck);
		
	?>
<td width="200"><input type="checkbox" id="checkItem_<?=$P_Code;?>" name="checkItem_<?=$P_Code;?>" value="<?=$P_Code;?>" <?  if($reCheck['P_Code_start']){echo "checked";}?>/>
<?=$open1['PRODUCTNAME'];?> </td>

	<td width="250">จำนวนเริ่มต้นที่&nbsp;&nbsp;<input type="text" id="count_<?=$P_Code;?>" name="count_<?=$P_Code;?>" value="<?=$reCheck['QtyChk'];?>" size="10"  onKeyUp="if(this.value*1!=this.value) this.value='' ;" <? if(!$reCheck['P_Code_start']){echo'disabled=""';} ?>>&nbsp;<?=$open1['st_unit_id'];?></td>
	<td width="200">ลดไป&nbsp;&nbsp;<input type="text" id="discount_<?=$P_Code;?>" name="discount_<?=$P_Code;?>" value="<?=$reCheck['AmountChk'];?>" size="10"  onKeyUp="if(this.value*1!=this.value) this.value='' ;" <? if(!$reCheck['P_Code_start']){echo'disabled=""';} ?>>&nbsp;บาท</td>
</tr>


	<?$i++;}?>
</table></tr></td>	

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td><B>บริษัท</B></td><td>
	<select id="txt_COMPANY" name="txt_COMPANY"  style="width:300px;">
	<option value="<?=$company['COMPANYCODE'];?>">**<?=$company['COMPANYNAME'];?>**</option>
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
<input type="submit" id="save" name="save" value="save">&nbsp;&nbsp;</tr>	
<input type="hidden" id="ID_PRO" name="ID_PRO" value="<?=$pp['PromotionId'];?>">

</table>
</form>
</div> <!--/-box-->
</div> <!--/-container_box-->
<div id="DivSave" ></div>
</body>
</html>