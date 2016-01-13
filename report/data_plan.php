<?
session_start();
set_time_limit(0);
include("../includes/config.php");

$txt_DC=trim($_POST['txt_DC']);
$txt_id=trim($_POST['txt_id']);
$txt_name=trim($_POST['txt_name']);
$txt_pro=trim($_POST['txt_pro']);
$txt_aum=trim($_POST['txt_aum']);
$txt_dis=trim($_POST['txt_dis']);
$txt_all=trim($_POST['txt_all']);

$order_n=trim($_POST['order_n']);
$order_by=trim($_POST['order_by']);

$filter="select distinct st_Master_plan.Plan_id,st_Master_plan.Plan_name
from st_Master_plan 
left join st_Master_PlanDetail on st_Master_plan.Plan_id = st_Master_PlanDetail.Plan_id 
left join st_user_group_dc on st_Master_plan.DC_id =  st_user_group_dc.dc_groupid 
left join st_View_cust_web on st_View_cust_web.CustNum =  st_Master_PlanDetail.Cust_num
where   st_Master_plan.DC_id like'%%' and st_Master_plan.Plan_status is null  ";

if($txt_DC){$filter.=" and st_Master_plan.DC_id ='$txt_DC' ";}
if($txt_id){$filter.=" and st_Master_plan.Plan_id like '%$txt_id%' ";}
if($txt_name){$filter.="and st_Master_plan.Plan_name like '%$txt_name%' ";}
if($txt_pro){$filter.=" and st_View_cust_web.PROVINCE_CODE ='$txt_pro' ";}
if($txt_aum){$filter.=" and st_View_cust_web.AMPHUR_CODE ='$txt_aum' ";}
if($txt_dis){$filter.=" and st_View_cust_web.DISTRICT_CODE ='$txt_dis' ";}
else if($txt_all){ }



if(!$order_n)
{
$filter.="group by st_Master_plan.Plan_id
,st_Master_plan.Plan_name
,st_View_cust_web.PROVINCE_CODE
order by st_Master_plan.Plan_id $order_by ";
} 
else
{
$filter.="group by st_Master_plan.Plan_id
,st_Master_plan.Plan_name
,st_View_cust_web.PROVINCE_CODE
order by $order_n $order_by ";
}
//echo $filter;
$F=sqlsrv_query($con,$filter,$params,$options);
$num_rows=sqlsrv_num_rows($F);

$r=1;

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

<style type="text/css">  
.inner_position_right{  
    
    top:0px; /* css กำหนดชิดด้านบน  */  
    left:70%; /* css กำหนดชิดขวา  */  
    z-index:999;  
}  
</style>
<style type="text/css">
#mouseOver {
        display: inline;
        position: relative;
    }
    
    #mouseOver #img2 {
        position: absolute;
        left: 50%;
        transform: translate(-100%);
        bottom: 0em;
        opacity: 0;
        pointer-events: none;
        transition-duration: 800ms; 
		top: 50px;
    }
    
    #mouseOver:hover #img2 {
        opacity: 1;
        transition-duration: 400ms;
    }
</style> 
</head>
<body>


<?if($num_rows==0){echo"<p align='center'><b>----------ไม่พบข้อมูล------------</b></p>";}else{	
$CountAll="select COUNT(st_Master_plan.Plan_id) AS COUNTPLAN
from st_Master_plan 
where st_Master_plan.DC_id ='$txt_DC' ";
$CountAll=sqlsrv_query($con,$CountAll);
$CountAll=sqlsrv_fetch_array($CountAll);
echo " <br>แผนทั้งหมด ".$CountAll['COUNTPLAN'];

$CountCancel="select COUNT(st_Master_plan.Plan_id) AS COUNTPLANCancel
from st_Master_plan 
where st_Master_plan.DC_id ='$txt_DC' and   st_Master_plan.Plan_status ='N' ";
$CountCancel=sqlsrv_query($con,$CountCancel);
$CountCancel=sqlsrv_fetch_array($CountCancel);
echo " ยกเลิก ".$CountCancel['COUNTPLANCancel'];

$PlanNum=$CountAll['COUNTPLAN']-$CountCancel['COUNTPLANCancel'];
echo " ใช้อยู่ ".$PlanNum." แผน";
?>

	<table  align="center" class="tables" >
	<tr>
	<th align="center"width="30px">ลำดับ</th>
	<th align="center"width="200px">รหัส</th>
	<th align="center"width="200px">DC</th>
	<th align="center"width="300px">ชื่อแผน</th>
	<th align="center"width="200px">หมายเหตุ</th>
	<th align="center"width="50px">จำนวน</th>
	<th align="center"width="70px">ดูแผน</th>
	<th align="center"width="50px">แก้ไข</th>
	<th align="center"width="50px">ยกเลิก</th>
	</tr>
	<?

	while($FF=sqlsrv_fetch_array($F)){

$sql="select st_Master_plan.Plan_id
,st_Master_plan.DC_id
,st_user_group_dc.dc_groupname
,st_Master_plan.Plan_name
,st_Master_plan.Remark
,count(st_Master_PlanDetail.Cust_num) as CountCust
from st_Master_plan left join st_Master_PlanDetail
on st_Master_plan.Plan_id = st_Master_PlanDetail.Plan_id left join st_user_group_dc
on st_Master_plan.DC_id =  st_user_group_dc.dc_groupid 
where st_Master_plan.Plan_id ='$FF[Plan_id]' ";

$sql.="group by  st_Master_plan.Plan_id
,st_Master_plan.DC_id
,st_user_group_dc.dc_groupname
,st_Master_plan.Plan_name
,st_Master_plan.Remark ";

$sql=sqlsrv_query($con,$sql);
	while($re=sqlsrv_fetch_array($sql))
	{ ?>
	<tr class="mousechange" class="mousechange"  height="30" valign= "top" >
	<td align="center"><?=$r;?> </td>
	<td align="left "><?=$re['Plan_id']?> </td>
	<td align="left "><?=$re['dc_groupname'];?> </td>
	<td align="left "><?=$re['Plan_name'];?></td>
	<td align="left "><?=$re['Remark'];?></td>
	<td align="left "><?=$re['CountCust'];?> </td>
	<td align="left "><a href="report/showDetailPlan.php?&id=<?=$re['Plan_id']?>&do=not" target="_blank" >#</a> </td>
	<td align="center" >
	<a href="?page=edit_Masterplan&id='<?=$re['Plan_id']?>'" >
	<img src="./images/edit.gif" style="cursor:pointer" alt="Complete"></a>
	</td>
	
	<td align="center" >
	<!--<a href="?page=from_plan&do=del&id='<?=$re['Plan_id']?>'" onclick="return confirm('คุณต้องการลบข้อมูล หรือไม่?');" >
	<img src="./images/del.gif" style="cursor:pointer" alt="Complete"></a>-->
	<a href="?page=from_plan&do=Cancel&id='<?=$re['Plan_id']?>'" onclick="return confirm('คุณยืนยัน ยกเลิก แผนนี้หรือไม่?');" >
	<img src="./images/no.gif" style="cursor:pointer" alt="Complete"></a>
	</td>
	</tr>
	<?
	
	$r++;} } }?>
	</table>
</div></div><br><br>


</body>
</html>
