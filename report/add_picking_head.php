<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		
		$USER_id=	$_SESSION["USER_id"];	//รหัสพนักงาน
		 $RoleID =$_SESSION["RoleID"];
		
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
$(function()
{	
			
		$('#save').button();$('#btn').button();
		
		$('#txt_date').datepicker({
			
				dateFormat:'dd-mm-yy'
			});
	var requiredCheckboxes = $(':checkbox[name="txtType[]"][required]');
	requiredCheckboxes.change(function(){
	if(requiredCheckboxes.is(':checked')) { requiredCheckboxes.removeAttr('required');}
	else {
            requiredCheckboxes.attr('required', 'required');
        }
    });//
	
	$('#txt_typePro').change(function(){
				$('#show_product').html("<img src='images/89.gif'>");
				$.ajax({
					url:'report/show_product.php',
					type:'POST',
						data:$('#frmuser').serialize(),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#show_product').html(result);
					}
				});
	});	
	$('#txt_location').change(function(){
				$('#show_product').html("<img src='images/89.gif'>");
				$.ajax({
					url:'report/show_product.php',
					type:'POST',
						data:$('#frmuser').serialize(),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#show_product').html(result);
					}
				});
	});	
		
		
});//function	
</script>
</head>
<body>
<div class="container_box">
    <div id="box">
	<div class="header"><h3>บันทึกจ่ายของเข้ารถ</h3><!---หัวเรื่องหลัก-->
           <p>&nbsp;</p><!---หัวเรื่องรอง-->
		   
		   <input type="button" value="ข้อมูลจ่ายของเข้ารถ" id="btn" onclick="window.location='?page=data_picking_head';" class="inner_position_right" >
	</div><div class="sep"></div><br>
<form  method="post" name="frmuser" id="frmuser" action="?page=save_picking_head" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>วันที่จ่ายของเข้ารถ</B></td>
	<td ><input type="text" id="txt_date" name="txt_date" required/><input type="hidden" id="picking" name="picking" value="picking">
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td ><B>จ่ายให้ :  </B></td><td>
	<select  id="txt_packName" name="txt_packName" style="width:170px;" required/>
	<option value="">-เลือกพนักงานขาย-</option>
		<? $sqlOp="select st_user_lv_Detail.user_id_head
			,st_user_lv_Detail.user_id_detail
			,st_user.*
			from st_user_lv_Detail left join st_user
			on st_user_lv_Detail.user_id_detail = st_user.User_id
			where  st_user_lv_Detail.user_id_head ='$USER_id' 
			order by st_user.Salecode asc";
			$qryOp=sqlsrv_query($con,$sqlOp,$params,$options);
			while($deOp=sqlsrv_fetch_array($qryOp)){
			echo "<option value='".$deOp['user_id_detail']." '>";
			echo $deOp['Salecode']." ".$deOp['name']." ".$deOp['surname'];
			echo "</option>";
			}
		?>
	</select>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td ><B>จ่ายจากคลัง</B></td><td>
	<select id="txt_location" name="txt_location"  style="width:170px;" required/>
	<option value="" > - เลือกคลังสินค้า - </option>
	<?	$sql="select st_user.warehouse_locationNo
,st_warehouse_location.locationname
from st_user  left join st_warehouse_location
on st_user.warehouse_locationNo = st_warehouse_location.locationno
where st_user.User_id='$USER_id'   ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry);

		
			?>
			<option value="<?print $detail['warehouse_locationNo']?>" ><?print $detail['locationname']?></option>
		
			<?
			}

		
	
	?>
	</select>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>

<tr><td ><B>ประเภทสินค้า :  </B></td><td>
	<select  id="txt_typePro" name="txt_typePro" style="width:170px;" required/>
	<option value="">-เลือกประเภทสินค้า-</option>
		<?  $sqlOp="select prd_type_id,prd_type_nm
			from st_item_type
			order by prd_type_nm asc";
			$qryOp=sqlsrv_query($con,$sqlOp,$params,$options);
			while($deOp=sqlsrv_fetch_array($qryOp)){
			echo "<option value='".$deOp['prd_type_id']." '>";
			echo $deOp['prd_type_nm'];
			echo "</option>";
			}
		?>
	</select>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td ><B>สินค้า </B></td>
<td><div id="show_product">
<?			$sql="SELECT P_Code,PRODUCTNAME  FROM st_item_product ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry); $P_Code=$detail['P_Code'];
			
		
?>
	
		
				
				<input type="hidden" id="checkItem_<?=$P_Code;?>" name="checkItem_<?=$P_Code;?>" value="<?print $P_Code;?>" >
				<? 		$sql2="  select st_unit_id,st_unit_name,P_Code
								  from st_item_unit_con
								  where P_Code ='$detail[P_Code]' order by st_unit_id asc ";
								$qry2=sqlsrv_query($con,$sql2,$params,$options);
								while($re2=sqlsrv_fetch_array($qry2)){
								
						?>
						<input type="hidden" id="NumP_<?=$P_Code;?>_U_<?=$re2['st_unit_id']?>" name="NumP_<?=$P_Code;?>_U_<?=$re2['st_unit_id']?>" size="5">
						<?}//while ?>
	
<?}?>
</div></td>

		

				
		
</td></tr><tr><td colspan="2">&nbsp;</td></tr>

<tr><td ><B>หมายเหตุ</B></td>
	<td colspan="1"><input type="text" id="txt_receive_Remark" name="txt_receive_Remark" size="70">
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