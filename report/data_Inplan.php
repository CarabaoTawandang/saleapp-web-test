<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$txt_DC=$_POST['txt_DC'];
$txt_User =$_POST['txt_User'];
$dateTo = $_POST['dateTo'];
$dateEnd = $_POST['dateEnd'];



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

	<table  align="center" class="tables" width="100%">
	<tr>
	<th align="center">วันที่เข้าแผน</th>
	<th align="center">DC</th>
	<th align="center">User</th>
	<th align="center">แผน</th>
	<th align="center">ดูแผน</th>
	<th align="center">ลบ</th>
	</tr>
	<? 
	$sql="select distinct st_plan_head.Plan_Docno
	, cast(st_plan_head.Plan_start_date as date) as date2
	, st_plan_head.Plan_id
	, st_plan_head.Plan_topic
	, st_plan_head.User_id,st_user.name,st_user.surname
	, st_Master_plan.DC_id
	, st_user_group_dc.dc_groupname

	from st_plan_head  left   join st_Master_plan
	on st_plan_head.Plan_id= st_Master_plan.Plan_id left join st_user
	on st_plan_head.User_id = st_user.User_id 
	left join st_user_group_dc
	on st_Master_plan.DC_id = st_user_group_dc.dc_groupid  
	where cast(Plan_start_date as date) between '$dateTo' and '$dateEnd'
	";



	if($txt_DC){	$sql.="and st_Master_plan.DC_id ='$txt_DC' ";}
	if($txt_User){	$sql.="and st_plan_head.User_id ='$txt_User' ";}
	$sql.="order by cast(st_plan_head.Plan_start_date as date) asc, st_user_group_dc.dc_groupname asc ,st_user.name asc ";

	$qry=sqlsrv_query($con,$sql);
	//echo $sql;
	$r=0;
	while($re=sqlsrv_fetch_array($qry))
	{ ?>
	<tr class="mousechange"  height="30" valign= "top" >
	<td align="left "><?=date_format($re['date2'],'d-m-Y');?> </td>
	<td align="left "><?=$re['dc_groupname']?> </td>
	<td align="left "><?=$re['name']." ".$re['surname'];?> </td>
	<td align="left "><?=$re['Plan_topic'];?></td>
	<td align="left "><a href="report/showDetailPlan.php?&id=<?=$re['Plan_id']?>&do=not" target="_blank" >#</a> </td>
	<td align="left ">
	<a href="?page=from_Inplan&do=del&id=<?=$re['Plan_Docno'];?>" onclick="return confirm('คุณต้องการลบข้อมูล Plan ของ  User หรือไม่?');" >
	<img src="./images/del.gif" style="cursor:pointer" alt="Complete"></a>
	</td>
	</tr>
	<?
	
	$r++;} ?>
	</table>
</div></div><br><br>


</body>
</html>
