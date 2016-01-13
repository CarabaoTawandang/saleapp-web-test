<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ
$receive_no=$_GET['receive_no'];

$txt_location=trim($_POST['txt_location']);
$dateStart =$_POST['dateStart'];
$dateEnd =$_POST['dateEnd'];
$txt_PS =$_POST['txt_PS'];
$txt_PO =$_POST['txt_PO'];
if($dateStart || $dateEnd){echo "<b>ค้นหาข้อมูลวันที่  "; echo $dateStart." ถึง  ".$dateEnd."</b><br>";}
if($txt_PS){echo "เลขที่D/O No.(PS) "; echo $txt_PS."<br>";}
if($txt_PO){echo "ใบสั่งซื้อเลขที่ (PO) "; echo $txt_PO."<br>";}

if($dateStart&&$dateStart)
{
$dateStart = date('Y-m-d', strtotime($dateStart));
$dateEndt = date('Y-m-d', strtotime($dateEnd));
}

$sql="select st_warehouse_stock_receive_head.receive_locationno ,st_warehouse_location.locationname 
, st_warehouse_stock_receive_head.receive_no
, cast(st_warehouse_stock_receive_head.receive_date as date) receive_date2 
 ,st_warehouse_stock_receive_head.ref_pack ,st_warehouse_stock_receive_head.ref_docno
,st_warehouse_stock_receive_head.receive_user_id
,uu.name as receive_user 
,zz.COMPANYNAME as receive_company 
,st_warehouse_stock_receive_detail.P_Code ,st_item_product.PRODUCTNAME 
,st_warehouse_stock_receive_head.receive_Remark
,st_warehouse_stock_receive_detail.receive_qty 
 ,A.st_unit_qty as A
,B.st_unit_qty as B
,(st_warehouse_stock_receive_detail.receive_qty )/(A.st_unit_qty) as TatalBox
,(st_warehouse_stock_receive_detail.receive_qty )%(A.st_unit_qty) as balance1
,((st_warehouse_stock_receive_detail.receive_qty )%(A.st_unit_qty))/B.st_unit_qty as TatalPack
,((st_warehouse_stock_receive_detail.receive_qty )%(A.st_unit_qty))%B.st_unit_qty as TatalBottle
,st_warehouse_stock_receive_head.Update_byAX

  from st_warehouse_stock_receive_head 
 left join st_warehouse_location 
  on st_warehouse_stock_receive_head.receive_locationno = st_warehouse_location.locationno left join st_warehouse_stock_receive_detail 
  on st_warehouse_stock_receive_head.receive_no = st_warehouse_stock_receive_detail.receive_no left join st_item_product 
  on st_warehouse_stock_receive_detail.P_Code=st_item_product.P_Code left join st_user uu 
  on st_warehouse_stock_receive_head.receive_user_id = uu.User_id left join st_companyinfo_exp zz 
  on st_warehouse_stock_receive_head.receive_user_id = zz.COMPANYCODE left join  st_item_unit_con A
on st_item_product.P_Code = A.P_Code and A.st_unit_id='ลัง' left join  st_item_unit_con B
on st_item_product.P_Code = B.P_Code and B.st_unit_id='แพ็ค' 
where st_warehouse_stock_receive_head.receive_locationno  ='$txt_location' ";
if($receive_no){ $sql.="and st_warehouse_stock_receive_head.receive_no='$receive_no' ";}
if($dateStart&&$dateStart){ $sql.="and cast(st_warehouse_stock_receive_head.receive_date as date) between '$dateStart' and '$dateEndt' ";}
if($txt_PS){ $sql.="and st_warehouse_stock_receive_head.ref_pack  like '$txt_PS%' ";}
if($txt_PO){ $sql.="and st_warehouse_stock_receive_head.ref_docno like '$txt_PO%' ";}

$sql.="order by cast(st_warehouse_stock_receive_head.receive_date as date) asc
,st_warehouse_stock_receive_head.CreateDate asc

,st_item_product.PRODUCTNAME asc";


//echo $sql;



