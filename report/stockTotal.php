<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$sql1="select st_warehouse_stock.locationno 
,st_warehouse_location.locationname
,st_warehouse_stock.P_Code
,st_item_product.PRODUCTNAME
,st_warehouse_stock.stock_count
from st_warehouse_stock left join st_warehouse_location
on st_warehouse_stock.locationno = st_warehouse_location.locationno left join st_item_product
on st_warehouse_stock.P_Code = st_item_product.P_Code";
$qry1=sqlsrv_query($con,$sql1,$params,$options);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
$(function(){	
			
		$('#btn_add').button();
	});//function	
</script>
</head>
<body>
<div class="container_box">
    <div id="box">
	<div class="header"><h3>ข้อมูล stock คลังสินค้า</h3><!---หัวเรื่องหลัก-->
           <p>&nbsp;</p><!---หัวเรื่องรอง-->
	</div><div class="sep"></div><br>
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="2">
	<table cellpadding="0" cellspacing="0"  border="1" align="center"  width="1000px">
	<tr><td align="center" width="100">คลังสินค้า</td>
	<td align="center" width="100">สินค้า</td>
	<td align="center" width="100">วันที่รับ/จ่าย</td>
	<td align="center" width="70">รับเข้าคลัง<br> (ขวด)</td>
	<td align="center" width="70">จ่ายเข้ารถ<br> (ขวด)</td>
	<td align="center" width="70">คงเหลือ<br> (ขวด)</td>
	
	<td align="center" width="100">เลขที่PO/DO</td>
	<td align="center" width="200">จ่ายออกให้</td>
	<TD align="center" width="50">แก้ไข</TD><TD align="center" width="50">ลบ</TD></tr>
	<? while($re=sqlsrv_fetch_array($qry1)){  if($re['P_Code']=="FG101401"){$col="#F2FAEB";}else if($re['P_Code']=="FG201401"){$col="#EEEEEE";}?>
	<tr  height="30" >
	<td align="center" <? if($re['P_Code']=="FG101401"){ echo "bgcolor= ' ".$col." '";}else{echo "bgcolor=''";} ?> >
	<? if($re['locationno'] <> $locationno){ echo $re['locationno']." ".$re['locationname'];}  $locationno=$re['locationno'];?> </td>
	<td align="left" bgcolor="<?=$col;?>">&nbsp;&nbsp;&nbsp;<?=$re['P_Code']." ".$re['PRODUCTNAME'];?></td>
	
	<td align="right" bgcolor="<?=$col;?>"></td>
	<td align="right" bgcolor="<?=$col;?>"><?=number_format($re['stock_count']); $TOtal=$re['stock_count'];?></td>
	<td align="right" bgcolor="<?=$col;?>"></td>
	<td align="right" bgcolor="<?=$col;?>"></td>
	<td align="right" bgcolor="<?=$col;?>"></td>
	<td align="right" bgcolor="<?=$col;?>"></td>
	<td align="right" bgcolor="<?=$col;?>"></td>
	<td align="right" bgcolor="<?=$col;?>"></td>
	</tr>
	<?  $sql2="select cast(st_warehouse_stock_receive_head.receive_date as date)  receive_date2  
		,st_warehouse_stock_receive_head.receive_locationno
		,st_warehouse_location.locationname
		,st_warehouse_stock_receive_detail.P_Code
		,st_item_product.PRODUCTNAME
		,st_warehouse_stock_receive_detail.receive_qty
		,st_warehouse_stock_receive_detail.receive_unit
		,st_warehouse_stock_receive_head.ref_docno
		,st_warehouse_stock_receive_head.receive_Remark
		from st_warehouse_stock_receive_head  left join st_warehouse_location
		on st_warehouse_stock_receive_head.receive_locationno =  st_warehouse_location.locationno left join st_warehouse_stock_receive_detail
		on st_warehouse_stock_receive_head.receive_no = st_warehouse_stock_receive_detail.receive_no left join st_item_product
		on st_warehouse_stock_receive_detail.P_Code=st_item_product.P_Code
		where st_warehouse_stock_receive_head.receive_locationno ='$locationno'
		and st_warehouse_stock_receive_detail.P_Code='$re[P_Code]'
		order by cast(st_warehouse_stock_receive_head.receive_date as date)  asc
		";
		$qry2=sqlsrv_query($con,$sql2,$params,$options);
		while($re2=sqlsrv_fetch_array($qry2)){
		echo '<tr bgcolor="" height="30" >';
		echo '<td align="center"></td>';
		echo '<td align="left"></td>';
		echo '<td align="center">'.date_format($re2['receive_date2'],'d/m/Y').'</td>';
		echo '<td align="right">+ '.number_format($re2['receive_qty']).'</td>';
		echo '<td align="right"></td>';
		echo '<td align="right"></td>';
		
		echo '<td align="left">&nbsp;&nbsp;&nbsp;'.$re2['ref_docno'].'</td>';
		echo '<td align="left">&nbsp;&nbsp;&nbsp;</td>';
		echo '<td align="right"></td>';
		echo '<td align="right"></td>';
		echo '</tr>';
		$TOtal =$TOtal+$re2['receive_qty'];}//while2
		echo "<tr>
			<td colspan='3' align='right'>รวม : &nbsp;&nbsp;&nbsp;</td>
			<td align='right'>".number_format($TOtal)."</td>
			</tr>";
		$TOtal ="";?>
	<?}//while1 ?>
	</table>
</td></tr>
</table>
</div><!--/-box-->
</div><!--/-container_box-->
</body>
</html>
<?
if($_GET['do']=="del")
{
	$id=$_GET['id'];
	$del="delete from st_user_group_dc where dc_groupid='$id'";
	$qrydel=sqlsrv_query($con,$del,$params,$options);
	$del2="delete from st_user_group_dc_detail where dc_groupid='$id'";
	$qrydel2=sqlsrv_query($con,$del2,$params,$options);
	
	$del3="delete from st_user_group_dc_cust where dc_groupid='$id'";
	$qrydel3=sqlsrv_query($con,$del3,$params,$options);
	if($qrydel && $qrydel2)
	{
			echo'<script type="text/javascript">';
			echo'alert("ลบ DC เรียบร้อยแล้ว ");';
			echo "window.location='?page=data_DC';";
			echo '</script>';
	}
	
}
?>
