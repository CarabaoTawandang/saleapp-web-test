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
		
		$('#txt_DC').change(function(){
				//alert('****');
				$.ajax({
					url:'report/UserByDC.php',
					type:'POST',
					data:'value='+$('#txt_DC').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_packName').html(result);
					}
				});
		});
		
		$('#btn_Search').click(function(){
				//alert('****');
				$('#txt_search').html("<img src='images/89.gif'>");
				$.ajax({
					url:'report/data_salekBalanceAdmin.php',
					type:'POST',
					data:$('#frmSearch').serialize(),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_search').html(result);
					}
				});
		});
	});//function	
</script>
</head>
<body>
<div class="container_box">
    <div id="box">
	<div class="header"><h3>stock ท้ายรถ</h3><!---หัวเรื่องหลัก-->
           <p>&nbsp;</p><!---หัวเรื่องรอง-->
		  <!--- <input type="button" value="-จ่ายของเข้ารถ" id="btn" onclick="window.location='?page=add_picking_head';" class="inner_position_right" >
		  --->
	</div><div class="sep"></div>
<form method="post"  id="frmSearch" name="frmSearch">
<table cellpadding="0" cellspacing="0"  border="0" align="center"  >
<tr><td colspan="2" align="center">
	<B>DC: </B>
	<select  id="txt_DC" name="txt_DC" style="width:170px;" >
	<option value="">-เลือก DC-</option>
		<? $sqlOp="select a.dc_groupname,a.dc_groupid
			from st_user_group_dc a   ";
			if($userType <>"7" and $userType2<>""){
				$sqlOp.=" left join st_user u
				on u.dc_groupid =a.dc_groupid
				where u.User_id= '$USER_id'"; }
			//echo $sqlOp;
			$qryOp=sqlsrv_query($con,$sqlOp,$params,$options);
			while($deOp=sqlsrv_fetch_array($qryOp)){
			echo "<option value='".$deOp['dc_groupid']." '>";
			echo $deOp['dc_groupname'];
			echo "</option>";
			}
		?>
	</select>
	<b>พนักงานขาย</b>
		<select  id="txt_packName" name="txt_packName" style="width:170px;" >
	<option value="">-ALL-</option>
		<? $sqlOp="select st_user.*from st_user where st_user.RoleID <> '7'   and st_user.User_id is not null order by st_user.Salecode asc";
			$qryOp=sqlsrv_query($con,$sqlOp,$params,$options);
			while($deOp=sqlsrv_fetch_array($qryOp)){
			echo "<option value='".$deOp['User_id']." '>";
			echo $deOp['Salecode']." ".$deOp['name']." ".$deOp['surname'];
			echo "</option>";
			}
		?>
	</select>
	<input type="button" id="btn_Search" name="btn_Search" value="ค้นหา">
	
</td></tr>
</table>
</form>
</div><!--/-box-->
</div><!--/-container_box-->

<br><br><div id="txt_search" align="center"></div>

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