$qry1=sqlsrv_query($con,$sql);
$re1=sqlsrv_fetch_array($qry1);
$r=0;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
$(function(){	
			
		
	});//function	
</script>
</head>
<body><br>
 <div align="center">คลัง :
<? 		
	
	$sqlOps="select locationname from st_warehouse_location    where locationno= '$txt_location' ";
	$qryOp=sqlsrv_query($con,$sqlOps);
	$deOp=sqlsrv_fetch_array($qryOp);
	echo $deOp['locationname'];
?>
</div>
<table cellpadding="0" cellspacing="0"  border="1" align="center"  >
	<tr>
	<td align="center" rowspan="2" width="170px" >เลขเอกสาร</td>
	<td align="center" rowspan="2" width="170px">วันที่ตามใบส่งของ</td>
	
	<td align="center" rowspan="2" width="170px">เลขที่D/O No.(PS)</td>
	<td align="center" rowspan="2" width="170px">ใบสั่งซื้อเลขที่ (PO)</td>
	<td align="center" rowspan="2" width="200px">รับจาก</td>
	<td align="center" rowspan="2" width="120px">รหัสสินค้า</td>
	<td align="center" rowspan="2" width="170px">สินค้า</td>
	
	
	<td align="center" rowspan="2" width="250px">หมายเหตุ</td>
	<td align="center" colspan="3">จำนวนรับของเข้าคลัง</td>
	<td align="center" rowspan="2" >แก้ไข</td>
	</tr>
	<tr>
	<td align="center">ลัง</td>
	<td align="center">แพ็ค</td>
	<td align="center">ขวด</td>
	</tr>
	<? $r=1;
	$qry=sqlsrv_query($con,$sql);
	while($re=sqlsrv_fetch_array($qry)){ if($r%2==0){ $col="#EEEEEE";}else{$col="#F2FAEB";}?>
	<tr class="mousechange"  bgcolor="<?=$col;?>" height="30" align="center">
		<? if($re['receive_no']<>$receive_no2){?>
	<td  ><? echo $re['receive_no']; ?></td>
	<td bgcolor="<? if($re['receive_date2'] <> $receive_date2 ){echo "red";}?>"><? echo date_format($re['receive_date2'],'d/m/Y')?></td>
	<td  ><? echo $re['ref_pack'];?></td>
	<td  ><? echo $re['ref_docno'];?></td>
	<td ><?  if($re['receive_user']){echo$re['receive_user'];} else if($re['receive_company']){echo$re['receive_company'];}?>
	<td ><? echo $re['P_Code'];?>
	</td>
		<? }else{
		echo '<td align="center" >"</td>
			<td align="center" >"</td>
			<td align="center" >"</td>
			<td align="center" >"</td>
			<td align="center" >"</td>
			<td align="center" >"</td>
			';
		} ?>
	
	<td  ><? echo "&nbsp;&nbsp;&nbsp;".$re['PRODUCTNAME'];?></td>
	
	
	
	<td ><? if($re['receive_no']<>$receive_no2){echo $re['receive_Remark'];}?></td>
	<td align="right"><?=number_format($re['TatalBox']);?></td>
	<td align="right"><?=number_format($re['TatalPack']);?></td>
	<td align="right"><?=number_format($re['TatalBottle']);?></td>
	<td align="center">
		<!---<? if(($re['Update_byAX']==NULL)&&($re['receive_no']<>$receive_no2))
		{	//echo "edit";echo $re['receive_no'];
			echo "<a href=\"?page=edit_receive_head&id=".$re['receive_no']."\"  >";
			echo '<img src="./images/edit.gif" style="cursor:pointer" alt="Complete"></a>';
		}
		?>---->
	
	</td>
	</tr>
	<? 
	$picking_no2=$re['receive_date2']; $receive_date2=$re['receive_date2'];
	$receive_no2=$re['receive_no'];
	$r++;
	}//while ?>
	</table>
	<div align="center">**หมายเหตุ : แก้ไขได้เฉพาะเอกสารที่AXยังไม่ยืนยัน</div>
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
