<?session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ

$txt_userPlan =trim($_POST['txt_userPlan']);
$txt_MONTH =trim($_POST['txt_MONTH']);
$txt_MONTH =str_pad($txt_MONTH,2,"0",STR_PAD_LEFT);

$txt_YEAR = $_POST['txt_YEAR'];
$txt_remark=$_POST['txt_remark'];
$txt_do = $_POST['txt_do'];

if($txt_do=="edit")
{	$YM=$txt_YEAR."-".$txt_MONTH;
	//echo "Edit";exit;
	$SQLDel1="delete st_plan_head  where User_id='$txt_userPlan' and cast(Plan_start_date as date) like '$YM%'";
	$SQLDel1=sqlsrv_query($con,$SQLDel1);
	//echo "<br>";
	$SQLDel2="delete st_plan_detail  where User_id='$txt_userPlan' and cast(Plan_start_date as date) like '$YM%'";
	$SQLDel2=sqlsrv_query($con,$SQLDel2);
	//echo "ลบแผนเดิมแล้ว";
	
}


$array_id = $_POST["txt_plan"]; $a=1;
    foreach($array_id as $item)
	{
			if($item)
			{
				//echo"<br>--------------"; 
				$YMD=$txt_YEAR."-".$txt_MONTH."-".$a;
				$dmY =$a."-".$txt_MONTH."-".$txt_YEAR;
				//echo $YMD." = ";
				//echo $item."   /   ";
				
				$sqlCheck="select * from st_plan_head where cast(Plan_start_date as date)='$YMD' and User_id='$txt_userPlan'";
				$sqlCheck=sqlsrv_query($con,$sqlCheck);
				$sqlCheck=sqlsrv_fetch_array($sqlCheck);
				if($sqlCheck)
				{
					echo'<script type="text/javascript">';
					echo'alert("วันที่ '.$dmY.'  วางแผนไปแล้ว วางแผนซ้ำไม่ได้!!! ");';
					echo '</script>';
					
				}
				else
				{
				
				$sqlOpentPlan="select * from st_Master_plan where Plan_id='$item'";//เอาชื่อแผน
				$qryOpentPlan=sqlsrv_query($con,$sqlOpentPlan);
				$reOpentPlan=sqlsrv_fetch_array($qryOpentPlan);
				
				$sqlMax="select SUBSTRING(max(Plan_Docno),11,5) as MaxID from st_plan_head
				where   SUBSTRING(Plan_Docno,1,2) ='$year' and SUBSTRING(Plan_Docno,4,6)  ='$txt_userPlan'";
				$qryMax=sqlsrv_query($con,$sqlMax);
				$reMax=sqlsrv_fetch_array($qryMax);
				$MaxID=$reMax['MaxID']; 
				$MaxID= $MaxID+1;
				$MaxID =str_pad($MaxID,5,"0",STR_PAD_LEFT);
				$MaxID =$year."-".$txt_userPlan."-".$MaxID ; 
				
				$sqlAdd1="insert into st_plan_head (Plan_Docno,Plan_Docdate ,Plan_start_date,Plan_end_date,Plan_topic ,User_id
				 ,Plan_Remark,Createby,Updateby,CreateDate,UpdateDate,Plan_active,Updatestatus ,Approveby ,ApproveDate ,Plan_id)
				 values
				 ('$MaxID',GETDATE() ,'$YMD','$YMD','$reOpentPlan[Plan_name]' ,'$txt_userPlan'
				 ,'$txt_remark','$USER_id','$USER_id',GETDATE(),GETDATE(),'0','1' ,'$USER_id' ,GETDATE() ,'$item')";//save แผน หลัก
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
						where st_Master_PlanDetail.Plan_id='$item'
						order by st_Master_PlanDetail.Plan_id asc
						,st_Master_PlanDetail.row asc";
						$qryOpentPlan_detail=sqlsrv_query($con,$sqlOpentPlan_detail);
							while ($reOpentPlan_detail=sqlsrv_fetch_array($qryOpentPlan_detail))
							{ //echo "<br>";
							$sqlAdd2="insert into st_plan_detail ( Plan_Docno,Plan_line,Plan_start_date,Plan_end_date,Plan_topic
							,CustNum ,CustName,lat ,long
							,User_id,Plan_Remark
							,Createby,Updateby,CreateDate,UpdateDate ,Updatestatus)
							 values
							 ('$MaxID','$reOpentPlan_detail[row]','$YMD','$YMD','$reOpentPlan[Plan_name]' 
							 ,'$reOpentPlan_detail[CustNum]','$reOpentPlan_detail[CustName]','$reOpentPlan_detail[lat]','$reOpentPlan_detail[long]'
							 ,'$txt_userPlan','$txt_remark'
							 ,'$USER_id','$USER_id',GETDATE(),GETDATE(),'1')";
							$qryAdd2=sqlsrv_query($con,$sqlAdd2);
							
							}
					}
				}//else*
				
			}//if item
	$a++;$MaxID="";
	}//foreach
 
 

 if($qryAdd1 || $SQLDel1)
	{
			echo'<script type="text/javascript">';
			if($txt_do=="edit"){echo'alert("แก้ไขแผนเรียบร้อยแล้วคะ");';}
			else{echo'alert("วางแผนเรียบร้อยแล้วคะ");';}
			echo "window.location='?page=from_Inplan2';";
			echo '</script>';
	}
	else 
	{
			echo'<script type="text/javascript">';
			echo'alert("ไม่สำเร็จ");';
			echo $sqlAdd1;
			echo '</script>';
			
	}

?>
