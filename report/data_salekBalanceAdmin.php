<? 
session_start();
set_time_limit(0);
$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ
include("../includes/config.php");

$txt_DC=trim($_POST['txt_DC']);
$txt_packName=trim($_POST['txt_packName']);
?>
<div align="center">DC :
<? 		$sqlOps="select dc_groupname from st_user_group_dc    where dc_groupid= '$txt_DC' ";
		$qryOp=sqlsrv_query($con,$sqlOps);
		$deOp=sqlsrv_fetch_array($qryOp);
		echo $deOp['dc_groupname'];
?>
</div>
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
	<? $r=1; 
	$sql="select st_warehouse_sale_stock.User_id ,st_warehouse_sale_stock.username 
,st_item_product.P_Code ,st_item_product.PRODUCTNAME ,st_item_product.prd_type_id ,st_item_type.prd_type_nm 
,st_warehouse_sale_stock.wh_stock_qty ,st_item_product.st_unit_id ,A.st_unit_qty as A 
,B.st_unit_qty as B ,st_warehouse_sale_stock.wh_stock_qty/A.st_unit_qty as ToptalA 
, cast(st_warehouse_sale_stock.wh_stock_qty as int) % cast(A.st_unit_qty as int) 
,(cast(st_warehouse_sale_stock.wh_stock_qty as int) % cast(A.st_unit_qty as int))/B.st_unit_qty as ToptalB 
,(cast(st_warehouse_sale_stock.wh_stock_qty as int) % cast(A.st_unit_qty as int)) % B.st_unit_qty as ToptalC 
 ,st_user.Salecode,st_user.name,st_user.surname
from  st_user  left join st_warehouse_sale_stock 
on st_user.User_id = st_warehouse_sale_stock.User_id left join st_item_product on st_warehouse_sale_stock.P_Code = st_item_product.P_Code left join st_item_type 
on st_item_product.prd_type_id = st_item_type.prd_type_id left join st_item_unit_con A on st_item_product.P_Code = A.P_Code and A.st_unit_id='ลัง' left join st_item_unit_con B 
on st_item_product.P_Code = B.P_Code and B.st_unit_id='แพ็ค' ";
			
			if($txt_DC)
			{	$sql.=" where  st_user.dc_groupid = '$txt_DC'";
				if($txt_packName){ $sql.="and  st_user.User_id='$txt_packName'and st_user.RoleID <> '7'
				and st_user.RoleID_Lineid = '6_2' 
				and prd_grp_id is not null ";}else{}
			}
			else if($txt_packName){ $sql.=" where  st_user.User_id='$txt_packName' and st_user.RoleID <> '7'
				and st_user.RoleID_Lineid = '6_2' 
				and prd_grp_id is not null ";}
				
			else{ $sql.=" where st_user.RoleID <> '7'
				and prd_grp_id is not null ";}
			
			$sql.=" order by st_user.Salecode  asc,st_user.User_id asc,st_item_product.prd_type_id desc";
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