<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ

$txt_userPlan=trim($_POST['txt_userPlan']);
$datefrom =trim($_POST['datefrom']);
$txt_plan =trim($_POST['txt_plan']);
$txt_remark = trim($_POST['txt_remark']);

$sqlCheck="select * from st_plan_head where cast(Plan_start_date as date)='$datefrom' and User_id='$txt_userPlan'";
				$sqlCheck=sqlsrv_query($con,$sqlCheck);
				$sqlCheck=sqlsrv_fetch_array($sqlCheck);
if($sqlCheck)
{
	echo'<script type="text/javascript">';
	echo'alert("วันที่ '.$datefrom.'  วางแผนไปแล้ว วางแผนซ้ำไม่ได้!!! ");';
	echo "window.location='?page=add_plan';";
	echo '</script>';
					
}
else
{
$sqlMax="select SUBSTRING(max(Plan_Docno),11,5) as MaxID from st_plan_head
where   SUBSTRING(Plan_Docno,1,2) ='$year' and SUBSTRING(Plan_Docno,4,6)  ='$txt_userPlan'";
$qryMax=sqlsrv_query($con,$sqlMax,$params,$options);
$reMax=sqlsrv_fetch_array($qryMax);
$MaxID=$reMax['MaxID']; 
$MaxID= $MaxID+1;
$MaxID =str_pad($MaxID,5,"0",STR_PAD_LEFT);
$MaxID =$year."-".$txt_userPlan."-".$MaxID ; //----------------------ID CODE 

$sqlOpentPlan="select * from st_Master_plan where Plan_id='$txt_plan'";
$qryOpentPlan=sqlsrv_query($con,$sqlOpentPlan);
$reOpentPlan=sqlsrv_fetch_array($qryOpentPlan);

	$sqlAdd1="insert into st_plan_head (Plan_Docno,Plan_Docdate ,Plan_start_date,Plan_end_date,Plan_topic ,User_id
	 ,Plan_Remark,Createby,Updateby,CreateDate,UpdateDate,Plan_active,Updatestatus ,Approveby ,ApproveDate ,Plan_id)
	 values
	 ('$MaxID',GETDATE() ,'$datefrom','$datefrom','$reOpentPlan[Plan_name]' ,'$txt_userPlan'
	 ,'$txt_remark','$USER_id','$USER_id',GETDATE(),GETDATE(),'0','1' ,'$USER_id' ,GETDATE() ,'$txt_plan')";
	$qryAdd1=sqlsrv_query($con,$sqlAdd1);

if($qryAdd1)
{
$sqlOpentPlan_detail="select st_Master_PlanDetail.Plan_id
,st_Master_PlanDetail.row
,st_Master_PlanDetail.Cust_num
,st_cust.CustName
,st_cust.lat
,st_cust.long
,st_cust.CustNum
from st_Master_PlanDetail left join st_cust
on st_Master_PlanDetail.Cust_num = st_cust.CustNum
where st_Master_PlanDetail.Plan_id='$txt_plan'
order by st_Master_PlanDetail.Plan_id asc
,st_Master_PlanDetail.row asc";
$qryOpentPlan_detail=sqlsrv_query($con,$sqlOpentPlan_detail,$params,$options);
	while ($reOpentPlan_detail=sqlsrv_fetch_array($qryOpentPlan_detail))
	{

	$sqlAdd2="insert into st_plan_detail ( Plan_Docno,Plan_line,Plan_start_date,Plan_end_date,Plan_topic
	,CustNum ,CustName,lat ,long
	,User_id,Plan_Remark
	,Createby,Updateby,CreateDate,UpdateDate ,Updatestatus)
	 values
	 ('$MaxID','$reOpentPlan_detail[row]','$datefrom','$datefrom','$reOpentPlan[Plan_name]' 
	 ,'$reOpentPlan_detail[CustNum]','$reOpentPlan_detail[CustName]','$reOpentPlan_detail[lat]','$reOpentPlan_detail[long]'
	 ,'$txt_userPlan','$txt_remark'
	 ,'$USER_id','$USER_id',GETDATE(),GETDATE(),'1')";
		//echo "<br>";
	$qryAdd2=sqlsrv_query($con,$sqlAdd2,$params,$options);
	
	}
}
if($qryAdd1)
	{
			echo'<script type="text/javascript">';
			echo'alert("วางแผนเรียบร้อยแล้วคะ");';
			echo "window.location='?page=from_Inplan';";
			echo '</script>';
	}
	else 
	{
			echo'<script type="text/javascript">';
			echo'alert("ไม่สำเร็จ");';
			
			echo '</script>';
			echo $sqlAdd1;
	}


}


?> 