<?
session_start();
set_time_limit(0);
$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ
include("../includes/config.php");

date_default_timezone_set('Asia/Bangkok');
$today_date=date("d-M-Y");
$today_time=date("h:i:s: a");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
$(function(){	
			
		$('#btn_Search').button();
		$('#btn').button();
	});//function	
</script>
</head>
<body>
<div class="container_box">
    <div id="box">
	<div class="header"><h3>stock ท้ายรถ</h3><!---หัวเรื่องหลัก-->
           <p>&nbsp;</p><!---หัวเรื่องรอง-->
		   <input type="button" value="-จ่ายของเข้ารถ" id="btn" onclick="window.location='?page=add_picking_head';" class="inner_position_right" >
		  
	</div><div class="sep"></div>
<form method="post" action="?page=stoc_salekBalance&do=search" id="frmSearch" name="frmSearch">
<table cellpadding="0" cellspacing="0"  border="0" align="center"  >
<tr><td colspan="2" align="center">
	<br><b>พนักงานขาย</b>
		<select  id="txt_packName" name="txt_packName" style="width:170px;" >
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
	<input type="submit" id="btn_Search" name="btn_Search" value="ค้นหา">
	
</td></tr>
</table>
</form>
</div><!--/-box-->
</div><!--/-container_box-->
<br><br>

