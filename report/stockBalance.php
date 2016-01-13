<?
session_start();
set_time_limit(0);
$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ
include("../includes/config.php");
 $sql="select st_user.warehouse_locationNo
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
where st_user.User_id='$USER_id'
order by st_item_product.prd_type_id desc";

$qry=sqlsrv_query($con,$sql);
$r=0;
//echo $sql;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
$(function(){	
			
		$('#btn_add').button();
		$('#btn').button();
		$('#btn2').button();
		$('#btn3').button();
	});//function	
</script>
</head>
<body>
<div class="container_box">
    <div id="box">
	<div class="header"><h3>stock ในคลัง</h3><!---หัวเรื่องหลัก-->
           <p>&nbsp;</p><!---หัวเรื่องรอง-->
		   <input type="button" value="+รับของเข้าคลัง" id="btn" onclick="window.location='?page=add_receive_head';" class="inner_position_right60" >
		   <input type="button" value="-จ่ายของเข้ารถ" id="btn2" onclick="window.location='?page=add_picking_head';" class="inner_position_right60" >
		    <input type="button" value="<->เปลี่ยนของ" id="btn3" onclick="window.location='?page=add_chenge_product';" class="inner_position_right60" >
	</div><div class="sep"></div><br>
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2">
	<table cellpadding="0" cellspacing="0"  border="1" align="center"  width="1000px">
	<tr>
	<td align="center" rowspan="2">คลังสินค้า</td>
	<td align="center" rowspan="2">ลำดับ</td>
	<td align="center" rowspan="2">รหัสสินค้า</td>
	<td align="center" rowspan="2">สินค้า</td>
	<td align="center" rowspan="2">จำนวนรับของในคลัง</td>
	<td align="center" rowspan="2">หน่วยย่อยของสินค้า</td>
	<td align="center" colspan="3">หรือเท่ากับ</td>
	</tr>
	<tr>
	<td align="center">ลัง</td>
	<td align="center">แพ็ค</td>
	<td align="center">ขวด</td>
	</tr>
	<? $r=1;while($re=sqlsrv_fetch_array($qry)){ if($r%2==0){ $col="#EEEEEE";}else{$col="#F2FAEB";}?>
	<tr class="mousechange"  bgcolor="<?=$col;?>" height="30" >
		
	<td align="left" >&nbsp;&nbsp;&nbsp;<? if($re['locationname'] <> $locationname) {echo $re['locationname'];}?></td>
	<td align="center" ><? echo $r;?></td>
	<td align="left" ><? echo "&nbsp;&nbsp;&nbsp;".$re['P_Code'];?></td>
	<td align="left" ><? echo "&nbsp;&nbsp;&nbsp;".$re['PRODUCTNAME'];?></td>
	
	<td align="right" ><? if($re['stock_count'] <>'0'){echo number_format($re['stock_count']);}?>&nbsp;&nbsp;&nbsp;</td>
	<td align="center" ><? echo$re['st_unit_id']?></td>
	<td align="center" ><? if($re['stock_count'] <>'0'){echo 	number_format(floor($re['ToptalA'])); }?></td>
	<td align="center" ><? if($re['stock_count'] <>'0'){echo	number_format($re['ToptalB']);}?></td>
	<td align="center" ><? if($re['stock_count'] <>'0'){echo	number_format($re['ToptalC']);}?></td>
	</tr>
	<? 
	$locationname=$re['locationname'];$r++;}//while ?>
	</table>
</td></tr>
</table>
<div align="center">**หมายเหตุ : เฉพาะคลังที่คุณสังกัด</div>
</div><!--/-box-->
</div><!--/-container_box-->
</body>
</html>

