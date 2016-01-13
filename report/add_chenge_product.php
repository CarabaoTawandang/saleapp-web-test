<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id=	$_SESSION["USER_id"];	//รหัสพนักงาน
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
		
		$('#txt_receive_date').datepicker({
			
				dateFormat:'dd-mm-yy'
			});
	var requiredCheckboxes = $(':checkbox[name="txtType[]"][required]');
	requiredCheckboxes.change(function(){
	if(requiredCheckboxes.is(':checked')) { requiredCheckboxes.removeAttr('required');}
	else {
            requiredCheckboxes.attr('required', 'required');
        }
    });//
	
	$('#txt_chenge').change(function(){
				//alert($('#txt_chenge').prop('value'));
				$('#show_Countproduct').html("<img src='images/89.gif'>");
				$.ajax({
					url:'report/show_countProduct1.php',
					type:'POST',
					//data:$('#frmuser').serialize(),
					data:'value='+$('#txt_chenge').prop('value'),
					
					//data:{name:'1'}
					success:function(data){
						$('#show_Countproduct1').html(data);
					}
				});
	});	
	$('#txt_receive').change(function(){
				$('#show_product').html("<img src='images/89.gif'>");
				$.ajax({
					url:'report/show_countProduct2.php',
					type:'POST',
					//data:$('#frmuser').serialize(),
					data:'value='+$('#txt_receive').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#show_product2').html(result);
					}
				});
	});	
	
		
});//function	
</script>
</head>
<body>
<div class="container_box">
    <div id="box">
	<div class="header"><h3>บันทึกเปลี่ยนของโรงงาน</h3><!---หัวเรื่องหลัก-->
           <p>&nbsp;</p><!---หัวเรื่องรอง-->
		   <input type="button" value="ข้อมูลเปลี่ยนของ" id="btn" onclick="window.location='?page=from_receive_head';" class="inner_position_right" >
	</div><div class="sep"></div><br>
<form  method="post" name="frmuser" id="frmuser" action="?page=save_receive_chenge" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>วันที่เปลี่ยนของ</B></td>
	<td ><input type="text" id="txt_receive_date" name="txt_receive_date" required/></td>
	
	</tr>
<tr><td colspan="2">&nbsp;</td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td ><B>สินค้าที่เปลี่ยน</B></td>
<td ><div  style="float:left">
	<select id="txt_chenge" name="txt_chenge"  style="width:170px;" required/>
	<option value="" > - เปลี่ยน - </option>
	<?	$sql="select st_user.warehouse_locationNo
		,st_warehouse_stock.*
		,st_item_product.PRODUCTNAME
		,st_item_product.st_unit_id
		,st_warehouse_location.locationname
		,A.st_unit_qty as A
		,B.st_unit_qty as B
		,st_warehouse_stock.stock_count/A.st_unit_qty as ToptalA
		, cast(st_warehouse_stock.stock_count as int) % cast(A.st_unit_qty as int) 
		,(cast(st_warehouse_stock.stock_count as int) % cast(A.st_unit_qty as int))/B.st_unit_qty as ToptalB
		,(cast(st_warehouse_stock.stock_count as int) % cast(A.st_unit_qty as int)) % B.st_unit_qty as ToptalC

		from st_user  left join st_warehouse_stock 
		on st_user.warehouse_locationNo = st_warehouse_stock.locationno left join st_item_product

		on st_warehouse_stock.P_Code = st_item_product.P_Code left join st_warehouse_location
		on st_warehouse_stock.locationno = st_warehouse_location.locationno left join  st_item_unit_con A
		on st_warehouse_stock.P_Code = A.P_Code and A.st_unit_id='ลัง' left join  st_item_unit_con B
		on st_warehouse_stock.P_Code = B.P_Code and B.st_unit_id='แพ็ค' 
		where st_user.User_id='$USER_id' and st_item_product.prd_type_id <>'S001'
		order by st_item_product.prd_type_id desc";

		$qry=sqlsrv_query($con,$sql);
		$detail2=sqlsrv_fetch_array($qry);
			while($detail=sqlsrv_fetch_array($qry))
			{
			?>
			<option value="<?print $detail['P_Code']?>" ><?print $detail['PRODUCTNAME']?></option>
		
			<?
			}

		
	
	?>
	</select></div>
	<div id="show_Countproduct1"  style="float:left" >
	<? 		$sql2="  select st_unit_id,st_unit_name,P_Code
								  from st_item_unit_con
								  order by st_unit_id asc ";
								$qry2=sqlsrv_query($con,$sql2,$params,$options);
								while($re2=sqlsrv_fetch_array($qry2)){
								
						?>
						<input  value="0" type="hidden" id="NumP_<?=$re2['P_Code'];?>_U_<?=$re2['st_unit_id']?>" name="NumP_<?=$re2['P_Code'];?>_U_<?=$re2['st_unit_id']?>" size="5">
	<?}//while ?>
	</div>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td ><B>สินค้าที่ได้รับ</B></td>
<td ><div style="float:left" >
	<select id="txt_receive" name="txt_receive"  style="width:170px;" required/>
	<option value="" > - สินค้า - </option>
	<?	$sql="select st_user.warehouse_locationNo
		,st_warehouse_stock.*
		,st_item_product.PRODUCTNAME
		,st_item_product.st_unit_id
		,st_warehouse_location.locationname
		,A.st_unit_qty as A
		,B.st_unit_qty as B
		,st_warehouse_stock.stock_count/A.st_unit_qty as ToptalA
		, cast(st_warehouse_stock.stock_count as int) % cast(A.st_unit_qty as int) 
		,(cast(st_warehouse_stock.stock_count as int) % cast(A.st_unit_qty as int))/B.st_unit_qty as ToptalB
		,(cast(st_warehouse_stock.stock_count as int) % cast(A.st_unit_qty as int)) % B.st_unit_qty as ToptalC

		from st_user  left join st_warehouse_stock 
		on st_user.warehouse_locationNo = st_warehouse_stock.locationno left join st_item_product

		on st_warehouse_stock.P_Code = st_item_product.P_Code left join st_warehouse_location
		on st_warehouse_stock.locationno = st_warehouse_location.locationno left join  st_item_unit_con A
		on st_warehouse_stock.P_Code = A.P_Code and A.st_unit_id='ลัง' left join  st_item_unit_con B
		on st_warehouse_stock.P_Code = B.P_Code and B.st_unit_id='แพ็ค' 
		where st_user.User_id='$USER_id' and st_item_product.prd_type_id ='S001'
		order by st_item_product.prd_type_id desc";

		$qry=sqlsrv_query($con,$sql);
			while($detail=sqlsrv_fetch_array($qry))
			{
			?>
			<option value="<?print $detail['P_Code']?>" ><?print $detail['PRODUCTNAME']?></option>
		
			<?
			}

		
	
	?>
	</select></div><div id="show_product2"  style="float:left" ></div>
</td></tr>			
		
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