<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" >
<tr><td colspan="2">

	<table cellpadding="0" cellspacing="0"  border="1" align="center">
	<tr>
	<td align="center" rowspan="2" width="50">ลำดับ</td>
	<td align="center" rowspan="2" width="200">Sales code</td>
	<td align="center" rowspan="2" width="200">Sales name</td>
	<td align="center" rowspan="2">ลำดับ</td>
	<td align="center" rowspan="2" width="200">รหัสสินค้า</td>
	<td align="center" rowspan="2" width="200">สินค้า</td>
	<td align="center" rowspan="2" width="200">จำนวนของท้ายรถ </td>
	<td align="center" rowspan="2" width="200">หน่วยย่อยของสินค้า</td>
	<td align="center" colspan="3">หรือเท่ากับ</td>
	<td align="center" rowspan="2" >คืนของให้คลัง</td>
	</tr>
	<tr>
	<td align="center" width="100">ลัง</td>
	<td align="center" width="100">แพ็ค</td>
	<td align="center" width="100">ขวด</td>
	</tr>
	<? $r=1;  $txt_packName=$_POST['txt_packName'];
	$sql="select st_user_lv_Detail.user_id_head
			,st_user_lv_Detail.user_id_detail
			,st_user.User_id
			,st_user.Salecode
			,st_user.User_name
			,st_user.User_Pass
			,st_user.name
			,st_user.surname
			,st_warehouse_sale_stock.User_id
			,st_warehouse_sale_stock.username
			,st_item_product.P_Code
			,st_item_product.PRODUCTNAME
			,st_item_product.prd_type_id
			,st_item_type.prd_type_nm
			,st_warehouse_sale_stock.wh_stock_qty
			,st_item_product.st_unit_id
			,A.st_unit_qty as A
			,B.st_unit_qty as B
			,st_warehouse_sale_stock.wh_stock_qty/A.st_unit_qty as ToptalA
			, cast(st_warehouse_sale_stock.wh_stock_qty as int) % cast(A.st_unit_qty as int) 
			,(cast(st_warehouse_sale_stock.wh_stock_qty as int) % cast(A.st_unit_qty as int))/B.st_unit_qty as ToptalB
			,(cast(st_warehouse_sale_stock.wh_stock_qty as int) % cast(A.st_unit_qty as int)) % B.st_unit_qty as ToptalC

						from st_user_lv_Detail left join st_user
						on st_user_lv_Detail.user_id_detail = st_user.User_id  left join st_warehouse_sale_stock 
			on  st_user.User_id = st_warehouse_sale_stock.User_id
			left join st_item_product
			on st_warehouse_sale_stock.P_Code  = st_item_product.P_Code left join st_item_type
			on st_item_product.prd_type_id = st_item_type.prd_type_id  left join  st_item_unit_con A
			on st_item_product.P_Code = A.P_Code and A.st_unit_id='ลัง' left join  st_item_unit_con B
			on st_item_product.P_Code = B.P_Code and B.st_unit_id='แพ็ค' 


						where  st_user_lv_Detail.user_id_head ='$USER_id' and prd_grp_id is not null ";
			if($_GET['do']=="search" && $txt_packName) { 
				$sql.="and st_user.User_id='$txt_packName' ";
			}
			
			$sql.="order by st_user.Salecode  asc,st_item_product.prd_type_id desc";
			//echo $sql;
			$qry=sqlsrv_query($con,$sql);
			$r=1;
			$tt=1;
			$rr=1;
	while($re=sqlsrv_fetch_array($qry)){ if($r%2==0){ $col="#EEEEEE";$col2="red";}else{$col="#F2FAEB";$col2="back"; }?>
	<tr class="mousechange"  bgcolor="<?=$col;?>" height="30" >
	<td align="center" ><? if($re['name'] <> $username) {echo $tt;}?></td>	
	<td align="center" ><? if($re['name'] <> $username) {echo $re['Salecode'];}?></td>	
	<td align="left" >&nbsp;&nbsp;&nbsp;<? if($re['name'] <> $username) {echo $re['name']." ".$re['surname']; $tt++; $rr=1;}?></td>
	<td align="center" ><? echo $rr; $rr++;?></td>
	<td align="left" >&nbsp;&nbsp;&nbsp;<? echo $re['P_Code'];?></td>
	<td align="left" >&nbsp;&nbsp;&nbsp;<? echo $re['PRODUCTNAME'];?></td>
	<td align="right" ><? if($re['wh_stock_qty']<>0){echo number_format($re['wh_stock_qty']);}?>&nbsp;&nbsp;&nbsp;</td>
	<td align="center" ><? echo $re['st_unit_id'];?></td>
	<td align="center" ><? if($re['wh_stock_qty']<>0){echo	number_format(floor($re['ToptalA']));}?></td>
	<td align="center" ><? if($re['wh_stock_qty']<>0){echo	number_format($re['ToptalB']);}?></td>
	<td align="center" ><? if($re['wh_stock_qty']<>0){echo	number_format($re['ToptalC']);}?></td>
	<td align="center" >
	<? if($re['wh_stock_qty']>0){?>
	<input type="button" id="reProLo"  name="reProLo"  
	onclick="window.location.href 
	= '?page=stoc_salekBalance&do=reProLo&VAN=<?=$re['User_id']; ?>&P=<?=$re['P_Code'];?>&Num=<?=$re['wh_stock_qty'];?>';"
	style="color:<?=$col2;?>;"  
	value="คืนของ">
	<? } ?>
	</td>
	
	</tr>
	<? 
	$prd_type_nm=$re['prd_type_nm'];
	$username=$re['name'];$r++;
	}//while ?>
	</table>
</td></tr>
</table>


<div align="center">**หมายเหตุ : เฉพาะ User ที่คุณดูแล</div>


</body>
</html>
<?

