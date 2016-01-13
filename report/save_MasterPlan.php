<?//------------------------------------------------------แก้ไข โดย phung 10/09/2015------------------------------------
session_start();
		set_time_limit(0);
		include("../includes/config.php");
	$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ
	
	$select_provider=trim($_POST['select_provider']); //รหัส DC
	$txt_planName =trim($_POST['txt_planName']); //แผน
	$txt_remark =trim($_POST['txt_remark']); //หมายเหตุ
	$txt_COMPANY =trim($_POST['txt_COMPANY']); //บริษัท
	
$sqlMax="select SUBSTRING(max(Plan_id),15,4) as MaxID from st_Master_plan
where   SUBSTRING(Plan_id,2,2) ='$year' and SUBSTRING(Plan_id,5,9) ='$select_provider'";
$qryMax=sqlsrv_query($con,$sqlMax,$params,$options);
$reMax=sqlsrv_fetch_array($qryMax);
$MaxID=$reMax['MaxID']; 
$MaxID= $MaxID+1;
$MaxID =str_pad($MaxID,4,"0",STR_PAD_LEFT);
$MaxID ="P".$year."-".$select_provider."-".$MaxID ; //----------------------ID CODE 58-DC5800001-0001 

$sqlAdd1="insert into st_Master_plan( Plan_id,DC_id,Plan_name,Createby ,Updateby,CreateDate,UpdateDate ,COMPANYCODE,Remark)
		values('$MaxID','$select_provider','$txt_planName','$USER_id','$USER_id',GETDATE(),GETDATE(),'$txt_COMPANY','$txt_remark')";
$qryAdd1=sqlsrv_query($con,$sqlAdd1);	

	$array_id = $_POST["array_id"]; $a=1;
    foreach($array_id as $item){
        if($item !="undefined")
		{
			$sqlAdd2="insert into st_Master_PlanDetail(Plan_id,Cust_num,row)values('$MaxID','$item','$a')";
			$qryAdd2=sqlsrv_query($con,$sqlAdd2);
			$a++;
		}
    }
	if($qryAdd2)
	{
			echo'<script type="text/javascript">';
			echo'alert("สร้างแผนเรียบร้อยแล้วคะ");';
			//echo "window.location='?page=from_plan';";
			echo "window.location='?page=showDetailPlan&id=".$MaxID."';";
			echo '</script>';
	}
	else 
	{
			echo'<script type="text/javascript">';
			echo'alert("ไม่สำเร็จ");';
			echo '</script>';
	}
	?>

