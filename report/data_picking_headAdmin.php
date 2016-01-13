<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ
$picking_no =$_GET['picking_no'];
$txt_location=trim($_POST['txt_location']);
$dateStart =trim($_POST['dateStart']);
$dateEnd =trim($_POST['dateEnd']);
$txt_sale =trim($_POST['txt_sale']);

				
if($dateStart || $dateEnd){echo "<b>ค้นหาข้อมูลวันที่  "; echo $dateStart." ถึง  ".$dateEnd."</b><br>";}
if($txt_sale){	echo "จ่ายให้ : "; 
				$sqlOp="select  name,surname from  st_user where  User_id='$txt_sale' ";
				$sqlOp=sqlsrv_query($con,$sqlOp);
				$sqlOp=sqlsrv_fetch_array($sqlOp);
				echo $sqlOp['name']." ".$sqlOp['surname'];
			}

if($dateStart&&$dateStart)
{
$dateStart = date('Y-m-d', strtotime($dateStart));
$dateEndt = date('Y-m-d', strtotime($dateEnd));
}

$sql="select st_warehouse_stock_picking_head.picking_locationno ,st_warehouse_location.locationname
,st_warehouse_stock_picking_head.picking_no ,cast(st_warehouse_stock_picking_head.picking_date as date) picking_date2 
,cast(st_warehouse_stock_picking_head.CreateDate as time) CreateDate2 
,st_warehouse_stock_picking_head.picking_user_id 

,st_warehouse_stock_picking_detail.P_Code ,st_item_product.PRODUCTNAME 

,st_warehouse_stock_picking_head.picking_Remark 
,st_warehouse_stock_picking_detail.picking_qty 
 ,A.st_unit_qty as A
,B.st_unit_qty as B
,(st_warehouse_stock_picking_detail.picking_qty  )/(A.st_unit_qty) as TatalBox
,(st_warehouse_stock_picking_detail.picking_qty  )%(A.st_unit_qty) as balance1
,((st_warehouse_stock_picking_detail.picking_qty  )%(A.st_unit_qty))/B.st_unit_qty as TatalPack
,((st_warehouse_stock_picking_detail.picking_qty  )%(A.st_unit_qty))%B.st_unit_qty as TatalBottle
,st_user.name ,st_user.surname,st_user.Salecode


from  st_warehouse_stock_picking_head 
left join st_warehouse_location 
on st_warehouse_stock_picking_head.picking_locationno = st_warehouse_location.locationno left join st_warehouse_stock_picking_detail 
on st_warehouse_stock_picking_head.picking_no = st_warehouse_stock_picking_detail.picking_no left join st_item_product 
on st_warehouse_stock_picking_detail.P_Code=st_item_product.P_Code left join st_user 
on st_warehouse_stock_picking_head.picking_user_id = st_user.User_id  left join  st_item_unit_con A
on st_item_product.P_Code = A.P_Code and A.st_unit_id='ลัง' left join  st_item_unit_con B
on st_item_product.P_Code = B.P_Code and B.st_unit_id='แพ็ค' 

where st_warehouse_stock_picking_head.picking_locationno ='$txt_location'  ";
if($picking_no){$sql.="and  st_warehouse_stock_picking_head.picking_no='$picking_no' ";}

if($dateStart&&$dateStart){ $sql.="and cast(st_warehouse_stock_picking_head.picking_date as date) between '$dateStart' and '$dateEndt' ";}
if($txt_sale){ $sql.="and st_warehouse_stock_picking_head.picking_user_id like '$txt_sale%' ";}


$sql.="order by 
cast(st_warehouse_stock_picking_head.picking_date as date) asc
,st_user.Salecode asc
,st_warehouse_stock_picking_head.picking_no asc
, st_warehouse_stock_picking_head.CreateDate asc
,st_item_product.PRODUCTNAME asc";

//echo $sql;



$qry1=sqlsrv_query($con,$sql);
$re1=sqlsrv_fetch_array($qry1);
$r=0;
?>

<table cellpadding="0" cellspacing="0"  border="1" align="center"  >
	<tr>
	<td align="center" rowspan="2" width="170px" >เลขเอกสาร</td>
	<td align="center" rowspan="2" width="170px">วันที่จ่ายของเข้ารถ</td>
	<td align="center" rowspan="2" width="170px">เวลา</td>
	<td align="center" rowspan="2" width="100px">Sales code</td>
	<td align="center" rowspan="2" width="250px">จ่ายให้</td>
	<td align="center" rowspan="2" width="120px">รหัสสินค้า</td>
	<td align="center" rowspan="2" width="170px">สินค้า</td>
	<td align="center" rowspan="2" width="400px">หมายเหตุ</td>
	<td align="center" colspan="3">จำนวนจ่ายของเข้ารถ</td>
	</tr>
	<tr>
	<td align="center">ลัง</td>
	<td align="center">แพ็ค</td>
	<td align="center">หน่วย</td>
	</tr>
	<? $r=1;
	$qry=sqlsrv_query($con,$sql);
	while($re=sqlsrv_fetch_array($qry)){ if($r%2==0){ $col="#EEEEEE";}else{$col="#F2FAEB";}?>
	<tr  class="mousechange"   bgcolor="<?=$col;?>" height="30" align="center">
	<? if($re['picking_no']<>$picking_no2){?>
	<td><? echo $re['picking_no']; ?></td>
	<td bgcolor="<? if($re['picking_date2'] <> $picking_date2 ){echo "red";}?>"><? echo date_format($re['picking_date2'],'d/m/Y'); ?></td>
	<td align="center" width="170px"><?=date_format($re['CreateDate2'],'H:i:s');?></td>
	<td><? echo $re['Salecode'];?></td>
	<td><? echo $re['name']." ".$re['surname'];?></td>
		<? }else{
		echo '<td>"</td>
			<td>"</td>
			<td>"</td>
			<td>"</td>
			<td>"</td>';
		} ?>
	<td  ><? echo $re['P_Code'];?></td>
	<td ><? echo $re['PRODUCTNAME'];?></td>
	
	<td  ><?  if($re['picking_no']<>$picking_no2){echo $re['picking_Remark'];}?></td>
	<td align="right"><?=number_format($re['TatalBox']);?></td>
	<td align="right"><?=number_format($re['TatalPack']);?></td>
	<td align="right"><?=number_format($re['TatalBottle']);?></td>
	</tr>
	<? $picking_no2=$re['picking_no']; $picking_date2=$re['picking_date2'];
	$r++;
	}//while ?>
	</table>
	<div align="center">**หมายเหตุ : ถ้าจ่ายของผิดให้ทำการคืนของ</div>

