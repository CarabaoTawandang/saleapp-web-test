<?
session_start();
set_time_limit(0);
$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ
include("../includes/config.php");

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
    
<form method="post" action="?page=stockBalanceAdmin&do=search" id="frmSearch" name="frmSearch">
<table cellpadding="0" cellspacing="0"  border="0" align="center"  >
<tr><td colspan="2" align="center">
	<select id="txt_location" name="txt_location"  style="width:170px;" required/>
	<option value="" > - เลือกคลังสินค้า - </option>
	<?	$sqlLoc="select * from st_warehouse_location ";
			$qryLoc=sqlsrv_query($con,$sqlLoc);
			$row=sqlsrv_num_rows($qryLoc);
			while($detail=sqlsrv_fetch_array($qryLoc))
			{
			?>
			<option value="<?print $detail['locationno']?>" ><?print $detail['locationname']?></option>
		
			<?
			}

		
	
	?>
	</select>
	<input type="submit" id="btn_Search" name="btn_Search" value="ค้นหา">
</td></tr>
</table>
</form>	
	</div><div class="sep"></div><br>

<? 
$txt_location=trim($_POST['txt_location']);
if($_GET['do']=="search") {
 $sql="select st_warehouse_location.locationno
,st_warehouse_location.locationname
,st_warehouse_stock.P_Code
,st_warehouse_stock.stock_count
,st_item_product.PRODUCTNAME
,st_item_product.st_unit_id
,A.st_unit_qty as A
,B.st_unit_qty as B
,st_warehouse_stock.stock_count/A.st_unit_qty as ToptalA
, cast(st_warehouse_stock.stock_count as int) % cast(A.st_unit_qty as int) 
,(cast(st_warehouse_stock.stock_count as int) % cast(A.st_unit_qty as int))/B.st_unit_qty as ToptalB
,(cast(st_warehouse_stock.stock_count as int) % cast(A.st_unit_qty as int)) % B.st_unit_qty as ToptalC
from st_warehouse_location left join st_warehouse_stock 
on st_warehouse_location.locationno = st_warehouse_stock.locationno left join st_item_product 
on st_warehouse_stock.P_Code = st_item_product.P_Code  left join  st_item_unit_con A
on st_warehouse_stock.P_Code = A.P_Code and A.st_unit_id='ลัง' left join  st_item_unit_con B
on st_warehouse_stock.P_Code = B.P_Code and B.st_unit_id='แพ็ค' 
where st_warehouse_location.locationno ='$txt_location'
order by  st_warehouse_location.locationno asc,st_item_product.prd_type_id desc
";

$qry=sqlsrv_query($con,$sql);
$r=0;
//echo $sql;
 ?>	
 <div align="center">คลัง :
<? 		$sqlOps="select locationname from st_warehouse_location    where locationno= '$txt_location' ";
		$qryOp=sqlsrv_query($con,$sqlOps);
		$deOp=sqlsrv_fetch_array($qryOp);
		echo $deOp['locationname'];
?>
</div>
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
<? } ?>
</div><!--/-box-->
</div><!--/-container_box-->
</body>
</html>

