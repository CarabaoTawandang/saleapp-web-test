<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$sql="select st_warehouse_stock.locationno 
,st_warehouse_location.locationname
,st_warehouse_stock.P_Code
,st_item_product.PRODUCTNAME
,st_warehouse_stock.stock_count
from st_warehouse_stock left join st_warehouse_location
on st_warehouse_stock.locationno = st_warehouse_location.locationno left join st_item_product
on st_warehouse_stock.P_Code = st_item_product.P_Code";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$qry=sqlsrv_query($con,$sql,$params,$options);
$r=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
$(function(){	
			
		$('#btn_warehouse_location').button();
	});//function	
</script>
</head>
<body>
<div class="container_box">
    <div id="box">
	<div class="header"><h3>ข้อมูลนับ stock สินค้าครั้งแรก</h3><!---หัวเรื่องหลัก-->
           <p>&nbsp;</p><!---หัวเรื่องรอง-->
		   <input type="button" value="นับ stock สินค้าครั้งแรก" id="btn_warehouse_location" onclick="window.location='?page=add_warehouse_stock';" class="inner_position_right" >
	</div><div class="sep"></div><br>
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2">
	<table cellpadding="0" cellspacing="0"  border="1" align="center"  width="1000px">
	<tr><td align="center">คลังสินค้า</td><td align="center">สินค้า</td><td align="center" width="200">จำนวนสต๊อกในคลัง (ขวด)</td><TD align="center">แก้ไข</TD><TD align="center">ลบ</TD></tr>
	<? while($re=sqlsrv_fetch_array($qry)){ if($r%2==0){ $col="#EEEEEE";}else{$col="#F2FAEB";}?>
	<tr bgcolor="<?=$col;?>" height="30" >
	<td align="center"><? if($re['locationno'] <> $locationno){ echo $re['locationno']." ".$re['locationname'];}  $locationno=$re['locationno'];?> </td>
	<td align="left">&nbsp;&nbsp;&nbsp;<?=$re['P_Code']." ".$re['PRODUCTNAME'];?></td>
	<td align="right"><?=$re['stock_count'];?>&nbsp;&nbsp;&nbsp;</td>
	</tr>
	<? $r++;} ?>
	</table>
</td></tr>
</table>
</div><!--/-box-->
</div><!--/-container_box-->
</body>
</html>