if($_GET['do']=="reProLo")
{ 
$item=$_GET['P'];
$Num=$_GET['Num'];
$VAN =$_GET['VAN'];
$dateT=date('Y-m-d H:i');

$sqlCheck="select a.*  from st_warehouse_stock_receive_detail a left join st_warehouse_stock_receive_head b
on a.receive_no = b.receive_no
where a.P_Code  ='$item'
and a.receive_qty ='$Num' 
and a.Createby='$USER_id' 
and convert(varchar  ,a.CreateDate,120)  like '$dateT%'
and b.receive_user_id ='$VAN'
 ";
$sqlCheck=sqlsrv_query($con,$sqlCheck,$params,$options);//-------------------check
$rowCheck=sqlsrv_num_rows($sqlCheck);

if($rowCheck>0){echo'<script type="text/javascript">';
			echo'alert("คืนของเข้าคลังไปแล้ว ");';
			echo "window.location='?page=stoc_salekBalance';";
			echo '</script>';
}
else
{
$sqlLocation="select st_user.warehouse_locationNo
,st_warehouse_location.locationname
from st_user  left join st_warehouse_location
on st_user.warehouse_locationNo = st_warehouse_location.locationno
where st_user.User_id='$USER_id'";
$sqlLocation=sqlsrv_query($con,$sqlLocation,$params,$options);
$sqlLocation=sqlsrv_fetch_array($sqlLocation);

$sqlMax="select SUBSTRING(max(receive_no),11,15) as MaxID from st_warehouse_stock_receive_head
where   SUBSTRING(receive_no,2,2) ='$year' and SUBSTRING(receive_no,5,5) ='$sqlLocation[warehouse_locationNo]'";
$qryMax=sqlsrv_query($con,$sqlMax,$params,$options);
$reMax=sqlsrv_fetch_array($qryMax);
$MaxID=$reMax['MaxID']; 
$MaxID= $MaxID+1;
$MaxID =str_pad($MaxID,5,"0",STR_PAD_LEFT);
$MaxID ="R".$year."-".$sqlLocation['warehouse_locationNo']."-".$MaxID ; //----------------------ID CODE 




$sqlIn2="insert into st_warehouse_stock_receive_detail 
				(receive_no,P_Code,receive_qty,receive_unit,Remark,Createby,Updateby,CreateDate,UpdateDate,Updatestatus) values
				('$MaxID','$item','$Num','ขวด','คืนของเหลือจากท้ายรถให้คลัง','$USER_id','$USER_id',GETDATE(),GETDATE(),'1')";
$qryIn2=sqlsrv_query($con,$sqlIn2,$params,$options);//add--detail
				
$sqlIn1="insert into st_warehouse_stock_receive_head
(receive_no,ref_docno,receive_date,receive_locationno,receive_Remark,Createby,CreateDate,Updatestatus,receive_user_id) values
('$MaxID','$txt_ref_docno',GETDATE(),'$sqlLocation[warehouse_locationNo]','คืนของเหลือจากท้ายรถให้คลัง','$USER_id',GETDATE(),'1','$VAN')";
$qryIn1=sqlsrv_query($con,$sqlIn1,$params,$options);//add--หลัก
			
				$stock ="select *
				from st_warehouse_stock 
				where P_Code='$item'
				and locationno='$sqlLocation[warehouse_locationNo]'";
				$stock=sqlsrv_query($con,$stock,$params,$options);//----ปรับยอดstock คลัง
				$stock=sqlsrv_fetch_array($stock);
				
				$stock=$stock['stock_count'];
				$stockSum=$stock+$Num;
				$stockUp="update st_warehouse_stock set stock_count='$stockSum' where P_Code='$item' and locationno='$sqlLocation[warehouse_locationNo]' ";
				$stockUp=sqlsrv_query($con,$stockUp,$params,$options);//-----ปรับยอดstock คลัง
				
				$stockSale ="select *
					from st_warehouse_sale_stock 
					where P_Code='$item'
					and User_id='$VAN'";
					$stockSale=sqlsrv_query($con,$stockSale,$params,$options);//----เปิดstock ท้ายรถ
					$stockSale=sqlsrv_fetch_array($stockSale);
					
					
					$stockSale=$stockSale['wh_stock_qty'];
					$stockSale=$stockSale-$Num;//จำนวนของท้ายรถ update
					$stockSaleUp="update st_warehouse_sale_stock set wh_stock_qty='0' where P_Code='$item' and User_id='$VAN' ";
					$stockSaleUp=sqlsrv_query($con,$stockSaleUp,$params,$options);//----ปรับยอดstockท้ายรถ ***เพิ่ม Stock ท้ายรถ
				
	if($qryIn1)
	{
			echo'<script type="text/javascript">';
			echo'alert("คืนของเข้าคลังเรียบร้อยแล้ว ");';
			echo "window.location='?page=stoc_salekBalance';";
			echo '</script>';
	}
	else 
	{
			echo'<script type="text/javascript">';
			echo'alert("ไม่สำเร็จ");';
			echo "window.location='?page=stoc_salekBalance';";
			echo '</script>';
	}
}//else
}
?>
